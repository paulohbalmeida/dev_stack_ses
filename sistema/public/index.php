<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use function Composer\Autoload\includeFile;

require '../vendor/autoload.php';
require '../include/conexao.php';
require '../config/config_api.php';

$app = new \Slim\App($config_api);

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

require '../src/routes/eixo.php';
require '../src/routes/perspectiva.php';
require '../src/routes/diretriz.php';
require '../src/routes/objetivo.php';
require '../src/routes/objetivo_ppa.php';
require '../src/routes/programa_trabalho.php';

$app->run();

?>