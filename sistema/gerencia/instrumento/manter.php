<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsInstrumento.php");

$acao = $_REQUEST['acao'];
$cod_modulo = $_REQUEST['id'];
$txt_modulo = $_REQUEST['txt_modulo'];
$cod_ativo = $_REQUEST['cod_ativo'];
$cod_exibir_consulta = $_REQUEST['cod_exibir_consulta'];
$cod_status = $_REQUEST['cod_status'];
$cod_exibir_consulta = $_REQUEST['cod_exibir_consulta'];

switch ($acao) {
    case 'incluir':
        $clsInstrumento = new clsInstrumento();
        $clsInstrumento->txt_modulo = $txt_modulo;
        $clsInstrumento->cod_ativo = $cod_ativo;
        $clsInstrumento->cod_exibir_consulta = $cod_exibir_consulta;
        $clsInstrumento->IncluirModulo();

        js_go('default.php');                      
        break; 

    case 'excluir':   
        $clsInstrumento = new clsInstrumento();
        $clsInstrumento->cod_modulo = $cod_modulo;
        $resultado = $clsInstrumento->ExcluirModulo();
        echo($resultado);
        break;

    case 'alterar':
        $clsInstrumento = new clsInstrumento();
        $clsInstrumento->cod_modulo = $cod_modulo;
        $clsInstrumento->txt_modulo = $txt_modulo;
        $clsInstrumento->cod_ativo = $cod_ativo;
        $clsInstrumento->cod_exibir_consulta = $cod_exibir_consulta;
        $clsInstrumento->AlterarModulo();   
                        
        js_go('incluir.php?id='.$cod_modulo.'&status=sucesso');
        break;
    
    case 'validacao_incluir':        
        $clsInstrumento = new clsInstrumento();        
        $r1 = $clsInstrumento->ListarModulo(" UPPER(txt_modulo) = '" .trim(strtoupper($txt_modulo))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;
    
    case 'validacao_alterar':
        $clsInstrumento = new clsInstrumento();        
        $r1 = $clsInstrumento->ListarModulo(" cod_modulo <> ".$cod_modulo." AND UPPER(txt_modulo) = '" .trim(strtoupper($txt_modulo))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;

    case 'status':
        $clsInstrumento = new clsInstrumento();
        $clsInstrumento->cod_modulo = $cod_modulo;
        $clsInstrumento->cod_status = $cod_status;
        $clsInstrumento->cod_exibir_consulta = $cod_exibir_consulta;
        $resultado = $clsInstrumento->IncluirStatus();        
        js_go('situacao.php?id='.$cod_modulo);
        break;

    case 'excluir_status':
        $clsInstrumento = new clsInstrumento();
        $clsInstrumento->cod_modulo = $cod_modulo;
        $clsInstrumento->cod_status = $cod_status;
        $resultado = $clsInstrumento->ExcluirStatus();           
        echo($resultado); 
        break;

    case 'alterar_status':
        $clsInstrumento = new clsInstrumento();
        $clsInstrumento->cod_modulo = $cod_modulo;
        $clsInstrumento->cod_status = $cod_status;
        $clsInstrumento->cod_exibir_consulta = $cod_exibir_consulta;
        $resultado = $clsInstrumento->AlterarStatus();        
        js_go('situacao.php?id='.$cod_modulo);
        break;
}   

?>