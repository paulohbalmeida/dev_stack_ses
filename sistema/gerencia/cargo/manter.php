<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsCargo.php");

$acao = $_REQUEST['acao'];
$cod_cargo = $_REQUEST['id'];
$txt_cargo = $_REQUEST['txt_cargo'];
$cod_ativo = $_REQUEST['cod_ativo'];
$txt_descricao = $_REQUEST['txt_descricao'];

switch ($acao) {
    case 'incluir':
        $clsCargo = new clsCargo();
        $clsCargo->txt_cargo = $txt_cargo;
        $clsCargo->cod_ativo = $cod_ativo;
        $clsCargo->txt_descricao = $txt_descricao;
        $clsCargo->IncluirCargo();

        js_go('default.php');                      
        break; 

    case 'excluir':   
        $clsCargo = new clsCargo();
        $clsCargo->cod_cargo = $cod_cargo;
        $resultado = $clsCargo->ExcluirCargo();        
        echo($resultado);
        break;

    case 'alterar':
        $clsCargo = new clsCargo();
        $clsCargo->cod_cargo = $cod_cargo;
        $clsCargo->txt_cargo = $txt_cargo;
        $clsCargo->cod_ativo = $cod_ativo;
        $clsCargo->txt_descricao = $txt_descricao;
        $clsCargo->AlterarCargo();   
                        
        js_go('incluir.php?id='.$cod_cargo.'&status=sucesso');
        break;
    
    case 'validacao_incluir':        
        $clsCargo = new clsCargo();        
        $r1 = $clsCargo->ListarCargo(" UPPER(txt_cargo) = '" .trim(strtoupper($txt_cargo))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;
    
    case 'validacao_alterar':
        $clsCargo = new clsCargo();        
        $r1 = $clsCargo->ListarCargo(" cod_cargo <> ".$cod_cargo." AND UPPER(txt_cargo) = '" .trim(strtoupper($txt_cargo))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;

}   

?>