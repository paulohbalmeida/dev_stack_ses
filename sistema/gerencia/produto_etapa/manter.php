<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsProdutoEtapa.php");

$acao = $_REQUEST['acao'];
$cod_produto_etapa = $_REQUEST['id'];
$txt_produto_etapa = $_REQUEST['txt_produto_etapa'];
$cod_ativo = $_REQUEST['cod_ativo'];


switch ($acao) {
    case 'incluir':
        $clsProdutoEtapa = new clsProdutoEtapa();
        $clsProdutoEtapa->txt_produto_etapa = $txt_produto_etapa;
        $clsProdutoEtapa->cod_ativo = $cod_ativo;
        $clsProdutoEtapa->IncluirProdutoEtapa();

        js_go('default.php');                      
        break; 

    case 'excluir':   
        $clsProdutoEtapa = new clsProdutoEtapa();
        $clsProdutoEtapa->cod_produto_etapa = $cod_produto_etapa;
        $clsProdutoEtapa->ExcluirProdutoEtapa();
        break;

    case 'alterar':
        $clsProdutoEtapa = new clsProdutoEtapa();
        $clsProdutoEtapa->cod_produto_etapa = $cod_produto_etapa;
        $clsProdutoEtapa->txt_produto_etapa = $txt_produto_etapa;
        $clsProdutoEtapa->cod_ativo = $cod_ativo;
        $clsProdutoEtapa->AlterarProdutoEtapa();   
                        
        js_go('incluir.php?id='.$cod_produto_etapa.'&status=sucesso');
        break;
    
    case 'validacao_incluir':        
        $clsProdutoEtapa = new clsProdutoEtapa();        
        $r1 = $clsProdutoEtapa->ListarProdutoEtapa(" UPPER(txt_produto_etapa) = '" .trim(strtoupper($txt_produto_etapa))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;
    
    case 'validacao_alterar':
        $clsProdutoEtapa = new clsProdutoEtapa();        
        $r1 = $clsProdutoEtapa->ListarProdutoEtapa(" cod_produto_etapa <> ".$cod_produto_etapa." AND UPPER(txt_produto_etapa) = '" .trim(strtoupper($txt_produto_etapa))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;

}   

?>