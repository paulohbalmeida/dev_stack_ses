<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsInstrumento.php");
include_once (__DIR__ . "/../../classes/clsStatus.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(37);

$id = $_REQUEST['id'];

if (empty($id)) {
    js_go_back("Instrumento de Planejamento não encontrado.");
}

if (empty($_REQUEST['log'])) {
	Auditoria(15, "Listar Situações dos Instrumentos de Planejamento", "");
}

$clsInstrumento = new clsInstrumento();
$clsStatus = new clsStatus();
$txt_titulo = $clsInstrumento->ConsultaPorId($id);
?>
<div id="main" class="container-fluid">
    <h3 class="page-header">Instrumento de Planejamento > Situação</h3>
    <form id="frm1">
        <input type="hidden" name="log" id="log" value="1" />
        <input type="hidden" name="id" id="id" value="<?=$id?>" />
        <input type="hidden" name="acao" id="acao" value="" />

        <div class="row">
            <div class="form-group col-md-12">                
                <center><b><?php echo($txt_titulo) ?></b><center><br />
            </div><!--form-group-->
            <div class="row">
                <div class="form-group col-md-12">                
                    <center>                  
                        <label for="exampleInputEmail1">Situação:</label>      
                        <?php                        
                        $sql = "cod_ativo = 1 AND cod_status NOT IN(SELECT t1.cod_status FROM tb_status_modulo t1 WHERE t1.cod_modulo = ".$id.") ORDER BY txt_status";
                        $q = $clsStatus->ListarStatus($sql);
                        ?>
                        <select id="cod_status" name="cod_status" class="chosen-select" data-placeholder="Situação">
                            <option></option>                            
                            <?php                                                    
                            while ($row = pg_fetch_array($q)) 
                            { ?>
                                <option value="<?=$row["cod_status"]?>"><?=$row["txt_status"] ?></option>
                            <?php	
                            } ?>
                        </select>
                    <center>
                </div><!--form-group-->            
                <div class="form-group col-md-12">
                    <center>    
                        <label for="exampleInputEmail1">Exibir no Painel:</label>			
                        <select id="cod_exibir_consulta" name="cod_exibir_consulta" class="form-control">
                            <option value="1" <?php
                                                if ($cod_exibir_consulta == 1) {
                                                    echo("selected");
                                                }
                                                ?>>SIM</option>			
                            <option value="0"<?php
                                                if ($cod_exibir_consulta == 0) {
                                                    echo("selected");
                                                }
                                                ?>>NÃO</option>
                        </select>
                    </center>    
                </div><!--form-group-->	     
                <div class="form-group col-md-12">                
                    <center>                      
                    <button type="submit" id="btn_incluir" class="btn btn-primary" onclick="return ValidarIncluirStatus();">Incluir</button>
                    <a href="default.php" class="btn btn-default">Voltar</a>
                    <center>
                </div><!--form-group-->
            </div>
            <div class="row">
                <div class="tab-content">
                    <?php
                    $sql = "SELECT tb_status_modulo.*, txt_status FROM tb_status_modulo "; 
                    $sql .=  " INNER JOIN tb_modulo ON tb_modulo.cod_modulo = tb_status_modulo.cod_modulo ";
                    $sql .=  " INNER JOIN tb_status ON tb_status.cod_status = tb_status_modulo.cod_status ";
                    $sql .= " WHERE tb_status_modulo.cod_modulo = " .$id. " ORDER BY txt_status";

                    $q1 = pg_query($sql);
                    if (pg_num_rows($q1) > 0) { ?>
                        <div class="table-responsive col-md-12">                                
                            <table class="table table-striped" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>                                                                                  
                                        <th>SITUAÇÃO</th>  
                                        <th>Exibir no Painel</th>                          
                                        <th></th>
                                    </tr>                                        
                                </thead>
                                <tbody>
                                    <?php												
                                    while ($rs1 = pg_fetch_array($q1)) {
                                    ?>
                                        <tr>
                                            <td><?php echo($rs1["txt_status"]) ?></td>
                                            <td><?php echo(destacar_ativo($rs1['cod_exibir_consulta'])) ?></td>
                                            <td class="actions">
                                                <a class="btn btn-warning btn-xs" data-toggle="modal" data-target="#ModalStatus" onclick="SetModal(<?php echo($rs1["cod_status"]) ?>, <?php echo($rs1["cod_exibir_consulta"]) ?>);">Editar</a>
                                                <a class="btn btn-danger btn-xs" onclick="return ExcluirSituacao(<?php echo($id) ?>, <?php echo($rs1["cod_status"]) ?>);" >Excluir</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>            
                    <?php 
                    } else {
                        ?>
                            <hr>
                            <center><h4>NÃO EXISTEM REGISTROS CADASTRADOS.</h4></center>
                    <?php
                    } ?>                    
                </div><!--tab-content-->  
            </div>
        </div>
    </form>
</div>
<!-- Modal -->
<div class="modal fade" id="ModalStatus" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo($txt_titulo) ?></h4>
            </div>
            <div class="modal-body">
                <form id="frm_modal">
                    <input type="hidden" name="cod_modulo_modal" id="cod_modulo_modal" value="<?=$id?>" />
                    <input type="hidden" name="cod_status_modal" id="cod_status_modal" />                    
                    <div class="row" align="center">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Exibir no Painel:</label>			
                            <select id="cod_exibir_consulta_modal" name="cod_exibir_consulta_modal" class="form-control">
                                <option value="1">SIM</option>			
                                <option value="0">NÃO</option>
                            </select>
                        </div>                
                    </div>                    
                </form>
            </div> 
            <div class="modal-footer">
                <button type="button" id="btn_salvar" class="btn btn-primary" onclick="return ValidarModalSituacao();">Salvar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>   
        </div>
    </div>
</div><!--modal fade-->
<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>

