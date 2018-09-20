<?php
include_once (__DIR__ . "/../include/conexao.php");

if(isset($_REQUEST["acao"]))
{	
	$acao = utf8_decode($_REQUEST["acao"]);
	$retorno = array();
	$erro = "";

	if($acao == "incluir")
	{		
		$txt_eixo = isset($_REQUEST["txt_eixo"]) ? $_REQUEST["txt_eixo"] : null;
		$txt_descricao = $_REQUEST['txt_descricao'];
		$cod_ativo = $_REQUEST['cod_ativo'];
		$codigo_eixo = trim($_REQUEST['codigo_eixo']);
	
		$txt_eixo = trim($txt_eixo);
		$txt_descricao = trim($txt_descricao);

		if($erro == "" && $codigo_eixo == "") {			
			$erro = "O campo CÓDIGO EIXO não pode ser vazio.";
		}
		if($erro == "" && $txt_eixo == "") {			
			$erro = "O campo EIXO não pode ser vazio.";
		}
		if($erro == "" && $cod_ativo == "") {			
			$erro = "O campo ATIVO não pode ser vazio.";
		}

		if($erro == "") 
		{			
			$q=pg_query("SELECT cod_eixo FROM tb_eixo WHERE LOWER(txt_eixo)='".trim(strtolower($txt_eixo))."'");
			if (pg_num_rows($q) > 0) {
				$erro = "Eixo já está cadastrado.";
			}
		}
		
		if($erro == "") {
			$rs=pg_fetch_array(pg_query("SELECT MAX(cod_eixo) FROM tb_eixo"));
			if (!isset($rs[0])) {
				$cod_eixo = 1;
			} else {
				$cod_eixo = intval($rs[0]) + 1;
			}

			$sql = "INSERT INTO tb_eixo(cod_eixo, codigo_eixo, txt_eixo, txt_descricao, cod_ativo) VALUES ('$cod_eixo', '$codigo_eixo', '$txt_eixo', '$txt_descricao', '$cod_ativo')";
			$resultado = pg_query($sql);
			if($resultado)
			{
				Auditoria(47, "", $sql);

				$retorno["status"] = "sucesso";
				$retorno["mensagem"] = "OPERAÇÃO REALIZADA COM SUCESSO.";
				$retorno["id"] = $cod_eixo;
			}
			else
			{
				$retorno["status"] = "falha";
				$retorno["mensagem"] = $sql;
			}			
		}
		else
		{
			$retorno["status"] = "falha";
			$retorno["mensagem"] = $erro;
		}
		
		echo(json_encode($retorno));
	}	
	else if($acao == "alterar") 
	{
		$cod_eixo = $_REQUEST['id'];
		$txt_eixo = $_REQUEST['txt_eixo'];
		$txt_descricao = $_REQUEST['txt_descricao'];
		$cod_ativo = $_REQUEST['cod_ativo'];
		$codigo_eixo = trim($_REQUEST['codigo_eixo']);

		$txt_eixo = trim($txt_eixo);
		$txt_descricao = trim($txt_descricao);
	
		if($erro == "" && $codigo_eixo == "") {			
			$erro = "O campo CÓDIGO EIXO não pode ser vazio.";
		}
		if($erro == "" && $txt_eixo == "") {			
			$erro = "O campo EIXO não pode ser vazio.";
		}
		if($erro == "" && $cod_ativo == "") {			
			$erro = "O campo ATIVO não pode ser vazio.";
		}

		if($erro == "") 
		{
			$q=pg_query("SELECT cod_eixo FROM tb_eixo WHERE cod_eixo <> ".$cod_eixo." AND LOWER(txt_eixo)='".trim(strtolower($txt_eixo))."'");
			if (pg_num_rows($q) > 0) {
				$erro = "Eixo já está cadastrado.";
			}
		}		
		
		if($erro == "") {			
			$sql = "UPDATE tb_eixo SET txt_eixo = '$txt_eixo', txt_descricao = '$txt_descricao', cod_ativo = '$cod_ativo', codigo_eixo = '$codigo_eixo' WHERE cod_eixo = '$cod_eixo'";			
			$resultado = pg_query($sql);
			if($resultado)
			{
				Auditoria(48, "", $sql);

				$retorno["status"] = "sucesso";
				$retorno["mensagem"] = "DADOS ALTERADOS.";
			}
			else
			{
				$retorno["status"] = "falha";
				$retorno["mensagem"] = $sql;
			}			
		}
		else
		{
			$retorno["status"] = "falha";
			$retorno["mensagem"] = $erro;
		}
		
		echo(json_encode($retorno));
	}
	else if($acao == "excluir")
	{
		$cod_eixo = isset($_REQUEST["cod_eixo"]) ? $_REQUEST["cod_eixo"] : null;

		$q=pg_query("SELECT * FROM tb_perspectiva WHERE cod_eixo = " .$cod_eixo);
		$rs=pg_fetch_array($q);
		if (pg_num_rows($q) > 0) {
			$erro = "Eixo não pode ser excluído. Pois, está vinculada a perspectiva ". $rs['txt_perspectiva'] .".";
		}

		if($erro == "") {
			$rs=pg_fetch_array(pg_query("SELECT txt_eixo FROM tb_eixo WHERE cod_eixo = ".$cod_eixo));        

			$sql = "DELETE FROM tb_eixo WHERE cod_eixo = '$cod_eixo'";
			$resultado = pg_query($sql);
			if($resultado)
			{
				Auditoria(49, "EXCLUIR EIXO: ".$rs['txt_eixo'], $sql);

				$retorno["status"] = "sucesso";
				$retorno["mensagem"] = "EIXO EXCLUÍDO.";
			}
			else
			{
				$retorno["status"] = "falha";
				$retorno["mensagem"] = $sql;
			}		
		}
		else {
			$retorno["status"] = "falha";
			$retorno["mensagem"] = $erro;
		}		

		echo(json_encode($retorno));
	}
}


?>
      
