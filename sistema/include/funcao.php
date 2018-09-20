<?php

function js_alert($mensagem)
{
    print "<script language=javascript> alert('$mensagem');</script>";
}

function js_go($txt_pagina)
{
    echo("<script language=javascript>self.location.href='$txt_pagina';</script>");
}

function js_go_back($mensagem)
{ 
    echo("<script language=javascript>alert('$mensagem');history.go(-1);</script>");
}

function destacar_ativo($valor) {
    if ($valor == "1") {
        return "<font color=\"green\"><b>SIM</b></font>";
    } else {
        return "<font color=\"red\"><b>NÃO</b></font>";
    }
}

function destacar_ativo2($valor) {
    if ($valor == "1") {
        return "SIM";
    } else {
        return "NÃO";
    }
}

function limpar_comparacao($texto) {
	if ($texto!="") {
		$texto=trim($texto);
		if (is_numeric($texto)) {
			$texto=intval($texto);
		}
	}
	return $texto;
}

function RetornaTextoMes($cod_mes) {
    switch ($cod_mes) { 
        case "1":
            $txt_mes = "Janeiro";
            break;
        case "2":
            $txt_mes = "Fevereiro";
            break;
        case "3":
            $txt_mes = "Março";
            break;
        case "4":
            $txt_mes = "Abril";
            break;
        case "5":
            $txt_mes = "Maio";
            break;
        case "6":
            $txt_mes = "Junho";
            break;
        case "7":
            $txt_mes = "Julho";
            break;
        case "8":
            $txt_mes = "Agosto";
            break;
        case "9":
            $txt_mes = "Setembro";
            break;
        case "10":
            $txt_mes = "Outubro";
            break;
        case "11":
            $txt_mes = "Novembro";
            break;
        case "12":
            $txt_mes = "Dezembro";
            break;
    }

    return $txt_mes;
}

function RetornaTextoMesPAS($cod_mes) {
    switch ($cod_mes) { 
        case "1":
            $txt_mes = "Janeiro/Fevereiro";
            break;       
        case "2":
            $txt_mes = "Março/Abril";
            break;       
        case "3":
            $txt_mes = "Maio/Junho";
            break;      
        case "4":
            $txt_mes = "Julho/Agosto";
            break;
        case "5":
            $txt_mes = "Setembro/Outubro";
            break;      
        case "6":
            $txt_mes = "Novembro/Dezembro";
            break;       
    }

    return $txt_mes;
}

function MascaraCPF($cpf) {
    $parte_um     = substr($cpf, 0, 3);
    $parte_dois   = substr($cpf, 3, 3);
    $parte_tres   = substr($cpf, 6, 3);
    $parte_quatro = substr($cpf, 9, 2);

    return $parte_um.".".$parte_dois.".".$parte_tres."-".$parte_quatro;
}

function FormataData($data) {
    if (!empty($data)) {
        return date("d/m/Y", strtotime($data));
    } else {
        return '';
    }    
}

function DataBanco($dateSql){
    $ano= substr($dateSql, 6);
    $mes= substr($dateSql, 3,-5);
    $dia= substr($dateSql, 0,-8);
    return $ano."-".$mes."-".$dia;
}

?>