<?php
include_once (__DIR__ . "/clsStatus.php");
class clsPas{    
    public $cod_pas;
    public $cod_eixo;
    public $cod_perspectiva;
    public $cod_diretriz;
    public $cod_objetivo;
    public $cod_objetivo_ppa;
    public $codigo_acao;
    public $txt_acao;
    public $cod_orgao;
    public $cod_parceiro;
    public $cod_mes_inicio;
    public $cod_mes_fim;
    public $cod_meta;
    public $cod_modulo;
    public $txt_consideracao;
    public $cod_bimeste;
    public $cod_resultado;
    public $cod_inicio_efetivo;
    public $cod_fim_efetivo;
    public $txt_medida;
    public $cod_controle;
    public $txt_justificativa;
    public $cod_autorizar;
    public $dt_autorizar;
    public $cod_inicio_previsto;
    public $cod_fim_previsto;

    private $retorno = array();    

    public function IncluirPAS() { 
        if (empty($this->cod_parceiro)) {
            $this->cod_parceiro = 'null';
        }
               
        $txt_acao_pas = str_replace("'", "''", $this->txt_acao);        

        $sql = "INSERT INTO tb_pas(cod_pas, cod_objetivo, cod_objetivo_ppa, ";
        $sql .= " txt_acao, cod_orgao, cod_inicio_previsto, cod_fim_previsto, cod_parceiro, cod_meta, codigo_acao, txt_medida)";
        $sql .= " VALUES(nextval('pas'), ";
        $sql .= " ".$this->cod_objetivo.", ".$this->cod_objetivo_ppa.", '".trim($txt_acao_pas)."', ".$this->cod_orgao.", ";
        $sql .= " ".$this->cod_mes_inicio.", ".$this->cod_mes_fim.", ".$this->cod_parceiro.", '".$this->cod_meta."', '".$this->codigo_acao."', '".$this->txt_medida."')";
        pg_query($sql);            

        Auditoria(86, "", $sql);
    }

    public function AlterarPAS() { 
        if (empty($this->cod_parceiro)) {
            $this->cod_parceiro = 'null';
        }

        $txt_acao_pas = str_replace("'", "''", $this->txt_acao);

        $sql = "UPDATE tb_pas SET cod_objetivo = ".$this->cod_objetivo.", ";
        $sql .= " cod_objetivo_ppa = ".$this->cod_objetivo_ppa.", txt_acao = '".trim($txt_acao_pas)."', ";
        $sql .= " cod_orgao = ".$this->cod_orgao.", cod_inicio_previsto = ".$this->cod_mes_inicio.", ";
        $sql .= " cod_fim_previsto = ".$this->cod_mes_fim.", cod_parceiro = ".$this->cod_parceiro.", ";
        $sql .= " cod_meta = '".$this->cod_meta."', codigo_acao =  '".$this->codigo_acao."', txt_medida = '".$this->txt_medida."' ";
        $sql .= " WHERE cod_pas = ".$this->cod_pas;        
        pg_query($sql);         

        Auditoria(87, "", $sql);
    }    

    public function ExcluirPAS() {
        $rs=pg_fetch_array(pg_query("SELECT txt_acao FROM tb_pas WHERE cod_pas = ".$this->cod_pas));                

        $sql = "DELETE FROM tb_pas_consideracao WHERE cod_pas = ".$this->cod_pas;
        pg_query($sql);

        Auditoria(91, "", $sql);

        $sql = "DELETE FROM tb_pas_controle_historico WHERE cod_pas = ".$this->cod_pas;
        pg_query($sql);
        
        Auditoria(107, "", $sql);

        $sql = "DELETE FROM tb_pas_analise WHERE cod_pas = ".$this->cod_pas;
        pg_query($sql);

        Auditoria(108, "", $sql);

        $sql = "DELETE FROM tb_pas WHERE cod_pas = ".$this->cod_pas;
        pg_query($sql);  
        
        Auditoria(88, "EXCLUIR PAS: ".$rs['txt_acao'], $sql);
    }

    public function IncluirConsideracao() {
        $q1 = pg_query("SELECT * FROM tb_pas_analise WHERE cod_pas = ".$this->cod_pas. " AND cod_bimestre = ".$this->cod_bimeste);
        if (pg_num_rows($q1) > 0) {            
            $q = pg_query("SELECT dt_reabrir FROM tb_pas_periodo");
            if (pg_num_rows($q) > 0) {
                $rs1 = pg_fetch_array($q);  
                
                if(!empty($rs1['dt_reabrir'])) {                    
                    $rs2 = pg_fetch_array($q1);   
                    
                    $sql = "INSERT INTO tb_pas_analise_historico(cod_pas, cod_bimestre, txt_justificativa, cod_usuario, dt_inclusao) ";
                    $sql .= " VALUES(".$rs2['cod_pas'].", ".$rs2['cod_bimestre'].", '".trim($rs2['txt_justificativa'])."', ";
                    $sql .= " ".$rs2['cod_usuario'].", (SELECT dt_inclusao FROM tb_pas_analise WHERE cod_pas = ".$this->cod_pas;
                    $sql .= " AND cod_bimestre = ".$this->cod_bimeste.")) ";                                       
                    pg_query($sql);  
                    
                    Auditoria(105, "", $sql);                    
                }            
            }

            $sql = "UPDATE tb_pas_analise SET txt_justificativa = '".trim($this->txt_consideracao)."', cod_usuario = ".$_SESSION['cod_usuario'];
            $sql .= " WHERE cod_pas = ".$this->cod_pas. " AND cod_bimestre = ".$this->cod_bimeste;
            pg_query($sql);

            Auditoria(104, "", $sql);            
        }
        else {
            $sql = "INSERT INTO tb_pas_analise(cod_pas, cod_bimestre, txt_justificativa, cod_usuario) ";
            $sql .= " VALUES(".$this->cod_pas.", ".$this->cod_bimeste.", '".trim($this->txt_consideracao)."', ".$_SESSION['cod_usuario'].")";
            pg_query($sql); 

            Auditoria(103, "", $sql);            
        }         
    }

    public function ExcluirConsideracao() {
        $rs=pg_fetch_array(pg_query("SELECT txt_consideracao FROM tb_pas_consideracao WHERE cod_pas = ".$this->cod_pas. " AND cod_bimestre = ".$this->cod_bimeste)); 

        $sql = "DELETE FROM tb_pas_consideracao WHERE cod_pas = ".$this->cod_pas. " AND cod_bimestre = ".$this->cod_bimeste;
        pg_query($sql);

        Auditoria(91, "EXCLUIR CONSIDERAÇÃO PAS: ".$rs['txt_consideracao'], $sql);
    }

    public function CompletarCadastro() {
        $sql = "UPDATE tb_pas SET cod_resultado = ".$this->cod_resultado.", cod_inicio_efetivo = ".$this->cod_inicio_efetivo.", cod_fim_efetivo = ".$this->cod_fim_efetivo."";
        $sql .= " WHERE cod_pas = ".$this->cod_pas;            
        pg_query($sql);
    }

    public function ListaPeriodo() {
        $sql = "SELECT * FROM tb_pas_periodo ORDER BY dt_inclusao DESC";
        $q = pg_query($sql);
        return $q; 
    }

    public function RegraPeriodo() {
        $retorno = true;
        
        $clsPas = new clsPas();
        $q2 = $clsPas->ListaPeriodo();        
        if (pg_num_rows($q2) > 0) {
            $rs = pg_fetch_array($q2);
            $d = date("d/m/Y");                        
            if (($d > FormataData($rs['dt_fim']) || $d < FormataData($rs['dt_inicio'])) && empty($rs['dt_reabrir'])) {
                $retorno = false;                
            }                 
        } 

        return $retorno;
    }

    public function IncluirPeriodoAtualizacao($dt_inicio, $dt_fim) {
        $rs=pg_fetch_array(pg_query("SELECT MAX(cod_chave) FROM tb_pas_periodo"));
        if (!isset($rs[0])) {
            $id = 1;
        } else {
            $id = intval($rs[0]) + 1;
        }


        $sql = "INSERT INTO tb_pas_periodo(cod_chave, dt_inicio, dt_fim, cod_usuario) ";
        $sql .= " VALUES(".$id.", '".trim(DataBanco($dt_inicio))."', '".trim(DataBanco($dt_fim))."', ".$_SESSION['cod_usuario'].")";        
        pg_query($sql);

        Auditoria(93, "", $sql);
    }

    public function AlterarPeriodoAtualizacao($id, $dt_inicio, $dt_fim) {
        $sql = "UPDATE tb_pas_periodo SET dt_inicio = '".trim(DataBanco($dt_inicio))."', ";
        $sql .= " dt_fim = '".trim(DataBanco($dt_fim))."', cod_usuario = ".$_SESSION['cod_usuario'];
        $sql .= " WHERE cod_chave = ".$id;
        pg_query($sql);

        Auditoria(94, "", $sql);
    }

    public function ExcluirPeriodoAtualizacao($id) {
        $sql = "DELETE FROM tb_pas_periodo WHERE cod_chave = ".$id;
        pg_query($sql);

        Auditoria(95, "", $sql);
    }

    public function EncerrarPeriodoAtualizacao($id) {
        $sql = "UPDATE tb_pas_periodo SET dt_reabrir = NULL, cod_usuario_reabrir = NULL WHERE cod_chave = ".$id;        
        pg_query($sql);

        Auditoria(96, "", $sql);
    }

    public function ReabrirPeriodoAtualizacao($id) {
        $sql = "UPDATE tb_pas_periodo SET dt_reabrir = CURRENT_DATE, cod_usuario_reabrir = ".$_SESSION['cod_usuario'];
        $sql .= " WHERE cod_chave = ".$id;
        pg_query($sql);

        Auditoria(97, "", $sql);
    }

    public function LimparPAS($cod_pas) { 
        $clsPas = new clsPas();
        $clsPas->cod_pas = $cod_pas;
        $clsPas->SalvarCompleto();

        Auditoria(117, "LIMPAR DADOS DA PAS", "");
    }

    public function SalvarCompleto() {        
        if (empty($this->cod_inicio_efetivo)) {
            $this->cod_inicio_efetivo = 'null';
        }
        if (empty($this->cod_fim_efetivo)) {
            $this->cod_fim_efetivo = 'null';
        }
        if (empty($this->cod_resultado) && strval($this->cod_resultado != '0')) {
            $this->cod_resultado = 'null';
        }
        if (empty($this->cod_controle)) {
            $this->cod_controle = 'null';
        }

        $sql = "UPDATE tb_pas SET cod_inicio_efetivo = ".$this->cod_inicio_efetivo.", cod_fim_efetivo = ".$this->cod_fim_efetivo.", ";                
        $sql .= " cod_resultado = ".$this->cod_resultado.", cod_controle = ".$this->cod_controle." WHERE cod_pas = ".$this->cod_pas;         
        pg_query($sql); 

        Auditoria(98, "", $sql);

        $clsPas = new clsPas();
        $cod_status = $clsPas->SituacaoPAS($this->cod_pas);
        if ($cod_status != '') {
            $clsStatus = new clsStatus();
            $txt_cor = $clsStatus->RetornaCorStatus($cod_status);                                                                        
            $txt_status = $clsStatus->RetornaStatus($cod_status);                                                                        
        } else {
            $txt_cor = "";
            $txt_status = "";
        }               

        return $txt_cor ."|". $txt_status;
    }    

    public function AtualizarSituacao() {
        $cod_inicio_efetivo = $this->cod_inicio_efetivo;
        $cod_fim_efetivo = $this->cod_fim_efetivo;

        $clsPas = new clsPas();
        $cod_status = $clsPas->SituacaoPAS_2($this->cod_pas, $cod_inicio_efetivo, $cod_fim_efetivo);       

        if ($cod_status != '') {
            $clsStatus = new clsStatus();
            $txt_cor = $clsStatus->RetornaCorStatus($cod_status);                                                                        
            $txt_status = $clsStatus->RetornaStatus($cod_status);                                                                        
        } else {
            $txt_cor = "";
            $txt_status = "";
        }              

        return $txt_cor ."|". $txt_status;
    }

    public function VerificaControleCanceladoAutorizado($id) {
        $retorno = false;

        $q = pg_query("SELECT cod_controle FROM tb_pas WHERE cod_pas = ".$id." AND cod_controle = 2");
        if (pg_num_rows($q) > 0) {
            $q = pg_query("SELECT cod_autorizar FROM tb_pas_controle_historico WHERE cod_pas = ".$id." AND cod_autorizar = 1");
            if (pg_num_rows($q) > 0) {
                $retorno = true;
            }
        }

        return $retorno;
    }

    public function SituacaoPAS($id) {        
        $retorno = "";

        $rs = pg_fetch_array(pg_query("SELECT * FROM tb_pas WHERE cod_pas = ".$id));
        $cod_inicio_previsto = $rs['cod_inicio_previsto'];
        $cod_fim_previsto = $rs['cod_fim_previsto'];
        $cod_inicio_efetivo = $rs['cod_inicio_efetivo'];  
        $cod_fim_efetivo = $rs['cod_fim_efetivo'];                

        $clsPas = new clsPas();
        $retorno = $clsPas->Situacao($id, $cod_inicio_previsto, $cod_fim_previsto, $cod_inicio_efetivo, $cod_fim_efetivo);

        return $retorno;
    }

    public function SituacaoPAS_2($id, $cod_inicio_efetivo, $cod_fim_efetivo) {
        $retorno = "";    
        
        $rs = pg_fetch_array(pg_query("SELECT * FROM tb_pas WHERE cod_pas = ".$id));
        $cod_inicio_previsto = $rs['cod_inicio_previsto'];
        $cod_fim_previsto = $rs['cod_fim_previsto'];        

        $clsPas = new clsPas();
        $retorno = $clsPas->Situacao($id, $cod_inicio_previsto, $cod_fim_previsto, $cod_inicio_efetivo, $cod_fim_efetivo);

        return $retorno;
    }

    public function Situacao($cod_pas, $cod_inicio_previsto, $cod_fim_previsto, $cod_inicio_efetivo, $cod_fim_efetivo) {
        //Desativar os campos quando houver um controle = cancelado e for autorizado. Também modificar a situação para cancelado. 
        $controle = $this->VerificaControleCanceladoAutorizado($cod_pas);
        if ($controle) {
            return  '6';
        }

        $mes_atual = intval(date('m'));
        $retorno = '';
        
        if (strval($mes_atual) == '1' || strval($mes_atual) == '2') {
            $mes_atual = '1';
        } else if (strval($mes_atual) == '3' || strval($mes_atual) == '4') { 
            $mes_atual = '2';
        } 
        else if (strval($mes_atual) == '5' || strval($mes_atual) == '6') { 
            $mes_atual = '3';
        }        
        else if (strval($mes_atual) == '7' || strval($mes_atual) == '8') { 
            $mes_atual = '4';
        }        
        else if (strval($mes_atual) == '9' || strval($mes_atual) == '10') { 
            $mes_atual = '5';
        }        
        else if (strval($mes_atual) == '11' || strval($mes_atual) == '12') { 
            $mes_atual = '6';
        }                              
        
        //A SER INICIADO
        //Este status aparece quando o campo “início previsto” tiver data superior a data atual e o campo início efetivo não estiver preenchido;
        if ($retorno == ''&& ($cod_inicio_previsto >= intval($mes_atual) && empty($cod_fim_efetivo) && empty($cod_inicio_efetivo)))
        {
            $retorno = "1";             
        }
       
        //ANDAMENTO NORMAL
        //Este status aparece quando o campo “Início previsto” tiver data igual a data atual preenchida pelo usuário no campo “início efetivo”.
        //Fim efetivo não pode estar preenchido
        //O fim previsto maior que a data atual quando o início previsto = fim previsto
        if ($retorno == '') {
            if ($retorno == '' && (($cod_inicio_previsto == $cod_inicio_efetivo || $cod_inicio_efetivo < $cod_inicio_previsto) && 
                empty($cod_fim_efetivo) && $cod_fim_previsto >= $mes_atual) || 
                (empty($cod_fim_efetivo) && $cod_fim_previsto > $mes_atual && $cod_inicio_efetivo <= $cod_fim_previsto))
            {
                $retorno = "2";   
                
                if (!empty($cod_fim_efetivo)) {
                    $retorno = '';
                }
                if (empty($cod_inicio_efetivo) && empty($cod_fim_efetivo)) {
                    $retorno = '';
                }
            }       
        }
        
        
        //ATRASADA
        //Este status aparece quando o campo “Início previsto” é inferior a data atual e o campo “início efetivo” não foi preenchido. 
        //Este status também aparece quando o campo “fim previsto” tem data inferior ao campo “fim efetivo”; 
        //O fim previso menor que a data atual.       
        if ($retorno == '' && (($cod_inicio_previsto < $mes_atual) && (empty($cod_inicio_efetivo))
        || ($cod_fim_previsto < $cod_fim_efetivo) || ($cod_fim_previsto < $mes_atual)))              
        {
            $retorno = "5";            
           
            if (!empty($cod_fim_efetivo)) {
                $retorno = '';
            }
        }       
       
        //CONCLUÍDO
        //Este status aparece quando o campo “fim efetivo” tiver data igual ou menor que o campo “fim previsto”. 
        if ($retorno == '' && !empty($cod_fim_efetivo) && !empty($cod_fim_previsto) && ($cod_fim_efetivo <= $cod_fim_previsto || !empty($cod_fim_previsto)))
        {            
            $retorno = "4";
        }                        
       
        return $retorno;
    }

    public function SalvarControle() {
        if(empty($this->cod_usuario_autorizar)) {
            $this->cod_usuario_autorizar = "NULL";
        }
        if(empty($this->cod_autorizar)) {
            $this->cod_autorizar = "NULL";
        }
        if(empty($this->cod_usuario_autorizar)) {
            $this->cod_usuario_autorizar = "NULL";
        }
        if(empty($this->dt_autorizar)) {
            $this->dt_autorizar = "NULL";
        } 
        if(empty($this->cod_controle)) {
            $this->cod_controle = "NULL";
        } 
        if(!empty($this->cod_inicio_previsto) && !empty($this->cod_fim_previsto)) {
            $update = " , cod_inicio_previsto = ".$this->cod_inicio_previsto.", cod_fim_previsto = ".$this->cod_fim_previsto;
        } else {
            $update = "";
        }        

        $q = pg_query("SELECT cod_pas FROM tb_pas_controle_historico WHERE cod_pas = ".$this->cod_pas);
        if (pg_num_rows($q) == 0) {            
            $sql = "INSERT INTO tb_pas_controle_historico(cod_pas, cod_usuario, txt_justificativa, cod_autorizar, cod_usuario_autorizar, dt_autorizar) ";
            $sql .= " VALUES(".$this->cod_pas.", ".$_SESSION['cod_usuario'].", '".trim($this->txt_justificativa)."', ".$this->cod_autorizar.", ";
            $sql .= " ".$this->cod_usuario_autorizar.", ".$this->dt_autorizar." ) ";            
            pg_query($sql);

            Auditoria(99, "", $sql);

            $sql = "UPDATE tb_pas SET cod_controle = ".$this->cod_controle." WHERE cod_pas=".$this->cod_pas;
            pg_query($sql);

            Auditoria(87, "", $sql);
        } else {
            $sql = "UPDATE tb_pas_controle_historico SET cod_usuario = ".$_SESSION['cod_usuario'].", txt_justificativa = '".trim($this->txt_justificativa)."', ";
            $sql .= " cod_autorizar = ".$this->cod_autorizar.", cod_usuario_autorizar = ".$this->cod_usuario_autorizar.", dt_autorizar = ".$this->dt_autorizar;
            $sql .= " WHERE cod_pas = ".$this->cod_pas;
            pg_query($sql);

            Auditoria(101, "", $sql);

            $sql = "UPDATE tb_pas SET cod_controle = ".$this->cod_controle." ".$update." WHERE cod_pas=".$this->cod_pas;
            pg_query($sql);

            Auditoria(87, "", $sql);
        }
    }
}   
?>