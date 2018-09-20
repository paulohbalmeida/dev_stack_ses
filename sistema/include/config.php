<?php 
session_start();
$dominio= $_SERVER['HTTP_HOST'];
$url = "http://" . $dominio;
 
//LOCAL
$_SESSION["txt_host"] = $url;
$_SESSION["url_api_mgi"] = "";

$_SESSION["txt_pagina_login"] = $_SESSION["txt_host"]."/sesplan_branch/sesplan/index.html";
$_SESSION["txt_caminho_aplicacao"] = $_SESSION["txt_host"]."/sesplan_branch/sesplan/sistema";
$_SESSION["txt_sigla_sistema"] = "SESPLAN";
$_SESSION["txt_pagina_inicial"] = $_SESSION["txt_caminho_aplicacao"]."/index.php";
$_SESSION["cod_auditoria"] = "0";
$_SESSION["cod_ldap"] = "0";
?>