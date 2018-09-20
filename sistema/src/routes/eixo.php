<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
 
$app->get('/api/eixo', function (Request $request, Response $response) {
    $sql = "SELECT * FROM tb_eixo";
    $q = pg_query($sql);        
    $arr = array();
 
    if(pg_num_rows($q) > 0) {
        while($row = pg_fetch_assoc($q)) {
            $arr[] = $row;  
        } 
    }    
 
    echo json_encode($arr);
});
 
$app->get('/api/eixo/{id}', function (Request $request, Response $response) {
    $sql = "SELECT * FROM tb_eixo WHERE cod_eixo = ".$request->getAttribute('id');
    $rs = pg_fetch_array(pg_query($sql));
 
    echo json_encode($rs);
});
 
?>