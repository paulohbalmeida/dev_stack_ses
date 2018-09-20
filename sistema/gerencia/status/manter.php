<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsStatus.php");

$acao = $_REQUEST['acao'];
$cod_status = $_REQUEST['id'];
$txt_status = $_REQUEST['txt_status'];
$cod_ativo = $_REQUEST['cod_ativo'];
$txt_descricao = $_REQUEST['txt_descricao'];
$txt_cor = $_REQUEST['txt_cor'];

switch ($acao) {
    case 'incluir':
        $clsStatus = new clsStatus();
        $clsStatus->txt_status = $txt_status;
        $clsStatus->cod_ativo = $cod_ativo;
        $clsStatus->txt_descricao = $txt_descricao;
        $clsStatus->txt_cor = $txt_cor;
        $clsStatus->IncluirStatus();

        js_go('default.php');                      
        break; 

    case 'excluir':   
        $clsStatus = new clsStatus();
        $clsStatus->cod_status = $cod_status;
        $resultado = $clsStatus->ExcluirStatus();        
        echo($resultado);
        break;

    case 'alterar':
        $clsStatus = new clsStatus();
        $clsStatus->cod_status = $cod_status;
        $clsStatus->txt_status = $txt_status;
        $clsStatus->cod_ativo = $cod_ativo;
        $clsStatus->txt_descricao = $txt_descricao;
        $clsStatus->txt_cor = $txt_cor;
        $clsStatus->AlterarStatus();   
                        
        js_go('incluir.php?id='.$cod_status.'&status=sucesso');
        break;
    
    case 'validacao_incluir':        
        $clsStatus = new clsStatus();        
        $r1 = $clsStatus->ListarStatus(" LOWER(txt_status) = '" .trim(strtolower($txt_status))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;
    
    case 'validacao_alterar':
        $clsStatus = new clsStatus();        
        $r1 = $clsStatus->ListarStatus(" cod_status <> ".$cod_status." AND UPPER(txt_status) = '" .trim(strtoupper($txt_status))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;

}   

?>