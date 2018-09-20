<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsUsuario.php");

$acao = $_REQUEST['acao'];
$cod_usuario = $_REQUEST['id'];
$txt_cpf = $_REQUEST['txt_cpf'];
$cod_ativo = $_REQUEST['cod_ativo'];
$txt_usuario = $_REQUEST['txt_usuario'];
$txt_email = $_REQUEST['txt_email'];
$cod_perfil = $_REQUEST['cod_perfil'];
$txt_login = $_REQUEST['txt_login'];
$txt_matricula = $_REQUEST['txt_matricula'];
$cod_orgao = $_REQUEST['cod_orgao'];
$cod_cargo = $_REQUEST['cod_cargo'];

switch ($acao) {
    case 'validacao_incluir':                  
        $clsUsuario = new clsUsuario();        
        $r1 = $clsUsuario->ListarUsuario(" txt_cpf = '".preg_replace('/\W+/u', '', trim($txt_cpf))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;

    case 'validacao_alterar':
        $clsUsuario = new clsUsuario();        
        $r1 = $clsUsuario->ListarUsuario(" cod_usuario <> ".$cod_usuario." AND txt_cpf = '".preg_replace('/\W+/u', '', trim($txt_cpf))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;

    case 'incluir':
        $clsUsuario = new clsUsuario();
        $clsUsuario->txt_cpf = $txt_cpf;
        $clsUsuario->cod_ativo = $cod_ativo;
        $clsUsuario->txt_usuario = $txt_usuario;
        $clsUsuario->txt_email = $txt_email;
        $clsUsuario->cod_perfil = $cod_perfil;
        $clsUsuario->txt_login = $txt_login;
        $clsUsuario->txt_matricula = $txt_matricula;
        $clsUsuario->cod_cargo = $cod_cargo;
        $clsUsuario->cod_orgao = $cod_orgao;
        $clsUsuario->IncluirUsuario();

        js_go('default.php');                      
        break; 

    case 'alterar':
        $clsUsuario = new clsUsuario();
        $clsUsuario->cod_usuario = $cod_usuario;
        $clsUsuario->txt_cpf = $txt_cpf;
        $clsUsuario->cod_ativo = $cod_ativo;
        $clsUsuario->txt_usuario = $txt_usuario;
        $clsUsuario->txt_email = $txt_email;
        $clsUsuario->cod_perfil = $cod_perfil;
        $clsUsuario->txt_login = $txt_login;
        $clsUsuario->txt_matricula = $txt_matricula;
        $clsUsuario->cod_cargo = $cod_cargo;
        $clsUsuario->cod_orgao = $cod_orgao;
        $clsUsuario->AlterarUsuario();   
                        
        js_go('default.php');
        break;

    case 'excluir':   
        $clsUsuario = new clsUsuario();
        $clsUsuario->cod_usuario = $cod_usuario;
        $resultado = $clsUsuario->ExcluirUsuario();        
        echo($resultado);
        break;    

    case 'unidade':
        $clsUsuario = new clsUsuario();
        $clsUsuario->cod_usuario = $cod_usuario;
        $clsUsuario->cod_orgao = $cod_orgao;
        $resultado = $clsUsuario->IncluirUnidade();        
        js_go('unidade.php?id='.$cod_usuario);
        break;

    case 'excluir_unidade':
        $clsUsuario = new clsUsuario();
        $clsUsuario->cod_usuario = $cod_usuario;
        $clsUsuario->cod_orgao = $cod_orgao;
        $resultado = $clsUsuario->ExcluirUnidade();           
        echo($resultado); 
        break;
}

?>