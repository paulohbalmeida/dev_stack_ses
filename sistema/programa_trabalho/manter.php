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
        $cod_objetivo_ppa = $_REQUEST['cod_objetivo_ppa'];
        $nr_programa_trabalho = $_REQUEST['nr_programa_trabalho'];
        $txt_programa_trabalho = $_REQUEST['txt_programa_trabalho'];
        $cod_ativo = $_REQUEST['cod_ativo'];
        $txt_titulo_programa = $_REQUEST['txt_titulo_programa'];       
        $cod_emenda = $_REQUEST['cod_emenda'];
        $cod_continuar = $_REQUEST['cod_continuar'];

        //NÚMERO DO PROGRAMA NÃO PODE SE REPETIR PARA O MESMO OBJETIVO
        $sql = "SELECT * FROM tb_programa_trabalho WHERE cod_objetivo = ".$cod_objetivo." AND nr_programa_trabalho = '".$nr_programa_trabalho."'";
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) { 
                $retorno["status"] = "falha";
                $retorno["mensagem"] = "NÚMERO DO PROGRAMA JÁ ESTÁ CADASTRADO NO OBJETIVO INFORMADO";
        } else {
            $sql = "INSERT INTO tb_programa_trabalho(cod_eixo, cod_perspectiva, cod_diretriz, cod_objetivo, cod_objetivo_ppa, nr_programa_trabalho, txt_programa_trabalho, txt_titulo_programa, cod_ativo, cod_emenda) ";
            $sql .= " VALUES(".$cod_eixo.", ".$cod_perspectiva.", ".$cod_diretriz.", ".$cod_objetivo.", " .$cod_objetivo_ppa.", '".trim($nr_programa_trabalho)."', '".trim($txt_programa_trabalho)."', '".trim($txt_titulo_programa)."', ".$cod_ativo.", ".$cod_emenda.")";
    
            $resultado = pg_query($sql);
            if($resultado)
            {
                Auditoria(43, "", $sql);
    
                $rs=pg_fetch_array(pg_query("SELECT MAX(cod_programa_trabalho) FROM tb_programa_trabalho"));
               
                $cod_programa_trabalho = intval($rs[0]);
                                     
                $retorno["status"] = "sucesso";
                $retorno["mensagem"] = "OPERAÇÃO REALIZADA COM SUCESSO.";
                $retorno["id"] = $cod_programa_trabalho;

                if ($cod_continuar == 1) {
                    $retorno["url"] = 'incluir.php?cod_eixo='.$cod_eixo.'&cod_perspectiva='.$cod_perspectiva.'&cod_diretriz='.$cod_diretriz.'&cod_objetivo='.$cod_objetivo;
                } else {
                    $retorno["url"] = 'default.php';
                }
            }
            else
            {
                $retorno["status"] = "falha";
                $retorno["mensagem"] = "";
            }	 
        }             
    }
    else if ($acao == "alterar") {
        $cod_programa_trabalho = $_REQUEST['id'];
        $cod_eixo = $_REQUEST['cod_eixo'];
        $cod_perspectiva = $_REQUEST['cod_perspectiva'];
        $cod_diretriz = $_REQUEST['cod_diretriz'];
        $cod_objetivo = $_REQUEST['cod_objetivo'];
        $cod_objetivo_ppa = $_REQUEST['cod_objetivo_ppa'];
        $nr_programa_trabalho = $_REQUEST['nr_programa_trabalho'];
        $txt_programa_trabalho = $_REQUEST['txt_programa_trabalho'];
        $cod_ativo = $_REQUEST['cod_ativo'];
        $txt_titulo_programa = $_REQUEST['txt_titulo_programa'];
        $cod_emenda = $_REQUEST['cod_emenda'];

        //NÚMERO DO PROGRAMA NÃO PODE SE REPETIR PARA O MESMO OBJETIVO
        $sql = "SELECT * FROM tb_programa_trabalho WHERE cod_objetivo = ".$cod_objetivo." AND nr_programa_trabalho = '".$nr_programa_trabalho."' AND cod_programa_trabalho <> ".$cod_programa_trabalho;        
        $q = pg_query($sql);
        if (pg_num_rows($q) > 0) { 
            $retorno["status"] = "falha";
            $retorno["mensagem"] = "NÚMERO DO PROGRAMA JÁ ESTÁ CADASTRADO NO OBJETIVO INFORMADO";
        } else {
            $sql = "UPDATE tb_programa_trabalho SET cod_eixo = ".$cod_eixo.", cod_perspectiva = ".$cod_perspectiva.", cod_diretriz = ".$cod_diretriz.", cod_objetivo = ".$cod_objetivo.", cod_objetivo_ppa = ".$cod_objetivo_ppa.", nr_programa_trabalho = '".$nr_programa_trabalho."', txt_programa_trabalho = '".$txt_programa_trabalho."', txt_titulo_programa = '".trim($txt_titulo_programa)."', cod_ativo = ".$cod_ativo.", cod_emenda = ".$cod_emenda." WHERE cod_programa_trabalho = ".$cod_programa_trabalho;
            $resultado = pg_query($sql);
            if($resultado)
            {
                Auditoria(44, "", $sql);
    
                $retorno["status"] = "sucesso";
                $retorno["mensagem"] = "DADOS ALTERADOS.";
                $retorno["id"] = $cod_programa_trabalho;
            }
            else
            {
                $retorno["status"] = "falha";
                $retorno["mensagem"] = '';
            }
        }        	      
    }
    else if($acao == "excluir") {
        $cod_programa_trabalho = $_REQUEST['cod_programa_trabalho'];		

		if($erro == "") {
            $rs=pg_fetch_array(pg_query("SELECT txt_programa_trabalho FROM tb_programa_trabalho WHERE cod_programa_trabalho = ".$cod_programa_trabalho));

			$sql = "DELETE FROM tb_programa_trabalho WHERE cod_programa_trabalho = " .$cod_programa_trabalho;
			$resultado = pg_query($sql);
			if($resultado)
			{
                Auditoria(45, "EXCLUIR PROGRAMA DE TRABALHO: ".$rs['txt_programa_trabalho'], $sql);

				$retorno["status"] = "sucesso";
				$retorno["mensagem"] = "PROGRAMA EXCLUÍDO.";
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