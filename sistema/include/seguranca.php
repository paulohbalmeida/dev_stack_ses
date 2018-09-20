<?php

function verifica_seguranca()
{
    global $application;
    if ($_SESSION["cod_usuario"] == "") {
        js_go($_SESSION["txt_pagina_login"]);
        flush();
        exit();
    }
}

function permissao_acesso($cod_permissao) 
{    
    //PERFIL DE ADMINISTRADOR
    if (limpar_comparacao($_SESSION['cod_perfil']) == 1) {
        return true;
    }

    $qPermissao = pg_query("SELECT * FROM tb_permissao_perfil WHERE cod_permissao = " .$cod_permissao. " AND cod_perfil = ".$_SESSION['cod_perfil']);
    if (pg_num_rows($qPermissao) > 0) {
        return true;
    } else {
        return false;
    }
}

function permissao_acesso_pagina($cod_permissao)
{
    if (!permissao_acesso($cod_permissao)) {
        js_go($_SESSION["txt_caminho_aplicacao"]."/include/pagina_acesso.php");
    }
}

function permissao_acesso_pagina_2($cod_permissao)
{
    $qPermissao = pg_query("SELECT * FROM tb_permissao_perfil WHERE cod_permissao IN (" .$cod_permissao. ") AND cod_perfil = ".$_SESSION['cod_perfil']);
    if (pg_num_rows($qPermissao) == 0) {
        js_go($_SESSION["txt_caminho_aplicacao"]."/include/pagina_acesso.php");
    }     
}

function permissao_acesso_unidade($cod_permissao, $cod_orgao)
{
    $r = false;

    if (strval($cod_orgao) != '') {          
        //PERFIL DE ADMINISTRADOR
        if (limpar_comparacao($_SESSION['cod_perfil']) == 1) {
            return true;
        }
        
        if (permissao_acesso($cod_permissao)) {
            $sql_ = " WITH RECURSIVE arvore AS ";
            $sql_ .= "( ";
            $sql_ .=  " SELECT t1.cod_orgao, txt_sigla, cod_orgao_superior ";
            $sql_ .=  " FROM tb_orgao AS t1 ";
            $sql_ .=  " WHERE cod_orgao = ".$cod_orgao;
            $sql_ .= " UNION ALL ";
            $sql_ .= " SELECT t2.cod_orgao, t2.txt_sigla, t2.cod_orgao_superior ";       
            $sql_ .= " FROM tb_orgao AS t2 ";
            $sql_ .= " INNER JOIN arvore ON arvore.cod_orgao_superior = t2.cod_orgao ) ";
            $sql_ .= " SELECT arvore.cod_orgao, arvore.txt_sigla FROM arvore ";
            $sql_ .= " ORDER BY arvore.txt_sigla ";

            $qPermissao1 = pg_query($sql_);

            if (pg_num_rows($qPermissao1) > 0) {                
                while ($rs1Permissao = pg_fetch_array($qPermissao1)) {
                    $a_cod_orgao = $a_cod_orgao."[".$rs1Permissao['cod_orgao']."]";
                }

                $a_cod_orgao = str_replace("][", ",", $a_cod_orgao);
                $a_cod_orgao = str_replace("]", "", $a_cod_orgao);
                $a_cod_orgao = str_replace("[", "", $a_cod_orgao);
            } else {
                $a_cod_orgao = $cod_orgao;
            }
         
            $qPermissao = pg_query("SELECT cod_orgao FROM tb_usuario_orgao WHERE cod_usuario = ".$_SESSION['cod_usuario']." AND cod_orgao IN (".$a_cod_orgao.")");            
            if (pg_num_rows($qPermissao) > 0) {
                $r = true;
            }         
        }
    }    

    return $r;
}
?>