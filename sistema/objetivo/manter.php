<?php
include_once (__DIR__ . "/../include/conexao.php");

if(isset($_REQUEST["acao"]))
{
    $acao = utf8_decode($_REQUEST["acao"]);
    $retorno = array();   

    if($acao == "incluir") {
        $cod_eixo = $_REQUEST['cod_eixo'];
        $cod_perspectiva = $_REQUEST['cod_perspectiva'];
        $cod_diretriz = $_REQUEST['cod_diretriz'];
        $txt_objetivo = $_REQUEST['txt_objetivo'];
        $cod_ativo = $_REQUEST['cod_ativo'];
        $txt_descricao = $_REQUEST['txt_descricao'];
        $codigo_objetivo = trim($_REQUEST['codigo_objetivo']);  

        $txt_objetivo = trim($txt_objetivo);
        $txt_descricao = trim($txt_descricao);   

        $rs=pg_fetch_array(pg_query("SELECT MAX(cod_objetivo) FROM tb_objetivo"));
        if (!isset($rs[0])) {
            $cod_objetivo = 1;
        } else {
            $cod_objetivo = intval($rs[0]) + 1;
        }

        $sql = "INSERT INTO tb_objetivo(cod_objetivo, cod_eixo, cod_perspectiva, cod_diretriz, txt_objetivo, txt_descricao, cod_ativo, codigo_objetivo) VALUES(".$cod_objetivo.", ".$cod_eixo.", ".$cod_perspectiva.", ".$cod_diretriz.", '".$txt_objetivo."', '".$txt_descricao."', ".$cod_ativo.", '".trim($codigo_objetivo)."')";
        $resultado = pg_query($sql);
        if($resultado)
        {
            Auditoria(59, "", $sql);

            $retorno["status"] = "sucesso";
            $retorno["mensagem"] = "OPERAÇÃO REALIZADA COM SUCESSO.";
            $retorno["id"] = $cod_objetivo;
        }
        else
        {
            $retorno["status"] = "falha";
            $retorno["mensagem"] = $sql;
        }	       
    }
    else if ($acao == "alterar") {
        $cod_objetivo = $_REQUEST['id'];
        $cod_eixo = $_REQUEST['cod_eixo'];
        $cod_perspectiva = $_REQUEST['cod_perspectiva'];
        $cod_diretriz = $_REQUEST['cod_diretriz'];
        $txt_objetivo = $_REQUEST['txt_objetivo'];
        $cod_ativo = $_REQUEST['cod_ativo'];
        $txt_descricao = $_REQUEST['txt_descricao'];
        $codigo_objetivo = trim($_REQUEST['codigo_objetivo']);  

        $txt_objetivo = trim($txt_objetivo);
        $txt_descricao = trim($txt_descricao); 

        $sql = "UPDATE tb_objetivo SET cod_eixo = ".$cod_eixo.", cod_perspectiva = ".$cod_perspectiva.", cod_diretriz = ".$cod_diretriz.", txt_objetivo = '".$txt_objetivo."', txt_descricao = '".$txt_descricao."', cod_ativo = ".$cod_ativo.", codigo_objetivo = '".trim($codigo_objetivo)."' WHERE cod_objetivo = ".$cod_objetivo;
        $resultado = pg_query($sql);
        if($resultado)
        {
            Auditoria(60, "", $sql);

            $retorno["status"] = "sucesso";
            $retorno["mensagem"] = "DADOS ALTERADOS.";
            $retorno["id"] = $cod_objetivo;
        }
        else
        {
            $retorno["status"] = "falha";
            $retorno["mensagem"] = $sql;
        }	      
    }
    else if($acao == "excluir")
	{
        $cod_objetivo = $_REQUEST['cod_objetivo'];	
        
        $q=pg_query("SELECT * FROM tb_objetivo_ppa WHERE cod_objetivo = " .$cod_objetivo);
		$rs=pg_fetch_array($q);
		if (pg_num_rows($q) > 0) {
			$erro = "Objetivo não pode ser excluído. Pois, está vinculado ao objetivo PPA ". $rs['txt_objetivo_ppa'] .".";
		}

		if($erro == "") {
            $rs=pg_fetch_array(pg_query("SELECT txt_objetivo FROM tb_objetivo WHERE cod_objetivo = ".$cod_objetivo));

			$sql = "DELETE FROM tb_objetivo WHERE cod_objetivo = " .$cod_objetivo;
			$resultado = pg_query($sql);
			if($resultado)
			{
                Auditoria(61, "EXCLUIR OBJETIVO: ".$rs['txt_objetivo'], $sql);

				$retorno["status"] = "sucesso";
				$retorno["mensagem"] = "OBJETIVO EXCLUÍDO.";
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