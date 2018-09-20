
<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsPas.php");

$cod_id = $_REQUEST['id'];
$acao = $_REQUEST['acao'];
$cod_pas = $_REQUEST['id'];
$cod_eixo = $_REQUEST['cod_eixo'];
$cod_perspectiva = $_REQUEST['cod_perspectiva'];
$cod_diretriz = $_REQUEST['cod_diretriz'];
$cod_objetivo = $_REQUEST['cod_objetivo'];
$cod_objetivo_ppa = $_REQUEST['cod_objetivo_ppa'];
$codigo_acao = $_REQUEST['codigo_acao'];
$txt_acao = $_REQUEST['txt_acao'];
$cod_orgao = $_REQUEST['cod_orgao'];
$cod_parceiro = $_REQUEST['cod_parceiro'];
$cod_mes_inicio = $_REQUEST['cod_mes_inicio'];
$cod_mes_fim = $_REQUEST['cod_mes_fim'];
$cod_meta = $_REQUEST['cod_meta'];
$cod_modulo = $_REQUEST['cod_modulo'];
$txt_consideracao = $_REQUEST['txt_consideracao'];
$cod_bimeste = $_REQUEST['cod_bimeste'];
$cod_resultado = $_REQUEST['cod_resultado'];
$cod_inicio_efetivo = $_REQUEST['cod_inicio_efetivo'];
$cod_fim_efetivo = $_REQUEST['cod_fim_efetivo'];
$cod_continuar = $_REQUEST['cod_continuar'];
$dt_inicio = $_REQUEST['dt_inicio'];
$dt_fim = $_REQUEST['dt_fim'];
$txt_medida = $_REQUEST['txt_medida'];
$cod_controle = $_REQUEST['cod_controle'];
$txt_justificativa = $_REQUEST['txt_justificativa'];
$cod_autorizar = $_REQUEST['cod_autorizar'];
$cod_inicio_previsto = $_REQUEST['cod_inicio_previsto'];
$cod_fim_previsto = $_REQUEST['cod_fim_previsto'];
$txt_justificativa = $_REQUEST['txt_justificativa'];
$retorno = array();

switch ($acao) {
    case 'incluir':    
        $clsPas = new clsPas();        
        $clsPas->cod_objetivo = $cod_objetivo;
        $clsPas->cod_objetivo_ppa = $cod_objetivo_ppa;
        $clsPas->codigo_acao = $codigo_acao;
        $clsPas->txt_acao = $txt_acao;
        $clsPas->cod_orgao = $cod_orgao;
        $clsPas->cod_parceiro = $cod_parceiro;
        $clsPas->cod_mes_inicio = $cod_mes_inicio;
        $clsPas->cod_mes_fim = $cod_mes_fim;
        $clsPas->cod_meta = $cod_meta;        
        $clsPas->txt_medida = $txt_medida;        
        $clsPas->IncluirPAS();
        
        if (strval($cod_continuar) == '1') {
            js_go('incluir.php?cod_objetivo_url='.$cod_objetivo.'&cod_objetivo_ppa_url='.$cod_objetivo_ppa);
        } else {
            js_go('default.php');                         
        }        
        break; 

    case 'alterar':
        $clsPas = new clsPas();
        $clsPas->cod_pas = $cod_pas;        
        $clsPas->cod_objetivo = $cod_objetivo;
        $clsPas->cod_objetivo_ppa = $cod_objetivo_ppa;
        $clsPas->codigo_acao = $codigo_acao;
        $clsPas->txt_acao = $txt_acao;
        $clsPas->cod_orgao = $cod_orgao;
        $clsPas->cod_parceiro = $cod_parceiro;
        $clsPas->cod_mes_inicio = $cod_mes_inicio;
        $clsPas->cod_mes_fim = $cod_mes_fim;
        $clsPas->cod_meta = $cod_meta;   
        $clsPas->txt_medida = $txt_medida;     
        $clsPas->AlterarPAS();   
                        
        js_go('alterar.php?id='.$cod_pas.'&status=sucesso');
        break;

    case 'excluir':   
        $clsPas = new clsPas();
        $clsPas->cod_pas = $cod_pas;
        $clsPas->ExcluirPAS();
        break;

    case 'limpar_campos':   
        $clsPas = new clsPas();        
        $clsPas->LimparPAS($cod_pas);
        break;

    case 'incluir_analise':
        $clsPas = new clsPas();
        $clsPas->cod_pas = $cod_pas;
        $clsPas->cod_bimeste = $cod_bimeste;
        $clsPas->txt_consideracao = $txt_consideracao;
        $clsPas->IncluirConsideracao();
        break;

    case 'excluir_consideracao':
        $clsPas = new clsPas();
        $clsPas->cod_pas = $cod_pas;
        $clsPas->cod_bimeste = $cod_bimeste;
        $clsPas->ExcluirConsideracao();
        break;

    case 'popular_modal_pas':
        $q1 = pg_query("SELECT * FROM tb_pas WHERE cod_pas = ".$cod_pas);
        $rs = pg_fetch_array($q1);
        echo($rs['codigo_acao']." - ".$rs['txt_acao']);
        break;

    case 'salvar_dados_modal':        
        $clsPas = new clsPas();
        $clsPas->cod_pas = $cod_pas;
        $clsPas->cod_resultado = $cod_resultado;
        $clsPas->cod_inicio_efetivo = $cod_inicio_efetivo;
        $clsPas->cod_fim_efetivo = $cod_fim_efetivo;
        $clsPas->CompletarCadastro();
        break;

    case "incluir_periodo_atualizacao":
        $clsPas = new clsPas();
        if (empty($cod_id)) {
            $clsPas->IncluirPeriodoAtualizacao($dt_inicio, $dt_fim);
        } else {
            $clsPas->AlterarPeriodoAtualizacao($cod_id, $dt_inicio, $dt_fim);
        }        
        js_go("periodo_atualizacao.php");
        break;

    case "excluir_periodo_atualizacao":
        $clsPas = new clsPas();
        $clsPas->ExcluirPeriodoAtualizacao($cod_id);
        break;

    case "encerrar_periodo_atualizacao":
        $clsPas = new clsPas();
        $clsPas->EncerrarPeriodoAtualizacao($cod_id);
        break;

    case "reabrir_periodo_atualizacao":
        $clsPas = new clsPas();
        $clsPas->ReabrirPeriodoAtualizacao($cod_id);
        break;
    
    case "salvar_completo":        
        $clsPas = new clsPas();
        $clsPas->cod_pas = $cod_id;
        $clsPas->cod_resultado = $cod_resultado;
        $clsPas->cod_inicio_efetivo = $cod_inicio_efetivo;
        $clsPas->cod_fim_efetivo = $cod_fim_efetivo;
        $clsPas->cod_controle = $cod_controle;
        echo($clsPas->SalvarCompleto());
        break;
    
    case 'atualizar_situacao':
        $clsPas = new clsPas();     
        $clsPas->cod_pas = $cod_id;  
        $clsPas->cod_inicio_efetivo = $cod_inicio_efetivo;
        $clsPas->cod_fim_efetivo = $cod_fim_efetivo;        
        echo($clsPas->AtualizarSituacao());
        break;

    case 'controle':
        $clsPas = new clsPas();
        $clsPas->cod_pas = $_REQUEST['id'];
        $clsPas->txt_justificativa = $txt_justificativa;
        $clsPas->cod_controle = $cod_controle;        
        if(strval($cod_controle) == '2') {
            $clsPas->cod_autorizar = $cod_autorizar;
            $clsPas->cod_usuario_autorizar = $_SESSION['cod_usuario'];
            $clsPas->dt_autorizar = 'CURRENT_TIMESTAMP';
        } else {
            $clsPas->cod_usuario_autorizar = 'NULL';
            $clsPas->dt_autorizar = 'NULL';
            $clsPas->cod_autorizar = 'NULL';
        }

        if (strval($cod_controle) == '3' || strval($cod_controle) == '4') {
            $clsPas->cod_inicio_previsto = $cod_inicio_previsto;
            $clsPas->cod_fim_previsto = $cod_fim_previsto;
        }

        $clsPas->SalvarControle();

        js_go("controle.php?id=".$_REQUEST['id']."&cod_objetivo_url=".$_REQUEST['cod_objetivo_url']);
        break;

    case 'validar_salvar_pas_analise':
        $dt_atual = date('d/m/Y');
        $a_dt_atual = explode('/', $dt_atual);        

        if (intval($a_dt_atual[1]) == 1 || intval($a_dt_atual[1]) == 2) {
            $cod_bimeste = 1;
        } 
        else if (intval($a_dt_atual[1]) == 3 || intval($a_dt_atual[1]) == 4) {
            $cod_bimeste = 2;
        }
        else if (intval($a_dt_atual[1]) == 5 || intval($a_dt_atual[1]) == 6) {
            $cod_bimeste = 3;
        }
        else if (intval($a_dt_atual[1]) == 7 || intval($a_dt_atual[1]) == 8) {
            $cod_bimeste = 4;
        }
        else if (intval($a_dt_atual[1]) == 9 || intval($a_dt_atual[1]) == 10) {
            $cod_bimeste = 5;
        }
        else if (intval($a_dt_atual[1]) == 11 || intval($a_dt_atual[1]) == 12) {
            $cod_bimeste = 6;
        }

        $cod_pas = $_REQUEST['id'];
        $sql = "SELECT * FROM tb_pas_analise WHERE cod_pas = ".$cod_pas." AND cod_bimestre = ".$cod_bimeste;        
        $query = pg_query($sql);           
        if (pg_num_rows($query) == 0) {             
            echo('0');
        }
        else {            
            $rs = pg_fetch_array($query);            
            if (trim($rs['txt_justificativa']) == '') {
                echo('0');
            } else {
                echo('1');
            }  
        }

        break;
}

?>