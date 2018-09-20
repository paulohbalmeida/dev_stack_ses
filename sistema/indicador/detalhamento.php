<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsIndicador.php");

verifica_seguranca();
cabecalho();

$clsIndicador = new clsIndicador();

$id = $_REQUEST['id'];

$sql = "SELECT tb_indicador.*, txt_eixo, txt_perspectiva, txt_diretriz, txt_objetivo, txt_objetivo_ppa, ";
$sql .= " tb_objetivo.cod_eixo, tb_objetivo.cod_perspectiva, tb_objetivo.cod_diretriz FROM tb_indicador ";
$sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_indicador.cod_objetivo ";
$sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo ";
$sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva ";
$sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz ";
$sql .= " INNER JOIN tb_objetivo_ppa ON tb_objetivo_ppa.cod_objetivo = tb_indicador.cod_objetivo_ppa  ";
$sql .= " WHERE cod_chave = " .$id;

$rs = pg_fetch_array(pg_query($sql));

$retorno_array = $clsIndicador->ConsultaIndicador($rs['cod_indicador']);
$txt_titulo = $retorno_array->titulo;

$cod_eixo = $rs['cod_eixo'];
$cod_perspectiva = $rs['cod_perspectiva'];
$cod_diretriz = $rs['cod_diretriz'];
$cod_objetivo = $rs['cod_objetivo'];

?>
<div id="main" class="container-fluid" style="margin-top: 50px">
    <form id="frm1">
        <input type="hidden" name="id" id="id" value="<?=$id?>" />
        <div id="top" class="row">
			<div class="col-sm-12">
				<h2>Indicadores > Detalhamento</h2>
			</div>			
		</div> <!-- /#top -->
		<br />
        <div class="row">
            <div class="col-md-12">
                <strong><?php echo($rs['txt_eixo']) ?></strong><br />
                &nbsp;&nbsp;<strong><?php echo($rs['txt_perspectiva']) ?></strong><br />
                &nbsp;&nbsp;<strong><?php echo($rs['txt_diretriz']) ?></strong><br />
                &nbsp;&nbsp;<strong><?php echo($rs['txt_objetivo']) ?></strong><br />
                &nbsp;&nbsp;<strong>Objetivo Específico PPA:</strong> <?php echo($rs['txt_objetivo_ppa']) ?><br /><br />

                <h4><strong>Descrição da Meta:</strong> <?php echo($rs['txt_descricao_meta']); ?></h4>
                <h4><strong>Indicador:</strong> <?php echo($txt_titulo); ?></h4>
                <h4><strong>Meta:</strong> <?php echo($rs['cod_meta']); ?></h4>
            </div><!--col-md-12--> 					
        </div><!--row-->
        <br />
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Janeiro - Abril</a></li>
                    <li><a data-toggle="tab" href="#menu1">Janeiro - Agosto</a></li>
                    <li><a data-toggle="tab" href="#menu2">Janeiro - Dezembro</a></li>                
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">                    
                        <?php
                        $sql = "SELECT * FROM tb_indicador_detalhe WHERE cod_chave = ".$id." AND cod_periodo = 1";
                        $q = pg_query($sql);
                        if (pg_num_rows($q) > 0) {
                            $rs1 = pg_fetch_array($q);
                        ?>
                        <br />
                        <div class="table-responsive col-md-12">
                            <table class="table table-striped" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>
                                        <th>Numerador</th>
                                        <th>Denominador</th>
                                        <th>Resultado</th>
                                        <th></th>
                                    </tr>                                        
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?=$rs1['cod_numerador']?></td>
                                        <td><?=$rs1['cod_denominador']?></td>
                                        <td><?=$rs1['cod_resultado']?></td>
                                        <td>                                                
                                            <a class="btn btn-danger btn-xs" onclick="return ExcluirDetalhe(<?=$id?>, 1);" >Excluir</a>
                                        </td>
                                    </tr>                                    
                                </tbody>
                            </table>                                
                        </div>
                        <?php
                        }                                  
                        ?>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <?php
                        $sql = "SELECT * FROM tb_indicador_detalhe WHERE cod_chave = ".$id." AND cod_periodo = 2";
                        $q = pg_query($sql);
                        if (pg_num_rows($q) > 0) {
                            $rs1 = pg_fetch_array($q);
                        ?>
                            <br />
                            <div class="table-responsive col-md-12">
                                <table class="table table-striped" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr>
                                            <th>Numerador</th>
                                            <th>Denominador</th>
                                            <th>Resultado</th>
                                            <th></th>
                                        </tr>                                        
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?=$rs1['cod_numerador']?></td>
                                            <td><?=$rs1['cod_denominador']?></td>  
                                            <td><?=$rs1['cod_resultado']?></td> 
                                            <td>                                                
                                                <a class="btn btn-danger btn-xs" onclick="return ExcluirDetalhe(<?=$id?>, 2);" >Excluir</a>
                                            </td>                                         
                                        </tr>                                    
                                    </tbody>
                                </table>                                
                            </div>
                        <?php
                        }                    
                        ?>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <?php
                        $sql = "SELECT * FROM tb_indicador_detalhe WHERE cod_chave = ".$id." AND cod_periodo = 3";
                        $q = pg_query($sql);
                        if (pg_num_rows($q) > 0) {
                            $rs1 = pg_fetch_array($q);
                        ?>
                            <br />
                            <div class="table-responsive col-md-12">
                                <table class="table table-striped" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr>
                                            <th>Numerador</th>
                                            <th>Denominador</th>
                                            <th>Resultado</th>
                                            <th></th>
                                        </tr>                                        
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?=$rs1['cod_numerador']?></td>
                                            <td><?=$rs1['cod_denominador']?></td>
                                            <td><?=$rs1['cod_resultado']?></td>
                                            <td>                                                
                                                <a class="btn btn-danger btn-xs" onclick="return ExcluirDetalhe(<?=$id?>, 3);" >Excluir</a>
                                            </td>
                                        </tr>                                    
                                    </tbody>
                                </table>                                
                            </div>
                        <?php
                        }
                        ?>
                    </div>  
                </div><!--tab-content-->
            </div><!--col-md-12-->
        </div><!--row-->
        <div class="row" align="center">
            <br /><br />
            <div class="col-md-12">                
                <button type="button" id="btn_incluir" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Editar</button>
                <a href="indicador.php?cod_eixo=<?=$cod_eixo?>&cod_perspectiva=<?=$cod_perspectiva?>&cod_diretriz=<?=$cod_diretriz?>&cod_objetivo=<?=$cod_objetivo?>" class="btn btn-default">Voltar</a>
            </div><!--col-md-12-->
        </div><!--row-->
    </form>
</div><!--main-->
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo($txt_titulo); ?></h4>
            </div>
            <div class="modal-body">
                <form id="frm_modal">
                    <div class="row" align="center">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Período</label>
                            <select id="cod_periodo" name="cod_periodo" class="form-control">
                                <option></option>
                                <option value="1">Janeiro - Abril</option>
                                <option value="2">Janeiro - Agosto</option>
                                <option value="3">Janeiro - Dezembro</option>                               
                            </select>
                        </div>                
                    </div><br />
                    <div class="row" align="center">
                        <div class="col-md-4">
                            <label for="exampleInputEmail1">Numerador</label>     
                            <input type="text" class="form-control" id="cod_numerador" name="cod_numerador" placeholder="Obrigatório" onkeyup="somenteNumeros(this);">                       
                        </div>
                        <div class="col-md-4">
                            <label for="exampleInputEmail1">Denominador</label>                            
                            <input type="text" class="form-control" id="cod_denominador" name="cod_denominador" placeholder="Obrigatório" onkeyup="somenteNumeros(this);">
                        </div>
                        <div class="col-md-4">
                            <label for="exampleInputEmail1">Resultado</label>                            
                            <input type="text" class="form-control" id="cod_resultado" name="cod_resultado" placeholder="Obrigatório" onkeyup="somenteNumeros(this);">
                        </div>
                    </div>
                </form>
            </div> 
            <div class="modal-footer">
                <button type="button" id="btn_salvar" class="btn btn-primary" onclick="return ValidarCamposDetalhamento();">Salvar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>   
        </div>
    </div>
</div><!--modal fade-->
<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>