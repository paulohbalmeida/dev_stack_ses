<?php
include_once(__DIR__ . "/include/conexao.php");
include_once (__DIR__ . "/classes/clsUsuario.php");

$cpf = $_REQUEST['field_login'];
$senha = $_REQUEST['field_password'];

if ($cpf == "" || $senha == "") {
    echo("ERRO AO CONECTAR");
    exit();
}

//TESTAR CONEXÃO SEM LDAP
if (strval($_SESSION["cod_ldap"]) == "0") {
    if ($cpf == 'administrador' && $senha == 'abcd1234') {
        $_SESSION["txt_login"] = "ADMINISTRADOR";
        $_SESSION["cod_usuario"] = "0";
        $_SESSION["txt_usuario"] = "ADMINISTRADOR DO SISTEMA";
        $_SESSION["cod_perfil"] = 1;
        $_SESSION["cod_orgao"] = 0;
    
        js_go("index.php");
    }
}
/*--------------------------*/

$ldap_server = "";
$user = trim($cpf)."";
$ldap_pass = $senha;
$ldapcon = ldap_connect($ldap_server);

if ($ldapcon){    
    $bind = @ldap_bind($ldapcon, "", "");
    
    if ($bind) {        
        $bind = @ldap_bind($ldapcon, $user, $ldap_pass);
        ldap_close($ldapcon);
        if ($bind == 1) {
            $clsUsuario = new clsUsuario();
            $q = $clsUsuario->ListarUsuario(" txt_login = '".trim($cpf)."'");            
            if (pg_num_rows($q) > 0) {   
                $rs1 = pg_fetch_array($q);             
                if (limpar_comparacao($rs1['cod_ativo']) == 0) {                    
                    js_go("login.php?mensagem=1");
                } else {
                    $_SESSION["txt_login"] = $rs1['txt_login'];
                    $_SESSION["cod_usuario"] = $rs1['cod_usuario'];
                    $_SESSION["txt_usuario"] = $rs1['txt_usuario'];
                    $_SESSION["cod_perfil"] = $rs1['cod_perfil'];
                    $_SESSION["cod_orgao"] = $rs1['cod_orgao'];

                    Auditoria(1, "Usuário autenticado", "");

                    js_go("index.php");
                }
            }
            else {                
                js_go("login.php?mensagem=3");
            }            
        } else {
            js_go("login.php?mensagem=2");            
        }
    } else {
        js_go("login.php?mensagem=4");
        exit();
    }

}
?>