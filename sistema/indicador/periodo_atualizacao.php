<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsIndicador.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(91);

$id = $_REQUEST['id'];

if (!empty($id)) {
    $condicao = " AND tbip.cod_chave = ".$id;
}

$sql = "SELECT tbip.*, txt_usuario FROM tb_indicador_periodo tbip ";
$sql .= " INNER JOIN tb_usuario tbu ON tbu.cod_usuario = tbip.cod_usuario ";
$sql .= " WHERE 1 = 1 ".$condicao." ORDER BY tbip.dt_inclusao DESC";
$q1 = pg_query($sql);
if (pg_num_rows($q1) > 0) {
    $css = "disabled";

    if (!empty($id)) {
        $rs1 = pg_fetch_array($q1);
        $dt_inicio = FormataData($rs1['dt_inicio']);
        $dt_fim = FormataData($rs1['dt_fim']);
        $css = "";
    } else {
        $dt_inicio = "";
        $dt_fim = "";
    }
}
else {
    $css = "";
}

$clsIndicador = new clsIndicador();

if (empty($_REQUEST['log'])) {
	Auditoria(66, "Listar Período de Atualização de Indicadores", "");
}

?>

<div id="main" class="container-fluid" style="margin-top: 50px">
    <form id="frm1">
        <input type="hidden" name="log" id="log" value="1" />
        <input type="hidden" name="id" id="id" value="<?=$id?>" />
        <input type="hidden" name="acao" id="acao" value="incluir_periodo_atualizacao" />
        <div id="top" class="row">
            <div class="col-sm-12">
                <h2>Indicadores > Período de Atualização</h2>
            </div>			
        </div> <!-- /#top -->
        <br />
        <div align="center">
            <div class="row">
                <div class="col-md-6">                                                           
                    <label for="exampleInputEmail1">Data Início:</label> 
                    <div class="form-group">
                        <div class='input-group date'>
                            <input type="text" class="form-control" id="dt_inicio" name='dt_inicio' autocomplete="off" value="<?=$dt_inicio?>" placeholder='DD/MM/AAAA' onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>  
                        </div>                                           
                    </div>                    
                </div>
                <div class="col-md-6">
                    <label for="exampleInputEmail1">Data Fim:</label>
                    <div class="form-group">
                        <div class='input-group date' >
                            <input type='text' class="form-control" id='dt_fim' name='dt_fim' autocomplete="off" value="<?=$dt_fim?>" placeholder='DD/MM/AAAA' onkeypress="return isNumberKey(event)"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>                                                                              
            </div>        
            <br />
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" id="btn_salvar" class="btn btn-primary" <?php echo($css) ?> onclick="return ValidarSalvar();">Salvar</button>                    
                </div><!--col-md-12-->         
            </div>            
        </div>   
        <br />
        <div class="row"><?php         
            $sql = "SELECT tbip.*, tbu.txt_usuario, tbu2.txt_usuario AS usuario_reabrir, tbip.dt_reabrir ";
            $sql .= " FROM tb_indicador_periodo tbip ";
            $sql .= " INNER JOIN tb_usuario tbu ON tbu.cod_usuario = tbip.cod_usuario ";
            $sql .= " LEFT JOIN tb_usuario tbu2 ON tbu2.cod_usuario = tbip.cod_usuario_reabrir ";
            $sql .= " ORDER BY tbip.dt_inclusao DESC";
            $q1 = pg_query($sql);  
            if (pg_num_rows($q1) > 0) {                
            ?>
                <div class="table-responsive col-md-12">
                    <table class="table table-striped" cellspacing="0" cellpadding="0">
                    <thead>
                            <tr>
                                <th>Data Início</th>
                                <th>Data Fim</th>								
                                <th>Responsável pela Inclusão</th>
                                <th>Data Reabertura</th>								
                                <th>Responsável pela Reabertura</th>                                
                                <th>&nbsp;</th>
                            </tr>                        
                        </thead>
                        <tbody>
                            <?php												
							while ($rs1 = pg_fetch_array($q1)) {
							?>
                                <tr>
                                    <td><?php echo(FormataData($rs1['dt_inicio'])); ?></td>
                                    <td><?php echo(FormataData($rs1['dt_fim'])); ?></td>                                    
                                    <td><?php echo($rs1['txt_usuario']); ?></td>        
                                    <td><?php echo(FormataData($rs1['dt_reabrir'])); ?></td>                            
                                    <td><?php echo($rs1['usuario_reabrir']); ?></td>                                    
                                    <td class="actions">                             
                                        <?php
                                        if (empty($rs1['dt_reabrir'])) { ?>
                                            <a class="btn btn-warning btn-xs" href="periodo_atualizacao.php?id=<?php echo($rs1['cod_chave']) ?>">Editar</a>
                                        <?php
                                        } ?>
                                        <a class="btn btn-danger btn-xs" onclick="return Excluir(<?php echo($rs1['cod_chave']) ?>);" >Excluir</a>
                                        <?php 
                                        if (!$clsIndicador->RegraPeriodo() && empty($rs1['dt_reabrir'])) { 
                                        ?>
                                            <a class="btn btn-primary btn-xs" onclick="return Reabrir(<?php echo($rs1['cod_chave']) ?>);" >Reabrir Período</a>
                                        <?php
                                        }?>
                                        <?php 
                                        if (!empty($rs1['dt_reabrir'])) { 
                                        ?>
                                            <a class="btn btn-primary btn-xs" onclick="return Fechar(<?php echo($rs1['cod_chave']) ?>);" >Encerrar Período</a>
                                        <?php 
                                        }?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>    
            <?php 
            }
            ?>
        </div>
    </form>
</div>
<script src="periodo_atualizacao.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>

<script type="text/javascript">
  $( function() {
    $( "#dt_inicio" ).datepicker();
    $( "#dt_fim" ).datepicker();
  });
</script>