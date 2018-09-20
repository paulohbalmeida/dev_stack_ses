<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(22);

$cod_eixo = $_REQUEST['cod_eixo'];
$cod_perspectiva = $_REQUEST['cod_perspectiva'];
$cod_diretriz = $_REQUEST['cod_diretriz'];
$cod_objetivo = $_REQUEST['cod_objetivo'];

if (!empty($cod_eixo)) {    
    $condicao_objetivo .= " AND tb_objetivo.cod_eixo = ".$cod_eixo;   
} 
if (!empty($cod_perspectiva)) {
    $condicao_objetivo .= " AND tb_objetivo.cod_perspectiva = ".$cod_perspectiva; 
} 
if (!empty($cod_diretriz)) {
    $condicao_objetivo = " AND tb_objetivo.cod_diretriz = ".$cod_diretriz;        
} 
if (!empty($cod_objetivo)) {
    $condicao_objetivo .= " AND tb_objetivo.cod_objetivo = ".$cod_objetivo;
} 

if (empty($_REQUEST['log'])) {
	Auditoria(72, "Listar Indicadores", "");
}
?>
<div id="main" class="container-fluid" style="margin-top: 50px">
    <form id="frm1">
        <input type="hidden" name="log" id="log" value="1" />
        <div id="top" class="row">
			<div class="col-sm-3">
				<h2>MONITORAMENTO</h2>
			</div>			
		</div> <!-- /#top -->
        <div class="row">         
            <div class="col-sm-12"><h3>Filtros</h3></div>             
        </div>
        <div class="row">
            <div class="col-sm-3">                
                <select id="cod_eixo" name="cod_eixo" data-placeholder="EIXO" class="chosen-select">
                    <option></option>
                    <?php                        
                    $q = pg_query("SELECT cod_eixo, txt_eixo, codigo_eixo FROM tb_eixo WHERE cod_ativo = 1 ORDER BY codigo_eixo");
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_eixo"]?>"<?php if ($cod_eixo == $row["cod_eixo"]) { echo("selected");}?>><?=$row["codigo_eixo"] ?> - <?=$row["txt_eixo"] ?></option>
                    <?php	
                    } ?>
                </select>   
            </div>
            <div class="col-sm-3">  
                <select id="cod_perspectiva" name="cod_perspectiva" data-placeholder="PERSPECTIVA" class="chosen-select">
                    <option></option>
                    <?php                        
                    $q = pg_query("SELECT cod_perspectiva, txt_perspectiva, codigo_perspectiva FROM tb_perspectiva WHERE cod_ativo = 1 ORDER BY codigo_perspectiva");
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_perspectiva"]?>"<?php if ($cod_perspectiva == $row["cod_perspectiva"]) { echo("selected");}?>><?=$row["codigo_perspectiva"] ?> - <?=$row["txt_perspectiva"] ?></option>
                    <?php	
                    } ?>
                </select>            
            </div>    
            <div class="col-sm-3">  
                <select id="cod_diretriz" name="cod_diretriz" data-placeholder="DIRETRIZ" class="chosen-select">
                    <option></option>
                    <?php                        
                    $q = pg_query("SELECT cod_diretriz, txt_diretriz, codigo_diretriz FROM tb_diretriz WHERE cod_ativo = 1 ORDER BY codigo_diretriz");
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_diretriz"]?>"<?php if ($cod_diretriz == $row["cod_diretriz"]) { echo("selected");}?>><?=$row["codigo_diretriz"] ?> - <?=$row["txt_diretriz"] ?></option>
                    <?php	
                    } ?>
                </select>            
            </div>   
            <div class="col-sm-3">  
                <select id="cod_objetivo" name="cod_objetivo" data-placeholder="OBJETIVO" class="chosen-select">
                    <option></option>
                    <?php                        
                    $q = pg_query("SELECT cod_objetivo, txt_objetivo, codigo_objetivo FROM tb_objetivo WHERE cod_ativo = 1 ORDER BY codigo_objetivo");
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_objetivo"]?>"<?php if ($cod_objetivo == $row["cod_objetivo"]) { echo("selected");}?>><?=$row["codigo_objetivo"] ?> - <?=$row["txt_objetivo"] ?></option>
                    <?php	
                    } ?>
                </select>            
            </div>      
        </div>
        <div class="row">
            <div class="col-sm-12">
                <a href="#" class="btn btn-primary h2" onclick="SubmitForm();">Filtrar</a>
                <a href="#" class="btn btn-primary h2" onclick="LimparForm();">Limpar Filtros</a>
            </div>
        </div>
        <hr />
        <!--<a class="btn btn-warning btn-xs pull-right" href="lista_indicadores.php">Lista de Indicadores</a>-->               
        <?php			
        //EIXO
        $sql = "SELECT DISTINCT(txt_eixo) AS txt_eixo, tb_objetivo.cod_eixo, codigo_eixo FROM tb_indicador "; 
        $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_indicador.cod_objetivo ";       
        $sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo WHERE tb_eixo.cod_ativo = 1 ".$condicao_objetivo;
        $sql .= " ORDER BY codigo_eixo";
        $q1 = pg_query($sql);
        if (pg_num_rows($q1) > 0) { ?>
            <p align="justify">
                <?php 
                while ($rs1 = pg_fetch_array($q1)) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h3><?php echo($rs1['codigo_eixo']) ?> - <?php echo($rs1['txt_eixo']) ?></h3>
                        </div><!--col-md-12-->
                    </div><!--row-->  
                    <?php
                    //PERSPECTIVA
                    $sql = "SELECT DISTINCT(txt_perspectiva) AS txt_perspectiva, tb_objetivo.cod_perspectiva, codigo_perspectiva ";
                    $sql .= " FROM tb_indicador ";    
                    $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_indicador.cod_objetivo ";                       
                    $sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva ";
                    $sql .= " WHERE tb_perspectiva.cod_ativo = 1 AND tb_objetivo.cod_eixo = ".$rs1['cod_eixo'].$condicao_objetivo;
                    $sql .= " ORDER BY codigo_perspectiva";
                    $qPerspectiva = pg_query($sql);
                    if (pg_num_rows($qPerspectiva) > 0) { ?>
                        <div class="col-md-12">
                            <?php
                            while ($rsPerspectiva = pg_fetch_array($qPerspectiva)) { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong><?php echo($rsPerspectiva['codigo_perspectiva']) ?> - <?php echo($rsPerspectiva['txt_perspectiva']) ?></strong>
                                    </div><!--col-md-12-->
                                </div><!--row-->                                  
                                <?php
                                //DIRETRIZ
                                $sql = "SELECT DISTINCT(txt_diretriz) AS txt_diretriz, tb_objetivo.cod_diretriz, codigo_diretriz ";
                                $sql .= " FROM tb_indicador ";
                                $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_indicador.cod_objetivo ";
                                $sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz ";                                
                                $sql .= " WHERE tb_diretriz.cod_ativo = 1 AND tb_objetivo.cod_eixo = ".$rs1['cod_eixo']; 
                                $sql .= " AND tb_objetivo.cod_perspectiva = ".$rsPerspectiva['cod_perspectiva'].$condicao_objetivo;
                                $sql .= " ORDER BY codigo_diretriz";
                                $q2 = pg_query($sql);
                                if (pg_num_rows($q2) > 0) { ?>
                                    <div class="col-md-12">
                                        <?php 
                                        while ($rs2 = pg_fetch_array($q2)) { ?>
                                            <div class="row">
                                                <strong><?php echo($rs2['codigo_diretriz']) ?> - <?php echo($rs2['txt_diretriz']) ?></strong>
                                            </div><!--row-->
                                            <div class="row">
                                                <div class="table-responsive col-md-12">
                                                    <table class="table table-striped" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                            <?php
                                                            //OBJETIVOS
                                                            $sql = "SELECT DISTINCT(txt_objetivo) AS txt_objetivo, tb_indicador.cod_objetivo, ";
                                                            $sql .= " codigo_objetivo, CAST(Replace(substring(codigo_objetivo,4,6), '.', '') AS INT) AS T FROM tb_indicador ";
                                                            $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_indicador.cod_objetivo ";                                                            
                                                            $sql .= " WHERE tb_objetivo.cod_ativo = 1 AND tb_objetivo.cod_eixo = ".$rs1['cod_eixo'];
                                                            $sql .= " AND tb_objetivo.cod_perspectiva = ".$rsPerspectiva['cod_perspectiva'];
                                                            $sql .= " AND tb_objetivo.cod_diretriz = ".$rs2['cod_diretriz'].$condicao_objetivo;
                                                            $sql .= " ORDER BY T";
                                                            //echo($sql);
                                                            $qObjetivo = pg_query($sql);
                                                            //echo($sql);
                                                            if (pg_num_rows($qObjetivo) > 0) {
                                                                while($rsObjetivo = pg_fetch_array($qObjetivo)) {
                                                            ?>                                                    
                                                                <tr>                                                                    
                                                                    <td><?php echo($rsObjetivo['codigo_objetivo']) ?> - <?php echo($rsObjetivo['txt_objetivo']) ?></td>
                                                                    <td class="actions">									                                           
                                                                        <select name="teste" class="form-control_select" onchange="javascript:go(this)">                                                                            
                                                                            <option value="">&nbsp;</option>
                                                                            <?php if (permissao_acesso(60)) { ?>
                                                                                <option value="indicador.php?cod_eixo=<?php echo($rs1['cod_eixo']) ?>&cod_perspectiva=<?php echo($rsPerspectiva['cod_perspectiva']) ?>&cod_diretriz=<?php echo($rs2['cod_diretriz']) ?>&cod_objetivo=<?php echo($rsObjetivo['cod_objetivo']) ?>">Indicador</option>  
                                                                            <?php } ?> 
                                                                            <?php if (permissao_acesso(67) || permissao_acesso(89)) { ?>
                                                                                <option value="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/pas/default.php?cod_objetivo_url=<?php echo($rsObjetivo['cod_objetivo']) ?>">PAS</option>
                                                                            <?php } ?> 
                                                                            <?php if (permissao_acesso(76) || permissao_acesso(90)) { ?>
                                                                                <option value="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/sag/default.php?cod_objetivo_url=<?php echo($rsObjetivo['cod_objetivo']) ?>">SAG</option>
                                                                            <?php } ?> 
                                                                            <?php if (permissao_acesso(59)) { ?>
                                                                                <option value="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/execucao_orcamentaria/default.php?cod_eixo=<?php echo($rs1['cod_eixo']) ?>&cod_perspectiva=<?php echo($rsPerspectiva['cod_perspectiva']) ?>&cod_diretriz=<?php echo($rs2['cod_diretriz']) ?>&cod_objetivo=<?php echo($rsObjetivo['cod_objetivo']) ?>">Execução Orçamentária</option>
                                                                            <?php } ?> 
                                                                        </select><br />       
                                                                        <?php if (permissao_acesso(63)) { ?>                  
                                                                            <a class="btn btn-danger btn-xs" onclick="return Excluir(<?php echo($rsObjetivo['cod_objetivo']) ?>);" >Excluir</a>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                                }
                                                            }?>                                                
                                                        </tbody>
                                                    </table>
                                                </div><!--table-responsive col-md-12-->
                                            </div><!--row-->
                                        <?php
                                        }?>
                                    </div><!--col-md_12-->   
                                <?php
                                }                                
                            }
                            ?>
                        </div><!--col-md-12-->
                    <?php
                    }
                    ?>
                    <?php                                                                       
                } ?>                                
            </p>
        <?php
        }
        ?>
    </form>
</div><!--main-->
<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>