<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsIndicador.php");

$acao = $_REQUEST['acao'];
$cod_id = $_REQUEST['id'];
$cod_indicador = $_REQUEST['cod_indicador'];
$cod_eixo = $_REQUEST['cod_eixo'];
$cod_perspectiva = $_REQUEST['cod_perspectiva'];
$cod_diretriz = $_REQUEST['cod_diretriz'];
$cod_objetivo = $_REQUEST['cod_objetivo'];
$cod_objetivo_ppa = $_REQUEST['cod_objetivo_ppa'];
$cod_orgao = $_REQUEST['cod_orgao'];
$cod_modulo = $_REQUEST['cod_modulo'];
$cod_meta = $_REQUEST['cod_meta'];
$cod_periodo = $_REQUEST['cod_periodo'];
$cod_numerador = $_REQUEST['cod_numerador'];
$cod_denominador = $_REQUEST['cod_denominador'];
$cod_resultado = $_REQUEST['cod_resultado'];
$txt_analise = $_REQUEST['txt_analise'];
$txt_analise_2 = $_REQUEST['txt_analise_2'];
$txt_encaminhamento = $_REQUEST['txt_encaminhamento'];
$txt_descricao_meta = $_REQUEST['txt_descricao'];
$codigo_indicador = $_REQUEST['codigo_indicador'];
$cod_dados_mgi = $_REQUEST['cod_dados_mgi'];
$txt_monitoramento = $_REQUEST['txt_monitoramento'];
$polaridade = $_REQUEST['polaridade'];
$txt_formula = $_REQUEST['txt_formula'];
$dt_extracao = $_REQUEST['dt_extracao'];
$txt_meta_parcial = $_REQUEST['txt_meta_parcial'];
$absoluto = $_REQUEST['absoluto'];
$dt_inicio = $_REQUEST['dt_inicio'];
$dt_fim = $_REQUEST['dt_fim'];
$cod_responsavel = $_REQUEST['cod_responsavel'];
$cod_responsavel_2 = $_REQUEST['cod_responsavel_2'];
$cod_regiao = $_REQUEST['cod_regiao'];
$cod_ra_qtd = $_REQUEST['cod_ra_qtd'];
$cod_reg_qtd = $_REQUEST['cod_reg_qtd'];
$cod_urd_qtd = $_REQUEST['cod_urd_qtd'];
$cod_hosp_qtd = $_REQUEST['cod_hosp_qtd'];
$cod_regiao_tipo = $_REQUEST['cod_regiao_tipo'];
$cod_acumulativo = $_REQUEST['cod_acumulativo'];

if ($acao == 'incluir' || $acao == 'alterar') {
    switch(strtolower($txt_monitoramento)) {
        case 'mensal':
            $qtd_campos = 12/1;                                    
            break;
        case 'bimestral':
            $qtd_campos = 12/2;
            break;
        case 'trimestral':
            $qtd_campos = 12/3;
            break;
        case 'quadrimestral':
            $qtd_campos = 12/4;
            break;
        case 'semestral':
            $qtd_campos = 12/6;        
            break;
    }
    $ct = 1;
    while ($ct <= 12) {
        $valor = trim($_REQUEST['cod_meta'.$ct]);        
        if (!empty($valor)) {
            $txt_meta_monitoramento .= "[" .$valor. "]";
        }        
        $ct += 1;
    }           
}

switch ($acao) {
    case 'incluir':        
        $clsIndicador = new clsIndicador();
        $clsIndicador->cod_indicador = $cod_indicador;        
        $clsIndicador->cod_objetivo = $cod_objetivo;
        $clsIndicador->cod_objetivo_ppa = $cod_objetivo_ppa;
        $clsIndicador->cod_orgao = $cod_orgao;            
        $clsIndicador->cod_meta = $cod_meta;
        $clsIndicador->txt_descricao_meta = $txt_descricao_meta;        
        $clsIndicador->cod_dados_mgi = $cod_dados_mgi;
        $clsIndicador->txt_monitoramento = $txt_monitoramento;
        $clsIndicador->txt_meta_monitoramento = $txt_meta_monitoramento;
        $clsIndicador->txt_formula = trim($txt_formula);
        $clsIndicador->cod_responsavel = $cod_responsavel;
        $clsIndicador->cod_responsavel_2 = $cod_responsavel_2;
        $clsIndicador->cod_regiao = $cod_regiao;
        $clsIndicador->cod_acumulativo = $cod_acumulativo;  
        $clsIndicador->IncluirIndicador();
    
        js_go('default.php');
        break; 

    case 'alterar':    
        $clsIndicador = new clsIndicador();                    
        $clsIndicador->cod_indicador = $cod_indicador;        
        $clsIndicador->cod_objetivo = $cod_objetivo;
        $clsIndicador->cod_objetivo_ppa = $cod_objetivo_ppa;
        $clsIndicador->cod_orgao = $cod_orgao;            
        $clsIndicador->cod_meta = $cod_meta;
        $clsIndicador->txt_descricao_meta = $txt_descricao_meta;        
        $clsIndicador->cod_dados_mgi = $cod_dados_mgi;
        $clsIndicador->txt_monitoramento = $txt_monitoramento;
        $clsIndicador->txt_meta_monitoramento = $txt_meta_monitoramento;
        $clsIndicador->txt_formula = trim($txt_formula);
        $clsIndicador->cod_responsavel = $cod_responsavel;
        $clsIndicador->cod_responsavel_2 = $cod_responsavel_2;
        $clsIndicador->cod_regiao = $cod_regiao; 
        $clsIndicador->cod_acumulativo = $cod_acumulativo;
        $clsIndicador->AlterarIndicador($cod_id);

        //REDIRECIONAR
        $query = $clsIndicador->QueryConsultaArvore($cod_id);        
        $rs1 = pg_fetch_array($query);         
        
        //js_go('indicador.php?cod_eixo='.$rs1['cod_eixo'].'&cod_perspectiva='.$rs1['cod_perspectiva'].'&cod_diretriz='.$rs1['cod_diretriz'].'&cod_objetivo='.$rs1['cod_objetivo'].'');
        js_go('alterar.php?id='.$cod_id);
        break; 

    case 'excluir':   
        $clsIndicador = new clsIndicador();        
        $clsIndicador->cod_objetivo = $cod_objetivo;
        $clsIndicador->ExcluirIndicador();
        break;

    case 'excluir_indicador':
        $clsIndicador = new clsIndicador();        
        $clsIndicador->ExcluirIndicadorChave($cod_id);
        break;

    case 'incluir_detalhe':
        $clsIndicador = new clsIndicador();
        $clsIndicador->cod_id = $cod_id;
        $clsIndicador->cod_periodo = $cod_periodo;
        $clsIndicador->cod_numerador = $cod_numerador;
        $clsIndicador->cod_denominador = $cod_denominador;
        $clsIndicador->cod_resultado = $cod_resultado;        
        $clsIndicador->IncluirDetalhe();
        break;

    case 'excluir_detalhe':
        $clsIndicador = new clsIndicador();
        $clsIndicador->cod_id = $cod_id;
        $clsIndicador->cod_periodo = $cod_periodo;
        $clsIndicador->ExcluirDetalhe();
        break;
    
    case 'incluir_analise':
        $clsIndicador = new clsIndicador();
        $clsIndicador->cod_id = $cod_id;
        $clsIndicador->cod_periodo = $cod_periodo;
        $clsIndicador->txt_analise = $txt_analise;
        $clsIndicador->txt_analise_2 = $txt_analise_2;
        $clsIndicador->txt_encaminhamento = $txt_encaminhamento;                
        $clsIndicador->cod_numerador = $cod_numerador;
        $clsIndicador->cod_denominador = $cod_denominador;
        $clsIndicador->cod_resultado = $cod_resultado;
        $clsIndicador->txt_polaridade = $polaridade;
        $clsIndicador->dt_extracao = $dt_extracao;
        $clsIndicador->txt_meta_parcial = $txt_meta_parcial;
        $clsIndicador->absoluto = $absoluto;
        $clsIndicador->cod_ra_qtd = $cod_ra_qtd;
        $clsIndicador->cod_reg_qtd = $cod_reg_qtd;
        $clsIndicador->cod_urd_qtd = $cod_urd_qtd;
        $clsIndicador->cod_hosp_qtd = $cod_hosp_qtd;
        $clsIndicador->cod_hosp_qtd_conv = $_REQUEST['cod_hosp_qtd_conv'];
        $clsIndicador->cod_regiao_tipo = $cod_regiao_tipo;
        $clsIndicador->ra_cod_numerador_regiao = $_REQUEST['ra_cod_numerador_regiao'];
        $clsIndicador->ra_cod_denominador_regiao = $_REQUEST['ra_cod_denominador_regiao'];
        $clsIndicador->ra_dt_extracao_regiao = $_REQUEST['ra_dt_extracao_regiao'];        
        $clsIndicador->reg_cod_numerador_regiao = $_REQUEST['reg_cod_numerador_regiao'];
        $clsIndicador->reg_cod_denominador_regiao = $_REQUEST['reg_cod_denominador_regiao'];
        $clsIndicador->reg_dt_extracao_regiao = $_REQUEST['reg_dt_extracao_regiao'];         
        $clsIndicador->urd_cod_numerador_regiao = $_REQUEST['urd_cod_numerador_regiao'];
        $clsIndicador->urd_cod_denominador_regiao = $_REQUEST['urd_cod_denominador_regiao'];
        $clsIndicador->urd_dt_extracao_regiao = $_REQUEST['urd_dt_extracao_regiao']; 
        $clsIndicador->hosp_cod_numerador_regiao = $_REQUEST['hosp_cod_numerador_regiao'];
        $clsIndicador->hosp_cod_denominador_regiao = $_REQUEST['hosp_cod_denominador_regiao'];
        $clsIndicador->hosp_dt_extracao_regiao = $_REQUEST['hosp_dt_extracao_regiao'];        
        $clsIndicador->hosp_cod_numerador_regiao_conv = $_REQUEST['hosp_cod_numerador_regiao_conv'];        
        $clsIndicador->hosp_cod_denominador_regiao_conv = $_REQUEST['hosp_cod_denominador_regiao_conv'];                
        $clsIndicador->hosp_dt_extracao_regiao_conv = $_REQUEST['hosp_dt_extracao_regiao_conv'];        
        $clsIndicador->IncluirAnalise();
        break;

    case 'excluir_analise':
        $clsIndicador = new clsIndicador();
        $clsIndicador->cod_id = $cod_id;
        $clsIndicador->cod_periodo = $cod_periodo;
        $clsIndicador->ExcluirAnalise();
        break;

    case "tabela_indicador":
        $clsIndicador = new clsIndicador();
        $retorno_array = $clsIndicador->ConsultaIndicador($cod_id);
        echo(json_encode($retorno_array));
        break;   
        
    case "incluir_periodo_atualizacao":
        $clsIndicador = new clsIndicador();
        if (empty($cod_id)) {
            $clsIndicador->IncluirPeriodoAtualizacao($dt_inicio, $dt_fim);
        } else {
            $clsIndicador->AlterarPeriodoAtualizacao($cod_id, $dt_inicio, $dt_fim);
        }        
        js_go("periodo_atualizacao.php");
        break;

    case "excluir_periodo_atualizacao":
        $clsIndicador = new clsIndicador();
        $clsIndicador->ExcluirPeriodoAtualizacao($cod_id);
        break;

    case "encerrar_periodo_atualizacao":
        $clsIndicador = new clsIndicador();
        $clsIndicador->EncerrarPeriodoAtualizacao($cod_id);
        break;

    case "reabrir_periodo_atualizacao":
        $clsIndicador = new clsIndicador();
        $clsIndicador->ReabrirPeriodoAtualizacao($cod_id);
        break;
    
    case "tabela_meta_monitoramento":
        $sql = "SELECT * FROM tb_indicador_meta WHERE cod_indicador = ".$cod_id;
        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;

    case "retorna_formula":
        $retorno = "";
        $sql = "SELECT txt_formula FROM tb_indicador WHERE cod_chave = ".$cod_id;
        $query = pg_query($sql);
        if(pg_num_rows($query) > 0) {
            $rs = pg_fetch_assoc($query);
            $retorno = $rs['txt_formula'];
        }
        echo($retorno);
        break;    

    case 'combo_ra':
        $sql = "SELECT * FROM tb_regiao_administrativa WHERE cod_regiao = ".$cod_regiao." AND cod_ativo = 1 ORDER BY txt_ra";        
        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;

    case 'combo_regiao':
        $sql = "SELECT * FROM tb_regiao WHERE cod_ativo = 1 ORDER BY txt_regiao";        
        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;
}
?>