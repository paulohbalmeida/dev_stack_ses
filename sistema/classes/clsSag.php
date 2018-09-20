<?php
class clsSag{    
    public $cod_sag;
    public $cod_eixo;
    public $cod_perspectiva;
    public $cod_diretriz;
    public $cod_objetivo;
    public $cod_objetivo_ppa;
    public $cod_programa_trabalho;
    public $nr_etapa_trabalho;
    public $txt_etapa_trabalho;
    public $cod_produto_etapa;
    public $nr_meta;
    public $nr_meta_parcial;
    public $cod_orgao;
    public $cod_inicio_previsto;
    public $cod_fim_previsto;    
    public $cod_parceiro;
    public $cod_modulo = 2;
    public $cod_unidade_medida;
    public $txt_consideracao;
    public $cod_bimestre;
    public $cod_resultado;
    public $cod_inicio_efetivo;
    public $cod_fim_efetivo;
    public $cod_obra;
    public $cod_acumulativo;
    public $nr_meta_1;
    public $nr_meta_2;
    public $nr_meta_3;
    public $nr_meta_4;
    public $nr_meta_5;
    public $nr_meta_6;
    public $txt_realizado_1;
    public $txt_realizado_2;
    public $txt_percentual;
    public $txt_analise_obra;
    public $nr_mes_1;
    public $nr_mes_2;
    public $txt_analise;
    public $cod_situacao;
    public $cod_controle;
    public $cod_causa_desvio;
    public $cod_natureza_desvio;
    public $txt_analise_desvio;
    public $cod_status;

    public $dt_alteracao = 'NOW()';

    private $retorno = array();

    public function IncluirSAG() { 
        if (empty($this->cod_parceiro)) {
            $this->cod_parceiro = 'null';
        }

        if (empty($this->nr_meta_1)) {
            $this->nr_meta_1 = 'null';
        }
        if (empty($this->nr_meta_2)) {
            $this->nr_meta_2 = 'null';
        }
        if (empty($this->nr_meta_3)) {
            $this->nr_meta_3 = 'null';
        }
        if (empty($this->nr_meta_4)) {
            $this->nr_meta_4 = 'null';
        }
        if (empty($this->nr_meta_5)) {
            $this->nr_meta_5 = 'null';
        }
        if (empty($this->nr_meta_6)) {
            $this->nr_meta_6 = 'null';
        }
               
        $sql = "INSERT INTO tb_sag(cod_objetivo, cod_objetivo_ppa, ";
        $sql .= " cod_programa_trabalho, nr_etapa_trabalho, txt_etapa_trabalho, cod_produto_etapa, ";
        $sql .= " nr_meta, cod_orgao, cod_inicio_previsto, cod_fim_previsto, cod_parceiro, cod_modulo, cod_unidade_medida, ";
        $sql .= " cod_obra, cod_acumulativo, nr_meta_1, nr_meta_2, nr_meta_3, nr_meta_4, nr_meta_5, nr_meta_6)";
        $sql .= " VALUES(".$this->cod_objetivo.", ".$this->cod_objetivo_ppa.", " .$this->cod_programa_trabalho.", ";
        $sql .= " ".$this->nr_etapa_trabalho.", '".trim($this->txt_etapa_trabalho)."', ".$this->cod_produto_etapa.", ";
        $sql .= " ".$this->nr_meta.", ".$this->cod_orgao.", " .$this->cod_inicio_previsto.", ";    
        $sql .= " ".$this->cod_fim_previsto.", ".$this->cod_parceiro.", ".$this->cod_modulo.", " .$this->cod_unidade_medida.", ";
        $sql .= " ".$this->cod_obra.", ".$this->cod_acumulativo.", ".$this->nr_meta_1.", ".$this->nr_meta_2.", ";
        $sql .= " ".$this->nr_meta_3.", ".$this->nr_meta_4.", ".$this->nr_meta_5.", ".$this->nr_meta_6.")";             
        pg_query($sql);            

        Auditoria(109, "", $sql);
    }

    public function AlterarSAG() { 
        if (empty($this->cod_parceiro)) {
            $this->cod_parceiro = 'null';
        }

        if (empty($this->nr_meta_1)) {
            $this->nr_meta_1 = 'null';
        }
        if (empty($this->nr_meta_2)) {
            $this->nr_meta_2 = 'null';
        }
        if (empty($this->nr_meta_3)) {
            $this->nr_meta_3 = 'null';
        }
        if (empty($this->nr_meta_4)) {
            $this->nr_meta_4 = 'null';
        }
        if (empty($this->nr_meta_5)) {
            $this->nr_meta_5 = 'null';
        }
        if (empty($this->nr_meta_6)) {
            $this->nr_meta_6 = 'null';
        }

        $sql = "UPDATE tb_sag SET cod_objetivo = ".$this->cod_objetivo.", ";
        $sql .= " cod_objetivo_ppa = ".$this->cod_objetivo_ppa.", cod_programa_trabalho = ".$this->cod_programa_trabalho.", ";
        $sql .= " nr_etapa_trabalho = ".$this->nr_etapa_trabalho.", txt_etapa_trabalho = '".trim($this->txt_etapa_trabalho)."', ";
        $sql .= " cod_produto_etapa = ".$this->cod_produto_etapa.", nr_meta = ".$this->nr_meta.", ";
        $sql .= " cod_orgao = ".$this->cod_orgao.", cod_inicio_previsto = ".$this->cod_inicio_previsto.", ";
        $sql .= " cod_fim_previsto = ".$this->cod_fim_previsto.", cod_parceiro = ".$this->cod_parceiro.", ";
        $sql .= " cod_modulo = ".$this->cod_modulo." , dt_alteracao = ".$this->dt_alteracao.  ", ";        
        $sql .= " cod_unidade_medida = ".$this->cod_unidade_medida.", cod_obra = ".$this->cod_obra.", ";
        $sql .= " cod_acumulativo = ".$this->cod_acumulativo.", nr_meta_1 = ".$this->nr_meta_1.", nr_meta_2 = ".$this->nr_meta_2.", ";
        $sql .= " nr_meta_3 = ".$this->nr_meta_3.", nr_meta_4 = ".$this->nr_meta_4.", nr_meta_5 = ".$this->nr_meta_5.", nr_meta_6 = ".$this->nr_meta_6;
        $sql .= " WHERE cod_sag = ".$this->cod_sag;            
        pg_query($sql);         

        Auditoria(110, "", $sql);
    }

    public function ExcluirSAG() {
        $rs=pg_fetch_array(pg_query("SELECT txt_etapa_trabalho FROM tb_sag WHERE cod_sag = ".$this->cod_sag)); 

        $sql = "DELETE FROM tb_sag WHERE cod_sag = ".$this->cod_sag;
        pg_query($sql);  

        Auditoria(112, "EXCLUIR SAG: ".$rs['txt_etapa_trabalho'], $sql);
    }

    public function IncluirAnalise() {        
        if (empty($this->txt_percentual) && strval($this->txt_percentual) != '0') {
            $this->txt_percentual = 'NULL';
        }
        if (empty($this->nr_mes_1) && strval($this->nr_mes_1) != '0') {           
            $this->nr_mes_1 = 'NULL';
        }
        if (empty($this->nr_mes_2) && strval($this->nr_mes_2) != '0') {
            $this->nr_mes_2 = 'NULL';
        }
        if (empty($this->cod_situacao)) {
            $this->cod_situacao = 'NULL';
        }
        if (empty($this->cod_controle)) {
            $this->cod_controle = 'NULL';
        }
        if (empty($this->cod_causa_desvio)) {
            $this->cod_causa_desvio = 'NULL';
        }
        if (empty($this->cod_natureza_desvio)) {
            $this->cod_natureza_desvio = 'NULL';
        }
        if (empty($this->cod_status)) {
            $this->cod_status = 'NULL';
        }
      
        $this->txt_analise = str_replace("'", "''", $this->txt_analise);
        $this->txt_analise_desvio = str_replace("'", "''", $this->txt_analise_desvio);
        $this->txt_analise_obra = str_replace("'", "''", $this->txt_analise_obra);
        $this->txt_realizado_2 = str_replace("'", "''", $this->txt_realizado_2);
        $this->txt_realizado_1 = str_replace("'", "''", $this->txt_realizado_1);
        
        $q1 = pg_query("SELECT * FROM tb_sag_analise WHERE cod_sag = ".$this->cod_sag. " AND cod_bimestre = ".$this->cod_bimestre);
        if (pg_num_rows($q1) > 0) {
            $q = pg_query("SELECT dt_reabrir FROM tb_sag_periodo");
            if (pg_num_rows($q) > 0) {
                $rs1 = pg_fetch_array($q);  
                if(!empty($rs1['dt_reabrir'])) {                    
                    $rs2 = pg_fetch_array($q1);                       

                    if (empty($rs2['cod_situacao'])) {
                        $cod_situacao_hist = 'NULL';
                    } else {
                        $cod_situacao_hist = $rs2['cod_situacao'];
                    }
                    if (empty($rs2['cod_controle'])) {
                        $cod_controle_hist = 'NULL';
                    } else {
                        $cod_controle_hist = $rs2['cod_controle'];
                    }
                    if (empty($rs2['cod_causa_desvio'])) {
                        $cod_causa_desvio_hist = 'NULL';
                    } else {
                        $cod_causa_desvio_hist = $rs2['cod_causa_desvio'];
                    }
                    if (empty($rs2['cod_natureza_desvio'])) {
                        $cod_natureza_desvio_hist = 'NULL';
                    } else {
                        $cod_natureza_desvio_hist = $rs2['cod_natureza_desvio'];
                    }
                    if (empty($rs2['cod_percentual'])) {
                        $cod_percentual_hist = 'NULL';
                    } else {
                        $cod_percentual_hist = $rs2['cod_percentual'];
                    }
                    if (empty($rs2['cod_status'])) {
                        $cod_status_hist = 'NULL';
                    } else {
                        $cod_status_hist = $rs2['cod_status'];
                    }

                    $sql = "INSERT INTO tb_sag_analise_historico(cod_sag, cod_bimestre, nr_mes_1, nr_mes_2, txt_analise, cod_situacao, cod_controle, cod_causa_desvio, ";
                    $sql .= " cod_natureza_desvio, txt_analise_desvio, txt_realizado_1, txt_realizado_2, cod_percentual, txt_analise_obra, cod_usuario, cod_status) ";
                    $sql .= " VALUES(".$rs2['cod_sag'].", ".$rs2['cod_bimestre']. ", " .$rs2['nr_mes_1'].", " .$rs2['nr_mes_2']. " ,'" .trim($rs2['txt_analise']). "', ";
                    $sql .= " ".$cod_situacao_hist.", ".$cod_controle_hist.", ".$cod_causa_desvio_hist.", ".$cod_natureza_desvio_hist.", '".trim($rs2['txt_analise_desvio'])."', ";
                    $sql .= " '".trim($rs2['txt_realizado_1'])."', '".trim($rs2['txt_realizado_2'])."', ".$cod_percentual_hist.", '".trim($rs2['txt_analise_obra'])."', ".$rs2['cod_usuario'].", ".$cod_status_hist.")";                    
                    pg_query($sql);  
                    
                    Auditoria(126, "", $sql);
                }
            }

            $sql = "UPDATE tb_sag_analise SET nr_mes_1 = ".$this->nr_mes_1.", nr_mes_2 = ".$this->nr_mes_2.", txt_analise = '".trim($this->txt_analise)."', ";
            $sql .= " cod_situacao = ".$this->cod_situacao.", cod_controle = ".$this->cod_controle.", cod_causa_desvio = " .$this->cod_causa_desvio.", ";
            $sql .= " cod_natureza_desvio = " .$this->cod_natureza_desvio.", txt_analise_desvio = '".trim($this->txt_analise_desvio)."', ";
            $sql .= " txt_realizado_1 = '".trim($this->txt_realizado_1)."', txt_realizado_2 = '".trim($this->txt_realizado_2)."', ";
            $sql .= " cod_percentual = ".$this->txt_percentual.", txt_analise_obra = '".trim($this->txt_analise_obra)."', cod_status = ".$this->cod_status.", ";
            $sql .= " cod_usuario = ".$_SESSION['cod_usuario']." WHERE cod_sag = ".$this->cod_sag. " AND cod_bimestre = ".$this->cod_bimestre;            
            pg_query($sql);

            Auditoria(114, "", $sql);
        }
        else {            
            $sql = "INSERT INTO tb_sag_analise(cod_sag, cod_bimestre, nr_mes_1, nr_mes_2, txt_analise, cod_situacao, cod_controle, cod_causa_desvio, ";
            $sql .= " cod_natureza_desvio, txt_analise_desvio, txt_realizado_1, txt_realizado_2, cod_percentual, txt_analise_obra, cod_usuario, cod_status) ";
            $sql .= " VALUES(".$this->cod_sag.", ".$this->cod_bimestre. ", " .$this->nr_mes_1.", " .$this->nr_mes_2. " ,'" .trim($this->txt_analise). "', ";
            $sql .= " ".$this->cod_situacao.", ".$this->cod_controle.", ".$this->cod_causa_desvio.", ".$this->cod_natureza_desvio.", '".trim($this->txt_analise_desvio)."', ";
            $sql .= " '".trim($this->txt_realizado_1)."', '".trim($this->txt_realizado_2)."', ".$this->txt_percentual.", '".trim($this->txt_analise_obra)."', ".$_SESSION['cod_usuario'].", ".$this->cod_status.")";
            pg_query($sql); 

            Auditoria(113, "", $sql);
        }
        
        if (empty($this->cod_inicio_efetivo)) {
            $this->cod_inicio_efetivo = 'NULL';
        }
        if (empty($this->cod_fim_efetivo)) {
            $this->cod_fim_efetivo = 'NULL';
        }

        $sql = "UPDATE tb_sag SET cod_inicio_efetivo = ".$this->cod_inicio_efetivo.", cod_fim_efetivo = ".$this->cod_fim_efetivo;
        $sql .= " WHERE cod_sag = ".$this->cod_sag;         
        pg_query($sql);
    }

    public function ExcluirAnalise() {
        $sql = "DELETE FROM tb_sag_analise WHERE cod_sag = ".$this->cod_sag. " AND cod_bimestre = ".$this->cod_bimestre;
        pg_query($sql);

        Auditoria(115, "", $sql);
    }

    public function CompletarCadastro() {
        $sql = "UPDATE tb_sag SET cod_inicio_efetivo = ".$this->cod_inicio_efetivo.", cod_fim_efetivo = ".$this->cod_fim_efetivo."";
        $sql .= " WHERE cod_sag = ".$this->cod_sag;            
        pg_query($sql);
    }

    public function SituacaoAnalise($variacao) {
        $variacao = trim(str_replace(".", "", $variacao));
        $variacao = trim(str_replace(",", ".", $variacao));        
        $retorno = floatval($variacao);

        if ($retorno < -40 && $retorno > -50) {
            //ALERTA
            $retorno = 16;
        }
        elseif($retorno <= -50) {
            //CRÍTICO
            $retorno = 18;
        }
        elseif($retorno >= -40) {
            //NORMAL
            $retorno = 9;
        }

        return $retorno;
    }

    public function ListaPeriodo() {
        $sql = "SELECT * FROM tb_sag_periodo ORDER BY dt_inclusao DESC";
        $q = pg_query($sql);
        return $q; 
    }

    public function RegraPeriodo() {
        $retorno = true;
        
        $clsSag = new clsSag();
        $q2 = $clsSag->ListaPeriodo();        
        if (pg_num_rows($q2) > 0) {
            $rs = pg_fetch_array($q2);

            if (strtotime("now") > strtotime($rs['dt_fim']) || strtotime("now") < strtotime($rs['dt_inicio'])) {
                $retorno = false;
            }    
            
            if (!empty($rs['dt_reabrir'])) {
                $retorno = true;
            }
        } 

        return $retorno;
    }

    public function IncluirPeriodoAtualizacao($dt_inicio, $dt_fim) {
        $rs=pg_fetch_array(pg_query("SELECT MAX(cod_chave) FROM tb_sag_periodo"));
        if (!isset($rs[0])) {
            $id = 1;
        } else {
            $id = intval($rs[0]) + 1;
        }


        $sql = "INSERT INTO tb_sag_periodo(cod_chave, dt_inicio, dt_fim, cod_usuario) ";
        $sql .= " VALUES(".$id.", '".trim(DataBanco($dt_inicio))."', '".trim(DataBanco($dt_fim))."', ".$_SESSION['cod_usuario'].")";        
        pg_query($sql);

        Auditoria(121, "", $sql);
    }

    public function AlterarPeriodoAtualizacao($id, $dt_inicio, $dt_fim) {
        $sql = "UPDATE tb_sag_periodo SET dt_inicio = '".trim(DataBanco($dt_inicio))."', ";
        $sql .= " dt_fim = '".trim(DataBanco($dt_fim))."', cod_usuario = ".$_SESSION['cod_usuario'];
        $sql .= " WHERE cod_chave = ".$id;
        pg_query($sql);

        Auditoria(122, "", $sql);
    }

    public function ExcluirPeriodoAtualizacao($id) {
        $sql = "DELETE FROM tb_sag_periodo WHERE cod_chave = ".$id;
        pg_query($sql);

        Auditoria(123, "", $sql);
    }

    public function EncerrarPeriodoAtualizacao($id) {
        $sql = "UPDATE tb_sag_periodo SET dt_reabrir = NULL, cod_usuario_reabrir = NULL WHERE cod_chave = ".$id;        
        pg_query($sql);

        Auditoria(124, "", $sql);
    }

    public function ReabrirPeriodoAtualizacao($id) {
        $sql = "UPDATE tb_sag_periodo SET dt_reabrir = CURRENT_DATE, cod_usuario_reabrir = ".$_SESSION['cod_usuario'];
        $sql .= " WHERE cod_chave = ".$id;
        pg_query($sql);

        Auditoria(125, "", $sql);
    }

    public function RetornaSituacaoSAG($id) {
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
        
        $sql = "SELECT cod_status FROM tb_sag_analise WHERE cod_sag = ".$id." AND cod_bimestre IS NOT NULL ORDER BY cod_bimestre DESC";
        $q = pg_query($sql);
        
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            $retorno = $rs['cod_status'];
        }
        
        return $retorno;
    }    
}   
?>