<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(60);
?>

<div id="main" class="container-fluid" style="margin-top: 50px">
    <div id="top" class="row">
        <div class="col-sm-3">
            <h2>Indicador</h2>
        </div>
    </div><!-- #row -->   
    <br />
    <div id="list" class="row">
        <ul class = "lista-grupo"> 
            <?php if (permissao_acesso(22)) { ?>
                <li class = "list-group-item">
                    <span class="glyphicon glyphicon-search"></span> 
                    <a href="default.php">Monitoramento</a>                
                </li>   
            <?php } ?>
            <?php if (permissao_acesso(61)) { ?> 
                <li class = "list-group-item">
                    <span class="glyphicon glyphicon-search"></span> 
                    <a href="incluir.php">Incluir</a>                
                </li>   
            <?php } ?> 
            <?php if (permissao_acesso(91)) { ?>
                <li class = "list-group-item">
                    <span class="glyphicon glyphicon-search"></span> 
                    <a href="periodo_atualizacao.php">Período de Atualização</a>                
                </li>     
            <?php } ?>     
        </ul> 
    </div><!-- #list -->
</div><!-- #main -->

<?php
rodape($dbcon);
?>