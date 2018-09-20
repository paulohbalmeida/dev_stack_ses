<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/api/perspectiva', function (Request $request, Response $response) {
    $sql = "SELECT * FROM tb_perspectiva";
    $q = pg_query($sql);        
    $arr = array();

    if(pg_num_rows($q) > 0) {
        while($row = pg_fetch_assoc($q)) {
            $arr[] = $row;  
        } 
    }    

    echo json_encode($arr);
});

$app->get('/api/perspectiva/{id}', function (Request $request, Response $response) {
    $sql = "SELECT * FROM tb_perspectiva WHERE cod_perspectiva = ".$request->getAttribute('id');
    $rs = pg_fetch_array(pg_query($sql));

    echo json_encode($rs);
});

?>