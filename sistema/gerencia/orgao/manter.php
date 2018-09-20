<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsOrgao.php");

$acao = $_REQUEST['acao'];
$cod_orgao = $_REQUEST['id'];
$txt_sigla = $_REQUEST['txt_sigla'];
$cod_ativo = $_REQUEST['cod_ativo'];
$cod_exibir_consulta = $_REQUEST['cod_exibir_consulta'];
$txt_descricao = $_REQUEST['txt_descricao'];
$cod_orgao_superior = $_REQUEST['cod_orgao_superior'];

switch ($acao) {
    case 'incluir':
        $clsOrgao = new clsOrgao();
        $clsOrgao->txt_sigla = $txt_sigla;
        $clsOrgao->txt_descricao = $txt_descricao;
        $clsOrgao->cod_ativo = $cod_ativo;
        $clsOrgao->cod_exibir_consulta = $cod_exibir_consulta;
        $clsOrgao->cod_orgao_superior = $cod_orgao_superior;
        $clsOrgao->IncluirOrgao();

        js_go('default.php');                      
        break; 

    case 'excluir':   
        $clsOrgao = new clsOrgao();
        $clsOrgao->cod_orgao = $cod_orgao;
        $clsOrgao->ExcluirOrgao();
        break;

    case 'alterar':
        $clsOrgao = new clsOrgao();
        $clsOrgao->cod_orgao = $cod_orgao;
        $clsOrgao->txt_sigla = $txt_sigla;
        $clsOrgao->txt_descricao = $txt_descricao;
        $clsOrgao->cod_ativo = $cod_ativo;
        $clsOrgao->cod_exibir_consulta = $cod_exibir_consulta;
        $clsOrgao->cod_orgao_superior = $cod_orgao_superior;
        $clsOrgao->AlterarOrgao();   
                        
        js_go('incluir.php?id='.$cod_orgao.'&status=sucesso');
        break;
    
    case 'validacao_incluir':        
        $clsOrgao = new clsOrgao();        
        $r1 = $clsOrgao->ListarOrgao(" UPPER(txt_sigla) = '" .trim(strtoupper($txt_sigla))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;
    
    case 'validacao_alterar':
        $clsOrgao = new clsOrgao();        
        $r1 = $clsOrgao->ListarOrgao(" cod_orgao <> ".$cod_orgao." AND UPPER(txt_sigla) = '" .trim(strtoupper($txt_sigla))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;

}   

?>