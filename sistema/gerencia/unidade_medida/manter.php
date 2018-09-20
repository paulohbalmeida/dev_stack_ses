<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsUnidadeMedida.php");

$acao = $_REQUEST['acao'];
$cod_unidade_medida = $_REQUEST['id'];
$txt_unidade_medida = $_REQUEST['txt_unidade_medida'];
$cod_ativo = $_REQUEST['cod_ativo'];


switch ($acao) {
    case 'incluir':
        $clsUnidadeMedida = new clsUnidadeMedida();
        $clsUnidadeMedida->txt_unidade_medida = $txt_unidade_medida;
        $clsUnidadeMedida->cod_ativo = $cod_ativo;
        $clsUnidadeMedida->IncluirUnidadeMedida();

        js_go('default.php');                      
        break; 

    case 'excluir':   
        $clsUnidadeMedida = new clsUnidadeMedida();
        $clsUnidadeMedida->cod_unidade_medida = $cod_unidade_medida;
        $clsUnidadeMedida->ExcluirUnidadeMedida();
        break;

    case 'alterar':
        $clsUnidadeMedida = new clsUnidadeMedida();
        $clsUnidadeMedida->cod_unidade_medida = $cod_unidade_medida;
        $clsUnidadeMedida->txt_unidade_medida = $txt_unidade_medida;
        $clsUnidadeMedida->cod_ativo = $cod_ativo;
        $clsUnidadeMedida->AlterarUnidadeMedida();   
                        
        js_go('incluir.php?id='.$cod_unidade_medida.'&status=sucesso');
        break;
    
    case 'validacao_incluir':        
        $clsUnidadeMedida = new clsUnidadeMedida();        
        $r1 = $clsUnidadeMedida->ListarUnidadeMedida(" UPPER(txt_unidade_medida) = '" .trim(strtoupper($txt_unidade_medida))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;
    
    case 'validacao_alterar':
        $clsUnidadeMedida = new clsUnidadeMedida();        
        $r1 = $clsUnidadeMedida->ListarUnidadeMedida(" cod_unidade_medida <> ".$cod_unidade_medida." AND UPPER(txt_unidade_medida) = '" .trim(strtoupper($txt_unidade_medida))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;

}   

?>