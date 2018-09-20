<?php
include_once(__DIR__ . "/include/conexao.php");

$_SESSION["cod_usuario"] = null;
session_destroy();

js_go("login.php");
?>