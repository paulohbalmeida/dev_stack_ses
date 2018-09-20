
<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsSag.php");
include_once (__DIR__ . "/../classes/clsStatus.php");

$cod_id = $_REQUEST['id'];
$acao = $_REQUEST['acao'];
$cod_sag = $_REQUEST['id'];
$cod_objetivo = $_REQUEST['cod_objetivo'];
$cod_objetivo_ppa = $_REQUEST['cod_objetivo_ppa'];

$cod_programa_trabalho = $_REQUEST['cod_programa_trabalho'];
$nr_etapa_trabalho = $_REQUEST['nr_etapa_trabalho'];
$txt_etapa_trabalho  =$_REQUEST['txt_etapa_trabalho'];
$cod_produto_etapa = $_REQUEST['cod_produto_etapa'];
$nr_meta = $_REQUEST['nr_meta'];
$nr_meta_parcial = $_REQUEST['nr_meta_parcial'];
$cod_inicio_previsto = $_REQUEST['cod_inicio_previsto'];
$cod_fim_previsto = $_REQUEST['cod_fim_previsto'];
$cod_orgao = $_REQUEST['cod_orgao'];
$cod_parceiro = $_REQUEST['cod_parceiro'];
$cod_modulo = 2;
$cod_unidade_medida = $_REQUEST['cod_unidade_medida'];
$cod_obra = $_REQUEST['cod_obra'];
$txt_analise = $_REQUEST['txt_analise'];
$cod_bimestre = $_REQUEST['cod_bimestre'];
$cod_resultado = $_REQUEST['cod_resultado'];
$cod_inicio_efetivo = $_REQUEST['cod_inicio_efetivo'];
$cod_fim_efetivo = $_REQUEST['cod_fim_efetivo'];
$cod_continuar = $_REQUEST['cod_continuar'];
$nr_meta_analise = $_REQUEST['nr_meta_analise'];
$nr_mes_1 = $_REQUEST['nr_mes_1'];
$nr_mes_2 = $_REQUEST['nr_mes_2'];
$cod_acumulativo = $_REQUEST['cod_acumulativo'];
$nr_meta_1 = $_REQUEST['nr_meta_1'];
$nr_meta_2 = $_REQUEST['nr_meta_2'];
$nr_meta_3 = $_REQUEST['nr_meta_3'];
$nr_meta_4 = $_REQUEST['nr_meta_4'];
$nr_meta_5 = $_REQUEST['nr_meta_5'];
$nr_meta_6 = $_REQUEST['nr_meta_6'];
$txt_realizado_1 = $_REQUEST['txt_realizado_1'];
$txt_realizado_2 = $_REQUEST['txt_realizado_2'];
$txt_percentual = $_REQUEST['txt_percentual'];
$txt_analise_obra = $_REQUEST['txt_analise_obra'];
$cod_situacao = $_REQUEST['cod_situacao'];
$cod_controle = $_REQUEST['cod_controle'];
$cod_causa_desvio = $_REQUEST['cod_causa_desvio'];
$cod_natureza_desvio = $_REQUEST['cod_natureza_desvio'];
$txt_analise_desvio = $_REQUEST['txt_analise_desvio'];
$txt_variacao = $_REQUEST['txt_variacao'];
$dt_inicio = $_REQUEST['dt_inicio'];
$dt_fim = $_REQUEST['dt_fim'];
$cod_status_analise = $_REQUEST['cod_status_analise'];

$retorno = array();

switch ($acao) {
    case 'incluir':
        $sql = "SELECT nr_etapa_trabalho FROM tb_sag WHERE nr_etapa_trabalho = ".$nr_etapa_trabalho;        
        $query = pg_query($sql);
        if(pg_num_rows($query) > 0) {
            js_go_back('ETAPA SAG já está cadastrada');
        } else {
            $clsSag = new clsSag();        
            $clsSag->cod_objetivo = $cod_objetivo;
            $clsSag->cod_objetivo_ppa = $cod_objetivo_ppa;
            $clsSag->cod_programa_trabalho = $cod_programa_trabalho;
            $clsSag->nr_etapa_trabalho = $nr_etapa_trabalho;
            $clsSag->txt_etapa_trabalho = $txt_etapa_trabalho;
            $clsSag->cod_produto_etapa = $cod_produto_etapa;
            $clsSag->nr_meta = $nr_meta;
            $clsSag->cod_inicio_previsto = $cod_inicio_previsto;
            $clsSag->cod_fim_previsto = $cod_fim_previsto;
            $clsSag->cod_orgao = $cod_orgao;
            $clsSag->cod_parceiro = $cod_parceiro;
            $clsSag->cod_modulo = $cod_modulo;
            $clsSag->cod_unidade_medida = $cod_unidade_medida;        
            $clsSag->cod_obra = $cod_obra; 
            $clsSag->cod_acumulativo = $cod_acumulativo; 
            $clsSag->nr_meta_1 = $nr_meta_1; 
            $clsSag->nr_meta_2 = $nr_meta_2; 
            $clsSag->nr_meta_3 = $nr_meta_3; 
            $clsSag->nr_meta_4 = $nr_meta_4; 
            $clsSag->nr_meta_5 = $nr_meta_5; 
            $clsSag->nr_meta_6 = $nr_meta_6;         
            $clsSag->IncluirSAG();        
            
            if (strval($cod_continuar) == '1') {
                js_go('incluir.php?cod_objetivo_url='.$cod_objetivo.'&cod_objetivo_ppa_url='.$cod_objetivo_ppa);
            } else {
                js_go('default.php');                         
            }
        }                           
        
        break; 

    case 'alterar':
        $sql = "SELECT nr_etapa_trabalho FROM tb_sag WHERE nr_etapa_trabalho = ".$nr_etapa_trabalho. " AND cod_sag <> ".$cod_id;
        $query = pg_query($sql);
        if(pg_num_rows($query) > 0) {
            js_go_back('ETAPA SAG já está cadastrada');            
        } else {
            $clsSag = new clsSag();
            $clsSag->cod_sag = $cod_sag;        
            $clsSag->cod_objetivo = $cod_objetivo;
            $clsSag->cod_objetivo_ppa = $cod_objetivo_ppa;
            $clsSag->cod_programa_trabalho = $cod_programa_trabalho;
            $clsSag->nr_etapa_trabalho = $nr_etapa_trabalho;
            $clsSag->txt_etapa_trabalho = $txt_etapa_trabalho;
            $clsSag->cod_produto_etapa = $cod_produto_etapa;
            $clsSag->nr_meta = $nr_meta;
            $clsSag->cod_inicio_previsto = $cod_inicio_previsto;
            $clsSag->cod_fim_previsto = $cod_fim_previsto;
            $clsSag->cod_orgao = $cod_orgao;
            $clsSag->cod_parceiro = $cod_parceiro;
            $clsSag->cod_modulo = $cod_modulo;
            $clsSag->cod_unidade_medida = $cod_unidade_medida;
            $clsSag->cod_obra = $cod_obra;        
            $clsSag->cod_acumulativo = $cod_acumulativo; 
            $clsSag->nr_meta_1 = $nr_meta_1; 
            $clsSag->nr_meta_2 = $nr_meta_2; 
            $clsSag->nr_meta_3 = $nr_meta_3; 
            $clsSag->nr_meta_4 = $nr_meta_4; 
            $clsSag->nr_meta_5 = $nr_meta_5; 
            $clsSag->nr_meta_6 = $nr_meta_6; 
            $clsSag->AlterarSAG();   
                            
            js_go('alterar.php?id='.$cod_sag.'&status=sucesso');
        }

        break;

    case 'excluir':   
        $clsSag = new clsSag();
        $clsSag->cod_sag = $cod_sag;
        $clsSag->ExcluirSAG();
        break;

    case 'incluir_analise':        
        $clsSag = new clsSag();
        $clsSag->cod_sag = $cod_sag;
        $clsSag->cod_bimestre = $cod_bimestre;
        $clsSag->cod_obra = $cod_obra;
        $clsSag->txt_realizado_1 = $txt_realizado_1;
        $clsSag->txt_realizado_2 = $txt_realizado_2;        
        $clsSag->txt_percentual = $txt_percentual;
        $clsSag->txt_analise_obra = $txt_analise_obra;
        $clsSag->nr_mes_1 = $nr_mes_1;
        $clsSag->nr_mes_2 = $nr_mes_2;
        $clsSag->txt_analise = $txt_analise;
        $clsSag->cod_situacao = $cod_situacao;
        $clsSag->cod_controle = $cod_controle;
        $clsSag->cod_causa_desvio = $cod_causa_desvio;
        $clsSag->cod_natureza_desvio = $cod_natureza_desvio;
        $clsSag->txt_analise_desvio = $txt_analise_desvio;
        $clsSag->cod_inicio_efetivo = $cod_inicio_efetivo;
        $clsSag->cod_fim_efetivo = $cod_fim_efetivo;    
        $clsSag->cod_status = $cod_status_analise;           
        $clsSag->IncluirAnalise();
        break;

    case 'excluir_analise':
        $clsSag = new clsSag();
        $clsSag->cod_sag = $cod_sag;
        $clsSag->cod_bimestre = $cod_bimestre;
        $clsSag->ExcluirAnalise();
        break;

    case 'popular_modal_sag':
        $q1 = pg_query("SELECT * FROM tb_sag WHERE cod_sag = ".$cod_sag);
        $rs = pg_fetch_array($q1);
        echo($rs['txt_etapa_trabalho']);
        break;

    case 'salvar_dados_modal':        
        $clsSag = new clsSag();
        $clsSag->cod_sag = $cod_sag;
        $clsSag->cod_inicio_efetivo = $cod_inicio_efetivo;
        $clsSag->cod_fim_efetivo = $cod_fim_efetivo;
        $clsSag->CompletarCadastro();
        break;

    case 'sag_status':
        $clsSag = new clsSag();
        $cod_status = $clsSag->SituacaoAnalise($txt_variacao);        
        $clsStatus = new clsStatus();        

        if (strval($cod_status) != '') {
            $retorno = $clsStatus->RetornaStatus($cod_status).'|'.$clsStatus->RetornaCorStatus($cod_status).'|'.$cod_status;
        }       

        echo($retorno);
        break;

    case 'combo_causa_desvio':
        $sql = "SELECT * FROM tb_sag_causa_desvio ";        
        $sql .= " WHERE cod_ativo = 1 ORDER BY txt_causa";

        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;

    case 'combo_natureza_desvio':
        $sql = "SELECT * FROM tb_sag_natureza_desvio ";        
        $sql .= " WHERE cod_ativo = 1 ORDER BY txt_natureza";

        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;

    case 'form_alterar_analise':
        $sql = "SELECT * FROM tb_sag_analise WHERE cod_sag = ".$cod_sag." AND cod_bimestre = ".$cod_bimestre;

        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }       
        echo(json_encode($arr));
        break;    

    case 'sag_total':
        $retorno = 0;

        $sql = "SELECT * FROM tb_sag_analise WHERE cod_sag = ".$cod_sag." AND cod_bimestre < ".$cod_bimestre." AND (nr_mes_1 IS NOT NULL AND nr_mes_2 IS NOT NULL)";
        $query = pg_query($sql);
        if(pg_num_rows($query) > 0) {
            while($r = pg_fetch_assoc($query)) {
                $retorno = intval($retorno) + (intval($r['nr_mes_1']) +  intval($r['nr_mes_2']));
            }
        }

        echo($retorno);
        break;  

    case "incluir_periodo_atualizacao":
        $clsSag = new clsSag();
        if (empty($cod_id)) {
            $clsSag->IncluirPeriodoAtualizacao($dt_inicio, $dt_fim);
        } else {
            $clsSag->AlterarPeriodoAtualizacao($cod_id, $dt_inicio, $dt_fim);
        }        
        js_go("periodo_atualizacao.php");
        break;

    case "excluir_periodo_atualizacao":
        $clsSag = new clsSag();
        $clsSag->ExcluirPeriodoAtualizacao($cod_id);
        break;

    case "encerrar_periodo_atualizacao":
        $clsSag = new clsSag();
        $clsSag->EncerrarPeriodoAtualizacao($cod_id);
        break;

    case "reabrir_periodo_atualizacao":
        $clsSag = new clsSag();
        $clsSag->ReabrirPeriodoAtualizacao($cod_id);
        break;    
}

?>