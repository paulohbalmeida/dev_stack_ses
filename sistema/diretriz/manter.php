<?php
include_once (__DIR__ . "/../include/conexao.php");

if(isset($_REQUEST["acao"]))
{
    $acao = utf8_decode($_REQUEST["acao"]);
    $retorno = array();        

    if($acao == "incluir")
	{	
        $txt_diretriz = $_REQUEST['txt_diretriz'];
		$txt_descricao = $_REQUEST['txt_descricao'];
        $cod_ativo = $_REQUEST['cod_ativo'];
        $cod_eixo = $_REQUEST['cod_eixo'];
		$cod_perspectiva = $_REQUEST['cod_perspectiva'];
		$codigo_diretriz = trim($_REQUEST['codigo_diretriz']);
	
		$txt_diretriz = trim($txt_diretriz);
        $txt_descricao = trim($txt_descricao);            

        if($erro == "" && $cod_eixo == "") {			
			$erro = "O campo EIXO não pode ser vazio.";
        }
        if($erro == "" && $cod_perspectiva == "") {			
			$erro = "O campo PERSPECTIVA não pode ser vazio.";
		}
		if($erro == "" && $codigo_diretriz == "") {			
			$erro = "O campo CÓDIGO DIRETRIZ não pode ser vazio.";
		}
        if($erro == "" && $txt_diretriz == "") {			
			$erro = "O campo DIRETRIZ não pode ser vazio.";
		}
		if($erro == "" && $cod_ativo == "") {			
			$erro = "O campo ATIVO não pode ser vazio.";
        }

        if($erro == "") 
		{  						
			$q=pg_query("SELECT * FROM tb_diretriz WHERE cod_perspectiva = ".$cod_perspectiva." AND cod_eixo = ".$cod_eixo." AND LOWER(txt_diretriz)='".trim(strtolower($txt_diretriz))."'");            
            if (pg_num_rows($q) > 0) {
                $erro = "Diretriz já está cadastrada no eixo e perspectiva selecionados.";                                
			}
		}
        
        if($erro == "") {
            $rs=pg_fetch_array(pg_query("SELECT MAX(cod_diretriz) FROM tb_diretriz"));
			if (!isset($rs[0])) {
				$cod_diretriz = 1;
			} else {
				$cod_diretriz = intval($rs[0]) + 1;
            }
            
            $sql = "INSERT INTO tb_diretriz(cod_diretriz, cod_eixo, cod_perspectiva, txt_diretriz, txt_descricao, cod_ativo, codigo_diretriz)";
            $sql .= " VALUES (".$cod_diretriz.", ".$cod_eixo.", ".$cod_perspectiva.", '".$txt_diretriz."', '".$txt_descricao."', ".$cod_ativo.", '".trim($codigo_diretriz)."')";
			$resultado = @pg_query($sql);
			if($resultado)
			{
				Auditoria(55, "", $sql);

				$retorno["status"] = "sucesso";
				$retorno["mensagem"] = "OPERAÇÃO REALIZADA COM SUCESSO.";
				$retorno["id"] = $cod_diretriz;
			}
			else
			{
				$retorno["status"] = "falha";
				$retorno["mensagem"] = "Diretriz já está cadastrada no eixo e perspectiva selecionados.";
			}	
        }
        else
		{
			$retorno["status"] = "falha";
			$retorno["mensagem"] = $erro;
		}				
    }
    else if($acao == "alterar") 
	{
        $cod_diretriz = $_REQUEST['id'];
		$txt_diretriz = $_REQUEST['txt_diretriz'];
		$txt_descricao = $_REQUEST['txt_descricao'];
        $cod_ativo = $_REQUEST['cod_ativo'];
        $cod_eixo = $_REQUEST['cod_eixo'];
		$cod_perspectiva = $_REQUEST['cod_perspectiva'];
		$codigo_diretriz = trim($_REQUEST['codigo_diretriz']);
	
		$txt_diretriz = trim($txt_diretriz);
        $txt_descricao = trim($txt_descricao);                    

        if($erro == "" && $cod_eixo == "") {			
			$erro = "O campo EIXO não pode ser vazio.";
        }
        if($erro == "" && $cod_perspectiva == "") {			
			$erro = "O campo PERSPECTIVA não pode ser vazio.";
		}
		if($erro == "" && $codigo_diretriz.trim() == "") {			
			$erro = "O campo CÓDIGO DIRETRIZ não pode ser vazio.";
		}
        if($erro == "" && $txt_diretriz.trim() == "") {			
			$erro = "O campo DIRETRIZ não pode ser vazio.";
		}
		if($erro == "" && $cod_ativo == "") {			
			$erro = "O campo ATIVO não pode ser vazio.";
        }

        if($erro == "") 
		{                                
			$q=pg_query("SELECT * FROM tb_diretriz WHERE cod_diretriz <> ".$cod_diretriz." AND cod_perspectiva = ".$cod_perspectiva." AND cod_eixo = ".$cod_eixo." AND LOWER(txt_diretriz)='".trim(strtolower($txt_diretriz))."'");            
            if (pg_num_rows($q) > 0) {
                $erro = "Diretriz já está cadastrada no eixo e perspectiva selecionados.";                                
			}
		}
		
		if($erro == "") {			
            $sql = "UPDATE tb_diretriz SET cod_eixo = ".$cod_eixo.", cod_perspectiva = ".$cod_perspectiva.", txt_diretriz='".$txt_diretriz."', txt_descricao = '".$txt_descricao."', cod_ativo = ".$cod_ativo.", codigo_diretriz = '".trim($codigo_diretriz)."' WHERE cod_diretriz = ".$cod_diretriz;
			$resultado = @pg_query($sql);
			if($resultado)
			{
				Auditoria(56, "", $sql);

				$retorno["status"] = "sucesso";
				$retorno["mensagem"] = "DADOS ALTERADOS.";
			}
			else
			{
				$retorno["status"] = "falha";
				$retorno["mensagem"] = "Diretriz já está cadastrada no eixo e perspectiva selecionados.";
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
		$cod_diretriz = $_REQUEST['cod_diretriz'];		

		$q=pg_query("SELECT * FROM tb_objetivo WHERE cod_diretriz = " .$cod_diretriz);
		$rs=pg_fetch_array($q);
		if (pg_num_rows($q) > 0) {
			$erro = "Diretriz não pode ser excluída. Pois, está vinculada ao objetivo ". $rs['txt_objetivo'] .".";
		}

		if($erro == "") {
			$rs=pg_fetch_array(pg_query("SELECT txt_diretriz FROM tb_diretriz WHERE cod_diretriz = ".$cod_diretriz));

			$sql = "DELETE FROM tb_diretriz WHERE cod_diretriz = " .$cod_diretriz;
			$resultado = pg_query($sql);
			if($resultado)
			{
				Auditoria(57, "EXCLUIR DIRETRIZ: ".$rs['txt_diretriz'], $sql);

				$retorno["status"] = "sucesso";
				$retorno["mensagem"] = "DIRETRIZ EXCLUÍDA.";
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
	}

    echo(json_encode($retorno));
}

?>