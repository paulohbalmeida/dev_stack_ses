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
        $cod_objetivo = $_REQUEST['cod_objetivo'];
        $txt_objetivo_ppa = $_REQUEST['txt_objetivo_ppa'];
        $cod_ativo = $_REQUEST['cod_ativo'];
        $txt_descricao = $_REQUEST['txt_descricao'];
        $codigo_objetivo_ppa = $_REQUEST['codigo_objetivo_ppa'];       

        $rs=pg_fetch_array(pg_query("SELECT MAX(cod_objetivo_ppa) FROM tb_objetivo_ppa"));
        if (!isset($rs[0])) {
            $cod_objetivo_ppa = 1;
        } else {
            $cod_objetivo_ppa = intval($rs[0]) + 1;
        }

        $sql = "INSERT INTO tb_objetivo_ppa(cod_objetivo_ppa, cod_eixo, cod_perspectiva, cod_diretriz, cod_objetivo, txt_objetivo_ppa, txt_descricao, cod_ativo, codigo_objetivo_ppa) VALUES(".$cod_objetivo_ppa.", ".$cod_eixo.", ".$cod_perspectiva.", ".$cod_diretriz.", ".$cod_objetivo.", '".$txt_objetivo_ppa."', '".$txt_descricao."', ".$cod_ativo.", '".trim($codigo_objetivo_ppa)."')";
        $resultado = pg_query($sql);
        if($resultado)
        {
            Auditoria(63, "", $sql);

            $retorno["status"] = "sucesso";
            $retorno["mensagem"] = "OPERAÇÃO REALIZADA COM SUCESSO.";
            $retorno["id"] = $cod_objetivo_ppa;
        }
        else
        {
            $retorno["status"] = "falha";
            $retorno["mensagem"] = $sql;
        }	       
    }
    else if ($acao == "alterar") {
        $cod_objetivo_ppa = $_REQUEST['id'];
        $cod_eixo = $_REQUEST['cod_eixo'];
        $cod_perspectiva = $_REQUEST['cod_perspectiva'];
        $cod_diretriz = $_REQUEST['cod_diretriz'];
        $cod_objetivo = $_REQUEST['cod_objetivo'];
        $txt_objetivo_ppa = $_REQUEST['txt_objetivo_ppa'];
        $cod_ativo = $_REQUEST['cod_ativo'];
        $txt_descricao = $_REQUEST['txt_descricao'];
        $codigo_objetivo_ppa = $_REQUEST['codigo_objetivo_ppa'];      

        $sql = "UPDATE tb_objetivo_ppa SET cod_eixo = ".$cod_eixo.", cod_perspectiva = ".$cod_perspectiva.", cod_diretriz = ".$cod_diretriz.", cod_objetivo = ".$cod_objetivo.", txt_objetivo_ppa = '".$txt_objetivo_ppa."', txt_descricao = '".$txt_descricao."', cod_ativo = ".$cod_ativo.", codigo_objetivo_ppa = '".trim($codigo_objetivo_ppa)."' WHERE cod_objetivo_ppa = ".$cod_objetivo_ppa;
        $resultado = pg_query($sql);
        if($resultado)
        {
            Auditoria(64, "", $sql);

            $retorno["status"] = "sucesso";
            $retorno["mensagem"] = "DADOS ALTERADOS.";
            $retorno["id"] = $cod_objetivo_ppa;
        }
        else
        {
            $retorno["status"] = "falha";
            $retorno["mensagem"] = $sql;
        }	      
    }
    else if($acao == "excluir") {
        $cod_objetivo_ppa = $_REQUEST['cod_objetivo_ppa'];
        
        $q=pg_query("SELECT * FROM tb_pas WHERE cod_objetivo_ppa = " .$cod_objetivo_ppa);
		$rs=pg_fetch_array($q);
		if (pg_num_rows($q) > 0) {
			$erro = "Objetivo PPA não pode ser excluído. Pois, está vinculado a uma PAS.";
        }
        
        if($erro == "") {
            $q=pg_query("SELECT * FROM tb_sag WHERE cod_objetivo_ppa = " .$cod_objetivo_ppa);
            $rs=pg_fetch_array($q);
            if (pg_num_rows($q) > 0) {
                $erro = "Objetivo PPA não pode ser excluído. Pois, está vinculado a uma SAG.";
            }
        }

        if($erro == "") {
            $q=pg_query("SELECT * FROM tb_indicador WHERE cod_objetivo_ppa = " .$cod_objetivo_ppa);
            $rs=pg_fetch_array($q);
            if (pg_num_rows($q) > 0) {
                $erro = "Objetivo PPA não pode ser excluído. Pois, está vinculado a um INDICADOR.";
            }
        }

		if($erro == "") {
            $sql = "DELETE FROM tb_objetivo_ppa WHERE cod_objetivo_ppa = " .$cod_objetivo_ppa;
            $resultado = pg_query($sql);

            if(!$resultado)
            {
                Auditoria(65, "EXCLUIR OBJETIVO PPA: ".$rs['txt_objetivo_ppa'], $sql);

                $retorno["status"] = "falha";
                $retorno["mensagem"] = $sql;                
            }  
            else
			{
				$retorno["status"] = "sucesso";
                $retorno["mensagem"] = "OBJETIVO PPA EXCLUÍDO.";
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