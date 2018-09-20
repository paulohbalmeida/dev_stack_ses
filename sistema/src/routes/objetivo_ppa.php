<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/api/objetivo_ppa', function (Request $request, Response $response) {
    $sql = "SELECT * FROM tb_objetivo_ppa";
    $q = pg_query($sql);        
    $arr = array();

    if(pg_num_rows($q) > 0) {
        while($row = pg_fetch_assoc($q)) {
            $arr[] = $row;  
        } 
    }    

    echo json_encode($arr);
});

$app->get('/api/objetivo_ppa/{id}', function (Request $request, Response $response) {
    $sql = "SELECT * FROM tb_objetivo_ppa WHERE cod_objetivo_ppa = ".$request->getAttribute('id');
    $rs = pg_fetch_array(pg_query($sql));

    echo json_encode($rs);
});

?>