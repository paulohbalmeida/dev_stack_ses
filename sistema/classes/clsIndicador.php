<?php
class clsIndicador{  
    public $cod_id;
    public $cod_indicador;
    public $cod_eixo;
    public $cod_perspectiva;
    public $cod_diretriz;
    public $cod_objetivo;
    public $cod_objetivo_ppa;
    public $cod_orgao; 
    public $cod_meta;
    public $cod_modulo;
    public $cod_periodo;
    public $cod_numerador;
    public $cod_denominador;
    public $cod_resultado;
    public $txt_analise;
    public $txt_analise_2;
    public $txt_encaminhamento;    
    public $txt_descricao_meta;    
    public $cod_dados_mgi;
    public $txt_monitoramento;
    public $txt_meta_monitoramento;
    public $txt_polaridade;    
    public $txt_formula;
    public $dt_extracao;
    public $txt_meta_parcial;
    public $absoluto;
    public $cod_responsavel;
    public $cod_responsavel_2;
    public $cod_regiao;
    public $cod_ra_qtd;
    public $cod_reg_qtd;
    public $cod_urd_qtd;
    public $cod_hosp_qtd;
    public $cod_hosp_qtd_conv;
    public $cod_regiao_tipo;
    public $ra_cod_numerador_regiao;
    public $ra_cod_denominador_regiao;
    public $ra_dt_extracao_regiao;
    public $reg_cod_numerador_regiao;
    public $reg_cod_denominador_regiao;
    public $reg_dt_extracao_regiao;
    public $urd_cod_numerador_regiao;
    public $urd_cod_denominador_regiao;
    public $urd_dt_extracao_regiao;
    public $hosp_cod_numerador_regiao;
    public $hosp_cod_denominador_regiao;
    public $hosp_dt_extracao_regiao;
    public $hosp_cod_numerador_regiao_conv;
    public $hosp_cod_denominador_regiao_conv;
    public $hosp_dt_extracao_regiao_conv;
    public $cod_acumulativo;

    public function ListaIndicador($id) {
        $sql = "SELECT * FROM tb_indicador WHERE cod_chave = ".$id;
        $q = pg_query($sql);
        return $q; 
    }

    function IncluirIndicador() {
        if (empty($this->cod_orgao)) {
            $this->cod_orgao = 'null';
        }
        if (empty($this->cod_regiao)) {
            $this->cod_regiao = 'null';
        }
        if (empty($this->cod_responsavel_2)) {
            $this->cod_responsavel_2 = 'null';
        }
        
        $sql = "INSERT INTO tb_indicador(cod_chave, cod_objetivo, ";
        $sql .= " cod_objetivo_ppa, cod_indicador, cod_orgao, cod_meta, txt_descricao_meta, cod_dados_mgi, txt_monitoramento, txt_formula, cod_responsavel_tecnico, cod_regiao_tipo, cod_responsavel_tecnico_2, cod_acumulativo) ";
        $sql .= " VALUES(NEXTVAL('indicador'), ";
        $sql .= " ".$this->cod_objetivo.", ".$this->cod_objetivo_ppa.", ";
        $sql .= " '".$this->cod_indicador."', ".$this->cod_orgao.", '".trim($this->cod_meta)."', '";
        $sql .= " " .trim($this->txt_descricao_meta)."', ".$this->cod_dados_mgi.", '".trim(strtolower($this->txt_monitoramento))."', '";
        $sql .= " " .trim(strtolower($this->txt_formula))."', ".$this->cod_responsavel.", ".$this->cod_regiao.", ".$this->cod_responsavel_2.", ".$this->cod_acumulativo.")";
        pg_query($sql);

        Auditoria(74, "", $sql);

        $q = pg_query("SELECT cod_chave FROM tb_indicador WHERE cod_objetivo = ".$this->cod_objetivo. " AND cod_indicador = '".$this->cod_indicador."'");
        $rs1 = pg_fetch_array($q);
        $cod_chave = $rs1['cod_chave'];

        if (!empty($this->txt_meta_monitoramento)) { 
            $txt_meta_monitoramento = str_replace("][", ";", $this->txt_meta_monitoramento);
            $txt_meta_monitoramento = str_replace("]", "", $txt_meta_monitoramento);
            $txt_meta_monitoramento = str_replace("[", "", $txt_meta_monitoramento);                
    

            switch(strtolower($this->txt_monitoramento)) {
                case 'mensal':
                    $campo = "campo_1, campo_2, campo_3, campo_4, campo_5, campo_6, campo_7, campo_8, campo_9, campo_10, campo_11, campo_12";
                    break;
                case 'bimestral':
                    $campo = "campo_6, campo_12";        
                    break;
                case 'trimestral':
                    $campo = "campo_3, campo_6, campo_9, campo_12";
                    break;
                case 'quadrimestral':
                    $campo = "campo_4, campo_8, campo_12";        
                    break;
                case 'semestral':
                    $campo = "campo_6, campo_12";        
                    break;
                default:
                    return 0;                
            }      

            $a_txt_meta_monitoramento = explode(";", $txt_meta_monitoramento);
            for ($x = 0; $x <= count($a_txt_meta_monitoramento) - 1; $x++) {                           
                $valor .= "['".$a_txt_meta_monitoramento[$x]."']";            
            }        
    
            $valor = str_replace("][", ",", $valor);
            $valor = str_replace("]", "", $valor);
            $valor = str_replace("[", "", $valor);
    
            $sql = "INSERT INTO tb_indicador_meta(cod_indicador, ".$campo.")VALUES(".$cod_chave.", ".$valor.")";        
            pg_query($sql);
        }        
    }

    function AlterarIndicador($cod_chave) {        
        if (empty($this->cod_orgao)) {
            $this->cod_orgao = 'null';
        }
        if (empty($this->cod_regiao)) {
            $this->cod_regiao = 'null';
        }
        if (empty($this->cod_responsavel_2)) {
            $this->cod_responsavel_2 = 'null';
        }

        $sql = "UPDATE tb_indicador SET cod_objetivo = ".$this->cod_objetivo. ", cod_objetivo_ppa = ".$this->cod_objetivo_ppa;
        $sql .= " , cod_indicador = '".$this->cod_indicador."', cod_orgao = ".$this->cod_orgao.", ";
        $sql .= " cod_meta = '".trim($this->cod_meta)."', txt_descricao_meta = '".trim($this->txt_descricao_meta)."', ";
        $sql .= " cod_dados_mgi = ".$this->cod_dados_mgi.", txt_monitoramento = '".trim(strtolower($this->txt_monitoramento))."', ";
        $sql .= " txt_formula = '".trim(strtolower($this->txt_formula))."', cod_responsavel_tecnico = ".$this->cod_responsavel.", ";
        $sql .= " cod_regiao_tipo = ".$this->cod_regiao.", cod_responsavel_tecnico_2 = ".$this->cod_responsavel_2.", ";
        $sql .= " cod_acumulativo = ".$this->cod_acumulativo." WHERE cod_chave = ".$cod_chave;
        pg_query($sql);  
        
        Auditoria(75, "", $sql);
        
        if (!empty($this->txt_meta_monitoramento)) {
            $txt_meta_monitoramento = str_replace("][", ";", $this->txt_meta_monitoramento);
            $txt_meta_monitoramento = str_replace("]", "", $txt_meta_monitoramento);
            $txt_meta_monitoramento = str_replace("[", "", $txt_meta_monitoramento);
    
            $sql = "DELETE FROM tb_indicador_meta WHERE cod_indicador = ".$cod_chave;
            pg_query($sql);        
    
            switch(strtolower($this->txt_monitoramento)) {
                case 'mensal':
                    $campo = "campo_1, campo_2, campo_3, campo_4, campo_5, campo_6, campo_7, campo_8, campo_9, campo_10, campo_11, campo_12";
                    break;
                case 'bimestral':
                    $campo = "campo_2, campo_4, campo_6, campo_8, campo_10, campo_12";        
                    break;
                case 'trimestral':
                    $campo = "campo_3, campo_6, campo_9, campo_12";
                    break;
                case 'quadrimestral':
                    $campo = "campo_4, campo_8, campo_12";        
                    break;
                case 'semestral':
                    $campo = "campo_6, campo_12";        
                    break;
                default:
                    return 0;                
            }            

            $a_txt_meta_monitoramento = explode(";", $txt_meta_monitoramento);            
            for ($x = 0; $x <= count($a_txt_meta_monitoramento) - 1; $x++) {                            
                $valor .= "['".$a_txt_meta_monitoramento[$x]."']";                
            }                   
    
            $valor = str_replace("][", ",", $valor);
            $valor = str_replace("]", "", $valor);
            $valor = str_replace("[", "", $valor);
    
            $sql = "INSERT INTO tb_indicador_meta(cod_indicador, ".$campo.")VALUES(".$cod_chave.", ".$valor.")";            
            pg_query($sql);
        }        
    }

    public function ExcluirIndicador() {
        $q = pg_query("SELECT cod_chave FROM tb_indicador WHERE cod_objetivo = ".$this->cod_objetivo);
        $rs1 = pg_fetch_array($q); 

        //INDICADOR REGIÃO
        $sql = "DELETE FROM tb_indicador_analise_regiao WHERE cod_chave = ".$rs1['cod_chave'];
        pg_query($sql);

        //ANÁLISE
        $sql = "DELETE FROM tb_indicador_analise WHERE cod_chave = ".$rs1['cod_chave'];
        pg_query($sql);                   

        //INDICADOR META
        $sql = "DELETE FROM tb_indicador_meta WHERE cod_indicador = ".$rs1['cod_chave'];
        pg_query($sql);                       

        //INDICADOR
        $sql = "DELETE FROM tb_indicador WHERE cod_objetivo = ".$this->cod_objetivo;       
        pg_query($sql);  

        Auditoria(76, "", $sql);
    }

    public function ExcluirIndicadorChave($cod_chave) {
        $rs=pg_fetch_array(pg_query("SELECT cod_indicador FROM tb_indicador WHERE cod_chave = ".$cod_chave));

        //ANÁLISE
        $sql = "DELETE FROM tb_indicador_analise WHERE cod_chave = ".$cod_chave;
        pg_query($sql);       

        //INDICADOR META
        $sql = "DELETE FROM tb_indicador_meta WHERE cod_indicador = ".$cod_chave;
        pg_query($sql);

        //INDICADOR
        $sql = "DELETE FROM tb_indicador WHERE cod_chave = ".$cod_chave;       
        pg_query($sql);         
        
        Auditoria(76, "EXCLUIR INDICADOR: ".$rs['cod_indicador'], $sql);
    }

    function ConsultaIndicadorPorChave($chave) {
        $q = pg_query("SELECT cod_indicador FROM tb_indicador WHERE cod_chave = ".$chave);
        $rs1 = pg_fetch_array($q);        
        return $rs1['cod_indicador'];
    }   
    
    function IndicadorVinculado($cod_indicador) {
        $q = pg_query("SELECT cod_indicador FROM tb_indicador WHERE cod_indicador = '".$cod_indicador."'");
        if (pg_num_rows($q) > 0) {
            return true;
        }
        else {
            return false;
        }
    }   

    function IndicadorVinculado_2($cod_indicador, $cod_chave) {
        $q = pg_query("SELECT cod_indicador FROM tb_indicador WHERE cod_indicador = '".$cod_indicador."' AND cod_chave <> ".$cod_chave );
        if (pg_num_rows($q) > 0) {
            return true;
        }
        else {
            return false;
        }
    }   

    function ListaIndicadores() {
        $url = $_SESSION["url_api_mgi"]."/api/indicador";
        return json_decode(file_get_contents($url));
    }    
    
    function VerificaIndicadorAtivo($id) {
        $url = $_SESSION["url_api_mgi"]."/api/indicador/".$id;
        $retorno_array = json_decode(file_get_contents($url));        
        if ($retorno_array->ativo == 1) {
            return true;
        } else {
            return false;
        }        
    }

    function ConsultaIndicador($id) {
        $url = $_SESSION["url_api_mgi"]."/api/indicador/".$id;       
        $retorno_array = json_decode(file_get_contents($url));
        return json_decode(file_get_contents($url));
    }          

    function ConsultaFonte($cod) {
        if (!empty($cod)) {
            $url = $_SESSION["url_api_mgi"]."/api/fonte-parametro/".$cod; 
            $retorno_array = json_decode(file_get_contents($url));        
            return $retorno_array->sigla;      
        } else {
            return "";
        }        

    }

    function ConsultaUnidadeMedida($codigo) {
        $url = $_SESSION["url_api_mgi"]."/api/unidade-medida/".$codigo;
        $retorno_array = json_decode(file_get_contents($url));        
        return $retorno_array->descricao; 
    }

    function ConsultaPolaridade($codigo) {        
        $url = $_SESSION["url_api_mgi"]."/api/polaridade";
        $retorno_array = json_decode(file_get_contents($url));        
        foreach ($retorno_array->polaridades as $valor) {
            if ($valor->codigo == $codigo) {
                return $valor->descricao;
            }
        }        
    }    

    function IncluirDetalhe() {
        $q1 = pg_query("SELECT * FROM tb_indicador_detalhe WHERE cod_chave = ".$this->cod_id." AND cod_periodo = ".$this->cod_periodo);
        if (pg_num_rows($q1) > 0) {
            $sql = "UPDATE tb_indicador_detalhe SET cod_numerador = " .$this->cod_numerador.", cod_denominador = ".$this->cod_denominador;            
            $sql .= " , cod_resultado = ".$this->cod_resultado." WHERE cod_chave = ".$this->cod_id. " AND cod_periodo = ".$this->cod_periodo;
            pg_query($sql);
        }
        else {
            $sql = "INSERT INTO tb_indicador_detalhe(cod_chave, cod_periodo, cod_numerador, cod_denominador, cod_resultado) ";
            $sql .= " VALUES(".$this->cod_id.", ".$this->cod_periodo.", ".$this->cod_numerador.", ".$this->cod_denominador.", ".$this->cod_resultado.")";
            pg_query($sql); 
        }         
    }

    public function ExcluirDetalhe() {
        $sql = "DELETE FROM tb_indicador_detalhe WHERE cod_chave = ".$this->cod_id. " AND cod_periodo = ".$this->cod_periodo;
        pg_query($sql);
    }

    public function SituacaoAnalise($polaridade, $meta, $resultado, $variacao) {
        //$meta = trim(str_replace(".", "", $meta));
        //$meta = trim(str_replace(",", ".", $meta));

        //$resultado = trim(str_replace(".", "", $resultado));            
        //$resultado = trim(str_replace(",", ".", $resultado));            

        //$retorno = (($resultado * 100) / $meta);
        //$retorno = number_format($retorno, 2, '.', '');

        $variacao = trim(str_replace(".", "", $variacao));
        $variacao = trim(str_replace(",", ".", $variacao));        
        $retorno = floatval($variacao);

        //echo($retorno);
        //exit();
        if(trim(strtolower($polaridade)) == 'maior - melhor') {                        
            if ($retorno > 0) {
                //SUPERADO
                $retorno = 20;
            }
            elseif($retorno > -5 && $retorno <= 0) {
                //ESPERADO
                $retorno = 19;
            }
            elseif($retorno > -25 && $retorno <= -5) {
                //ALERTA
                $retorno = 16;
            }
            elseif($retorno >-50 && $retorno <= -25) { 
                //CRÍTICO
                $retorno = 18;
            }
            elseif($retorno <= -50) { 
                //MUITO CRÍTICO
                $retorno = 17;
            }
            else {
                $retorno = "";
            }
        }
        else {                                    
            if ($retorno < 0) {
                //SUPERADO
                $retorno = 20;
            }
            elseif($retorno >= 0 && $retorno < 5) {
                //ESPERADO
                $retorno = 19;
            }
            elseif($retorno >= 5 && $retorno < 25) {
                //ALERTA
                $retorno = 16;
            }
            elseif($retorno >= 25 && $retorno < 50) { 
                //CRÍTICO
                $retorno = 18;
            }
            elseif($retorno >= 50) { 
                //MUITO CRÍTICO
                $retorno = 17;
            }
            else {
                $retorno = "";
            }
        }        

        return $retorno;
    }    

    function CalcularResultado($id, $cod_numerador, $cod_denominador) {        
        if (!empty($id) && !empty($cod_numerador) && !empty($cod_denominador)) {                    
            $rs1 = pg_fetch_array(self::ListaIndicador($id));
            if (!empty($rs1['txt_formula'])) {                
                $cod_numerador = str_replace(".", "", (string)$cod_numerador);
                $cod_numerador = str_replace(",", ".", (string)$cod_numerador); 
                     
                $cod_denominador = str_replace(".", "", (string)$cod_denominador);
                $cod_denominador = str_replace(",", ".", (string)$cod_denominador);

                $txt_formula = strtolower($rs1['txt_formula']);                                

                $txt_formula = str_replace("n", (string)$cod_numerador, $txt_formula);
                $txt_formula = str_replace("d", (string)$cod_denominador, $txt_formula);                  
                
                $txt_resultado = eval('return '.$txt_formula.';'); 
                $txt_resultado = @number_format($txt_resultado, 2, ',', '.');                
                
                return $txt_resultado;
            } else {
                return "0";
            }            
        } else {
            return "0";
        }           
    }

    public function VariacaoMeta($meta, $resultado) {              
        $meta = trim(str_replace(".", "", $meta));
        $meta = trim(str_replace(",", ".", $meta));

        $resultado = trim(str_replace(".", "", $resultado));        
        $resultado = trim(str_replace(",", ".", $resultado));        

        $retorno = ($resultado / $meta - 1) * 100;       
        $retorno = @number_format($retorno, 2, ',', '.');
        
        return $retorno;
    }

    public function IncluirAnalise() {       
        if (!empty($this->txt_polaridade)) {             
            $clsIndicador = new clsIndicador();
            if($this->absoluto != 'SIM') {
                $cod_resultado = $clsIndicador->CalcularResultado($this->cod_id, trim($this->cod_numerador), trim($this->cod_denominador));
            }            
            else {
                $cod_resultado = trim($this->cod_numerador);
            }            
            if(!empty($this->txt_meta_parcial)) {
                $txt_meta_parcial = $this->txt_meta_parcial;
            } else {
                $q = pg_query("SELECT * FROM tb_indicador_meta WHERE cod_indicador = ".$this->cod_id);
                if (pg_num_rows($q) > 0) {
                    $rs1 = pg_fetch_array($q);
                    $c = $this->cod_periodo;
                    
                    while ($c <= 12){                                       
                        if(!empty($rs1['campo_'.intval($c)])) {    
                            $txt_meta_parcial = strval($rs1['campo_'.intval($c)]);    
                            break;
                        }
                                                
                        $c = $c + 1;                   
                    }                                                              
                }            
            }           
            
            $txt_variacao = $clsIndicador->VariacaoMeta($txt_meta_parcial, $cod_resultado);         
            $cod_status = $clsIndicador->SituacaoAnalise($this->txt_polaridade, $txt_meta_parcial, $cod_resultado, $txt_variacao);   
        }                     

        if (empty($cod_status)) {
            $cod_status = 'NULL';
        }

        $this->txt_analise = str_replace("'", "''", $this->txt_analise);
        $this->txt_analise_2 = str_replace("'", "''", $this->txt_analise_2);

        $q1 = pg_query("SELECT * FROM tb_indicador_analise WHERE cod_chave = ".$this->cod_id." AND cod_periodo = ".$this->cod_periodo);
        if (pg_num_rows($q1) > 0) {            
            $q = pg_query("SELECT dt_reabrir FROM tb_indicador_periodo");
            if (pg_num_rows($q) > 0) {
                $rs1 = pg_fetch_array($q);  
                
                if(!empty($rs1['dt_reabrir'])) {                    
                    $rs2 = pg_fetch_array($q1);   

                    $sql = "INSERT INTO tb_indicador_analise_historico(cod_chave, cod_periodo, txt_analise, txt_encaminhamento, ";
                    $sql .= " cod_usuario, cod_numerador, cod_denominador, cod_resultado, cod_status, dt_extracao, txt_variacao, txt_analise_2) ";
                    $sql .= " VALUES(".$this->cod_id.", ".$this->cod_periodo.", '".trim($rs2['txt_analise'])."', ";
                    $sql .= " '".trim($rs2['txt_encaminhamento'])."', ".$rs2["cod_usuario"].", '".trim($rs2['cod_numerador'])."', ";
                    $sql .= " '".trim($rs2['cod_denominador'])."', '".trim($rs2['cod_resultado'])."', ".$rs2['cod_status'].", '".trim($rs2['dt_extracao'])."', ";
                    $sql .= " '".trim($rs2['txt_variacao'])."', '".trim($rs2['txt_analise_2'])."')";                      
                    pg_query($sql);  
                    
                    Auditoria(82, "", $sql);
                }                
            }            

            $sql = "UPDATE tb_indicador_analise SET txt_analise = '" .trim($this->txt_analise)."', txt_encaminhamento = '".trim($this->txt_encaminhamento)."', ";
            $sql .= " cod_usuario = ".$_SESSION["cod_usuario"].", cod_status = ".$cod_status.", ";
            $sql .= " cod_numerador = '".trim($this->cod_numerador)."', cod_denominador = '".trim($this->cod_denominador)."', ";
            $sql .= " cod_resultado = '".trim($cod_resultado)."', dt_extracao = '".trim(DataBanco($this->dt_extracao))."', ";
            $sql .= "  txt_variacao = '".$txt_variacao."', txt_analise_2 = '" .trim($this->txt_analise_2)."' ";
            $sql .= " WHERE cod_chave = ".$this->cod_id. " AND cod_periodo = ".$this->cod_periodo;        
            pg_query($sql);
            
            Auditoria(81, "", $sql);
        }
        else {                        
            $sql = "INSERT INTO tb_indicador_analise(cod_chave, cod_periodo, txt_analise, txt_encaminhamento, ";
            $sql .= " cod_usuario, cod_numerador, cod_denominador, cod_resultado, cod_status, dt_extracao, txt_variacao, txt_analise_2) ";
            $sql .= " VALUES(".$this->cod_id.", ".$this->cod_periodo.", '".trim($this->txt_analise)."', ";
            $sql .= " '".trim($this->txt_encaminhamento)."', ".$_SESSION["cod_usuario"].", '".trim($this->cod_numerador)."', ";
            $sql .= " '".trim($this->cod_denominador)."', '".trim($cod_resultado)."', ".$cod_status.", '".trim(DataBanco($this->dt_extracao))."', ";
            $sql .= " '".trim($txt_variacao)."', '".trim($this->txt_analise_2)."')";            
            pg_query($sql); 
            
            Auditoria(80, "", $sql);
        }

        //ANÁLISE REGIÃO
        if (limpar_comparacao($this->cod_regiao_tipo) == 3) {
            //RA
            if (!empty($this->ra_cod_numerador_regiao) && !empty($this->ra_dt_extracao_regiao)) {
                pg_query("DELETE FROM tb_indicador_analise_regiao WHERE cod_chave = ".$this->cod_id." AND cod_periodo = ".$this->cod_periodo." AND cod_regiao_tipo = ".$this->cod_regiao_tipo);
            
                $this->ra_cod_numerador_regiao = str_replace('][', '@', $this->ra_cod_numerador_regiao);
                $this->ra_cod_numerador_regiao = str_replace(']', '', $this->ra_cod_numerador_regiao);
                $this->ra_cod_numerador_regiao = str_replace('[', '', $this->ra_cod_numerador_regiao);
                $a_ra_cod_numerador_regiao = explode("@", trim($this->ra_cod_numerador_regiao));
    
    
                $this->ra_cod_denominador_regiao = str_replace('][', '@', $this->ra_cod_denominador_regiao);
                $this->ra_cod_denominador_regiao = str_replace(']', '', $this->ra_cod_denominador_regiao);
                $this->ra_cod_denominador_regiao = str_replace('[', '', $this->ra_cod_denominador_regiao);
                $a_ra_cod_denominador_regiao = explode("@", trim($this->ra_cod_denominador_regiao));
    
                $this->ra_dt_extracao_regiao = str_replace('][', '@', $this->ra_dt_extracao_regiao);
                $this->ra_dt_extracao_regiao = str_replace(']', '', $this->ra_dt_extracao_regiao);
                $this->ra_dt_extracao_regiao = str_replace('[', '', $this->ra_dt_extracao_regiao);
                $a_ra_dt_extracao_regiao = explode("@", trim($this->ra_dt_extracao_regiao));                    
                
                for ($x = 0; $x <= count($a_ra_cod_numerador_regiao) - 1; $x++) {                           
                    $n = explode("_", trim($a_ra_cod_numerador_regiao[$x]));
                    $d = explode("_", trim($a_ra_cod_denominador_regiao[$x]));
                    $e = explode("_", trim($a_ra_dt_extracao_regiao[$x]));
    
                    if (!empty($this->txt_polaridade)) { 
                        $clsIndicador = new clsIndicador();
                        if($this->absoluto != 'SIM') {
                            $cod_resultado = $clsIndicador->CalcularResultado($this->cod_id, trim($n[1]), trim($d[1]));
                        }            
                        else {
                            $cod_resultado = trim($n[1]);
                        }   
                    } else {
                        $cod_resultado = 0;
                    }
    
                    $sql = "INSERT INTO tb_indicador_analise_regiao(cod_chave, cod_periodo, cod_numerador, cod_denominador, cod_resultado, cod_usuario, dt_extracao, cod_regiao_tipo, cod_ra) ";
                    $sql .= " VALUES(".$this->cod_id.", ".$this->cod_periodo.", '".trim($n[1])."', '".trim($d[1])."', '".trim($cod_resultado)."', ".$_SESSION["cod_usuario"].", '".DataBanco(trim($e[1]))."', ".$this->cod_regiao_tipo.", ".$n[0].")";               
                    pg_query($sql);                               
                }  
            }             
        } 
        else if (limpar_comparacao($this->cod_regiao_tipo) == 1) {
            //Região de Saúde/URD

            if (!empty($this->reg_cod_numerador_regiao) && !empty($this->reg_dt_extracao_regiao)) {
                pg_query("DELETE FROM tb_indicador_analise_regiao WHERE cod_chave = ".$this->cod_id." AND cod_periodo = ".$this->cod_periodo." AND cod_regiao_tipo = ".$this->cod_regiao_tipo);
            }   
            
            if (!empty($this->urd_cod_numerador_regiao) && !empty($this->urd_dt_extracao_regiao)) {
                pg_query("DELETE FROM tb_indicador_analise_regiao WHERE cod_chave = ".$this->cod_id." AND cod_periodo = ".$this->cod_periodo." AND cod_regiao_tipo = ".$this->cod_regiao_tipo);
            }  

            if (!empty($this->reg_cod_numerador_regiao)) {                

                $this->reg_cod_numerador_regiao = str_replace('][', '@', $this->reg_cod_numerador_regiao);
                $this->reg_cod_numerador_regiao = str_replace(']', '', $this->reg_cod_numerador_regiao);
                $this->reg_cod_numerador_regiao = str_replace('[', '', $this->reg_cod_numerador_regiao);
                $a_reg_cod_numerador_regiao = explode("@", trim($this->reg_cod_numerador_regiao));


                $this->reg_cod_denominador_regiao = str_replace('][', '@', $this->reg_cod_denominador_regiao);
                $this->reg_cod_denominador_regiao = str_replace(']', '', $this->reg_cod_denominador_regiao);
                $this->reg_cod_denominador_regiao = str_replace('[', '', $this->reg_cod_denominador_regiao);
                $a_reg_cod_denominador_regiao = explode("@", trim($this->reg_cod_denominador_regiao));

                $this->reg_dt_extracao_regiao = str_replace('][', '@', $this->reg_dt_extracao_regiao);
                $this->reg_dt_extracao_regiao = str_replace(']', '', $this->reg_dt_extracao_regiao);
                $this->reg_dt_extracao_regiao = str_replace('[', '', $this->reg_dt_extracao_regiao);
                $a_reg_dt_extracao_regiao = explode("@", trim($this->reg_dt_extracao_regiao));

                for ($x = 0; $x <= count($a_reg_cod_numerador_regiao) - 1; $x++) {                           
                    $n = explode("_", trim($a_reg_cod_numerador_regiao[$x]));
                    $d = explode("_", trim($a_reg_cod_denominador_regiao[$x]));
                    $e = explode("_", trim($a_reg_dt_extracao_regiao[$x]));
                
                    if (!empty($this->txt_polaridade)) { 
                        $clsIndicador = new clsIndicador();
                        if($this->absoluto != 'SIM') {
                            $cod_resultado = $clsIndicador->CalcularResultado($this->cod_id, trim($n[1]), trim($d[1]));
                        }            
                        else {
                            $cod_resultado = trim($n[1]);
                        }   
                    } else {
                        $cod_resultado = 0;
                    }
                
                    $sql = "INSERT INTO tb_indicador_analise_regiao(cod_chave, cod_periodo, cod_numerador, cod_denominador, cod_resultado, cod_usuario, dt_extracao, cod_regiao_tipo, cod_reg) ";
                    $sql .= " VALUES(".$this->cod_id.", ".$this->cod_periodo.", '".trim($n[1])."', '".trim($d[1])."', '".trim($cod_resultado)."', ".$_SESSION["cod_usuario"].", '".DataBanco(trim($e[1]))."', ".$this->cod_regiao_tipo.", ".$n[0].")";                                   
                    pg_query($sql);                               
                }
            }
            if (!empty($this->urd_cod_numerador_regiao) && !empty($this->urd_dt_extracao_regiao)) {                                

                $this->urd_cod_numerador_regiao = str_replace('][', '@', $this->urd_cod_numerador_regiao);
                $this->urd_cod_numerador_regiao = str_replace(']', '', $this->urd_cod_numerador_regiao);
                $this->urd_cod_numerador_regiao = str_replace('[', '', $this->urd_cod_numerador_regiao);
                $a_urd_cod_numerador_regiao = explode("@", trim($this->urd_cod_numerador_regiao));
                
                
                $this->urd_cod_denominador_regiao = str_replace('][', '@', $this->urd_cod_denominador_regiao);
                $this->urd_cod_denominador_regiao = str_replace(']', '', $this->urd_cod_denominador_regiao);
                $this->urd_cod_denominador_regiao = str_replace('[', '', $this->urd_cod_denominador_regiao);
                $a_urd_cod_denominador_regiao = explode("@", trim($this->urd_cod_denominador_regiao));
                
                $this->urd_dt_extracao_regiao = str_replace('][', '@', $this->urd_dt_extracao_regiao);
                $this->urd_dt_extracao_regiao = str_replace(']', '', $this->urd_dt_extracao_regiao);
                $this->urd_dt_extracao_regiao = str_replace('[', '', $this->urd_dt_extracao_regiao);
                $a_urd_dt_extracao_regiao = explode("@", trim($this->urd_dt_extracao_regiao));
                
                for ($x = 0; $x <= count($a_urd_cod_numerador_regiao) - 1; $x++) {                           
                    $n = explode("_", trim($a_urd_cod_numerador_regiao[$x]));
                    $d = explode("_", trim($a_urd_cod_denominador_regiao[$x]));
                    $e = explode("_", trim($a_urd_dt_extracao_regiao[$x]));
                
                    if (!empty($this->txt_polaridade)) { 
                        $clsIndicador = new clsIndicador();
                        if($this->absoluto != 'SIM') {
                            $cod_resultado = $clsIndicador->CalcularResultado($this->cod_id, trim($n[1]), trim($d[1]));
                        }            
                        else {
                            $cod_resultado = trim($n[1]);
                        }   
                    } else {
                        $cod_resultado = 0;
                    }
                
                    $sql = "INSERT INTO tb_indicador_analise_regiao(cod_chave, cod_periodo, cod_numerador, cod_denominador, cod_resultado, cod_usuario, dt_extracao, cod_regiao_tipo, cod_urd) ";
                    $sql .= " VALUES(".$this->cod_id.", ".$this->cod_periodo.", '".trim($n[1])."', '".trim($d[1])."', '".trim($cod_resultado)."', ".$_SESSION["cod_usuario"].", '".DataBanco(trim($e[1]))."', ".$this->cod_regiao_tipo.", ".$n[0].")";                                   
                    pg_query($sql);                               
                }
            }
        }
        else if (limpar_comparacao($this->cod_regiao_tipo) == 4) {
            //Região de Saúde

            if (!empty($this->reg_cod_numerador_regiao) && !empty($this->reg_dt_extracao_regiao)) {
                pg_query("DELETE FROM tb_indicador_analise_regiao WHERE cod_chave = ".$this->cod_id." AND cod_periodo = ".$this->cod_periodo." AND cod_regiao_tipo = ".$this->cod_regiao_tipo);
            }   
                        
            if (!empty($this->reg_cod_numerador_regiao)) {                

                $this->reg_cod_numerador_regiao = str_replace('][', '@', $this->reg_cod_numerador_regiao);
                $this->reg_cod_numerador_regiao = str_replace(']', '', $this->reg_cod_numerador_regiao);
                $this->reg_cod_numerador_regiao = str_replace('[', '', $this->reg_cod_numerador_regiao);
                $a_reg_cod_numerador_regiao = explode("@", trim($this->reg_cod_numerador_regiao));


                $this->reg_cod_denominador_regiao = str_replace('][', '@', $this->reg_cod_denominador_regiao);
                $this->reg_cod_denominador_regiao = str_replace(']', '', $this->reg_cod_denominador_regiao);
                $this->reg_cod_denominador_regiao = str_replace('[', '', $this->reg_cod_denominador_regiao);
                $a_reg_cod_denominador_regiao = explode("@", trim($this->reg_cod_denominador_regiao));

                $this->reg_dt_extracao_regiao = str_replace('][', '@', $this->reg_dt_extracao_regiao);
                $this->reg_dt_extracao_regiao = str_replace(']', '', $this->reg_dt_extracao_regiao);
                $this->reg_dt_extracao_regiao = str_replace('[', '', $this->reg_dt_extracao_regiao);
                $a_reg_dt_extracao_regiao = explode("@", trim($this->reg_dt_extracao_regiao));

                for ($x = 0; $x <= count($a_reg_cod_numerador_regiao) - 1; $x++) {                           
                    $n = explode("_", trim($a_reg_cod_numerador_regiao[$x]));
                    $d = explode("_", trim($a_reg_cod_denominador_regiao[$x]));
                    $e = explode("_", trim($a_reg_dt_extracao_regiao[$x]));
                
                    if (!empty($this->txt_polaridade)) { 
                        $clsIndicador = new clsIndicador();
                        if($this->absoluto != 'SIM') {
                            $cod_resultado = $clsIndicador->CalcularResultado($this->cod_id, trim($n[1]), trim($d[1]));
                        }            
                        else {
                            $cod_resultado = trim($n[1]);
                        }   
                    } else {
                        $cod_resultado = 0;
                    }
                
                    $sql = "INSERT INTO tb_indicador_analise_regiao(cod_chave, cod_periodo, cod_numerador, cod_denominador, cod_resultado, cod_usuario, dt_extracao, cod_regiao_tipo, cod_reg) ";
                    $sql .= " VALUES(".$this->cod_id.", ".$this->cod_periodo.", '".trim($n[1])."', '".trim($d[1])."', '".trim($cod_resultado)."', ".$_SESSION["cod_usuario"].", '".DataBanco(trim($e[1]))."', ".$this->cod_regiao_tipo.", ".$n[0].")";                                   
                    pg_query($sql);                               
                }
            }            
        }
        else if (limpar_comparacao($this->cod_regiao_tipo) == 5) {
            //Hospitais/Hospitais Conveniados
            if (!empty($this->hosp_cod_numerador_regiao) || !empty($this->hosp_cod_numerador_regiao_conv)) {
                pg_query("DELETE FROM tb_indicador_analise_regiao WHERE cod_chave = ".$this->cod_id." AND cod_periodo = ".$this->cod_periodo." AND cod_regiao_tipo = ".$this->cod_regiao_tipo);
            }  

            if (!empty($this->hosp_cod_numerador_regiao) && !empty($this->hosp_dt_extracao_regiao)) {                

                $this->hosp_cod_numerador_regiao = str_replace('][', '@', $this->hosp_cod_numerador_regiao);
                $this->hosp_cod_numerador_regiao = str_replace(']', '', $this->hosp_cod_numerador_regiao);
                $this->hosp_cod_numerador_regiao = str_replace('[', '', $this->hosp_cod_numerador_regiao);
                $a_hosp_cod_numerador_regiao = explode("@", trim($this->hosp_cod_numerador_regiao));
                
                
                $this->hosp_cod_denominador_regiao = str_replace('][', '@', $this->hosp_cod_denominador_regiao);
                $this->hosp_cod_denominador_regiao = str_replace(']', '', $this->hosp_cod_denominador_regiao);
                $this->hosp_cod_denominador_regiao = str_replace('[', '', $this->hosp_cod_denominador_regiao);
                $a_hosp_cod_denominador_regiao = explode("@", trim($this->hosp_cod_denominador_regiao));
                
                $this->hosp_dt_extracao_regiao = str_replace('][', '@', $this->hosp_dt_extracao_regiao);
                $this->hosp_dt_extracao_regiao = str_replace(']', '', $this->hosp_dt_extracao_regiao);
                $this->hosp_dt_extracao_regiao = str_replace('[', '', $this->hosp_dt_extracao_regiao);
                $a_hosp_dt_extracao_regiao = explode("@", trim($this->hosp_dt_extracao_regiao));
                
                for ($x = 0; $x <= count($a_hosp_cod_numerador_regiao) - 1; $x++) {                           
                    $n = explode("_", trim($a_hosp_cod_numerador_regiao[$x]));
                    $d = explode("_", trim($a_hosp_cod_denominador_regiao[$x]));
                    $e = explode("_", trim($a_hosp_dt_extracao_regiao[$x]));                               

                    if (!empty($this->txt_polaridade)) { 
                        $clsIndicador = new clsIndicador();
                        if($this->absoluto != 'SIM') {
                            $cod_resultado = $clsIndicador->CalcularResultado($this->cod_id, trim($n[1]), trim($d[1]));                            
                        }            
                        else {
                            $cod_resultado = trim($n[1]);
                        }   
                    } else {
                        $cod_resultado = 0;
                    }
                
                    $sql = "INSERT INTO tb_indicador_analise_regiao(cod_chave, cod_periodo, cod_numerador, cod_denominador, cod_resultado, cod_usuario, dt_extracao, cod_regiao_tipo, cod_hospital) ";
                    $sql .= " VALUES(".$this->cod_id.", ".$this->cod_periodo.", '".trim($n[1])."', '".trim($d[1])."', '".trim($cod_resultado)."', ".$_SESSION["cod_usuario"].", '".DataBanco(trim($e[1]))."', ".$this->cod_regiao_tipo.", ".$n[0].")";                                       
                    pg_query($sql);                               
                }
            }

            if (!empty($this->hosp_cod_numerador_regiao_conv) && !empty($this->hosp_dt_extracao_regiao_conv)) {                

                $this->hosp_cod_numerador_regiao_conv = str_replace('][', '@', $this->hosp_cod_numerador_regiao_conv);
                $this->hosp_cod_numerador_regiao_conv = str_replace(']', '', $this->hosp_cod_numerador_regiao_conv);
                $this->hosp_cod_numerador_regiao_conv = str_replace('[', '', $this->hosp_cod_numerador_regiao_conv);
                $a_hosp_cod_numerador_regiao_conv = explode("@", trim($this->hosp_cod_numerador_regiao_conv));
                
                
                $this->hosp_cod_denominador_regiao_conv = str_replace('][', '@', $this->hosp_cod_denominador_regiao_conv);
                $this->hosp_cod_denominador_regiao_conv = str_replace(']', '', $this->hosp_cod_denominador_regiao_conv);
                $this->hosp_cod_denominador_regiao_conv = str_replace('[', '', $this->hosp_cod_denominador_regiao_conv);
                $a_hosp_cod_denominador_regiao_conv = explode("@", trim($this->hosp_cod_denominador_regiao_conv));
                
                $this->hosp_dt_extracao_regiao_conv = str_replace('][', '@', $this->hosp_dt_extracao_regiao_conv);
                $this->hosp_dt_extracao_regiao_conv = str_replace(']', '', $this->hosp_dt_extracao_regiao_conv);
                $this->hosp_dt_extracao_regiao_conv = str_replace('[', '', $this->hosp_dt_extracao_regiao_conv);
                $a_hosp_dt_extracao_regiao_conv = explode("@", trim($this->hosp_dt_extracao_regiao_conv));
                
                for ($x = 0; $x <= count($a_hosp_cod_numerador_regiao_conv) - 1; $x++) {                           
                    $n = explode("_", trim($a_hosp_cod_numerador_regiao_conv[$x]));
                    $d = explode("_", trim($a_hosp_cod_denominador_regiao_conv[$x]));
                    $e = explode("_", trim($a_hosp_dt_extracao_regiao_conv[$x]));                               

                    if (!empty($this->txt_polaridade)) { 
                        $clsIndicador = new clsIndicador();
                        if($this->absoluto != 'SIM') {
                            $cod_resultado = $clsIndicador->CalcularResultado($this->cod_id, trim($n[1]), trim($d[1]));                            
                        }            
                        else {
                            $cod_resultado = trim($n[1]);
                        }   
                    } else {
                        $cod_resultado = 0;
                    }
                
                    $sql = "INSERT INTO tb_indicador_analise_regiao(cod_chave, cod_periodo, cod_numerador, cod_denominador, cod_resultado, cod_usuario, dt_extracao, cod_regiao_tipo, cod_hospital) ";
                    $sql .= " VALUES(".$this->cod_id.", ".$this->cod_periodo.", '".trim($n[1])."', '".trim($d[1])."', '".trim($cod_resultado)."', ".$_SESSION["cod_usuario"].", '".DataBanco(trim($e[1]))."', ".$this->cod_regiao_tipo.", ".$n[0].")";                                                           
                    pg_query($sql);                               
                }
            }
        }
        else if (limpar_comparacao($this->cod_regiao_tipo) == 2) {
            //Hospitais/URD  
            if (!empty($this->urd_cod_numerador_regiao) || !empty($this->hosp_cod_numerador_regiao)) {
                pg_query("DELETE FROM tb_indicador_analise_regiao WHERE cod_chave = ".$this->cod_id." AND cod_periodo = ".$this->cod_periodo." AND cod_regiao_tipo = ".$this->cod_regiao_tipo);
            }  

            if (!empty($this->urd_cod_numerador_regiao) && !empty($this->urd_dt_extracao_regiao)) {
                pg_query("DELETE FROM tb_indicador_analise_regiao WHERE cod_chave = ".$this->cod_id." AND cod_periodo = ".$this->cod_periodo." AND cod_regiao_tipo = ".$this->cod_regiao_tipo);
            } 

            if (!empty($this->hosp_cod_numerador_regiao) && !empty($this->hosp_dt_extracao_regiao)) {                

                $this->hosp_cod_numerador_regiao = str_replace('][', '@', $this->hosp_cod_numerador_regiao);
                $this->hosp_cod_numerador_regiao = str_replace(']', '', $this->hosp_cod_numerador_regiao);
                $this->hosp_cod_numerador_regiao = str_replace('[', '', $this->hosp_cod_numerador_regiao);
                $a_hosp_cod_numerador_regiao = explode("@", trim($this->hosp_cod_numerador_regiao));
                
                
                $this->hosp_cod_denominador_regiao = str_replace('][', '@', $this->hosp_cod_denominador_regiao);
                $this->hosp_cod_denominador_regiao = str_replace(']', '', $this->hosp_cod_denominador_regiao);
                $this->hosp_cod_denominador_regiao = str_replace('[', '', $this->hosp_cod_denominador_regiao);
                $a_hosp_cod_denominador_regiao = explode("@", trim($this->hosp_cod_denominador_regiao));
                
                $this->hosp_dt_extracao_regiao = str_replace('][', '@', $this->hosp_dt_extracao_regiao);
                $this->hosp_dt_extracao_regiao = str_replace(']', '', $this->hosp_dt_extracao_regiao);
                $this->hosp_dt_extracao_regiao = str_replace('[', '', $this->hosp_dt_extracao_regiao);
                $a_hosp_dt_extracao_regiao = explode("@", trim($this->hosp_dt_extracao_regiao));
                
                for ($x = 0; $x <= count($a_hosp_cod_numerador_regiao) - 1; $x++) {                           
                    $n = explode("_", trim($a_hosp_cod_numerador_regiao[$x]));
                    $d = explode("_", trim($a_hosp_cod_denominador_regiao[$x]));
                    $e = explode("_", trim($a_hosp_dt_extracao_regiao[$x]));                               

                    if (!empty($this->txt_polaridade)) { 
                        $clsIndicador = new clsIndicador();
                        if($this->absoluto != 'SIM') {
                            $cod_resultado = $clsIndicador->CalcularResultado($this->cod_id, trim($n[1]), trim($d[1]));                            
                        }            
                        else {
                            $cod_resultado = trim($n[1]);
                        }   
                    } else {
                        $cod_resultado = 0;
                    }
                
                    $sql = "INSERT INTO tb_indicador_analise_regiao(cod_chave, cod_periodo, cod_numerador, cod_denominador, cod_resultado, cod_usuario, dt_extracao, cod_regiao_tipo, cod_hospital) ";
                    $sql .= " VALUES(".$this->cod_id.", ".$this->cod_periodo.", '".trim($n[1])."', '".trim($d[1])."', '".trim($cod_resultado)."', ".$_SESSION["cod_usuario"].", '".DataBanco(trim($e[1]))."', ".$this->cod_regiao_tipo.", ".$n[0].")";                                       
                    pg_query($sql);                               
                }
            }

            if (!empty($this->urd_cod_numerador_regiao) && !empty($this->urd_dt_extracao_regiao)) {                

                $this->urd_cod_numerador_regiao = str_replace('][', '@', $this->urd_cod_numerador_regiao);
                $this->urd_cod_numerador_regiao = str_replace(']', '', $this->urd_cod_numerador_regiao);
                $this->urd_cod_numerador_regiao = str_replace('[', '', $this->urd_cod_numerador_regiao);
                $a_urd_cod_numerador_regiao = explode("@", trim($this->urd_cod_numerador_regiao));
                
                
                $this->urd_cod_denominador_regiao = str_replace('][', '@', $this->urd_cod_denominador_regiao);
                $this->urd_cod_denominador_regiao = str_replace(']', '', $this->urd_cod_denominador_regiao);
                $this->urd_cod_denominador_regiao = str_replace('[', '', $this->urd_cod_denominador_regiao);
                $a_urd_cod_denominador_regiao = explode("@", trim($this->urd_cod_denominador_regiao));
                
                $this->urd_dt_extracao_regiao = str_replace('][', '@', $this->urd_dt_extracao_regiao);
                $this->urd_dt_extracao_regiao = str_replace(']', '', $this->urd_dt_extracao_regiao);
                $this->urd_dt_extracao_regiao = str_replace('[', '', $this->urd_dt_extracao_regiao);
                $a_urd_dt_extracao_regiao = explode("@", trim($this->urd_dt_extracao_regiao));
                
                for ($x = 0; $x <= count($a_urd_cod_numerador_regiao) - 1; $x++) {                           
                    $n = explode("_", trim($a_urd_cod_numerador_regiao[$x]));
                    $d = explode("_", trim($a_urd_cod_denominador_regiao[$x]));
                    $e = explode("_", trim($a_urd_dt_extracao_regiao[$x]));
                
                    if (!empty($this->txt_polaridade)) { 
                        $clsIndicador = new clsIndicador();
                        if($this->absoluto != 'SIM') {
                            $cod_resultado = $clsIndicador->CalcularResultado($this->cod_id, trim($n[1]), trim($d[1]));
                        }            
                        else {
                            $cod_resultado = trim($n[1]);
                        }   
                    } else {
                        $cod_resultado = 0;
                    }
                
                    $sql = "INSERT INTO tb_indicador_analise_regiao(cod_chave, cod_periodo, cod_numerador, cod_denominador, cod_resultado, cod_usuario, dt_extracao, cod_regiao_tipo, cod_urd) ";
                    $sql .= " VALUES(".$this->cod_id.", ".$this->cod_periodo.", '".trim($n[1])."', '".trim($d[1])."', '".trim($cod_resultado)."', ".$_SESSION["cod_usuario"].", '".DataBanco(trim($e[1]))."', ".$this->cod_regiao_tipo.", ".$n[0].")";                                   
                    pg_query($sql);                               
                }
            }            
        }
    }

    public function ExcluirAnalise() {
        $sql = "DELETE FROM tb_indicador_analise WHERE cod_chave = ".$this->cod_id. " AND cod_periodo = ".$this->cod_periodo;
        pg_query($sql);

        Auditoria(83, "", $sql);

        $sql = "DELETE FROM tb_indicador_analise_regiao WHERE cod_chave = ".$this->cod_id. " AND cod_periodo = ".$this->cod_periodo;
        pg_query($sql);

        Auditoria(83, "", $sql);
    }

    public function QueryConsultaArvore($cod_id) {
        $query = "SELECT cod_eixo, cod_perspectiva, cod_diretriz, tb_indicador.cod_objetivo ";
        $query .= " FROM tb_indicador ";
        $query .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_indicador.cod_objetivo ";
        $query .= " WHERE tb_indicador.cod_chave = ".$cod_id;   
        $q = pg_query($query);
        
        return $q;
    }

    public function TipoMonitoramento($txt_monitoramento) {
        switch(strtolower($txt_monitoramento)) {
            case 'mensal':
                return 12/1;            
                
                break;
            case 'bimestral':
                return 12/2;
    
                break;
            case 'trimestral':
                return 12/3;
    
                break;
            case 'quadrimestral':
                return 12/4;
    
                break;
            case 'semestral':
                return 12/6;
    
                break;
            default:
                return 0;                
        }
    }

    public function RetornaUltimoStatus($id) {
        $sql = "SELECT cod_status FROM tb_indicador_analise WHERE cod_chave = ".$id." ORDER BY cod_periodo DESC LIMIT 1";
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs1 = pg_fetch_array($q);

            return $rs1['cod_status'];
        } else {
            return "";
        }        
    }

    public function IncluirPeriodoAtualizacao($dt_inicio, $dt_fim) {
        $rs=pg_fetch_array(pg_query("SELECT MAX(cod_chave) FROM tb_indicador_periodo"));
        if (!isset($rs[0])) {
            $id = 1;
        } else {
            $id = intval($rs[0]) + 1;
        }


        $sql = "INSERT INTO tb_indicador_periodo(cod_chave, dt_inicio, dt_fim, cod_usuario) ";
        $sql .= " VALUES(".$id.", '".trim(DataBanco($dt_inicio))."', '".trim(DataBanco($dt_fim))."', ".$_SESSION['cod_usuario'].")";        
        pg_query($sql);

        Auditoria(67, "", $sql);
    }

    public function AlterarPeriodoAtualizacao($id, $dt_inicio, $dt_fim) {
        $sql = "UPDATE tb_indicador_periodo SET dt_inicio = '".trim(DataBanco($dt_inicio))."', ";
        $sql .= " dt_fim = '".trim(DataBanco($dt_fim))."', cod_usuario = ".$_SESSION['cod_usuario'];
        $sql .= " WHERE cod_chave = ".$id;
        pg_query($sql);

        Auditoria(68, "", $sql);
    }

    public function ExcluirPeriodoAtualizacao($id) {
        $sql = "DELETE FROM tb_indicador_periodo WHERE cod_chave = ".$id;
        pg_query($sql);

        Auditoria(69, "", $sql);
    }

    public function EncerrarPeriodoAtualizacao($id) {
        $sql = "UPDATE tb_indicador_periodo SET dt_reabrir = NULL, cod_usuario_reabrir = NULL WHERE cod_chave = ".$id;        
        pg_query($sql);

        Auditoria(70, "", $sql);
    }

    public function ReabrirPeriodoAtualizacao($id) {
        $sql = "UPDATE tb_indicador_periodo SET dt_reabrir = CURRENT_DATE, cod_usuario_reabrir = ".$_SESSION['cod_usuario'];
        $sql .= " WHERE cod_chave = ".$id;
        pg_query($sql);

        Auditoria(71, "", $sql);
    }

    public function ListaPeriodo() {
        $sql = "SELECT * FROM tb_indicador_periodo ORDER BY dt_inclusao DESC";
        $q = pg_query($sql);
        return $q; 
    }

    public function RegraPeriodo() {
        $retorno = true;
        
        $clsIndicador = new clsIndicador();
        $q2 = $clsIndicador->ListaPeriodo();        
        if (pg_num_rows($q2) > 0) {
            $rs = pg_fetch_array($q2);

            if (strtotime("now") > strtotime($rs['dt_fim']) || strtotime("now") < strtotime($rs['dt_inicio'])) {
                $retorno = false;
            }                 
        } 

        return $retorno;
    }

    public function RegraPeriodoAnalise() {
        $retorno = true;
        
        $clsIndicador = new clsIndicador();
        $q2 = $clsIndicador->ListaPeriodo();        
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

    public function RetornaNumeradorRA($id, $periodo, $cod_regiao_tipo, $cod_ra) {
        $sql = "SELECT cod_numerador FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_ra = ".$cod_ra;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return $rs['cod_numerador'];
        } else {
            return '';
        }        
    }

    public function RetornaValorNumeradorRA($id, $periodo, $cod_regiao_tipo, $cod_ra) {
        $sql = "SELECT cod_numerador FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_ra = ".$cod_ra;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return $rs['cod_numerador'];
        } else {
            return '';
        }        
    }

    public function RetornaValorDenominadorRA($id, $periodo, $cod_regiao_tipo, $cod_ra) {
        $sql = "SELECT cod_denominador FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_ra = ".$cod_ra;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return $rs['cod_denominador'];
        } else {
            return '';
        }        
    }

    public function RetornaValorExtracaoRA($id, $periodo, $cod_regiao_tipo, $cod_ra) {
        $sql = "SELECT dt_extracao FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_ra = ".$cod_ra;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return FormataData($rs['dt_extracao']);
        } else {
            return '';
        }        
    }

    public function RetornaValorResultadoRA($id, $periodo, $cod_regiao_tipo, $cod_ra) {
        $sql = "SELECT cod_resultado FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_ra = ".$cod_ra;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return $rs['cod_resultado'];
        } else {
            return '';
        }        
    }

    public function RetornaValorNumeradorReg($id, $periodo, $cod_regiao_tipo, $cod_reg) {
        $sql = "SELECT cod_numerador FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_reg = ".$cod_reg;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return $rs['cod_numerador'];
        } else {
            return '';
        }        
    }

    public function RetornaValorDenominadorReg($id, $periodo, $cod_regiao_tipo, $cod_reg) {
        $sql = "SELECT cod_denominador FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_reg = ".$cod_reg;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return $rs['cod_denominador'];
        } else {
            return '';
        }        
    }

    public function RetornaValorExtracaoReg($id, $periodo, $cod_regiao_tipo, $cod_reg) {
        $sql = "SELECT dt_extracao FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_reg = ".$cod_reg;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return FormataData($rs['dt_extracao']);
        } else {
            return '';
        }        
    }

    public function RetornaValorResultadoReg($id, $periodo, $cod_regiao_tipo, $cod_reg) {
        $sql = "SELECT cod_resultado FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_reg = ".$cod_reg;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return $rs['cod_resultado'];
        } else {
            return '';
        }        
    }

    public function RetornaValorNumeradorUrd($id, $periodo, $cod_regiao_tipo, $cod_urd) {
        $sql = "SELECT cod_numerador FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_urd = ".$cod_urd;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return $rs['cod_numerador'];
        } else {
            return '';
        }        
    }

    public function RetornaValorDenominadorUrd($id, $periodo, $cod_regiao_tipo, $cod_urd) {
        $sql = "SELECT cod_denominador FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_urd = ".$cod_urd;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return $rs['cod_denominador'];
        } else {
            return '';
        }        
    }

    public function RetornaValorExtracaoUrd($id, $periodo, $cod_regiao_tipo, $cod_urd) {
        $sql = "SELECT dt_extracao FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_urd = ".$cod_urd;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return FormataData($rs['dt_extracao']);
        } else {
            return '';
        }        
    }

    public function RetornaValorResultadoUrd($id, $periodo, $cod_regiao_tipo, $cod_urd) {
        $sql = "SELECT cod_resultado FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_urd = ".$cod_urd;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return $rs['cod_resultado'];
        } else {
            return '';
        }        
    }

    public function RetornaValorNumeradorHosp($id, $periodo, $cod_regiao_tipo, $cod_hosp) {
        $sql = "SELECT cod_numerador FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_hospital = ".$cod_hosp;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return $rs['cod_numerador'];
        } else {
            return '';
        }        
    }

    public function RetornaValorDenominadorHosp($id, $periodo, $cod_regiao_tipo, $cod_hosp) {
        $sql = "SELECT cod_denominador FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_hospital = ".$cod_hosp;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return $rs['cod_denominador'];
        } else {
            return '';
        }        
    }

    public function RetornaValorExtracaoHosp($id, $periodo, $cod_regiao_tipo, $cod_hosp) {
        $sql = "SELECT dt_extracao FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_hospital = ".$cod_hosp;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return FormataData($rs['dt_extracao']);
        } else {
            return '';
        }        
    }

    public function RetornaValorResultadoHosp($id, $periodo, $cod_regiao_tipo, $cod_hosp) {
        $sql = "SELECT cod_resultado FROM tb_indicador_analise_regiao WHERE cod_chave = ".$id." AND cod_periodo = ".$periodo." AND cod_regiao_tipo = ".$cod_regiao_tipo." AND cod_hospital = ".$cod_hosp;
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) {
            $rs = pg_fetch_array($q);

            return $rs['cod_resultado'];
        } else {
            return '';
        }        
    }
}
?>