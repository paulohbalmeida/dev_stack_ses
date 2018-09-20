<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsExecucaoOrcamentaria.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(59);

$clsExecucaoOrcamentaria = new clsExecucaoOrcamentaria();

$cod_eixo = $_REQUEST['cod_eixo'];
$cod_perspectiva = $_REQUEST['cod_perspectiva'];
$cod_diretriz = $_REQUEST['cod_diretriz'];
$cod_objetivo = $_REQUEST['cod_objetivo'];
$cod_programa_trabalho = $_REQUEST['cod_programa_trabalho'];

if (!empty($cod_eixo)) {    
    $condicao_objetivo .= " AND tb_programa_trabalho.cod_eixo = ".$cod_eixo;   
} 
if (!empty($cod_perspectiva)) {
    $condicao_objetivo .= " AND tb_programa_trabalho.cod_perspectiva = ".$cod_perspectiva; 
} 
if (!empty($cod_diretriz)) {
    $condicao_objetivo = " AND tb_programa_trabalho.cod_diretriz = ".$cod_diretriz;        
} 
if (!empty($cod_objetivo)) {
    $condicao_objetivo .= " AND tb_programa_trabalho.cod_objetivo = ".$cod_objetivo;
}
if (!empty($cod_programa_trabalho)) {
    $condicao_objetivo .= " AND tb_programa_trabalho.cod_programa_trabalho = ".$cod_programa_trabalho;
} 

if (empty($_REQUEST['log'])) {
	Auditoria(130, "Listar Execução Orçamentária", "");
}
?>

<div id="main" class="container-fluid" style="margin-top: 50px">
    <form id="frm1">
        <input type="hidden" name="log" id="log" value="1" />
        <div id="top" class="row">
			<div class="col-sm-12">
				<h2>EXECUÇÃO ORÇAMENTÁRIA</h2>
			</div>			
		</div> <!-- /#top -->
        <div class="row">         
            <div class="col-sm-12"><h3>Filtros</h3></div>             
        </div>
        <div class="row">
            <div class="col-sm-2">                
                <select id="cod_eixo" name="cod_eixo" data-placeholder="EIXO" class="chosen-select">
                    <option></option>
                    <?php                        
                    $q = pg_query("SELECT DISTINCT(cod_eixo) AS cod_eixo, txt_eixo, codigo_eixo FROM tb_eixo WHERE cod_ativo = 1 ORDER BY codigo_eixo");
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_eixo"]?>"<?php if ($cod_eixo == $row["cod_eixo"]) { echo("selected");}?>><?=$row["codigo_eixo"] ?> - <?=$row["txt_eixo"] ?></option>
                    <?php	
                    } ?>
                </select>   
            </div>
            <div class="col-sm-2">  
                <select id="cod_perspectiva" name="cod_perspectiva" data-placeholder="PERSPECTIVA" class="chosen-select">
                    <option></option>
                    <?php                        
                    $q = pg_query("SELECT DISTINCT(cod_perspectiva) AS cod_perspectiva, txt_perspectiva, codigo_perspectiva FROM tb_perspectiva WHERE cod_ativo = 1 ORDER BY codigo_perspectiva");
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_perspectiva"]?>"<?php if ($cod_perspectiva == $row["cod_perspectiva"]) { echo("selected");}?>><?=$row["codigo_perspectiva"] ?> - <?=$row["txt_perspectiva"] ?></option>
                    <?php	
                    } ?>
                </select>            
            </div>    
            <div class="col-sm-2">  
                <select id="cod_diretriz" name="cod_diretriz" data-placeholder="DIRETRIZ" class="chosen-select">
                    <option></option>
                    <?php                        
                    $q = pg_query("SELECT DISTINCT(cod_diretriz) AS cod_diretriz, txt_diretriz, codigo_diretriz FROM tb_diretriz WHERE cod_ativo = 1 ORDER BY codigo_diretriz");
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_diretriz"]?>"<?php if ($cod_diretriz == $row["cod_diretriz"]) { echo("selected");}?>><?=$row["codigo_diretriz"] ?> - <?=$row["txt_diretriz"] ?></option>
                    <?php	
                    } ?>
                </select>            
            </div>   
            <div class="col-sm-4">  
                <select id="cod_objetivo" name="cod_objetivo" data-placeholder="OBJETIVO" class="chosen-select">
                    <option></option>
                    <?php                        
                    $q = pg_query("SELECT DISTINCT(cod_objetivo) AS cod_objetivo, txt_objetivo, codigo_objetivo FROM tb_objetivo WHERE cod_ativo = 1 ORDER BY codigo_objetivo");
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_objetivo"]?>"<?php if ($cod_objetivo == $row["cod_objetivo"]) { echo("selected");}?>><?=$row["codigo_objetivo"] ?> - <?=$row["txt_objetivo"] ?></option>
                    <?php	
                    } ?>
                </select>            
            </div>                  
            <div class="col-sm-2">  
                <select id="cod_programa_trabalho" name="cod_programa_trabalho" data-placeholder="PROGRAMA DE TRABALHO" class="chosen-select">
                    <option></option>
                    <?php                        
                    $q = pg_query("SELECT DISTINCT(cod_programa_trabalho) AS cod_programa_trabalho, nr_programa_trabalho FROM tb_programa_trabalho WHERE cod_ativo = 1 ORDER BY nr_programa_trabalho");
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_programa_trabalho"]?>"<?php if ($cod_programa_trabalho == $row["cod_programa_trabalho"]) { echo("selected");}?>><?=$row["nr_programa_trabalho"] ?></option>
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
        <?php
        //EIXO
        $sql = "SELECT DISTINCT(txt_eixo) AS txt_eixo, tb_programa_trabalho.cod_eixo, codigo_eixo FROM tb_programa_trabalho ";         
        $sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_programa_trabalho.cod_eixo WHERE tb_programa_trabalho.cod_ativo = 1 ".$condicao_objetivo;
        $sql .= " ORDER BY codigo_eixo";                        
        $q1 = pg_query($sql);
        if (pg_num_rows($q1) > 0) { ?>
            <p align="justify"> <?php 
                while ($rs1 = pg_fetch_array($q1)) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h3><?php echo($rs1['codigo_eixo']) ?> - <?php echo($rs1['txt_eixo']) ?></h3>
                        </div><!--col-md-12-->
                    </div><!--row-->  
                    <?php
                    //PERSPECTIVA
                    $sql = "SELECT DISTINCT(txt_perspectiva) AS txt_perspectiva, tb_programa_trabalho.cod_perspectiva, codigo_perspectiva ";
                    $sql .= " FROM tb_programa_trabalho ";                                     
                    $sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_programa_trabalho.cod_perspectiva ";
                    $sql .= " WHERE tb_programa_trabalho.cod_eixo = ".$rs1['cod_eixo'].$condicao_objetivo;
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
                                $sql = "SELECT DISTINCT(txt_diretriz) AS txt_diretriz, tb_programa_trabalho.cod_diretriz, codigo_diretriz ";
                                $sql .= " FROM tb_programa_trabalho ";                                
                                $sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_programa_trabalho.cod_diretriz ";                                
                                $sql .= " WHERE tb_programa_trabalho.cod_eixo = ".$rs1['cod_eixo']; 
                                $sql .= " AND tb_programa_trabalho.cod_perspectiva = ".$rsPerspectiva['cod_perspectiva'].$condicao_objetivo;
                                $sql .= " ORDER BY codigo_diretriz";                                                                                             
                                $q2 = pg_query($sql);
                                if (pg_num_rows($q2) > 0) { ?>
                                    <div class="col-md-12">
                                        <?php 
                                        while ($rs2 = pg_fetch_array($q2)) { ?>
                                            <div class="row">
                                                <strong><?php echo($rs2['codigo_diretriz']) ?> - <?php echo($rs2['txt_diretriz']) ?></strong>
                                            </div><!--row-->
                                            <?php
                                            //OBJETIVOS
                                            $sql = "SELECT DISTINCT(txt_objetivo) AS txt_objetivo, tb_programa_trabalho.cod_objetivo, ";
                                            $sql .= " codigo_objetivo, CAST(Replace(substring(codigo_objetivo,4,6), '.', '') AS INT) AS T FROM tb_programa_trabalho ";
                                            $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_programa_trabalho.cod_objetivo ";                                                            
                                            $sql .= " WHERE tb_programa_trabalho.cod_eixo = ".$rs1['cod_eixo'];
                                            $sql .= " AND tb_programa_trabalho.cod_perspectiva = ".$rsPerspectiva['cod_perspectiva'];
                                            $sql .= " AND tb_programa_trabalho.cod_diretriz = ".$rs2['cod_diretriz'].$condicao_objetivo;
                                            $sql .= " ORDER BY T";                                           
                                            $qObjetivo = pg_query($sql);
                                            if (pg_num_rows($qObjetivo) > 0) {
                                                while($rsObjetivo = pg_fetch_array($qObjetivo)) { ?>                                                   
                                                    <div class="row">
                                                        <strong><?php echo($rsObjetivo['codigo_objetivo']) ?> - <?php echo($rsObjetivo['txt_objetivo']) ?></strong>
                                                    </div><!--row-->                                                    
                                                    <?php
                                                    //OBJETIVO PPA
                                                    $sql = "SELECT DISTINCT(txt_objetivo_ppa) AS txt_objetivo_ppa, tb_programa_trabalho.cod_objetivo_ppa, codigo_objetivo_ppa ";
                                                    $sql .= " FROM tb_programa_trabalho ";
                                                    $sql .= " INNER JOIN tb_objetivo_ppa ON tb_objetivo_ppa.cod_objetivo_ppa = tb_programa_trabalho.cod_objetivo_ppa "; 
                                                    $sql .= " WHERE tb_programa_trabalho.cod_eixo = ".$rs1['cod_eixo'];
                                                    $sql .= " AND tb_programa_trabalho.cod_perspectiva = ".$rsPerspectiva['cod_perspectiva'];
                                                    $sql .= " AND tb_programa_trabalho.cod_diretriz = ".$rs2['cod_diretriz'];
                                                    $sql .= " AND tb_programa_trabalho.cod_objetivo = ".$rsObjetivo['cod_objetivo'];
                                                    $sql .= " ORDER BY codigo_objetivo_ppa";                                                   
                                                    $qObjetivoPpa = pg_query($sql);
                                                    if (pg_num_rows($qObjetivoPpa) > 0) {
                                                        while($rsObjetivoPpa = pg_fetch_array($qObjetivoPpa)) { ?>
                                                             <br />
                                                            <div class="row">
                                                                <strong>Objetivo Específico PPA - </strong><?php echo($rsObjetivoPpa['codigo_objetivo_ppa']) ?> - <?php echo($rsObjetivoPpa['txt_objetivo_ppa']) ?>
                                                            </div><!--row--> 
                                                            <br />  
                                                            <div class="row">
                                                                <div class="table-responsive col-md-12">
                                                                    <?php
                                                                    $sql = "SELECT * FROM tb_programa_trabalho WHERE cod_ativo = 1 AND cod_eixo = ".$rs1['cod_eixo'];
                                                                    $sql .= " AND cod_perspectiva = ".$rsPerspectiva['cod_perspectiva'];
                                                                    $sql .= " AND cod_diretriz = ".$rs2['cod_diretriz'];
                                                                    $sql .= " AND cod_objetivo = ".$rsObjetivo['cod_objetivo'];
                                                                    $sql .= " AND cod_objetivo_ppa = ".$rsObjetivoPpa['cod_objetivo_ppa'];                                                                     
                                                                    $qProg = pg_query($sql);  
                                                                    
                                                                    while ($rsProg = pg_fetch_array($qProg)) {
                                                                        $cod_programa_trabalho = $rsProg['cod_programa_trabalho'];
                                                                    ?>
                                                                    <table class="table table-striped" cellspacing="0" cellpadding="0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th>Código Programa de Trabalho/Recurso</th>
                                                                                <th>Nome Programa de Trabalho/Recurso</th>
                                                                                <th>Lei (Dotado)R$</th>
                                                                            </tr>
                                                                            <?php                                                                                                                                                        
                                                                            $txt_titulo_programa =trim($rsProg['txt_titulo_programa']);                                                             
                                                                            $nr_programa_trabalho = trim($rsProg['nr_programa_trabalho']);                                                            
                                                                            $nr_1 = substr($nr_programa_trabalho, 0, 2);
                                                                            $nr_2 = substr($nr_programa_trabalho, 3, 3);
                                                                            $nr_3 = substr($nr_programa_trabalho, 7, 4);
                                                                            $nr_4 = substr($nr_programa_trabalho, 12, 4);
                                                                            $nr_5 = substr($nr_programa_trabalho, 17, 4);
                                                                                                                                                                                                     
                                                                            $sql = "SELECT SUM(cast(cast(LEI as text) as integer)) AS lei FROM tab_siggo_sesplan WHERE cofuncao  = '".$nr_1."' ";
                                                                            $sql .= " AND cosubfuncao = '".$nr_2."' AND coprograma = '".$nr_3."' ";
                                                                            $sql .= " AND coprojeto = '".$nr_4."' AND cosubtitulo = '".$nr_5."'";                                                                                                                                                                                                                                
                                                                            $qStage = pg_query($sql); 
                                                                            while ($rsStage = pg_fetch_array($qStage)) {
                                                                                $lei = $rsStage['lei'];
                                                                            ?>
                                                                                <tr>
                                                                                    <td><?php echo($nr_programa_trabalho); ?></td>
                                                                                    <td><?php echo($txt_titulo_programa); ?></td>
                                                                                    <td><?php echo(number_format($lei, 2, ',', '.')); ?></td>
                                                                                </tr>
                                                                            <?php
                                                                            }
                                                                            ?>                                                                           
                                                                        </tbody>
                                                                    </table>
                                                                    <table class="table table-striped" cellspacing="0" cellpadding="0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th>
                                                                                    <ul class="nav nav-tabs">
                                                                                        <?php 
                                                                                        $ct = 1;    
                                                                                        $css = "active";                                                                                    
                                                                                        while($ct <= 12) { 
                                                                                            if ($ct > 1) {
                                                                                                $css = "";
                                                                                            }
                                                                                            ?>
                                                                                            <li class="<?php echo($css) ?>"><a data-toggle="tab" href="#menu_<?php echo($cod_programa_trabalho) ?>_<?php echo($ct) ?>"><?php echo(RetornaTextoMes($ct)) ?></a></li>
                                                                                        <?php 
                                                                                            $ct += 1;
                                                                                        } ?>                                                                                       
                                                                                    </ul> 
                                                                                    <div class="tab-content">
                                                                                        <?php
                                                                                        $autorizado = 0;  
                                                                                        $disponivel = 0;
                                                                                        $empenhado = 0;
                                                                                        $liquidado = 0;
                                                                                        $ct_1 = 1;
                                                                                        while($ct_1 <= 12) {
                                                                                            if ($ct_1 == 1) {
                                                                                                $css_1 = "tab-pane fade in active";
                                                                                            } else {
                                                                                                $css_1 = "tab-pane fade";
                                                                                            } ?>
                                                                                            <div id="menu_<?php echo($cod_programa_trabalho) ?>_<?=$ct_1?>" class="<?=$css_1?>">
                                                                                                <?php
                                                                                                $sql = "SELECT disponivel, empenhado, liquidado, autorizado FROM tab_siggo_sesplan WHERE cofuncao  = '".$nr_1."' ";
                                                                                                $sql .= " AND cosubfuncao = '".$nr_2."' AND coprograma = '".$nr_3."' ";
                                                                                                $sql .= " AND coprojeto = '".$nr_4."' AND cosubtitulo = '".$nr_5."'";
                                                                                                $sql .= " AND CAST(inmes as integer) = ".$ct_1;                                                                                                                                                                                                                                                          
                                                                                                $qStage2 = pg_query($sql); 
                                                                                                ?>
                                                                                                <table class="table table-striped" cellspacing="0" cellpadding="0">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th>Dotação autorizadaR$</th>
                                                                                                            <th>DisponívelR$</th>
                                                                                                            <th>EmpenhadoR$</th>
                                                                                                            <th>LiquidadoR$</th>    
                                                                                                            <th>Recurso empenhado/autorizado%</th>
                                                                                                            <th>Recurso liquidado/empenhado%</th>                                                                                                        
                                                                                                            <th>Situação</th>
                                                                                                        </tr>
                                                                                                    </thead>	
                                                                                                    <?php
                                                                                                    if (pg_num_rows($qStage2) > 0) {                                                                                                            
                                                                                                        while($rsStage2 = pg_fetch_array($qStage2)) {
                                                                                                            $autorizado = $autorizado + $rsStage2['autorizado'];
                                                                                                            $disponivel = $disponivel + $rsStage2['disponivel'];
                                                                                                            $empenhado = $empenhado + $rsStage2['empenhado'];
                                                                                                            $liquidado = $liquidado + $rsStage2['liquidado'];  
                                                                                                            
                                                                                                            $empenhado_autorizado = $clsExecucaoOrcamentaria->RecursoEmpenhadoAutorizado($empenhado, $autorizado);
                                                                                                            $liquidado_empenhado = $clsExecucaoOrcamentaria->RecursoLiquidadoEmpenhado($liquidado, $empenhado);

                                                                                                            $situacao_execucao = $clsExecucaoOrcamentaria->Situacao($empenhado_autorizado, $ct_1);
                                                                                                            $a_situacao_execucao = explode("|", $situacao_execucao);                                                                                                            
                                                                                                        }
                                                                                                        ?> 
                                                                                                        <tbody>                                                                                                            
                                                                                                            <tr>
                                                                                                                <td><?php echo(number_format($autorizado, 2, ',', '.')) ?></td>
                                                                                                                <td><?php echo(number_format($disponivel, 2, ',', '.')) ?></td>
                                                                                                                <td><?php echo(number_format($empenhado, 2, ',', '.')) ?></td>
                                                                                                                <td><?php echo(number_format($liquidado, 2, ',', '.')) ?></td>
                                                                                                                <td><?php echo($empenhado_autorizado) ?></td>
                                                                                                                <td><?php echo($liquidado_empenhado) ?></td>
                                                                                                                <td>
                                                                                                                    <font color="<?php echo($a_situacao_execucao[0]); ?>"><b><?php echo($a_situacao_execucao[1]); ?></b></font>
                                                                                                                </td>
                                                                                                            </tr>                                                                                                                                                                                                                  
                                                                                                        </tbody>
                                                                                                        <?php	
                                                                                                    }
                                                                                                    ?>                                                                                                    
                                                                                                </table>
                                                                                            </div> <?php   
                                                                                            
                                                                                            $ct_1 += 1;
                                                                                        }
                                                                                        ?>                                                                                        
                                                                                    </div>                                                                                          
                                                                                </th>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <?php
                                                                    }
                                                                    ?>                                                                    
                                                                </div>
                                                            </div><!--row-->  
                                                            <br />
                                                        <?php
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                } ?>
            </p>
        <?php 
        }
        ?>         
        <br />        
        <div class="row">
            <div class="col-md-12">                
                <a href="../indicador/default.php" class="btn btn-default">Voltar</a>
            </div><!--col-md-12--> 
        </div><!--row-->           
    </form>
</div>
<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>