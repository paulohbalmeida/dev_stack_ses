<?php
include_once (__DIR__ . "/conexao.php");

$acao = $_REQUEST['acao'];
$cod_modulo = $_REQUEST['cod_modulo'];
$cod_eixo = $_REQUEST['cod_eixo'];
$cod_perspectiva = $_REQUEST['cod_perspectiva'];
$cod_diretriz = $_REQUEST['cod_diretriz'];

switch ($acao) {
    case 'tabela_status':
        $sql = "SELECT tbsm.cod_status, tbs.txt_status FROM tb_status_modulo tbsm ";
        $sql .= " INNER JOIN tb_status tbs ON tbs.cod_status = tbsm.cod_status ";
        $sql .= " WHERE tbsm.cod_exibir_consulta = 1 AND tbsm.cod_modulo = ".$cod_modulo;

        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;

    case 'tabela_eixo':
        $sql = "SELECT * FROM tb_eixo WHERE cod_ativo = 1 ORDER BY cod_eixo";
        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;

    case 'tabela_perspectiva':
        $sql = "SELECT * FROM tb_perspectiva WHERE cod_eixo = ".$cod_eixo." AND cod_ativo = 1 ORDER BY cod_perspectiva";
        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;
    
    case 'tabela_diretriz':
        $sql = "SELECT * FROM tb_diretriz WHERE cod_eixo = ".$cod_eixo." AND cod_perspectiva = ".$cod_perspectiva;
        $sql .= " AND cod_ativo = 1 ORDER BY cod_diretriz";        
        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;

    case 'tabela_objetivo':
        $sql = "SELECT * FROM tb_objetivo WHERE cod_eixo = ".$cod_eixo." AND cod_perspectiva = ".$cod_perspectiva;
        $sql .= " AND cod_diretriz = ".$cod_diretriz." AND cod_ativo = 1 ORDER BY cod_objetivo";        
        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;
}

?>