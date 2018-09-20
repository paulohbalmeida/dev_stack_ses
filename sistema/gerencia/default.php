<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(23);

Auditoria(3, "Listar Tabelas de Apoio", "");

?>

<div id="main" class="container-fluid" style="margin-top: 50px">
    <div id="top" class="row">
        <div class="col-sm-3">
            <h2>Tabelas de Apoio</h2>
        </div>
    </div><!-- #row -->   
    <div id="list" class="row">
        <ul class = "lista-grupo"> 
            <?php if (permissao_acesso(25)) { ?>
                <li class = "list-group-item">
                    <span class="glyphicon glyphicon-search"></span> 
                    <a href="orgao/default.php">Área Responsável</a>                
                </li>
            <?php } ?>
            <?php if (permissao_acesso(29)) { ?>
                <li class = "list-group-item">
                    <span class="glyphicon glyphicon-search"></span> 
                    <a href="cargo/default.php">Cargos</a>                
                </li>      
            <?php } ?>
            <?php if (permissao_acesso(33)) { ?>
                <li class = "list-group-item">
                    <span class="glyphicon glyphicon-search"></span> 
                    <a href="instrumento/default.php">Instrumento de Planejamento</a>                
                </li>    
            <?php } ?>
            <?php if (permissao_acesso(38)) { ?>
                <li class = "list-group-item">
                    <span class="glyphicon glyphicon-search"></span> 
                    <a href="produto_etapa/default.php">Produto da Etapa</a>                
                </li>    
            <?php } ?>
            <?php if (permissao_acesso(42)) { ?>
                <li class = "list-group-item">
                    <span class="glyphicon glyphicon-search"></span> 
                    <a href="unidade_medida/default.php">Unidade de Medida</a>                
                </li>    
            <?php } ?>
            <?php if (permissao_acesso(46)) { ?>
                <li class = "list-group-item">
                    <span class="glyphicon glyphicon-search"></span> 
                    <a href="perfil/default.php">Perfis de Usuários</a>                
                </li>   
            <?php } ?>
            <?php if (permissao_acesso(88)) { ?>
                <li class = "list-group-item">
                    <span class="glyphicon glyphicon-search"></span> 
                    <a href="status/default.php">Situações</a>                
                </li>   
            <?php } ?>
            <?php if (permissao_acesso(53)) { ?>
                <li class = "list-group-item">
                    <span class="glyphicon glyphicon-search"></span> 
                    <a href="usuario/default.php">Usuários</a>                
                </li>   
            <?php } ?>
        </ul> 
    </div><!-- #list -->
</div><!-- #main -->

<?php
rodape($dbcon);
?>