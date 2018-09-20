<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();

?>
<div id="main" class="container-fluid">
    <hr /><hr /><hr />
    <div align="center">
        <div class="row">
            <div class="col-sm-12">
                <h1>PERMISSÃO NEGADA.</h1>
            </div>        
        </div>
    </div>    
</div>

<?php
rodape($dbcon);
?>