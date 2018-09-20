<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsPerfil.php");

$acao = $_REQUEST['acao'];
$cod_perfil = $_REQUEST['id'];
$txt_perfil = $_REQUEST['txt_perfil'];
$cod_ativo = $_REQUEST['cod_ativo'];
$txt_descricao = $_REQUEST['txt_descricao'];
$cod_permissao = $_REQUEST['cod_permissao'];

switch ($acao) {
    case 'incluir':
        $clsPerfil = new clsPerfil();
        $clsPerfil->txt_perfil = $txt_perfil;
        $clsPerfil->cod_ativo = $cod_ativo;
        $clsPerfil->txt_descricao = $txt_descricao;
        $clsPerfil->IncluirPerfil();

        js_go('default.php');                      
        break; 

    case 'excluir':   
        $clsPerfil = new clsPerfil();
        $clsPerfil->cod_perfil = $cod_perfil;
        $resultado = $clsPerfil->ExcluirPerfil();        
        echo($resultado);
        break;

    case 'alterar':
        $clsPerfil = new clsPerfil();
        $clsPerfil->cod_perfil = $cod_perfil;
        $clsPerfil->txt_perfil = $txt_perfil;
        $clsPerfil->cod_ativo = $cod_ativo;
        $clsPerfil->txt_descricao = $txt_descricao;
        $clsPerfil->AlterarPerfil();   
                        
        js_go('incluir.php?id='.$cod_perfil.'&status=sucesso');
        break;
    
    case 'validacao_incluir':        
        $clsPerfil = new clsPerfil();        
        $r1 = $clsPerfil->ListarPerfil(" UPPER(txt_perfil) = '" .trim(strtoupper($txt_perfil))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;
    
    case 'validacao_alterar':
        $clsPerfil = new clsPerfil();        
        $r1 = $clsPerfil->ListarPerfil(" cod_perfil <> ".$cod_perfil." AND UPPER(txt_perfil) = '" .trim(strtoupper($txt_perfil))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;

    case 'permissao':        
        $clsPerfil = new clsPerfil();
        $clsPerfil->cod_perfil = $cod_perfil;
        $clsPerfil->cod_permissao = $cod_permissao;
        $clsPerfil->Permissao();    
        
        js_alert("OPERAÇÃO REALIZADA COM SUCESSO");
        js_go("permissao.php?id=".$cod_perfil);
        break;

}   

?>