<?php
include_once (__DIR__ . "/../include/conexao.php");

if(isset($_REQUEST["acao"]))
{	
	$acao = utf8_decode($_REQUEST["acao"]);
    $retorno = array();        

    if($acao == "incluir")
	{	
        $txt_perspectiva = $_REQUEST['txt_perspectiva'];
		$txt_descricao = $_REQUEST['txt_descricao'];
        $cod_ativo = $_REQUEST['cod_ativo'];
		$cod_eixo = $_REQUEST['cod_eixo'];
		$codigo_perspectiva = trim($_REQUEST['codigo_perspectiva']);
	
		$txt_perspectiva = trim($txt_perspectiva);
        $txt_descricao = trim($txt_descricao);            

        if($erro == "" && $cod_eixo == "") {			
			$erro = "O campo EIXO não pode ser vazio.";
		}
		if($erro == "" && $codigo_perspectiva == "") {			
			$erro = "O campo CÓDIGO PERSPECTIVA não pode ser vazio.";
		}
        if($erro == "" && $txt_perspectiva == "") {			
			$erro = "O campo PERSPECTIVA não pode ser vazio.";
		}
		if($erro == "" && $cod_ativo == "") {			
			$erro = "O campo ATIVO não pode ser vazio.";
        }

        if($erro == "") 
		{                      
			$q=pg_query("SELECT * FROM tb_perspectiva WHERE cod_eixo = ".$cod_eixo." AND LOWER(txt_perspectiva)='".trim(strtolower($txt_perspectiva))."'");            
            if (pg_num_rows($q) > 0) {
                $erro = "Perspectiva já está cadastrada no eixo selecionado.";                                
			}
		}
        
        if($erro == "") {
            $rs=pg_fetch_array(pg_query("SELECT MAX(cod_perspectiva) FROM tb_perspectiva"));
			if (!isset($rs[0])) {
				$cod_perspectiva = 1;
			} else {
				$cod_perspectiva = intval($rs[0]) + 1;
            }
            
            $sql = "INSERT INTO tb_perspectiva(cod_perspectiva, cod_eixo, txt_perspectiva, txt_descricao, cod_ativo, codigo_perspectiva)";
            $sql .= " VALUES (".$cod_perspectiva.", ".$cod_eixo.", '".$txt_perspectiva."', '".$txt_descricao."', ".$cod_ativo.", '".$codigo_perspectiva."')";           
			$resultado = pg_query($sql);
			if($resultado)
			{
				Auditoria(51, "", $sql);

				$retorno["status"] = "sucesso";
				$retorno["mensagem"] = "OPERAÇÃO REALIZADA COM SUCESSO.";
				$retorno["id"] = $cod_perspectiva;
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
		$cod_perspectiva = $_REQUEST['id'];
		$txt_perspectiva = $_REQUEST['txt_perspectiva'];
		$txt_descricao = $_REQUEST['txt_descricao'];
        $cod_ativo = $_REQUEST['cod_ativo'];
		$cod_eixo = $_REQUEST['cod_eixo'];
		$codigo_perspectiva = trim($_REQUEST['codigo_perspectiva']);

		$txt_perspectiva = trim($txt_perspectiva);
		$txt_descricao = trim($txt_descricao);
	
		if($erro == "" && $cod_eixo == "") {			
			$erro = "O campo EIXO não pode ser vazio.";
		}
		if($erro == "" && $codigo_perspectiva == "") {			
			$erro = "O campo CÓDIGO PERSPECTIVA não pode ser vazio.";
		}
        if($erro == "" && $txt_perspectiva == "") {			
			$erro = "O campo PERSPECTIVA não pode ser vazio.";
		}
		if($erro == "" && $cod_ativo == "") {			
			$erro = "O campo ATIVO não pode ser vazio.";
        }

        if($erro == "") 
		{                      
			$q=pg_query("SELECT * FROM tb_perspectiva WHERE cod_perspectiva <> ".$cod_perspectiva." AND cod_eixo = ".$cod_eixo." AND LOWER(txt_perspectiva)='".trim(strtolower($txt_perspectiva))."'");            
            if (pg_num_rows($q) > 0) {
                $erro = "Perspectiva já está cadastrada no eixo selecionado.";                                
			}
		}
		
		if($erro == "") {			
			$sql = "UPDATE tb_perspectiva SET cod_eixo = '$cod_eixo', txt_perspectiva = '$txt_perspectiva', txt_descricao = '$txt_descricao', cod_ativo = '$cod_ativo', codigo_perspectiva = '$codigo_perspectiva' WHERE cod_perspectiva = '$cod_perspectiva'";			
			$resultado = pg_query($sql);
			if($resultado)
			{
				Auditoria(52, "", $sql);

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
		$cod_perspectiva = $_REQUEST['cod_perspectiva'];

		$q=pg_query("SELECT * FROM tb_diretriz WHERE cod_perspectiva = " .$cod_perspectiva);
		$rs=pg_fetch_array($q);
		if (pg_num_rows($q) > 0) {
			$erro = "Perspectiva não pode ser excluída. Pois, está vinculada a diretriz ". $rs['txt_diretriz'] .".";
		}

		if($erro == "") {
			$rs=pg_fetch_array(pg_query("SELECT txt_perspectiva FROM tb_perspectiva WHERE cod_perspectiva = ".$cod_perspectiva));        

			$sql = "DELETE FROM tb_perspectiva WHERE cod_perspectiva = '$cod_perspectiva'";
			$resultado = pg_query($sql);
			if($resultado)
			{
				Auditoria(53, "EXCLUIR PERSPECTIVA: ".$rs['txt_perspectiva'], $sql);

				$retorno["status"] = "sucesso";
				$retorno["mensagem"] = "PERSPECTIVA EXCLUÍDA.";
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