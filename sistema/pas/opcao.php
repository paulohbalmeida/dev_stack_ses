<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(67);
?>

<div id="main" class="container-fluid" style="margin-top: 50px">
    <div id="top" class="row">
        <div class="col-sm-3">
            <h2>PAS</h2>            
        </div>
    </div><!-- #row --> 
    <br />  
    <div id="list" class="row">
        <ul class = "lista-grupo"> 
            <?php if (permissao_acesso(22)) { ?>
                <li class = "list-group-item">
                    <span class="glyphicon glyphicon-search"></span> 
                    <a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/indicador/default.php">Monitoramento</a>                
                </li>    
            <?php } ?>
            <?php if (permissao_acesso(68)) { ?>
                <li class = "list-group-item">
                    <span class="glyphicon glyphicon-search"></span> 
                    <a href="incluir.php">Incluir</a>                
                </li>  
            <?php } ?>  
            <?php if (permissao_acesso(89)) { ?>                 
                <li class = "list-group-item">
                    <span class="glyphicon glyphicon-search"></span> 
                    <a href="default.php">Listagem</a>                
                </li> 
            <?php } ?>  
            <?php if (permissao_acesso(71)) { ?>  
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