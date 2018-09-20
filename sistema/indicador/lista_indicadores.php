<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();

$url = $_SESSION["url_api_mgi"]."/api/indicador";
$retorno_array = json_decode(file_get_contents($url));
?>
<div id="main" class="container-fluid" style="margin-top: 50px">
    <div id="top" class="row">
        <div class="col-sm-6">
            <h2>Listagem de Indicadores</h2>
        </div>			
    </div> <!-- /#top -->    
    <div class="col-md-12">
        <div class="row">
            <div class="table-responsive col-md-12">
                <table class="table table-striped" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CÓDIGO</th>
                            <th>TÍTULO</th>
                            <th>DESCRIÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php                                           
                        foreach ($retorno_array->rows as $valor) { ?>                        
                            <tr>
                                <td><?php echo($valor->id); ?></td>
                                <td><?php echo($valor->codigo); ?></td>
                                <td><?php echo($valor->titulo); ?></td>
                                <td><?php echo($valor->descricao); ?></td>
                            </tr>                                                        
                        <?php
                        }                    
                        ?>
                    </tbody>
                </table>
            </div><!--table-responsive col-md-12-->
        </div><!--row-->
        <br />        
        <div class="row">
            <div class="col-md-12">
                <a href="default.php" class="btn btn-default">Voltar</a>
            </div><!--col-md-12--> 
        </div><!--row--> 
    </div><!--div-->
</div><!--main-->

<?php
rodape($dbcon);
?>