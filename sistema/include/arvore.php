<?php
include_once (__DIR__ . "/conexao.php");

$acao = $_REQUEST['acao'];
$cod_objetivo = $_REQUEST['cod_objetivo'];
$cod_objetivo_ppa = $_REQUEST['cod_objetivo_ppa'];
$cod_programa = $_REQUEST['cod_programa'];

switch ($acao) {
    case 'dados_usuario':
        $sql = "SELECT txt_login, txt_email, txt_cargo, txt_perfil, txt_sigla FROM tb_usuario ";
        $sql .= " LEFT JOIN tb_cargo ON tb_cargo.cod_cargo = tb_usuario.cod_cargo";
        $sql .= " LEFT JOIN tb_perfil ON tb_perfil.cod_perfil = tb_usuario.cod_perfil";
        $sql .= " LEFT JOIN tb_orgao ON tb_orgao.cod_orgao = tb_usuario.cod_orgao";
        $sql .= " WHERE tb_usuario.cod_usuario = ".$_SESSION['cod_usuario'];
       
        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }    

        echo(json_encode($arr));
        break;

    case 'tabela_arvore':
        $sql = "SELECT txt_eixo, txt_perspectiva, txt_diretriz, codigo_eixo, codigo_diretriz, codigo_perspectiva ";
        $sql .= " FROM tb_objetivo ";
        $sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo ";
        $sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva ";
        $sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz ";
        $sql .= " WHERE tb_objetivo.cod_objetivo = " .$cod_objetivo;
        
        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }    

        echo(json_encode($arr));
        break;

    case 'tabela_objetivo_ppa':
        $sql = "SELECT codigo_objetivo_ppa, cod_objetivo_ppa, txt_objetivo_ppa FROM tb_objetivo_ppa ";
        $sql .= " WHERE cod_objetivo = " .$cod_objetivo. " AND cod_ativo = 1"; 

        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }   

        echo(json_encode($arr));
        break;

    case 'tabela_programa_trabalho':
        $sql = "SELECT cod_programa_trabalho, nr_programa_trabalho, txt_titulo_programa FROM tb_programa_trabalho ";
        $sql .= " WHERE cod_objetivo_ppa = " .$cod_objetivo_ppa. " AND cod_ativo = 1 ";
        
        if (!empty($cod_programa)) {
            $sql .= " AND cod_programa_trabalho = " .$cod_programa;
        }

        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }   
        
        echo(json_encode($arr));
        break;

    case 'alterar_unidade':
        $_SESSION["cod_orgao"] = $_REQUEST['cod_orgao'];     

        echo("");
        break;
}
?>