<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsSag.php");
include_once (__DIR__ . "/../classes/clsStatus.php");
verifica_seguranca();
cabecalho();

if (empty($_REQUEST['log'])) {
	Auditoria(111, "Listar SAG", "");
}

$txt_pesquisa = $_REQUEST['txt_pesquisa'];
$cod_objetivo_url = $_REQUEST['cod_objetivo_url'];
$txt_filtro_etapa = $_REQUEST['txt_filtro_etapa'];
$txt_filtro_responsavel = $_REQUEST['txt_filtro_responsavel'];

if (!empty($cod_objetivo_url)) {
    $condicao = " AND tb_objetivo.cod_objetivo = ".$cod_objetivo_url;
    permissao_acesso_pagina(76);
} else {
    $condicao = "";
    permissao_acesso_pagina(90);
}

if (!empty($txt_filtro_etapa)) {
    $condicao .= " AND tb_sag.nr_etapa_trabalho = '" .trim($txt_filtro_etapa). "'";
}

if (!empty($txt_filtro_responsavel)) {
    $condicao .= " AND tb_sag.cod_orgao = ".$txt_filtro_responsavel;
}

$clsSag = new clsSag();
$clsStatus = new clsStatus();
?>

<div id="main" class="container-fluid" style="margin-top: 50px">
    <form id="frm1">
        <input type="hidden" name="log" id="log" value="1" />
        <input type="hidden" name="cod_objetivo_url" id="cod_objetivo_url" value="<?php echo($cod_objetivo_url) ?>" />
        <div id="top" class="row">
			<div class="col-sm-3">
				<h2>SAG</h2>
			</div>
			<div class="col-sm-6">				
				<div class="input-group h2">
					
				</div>			
			</div>
			<div class="col-sm-3">
                <?php if (permissao_acesso(77)) { ?>
				    <a href="incluir.php" class="btn btn-primary pull-right h2">Incluir</a>
                <?php } ?>
			</div>
		</div> <!-- /#top -->
        <div class="row">               
            <div class="col-sm-6">                
                <select id="txt_filtro_etapa" name="txt_filtro_etapa" data-placeholder="ETAPA" class="chosen-select">
                    <option></option>
                    <?php                        
                    $q = pg_query("SELECT nr_etapa_trabalho FROM tb_sag WHERE cod_ativo = 1 ORDER BY nr_etapa_trabalho");
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["nr_etapa_trabalho"]?>"<?php if ($txt_filtro_etapa == $row["nr_etapa_trabalho"]) { echo("selected");}?>><?=$row["nr_etapa_trabalho"] ?></option>
                    <?php	
                    } ?>
                </select>   
            </div>  
            <div class="col-sm-6">                
                <select id="txt_filtro_responsavel" name="txt_filtro_responsavel" class="chosen-select" data-placeholder="RESPONSÁVEL">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT DISTINCT tb_orgao.cod_orgao, txt_sigla FROM tb_orgao INNER JOIN tb_sag ON tb_orgao.cod_orgao = tb_sag.cod_orgao  WHERE tb_orgao.cod_ativo = 1 ORDER BY txt_sigla");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_orgao"]?>"<?php if ($txt_filtro_responsavel == $row["cod_orgao"]) { echo("selected");}?>><?=$row["txt_sigla"] ?></option>
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
        $sql = "SELECT DISTINCT(txt_eixo) AS txt_eixo, tb_objetivo.cod_eixo, codigo_eixo FROM tb_sag ";
        $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_sag.cod_objetivo ";        
        $sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo ";
        $sql .= " INNER JOIN tb_programa_trabalho ON tb_programa_trabalho.cod_eixo = tb_eixo.cod_eixo ";
        $sql .= " WHERE tb_eixo.cod_ativo = 1".$condicao;
        $q1 = pg_query($sql);
        if (pg_num_rows($q1) > 0) { ?>
            <p align="justify">
                <?php 
                while ($rs1 = pg_fetch_array($q1)) { ?>
                    <tr>								
                        <th>
                            <h3><?php echo($rs1['codigo_eixo']) ?> - <?php echo($rs1['txt_eixo']) ?></h3>                                                                   
                            <?php 
                            //PERSPECTIVA
                            $sql = "SELECT DISTINCT(txt_perspectiva) AS txt_perspectiva, tb_perspectiva.cod_perspectiva, codigo_perspectiva FROM tb_sag ";
                            $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_sag.cod_objetivo ";
                            $sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva ";
                            $sql .= " INNER JOIN tb_programa_trabalho ON tb_programa_trabalho.cod_perspectiva = tb_perspectiva.cod_perspectiva ";
                            $sql .= " WHERE tb_perspectiva.cod_ativo = 1 AND tb_objetivo.cod_eixo = ".$rs1['cod_eixo'].$condicao;
                            ?>
                            <n />
                            &nbsp;&nbsp;
                            <?php 
                            $q2 = pg_query($sql);
                            while ($rs2 = pg_fetch_array($q2)) { ?>
                                <strong><?php echo($rs2['codigo_perspectiva']);?> - <?php echo($rs2['txt_perspectiva']);?></strong>                                        
                                <?php
                                //DIRETRIZ
                                $sql = "SELECT DISTINCT(txt_diretriz) AS txt_diretriz, tb_diretriz.cod_diretriz, codigo_diretriz FROM tb_sag ";
                                $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_sag.cod_objetivo ";
                                $sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz ";
                                $sql .= " INNER JOIN tb_programa_trabalho ON tb_programa_trabalho.cod_diretriz = tb_diretriz.cod_diretriz ";
                                $sql .= " WHERE tb_diretriz.cod_ativo = 1 AND tb_objetivo.cod_eixo = ".$rs1['cod_eixo'];
                                $sql .= " AND tb_objetivo.cod_perspectiva = ".$rs2['cod_perspectiva'].$condicao;
                                ?>
                                <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php 
                                $q3 = pg_query($sql);
                                while ($rs3 = pg_fetch_array($q3)) { ?>
                                    <strong><?php echo($rs3['codigo_diretriz']);?> - <?php echo($rs3['txt_diretriz']);?></strong>  
                                    <?php 
                                    //OBJETIVO
                                    $sql = "SELECT DISTINCT(txt_objetivo) AS txt_objetivo, tb_sag.cod_objetivo, codigo_objetivo FROM tb_sag ";
                                    $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_sag.cod_objetivo ";
                                    $sql .= " INNER JOIN tb_programa_trabalho ON tb_programa_trabalho.cod_objetivo = tb_objetivo.cod_objetivo ";
                                    $sql .= " WHERE tb_objetivo.cod_ativo = 1 AND tb_objetivo.cod_eixo = ".$rs1['cod_eixo'];
                                    $sql .= " AND tb_objetivo.cod_perspectiva = ".$rs2['cod_perspectiva'];
                                    $sql .= " AND tb_objetivo.cod_diretriz = ".$rs3['cod_diretriz'].$condicao;                                    
                                    ?>
                                    <br />
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php 
                                    $q4 = pg_query($sql);
                                    while ($rs4 = pg_fetch_array($q4)) { ?>
                                        <strong><?php echo($rs4['codigo_objetivo']);?> - <?php echo($rs4['txt_objetivo']);?></strong>
                                        <?php
                                        //OBJETIVO PPA
                                        $sql = "SELECT DISTINCT(txt_objetivo_ppa) AS txt_objetivo_ppa, tb_sag.cod_objetivo_ppa, codigo_objetivo_ppa FROM tb_sag ";
                                        $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_sag.cod_objetivo ";
                                        $sql .= " INNER JOIN tb_objetivo_ppa ON tb_objetivo_ppa.cod_objetivo_ppa = tb_sag.cod_objetivo_ppa ";
                                        $sql .= " INNER JOIN tb_programa_trabalho ON tb_programa_trabalho.cod_objetivo_ppa = tb_objetivo_ppa.cod_objetivo_ppa ";
                                        $sql .= " WHERE tb_objetivo_ppa.cod_ativo = 1 AND tb_objetivo.cod_eixo = ".$rs1['cod_eixo'];
                                        $sql .= " AND tb_objetivo.cod_perspectiva = ".$rs2['cod_perspectiva'];
                                        $sql .= " AND tb_objetivo.cod_diretriz = ".$rs3['cod_diretriz'];
                                        $sql .= " AND tb_sag.cod_objetivo = ".$rs4['cod_objetivo'].$condicao;
                                        ?>
                                        <br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php                                                                                
                                        $q5 = pg_query($sql);                                        
                                        while ($rs5 = pg_fetch_array($q5)) {    ?>                                            
                                            <strong><?php echo($rs5['codigo_objetivo_ppa']);?> - <?php echo($rs5['txt_objetivo_ppa']);?></strong>;                                            
                                            <?php
                                            //PROGRAMA DE TRABALHO
                                            $sql = "SELECT DISTINCT nr_programa_trabalho, txt_programa_trabalho, txt_titulo_programa , tb_sag.cod_programa_trabalho FROM tb_sag ";
                                            $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_sag.cod_objetivo ";
                                            $sql .= " INNER JOIN tb_programa_trabalho ON tb_programa_trabalho.cod_programa_trabalho = tb_sag.cod_programa_trabalho ";
                                            $sql .= " WHERE tb_programa_trabalho.cod_ativo = 1 AND tb_objetivo.cod_eixo = ".$rs1['cod_eixo'];
                                            $sql .= " AND tb_objetivo.cod_perspectiva = ".$rs2['cod_perspectiva'];
                                            $sql .= " AND tb_objetivo.cod_diretriz = ".$rs3['cod_diretriz']. " AND tb_sag.cod_objetivo = ".$rs4['cod_objetivo'];
                                            $sql .= " AND tb_sag.cod_objetivo_ppa = ".$rs5['cod_objetivo_ppa'].$condicao;                                           
                                            ?>
                                            <br />
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php 
                                            $ct = 0;
                                            $q6 = pg_query($sql);                                           
                                            while ($rs6 = pg_fetch_array($q6)) {                                                     
                                                if($ct > 0) { 
                                                    if ($cod_eixo_old != $rs1['cod_eixo'])    
                                                    { ?>
                                                        <h3><?php echo($rs1['codigo_eixo']) ?> - <?php echo($rs1['txt_eixo']);?></h3> <br />
                                                    <?php 
                                                    } 
                                                    if ($cod_perspectiva_old != $rs2['cod_perspectiva'])    
                                                    { ?>
                                                        &nbsp;&nbsp;<strong><?php echo($rs2['codigo_perspectiva']) ?> - <?php echo($rs2['txt_perspectiva']);?></strong> <br />
                                                    <?php
                                                    }
                                                    if ($cod_diretriz_old != $rs3['cod_diretriz'])    
                                                    { ?>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($rs3['codigo_diretriz']) ?> - <?php echo($rs3['txt_diretriz']);?></strong> <br />
                                                    <?php
                                                    }
                                                    if ($cod_objetivo_old != $rs4['cod_objetivo'])
                                                    { ?>    
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($rs4['codigo_objetivo']) ?> - <?php echo($rs4['txt_objetivo']);?></strong> <br />                                                                                                        
                                                    <?php   
                                                    } 
                                                    if ($cod_objetivo_ppa_old != $rs5['cod_objetivo_ppa']) 
                                                    {?>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($rs5['codigo_objetivo_ppa']) ?> - <?php echo($rs5['txt_objetivo_ppa']);?></strong> <br />
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                    <?php
                                                    }                                       
                                                }
                                                $cod_eixo_old = $rs1['cod_eixo'];
                                                $cod_perspectiva_old = $rs2['cod_perspectiva'];
                                                $cod_diretriz_old = $rs3['cod_diretriz'];
                                                $cod_objetivo_old = $rs4['cod_objetivo'];
                                                $cod_objetivo_ppa_old = $rs5['cod_objetivo_ppa'];
                                                ?>
                                                <strong><?php echo($rs6['nr_programa_trabalho']);?> - <?php echo($rs6['txt_titulo_programa']);?></strong> <br />
                                                <?php
                                                //AÇÕES
                                                $sql = "SELECT tb_sag.*, tb_orgao.txt_sigla, t1.txt_mes AS mes_inicio, t2.txt_mes AS mes_fim, ";
                                                $sql .= " parceiro.txt_sigla AS txt_parceiro, txt_modulo, t3.txt_mes AS cod_inicio_efetivo, ";
                                                $sql .= " t4.txt_mes AS cod_fim_efetivo, um.txt_unidade_medida, pe.txt_produto_etapa ";
                                                $sql .= " FROM tb_sag ";
                                                $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_sag.cod_objetivo ";
                                                $sql .= " INNER JOIN tb_orgao ON tb_orgao.cod_orgao = tb_sag.cod_orgao";
                                                $sql .= " LEFT JOIN tb_orgao parceiro ON parceiro.cod_orgao = tb_sag.cod_parceiro";
                                                $sql .= " INNER JOIN tb_mes t1 ON t1.cod_mes = tb_sag.cod_inicio_previsto";
                                                $sql .= " INNER JOIN tb_mes t2 ON t2.cod_mes = tb_sag.cod_fim_previsto";
                                                $sql .= " LEFT JOIN tb_mes t3 ON t3.cod_mes = tb_sag.cod_inicio_efetivo";
                                                $sql .= " LEFT JOIN tb_mes t4 ON t4.cod_mes = tb_sag.cod_fim_efetivo";
                                                $sql .= " INNER JOIN tb_modulo ON tb_modulo.cod_modulo = tb_sag.cod_modulo";
                                                $sql .= " INNER JOIN tb_unidade_medida um ON um.cod_unidade_medida = tb_sag.cod_unidade_medida";
                                                $sql .= " INNER JOIN tb_produto_etapa pe ON pe.cod_produto_etapa = tb_sag.cod_produto_etapa";
                                                $sql .= " WHERE cod_eixo = ".$rs1['cod_eixo'];
                                                $sql .= " AND cod_perspectiva = ".$rs2['cod_perspectiva']. " AND cod_diretriz = ".$rs3['cod_diretriz'];
                                                $sql .= " AND tb_sag.cod_objetivo = ".$rs4['cod_objetivo']. " AND cod_objetivo_ppa = ".$rs5['cod_objetivo_ppa'];
                                                $sql .= " AND cod_programa_trabalho = ".$rs6['cod_programa_trabalho'].$condicao;
                                                $qEtapa = pg_query($sql);
                                                if (pg_num_rows($qEtapa) > 0) { ?>
                                                    <br />  <?php
                                                    while ($rsEtapa = pg_fetch_array($qEtapa)) { ?>                                                                                                              
                                                        <div id="list" class="row">                                               
                                                            <div class="col-md-12">
                                                                <h4>
                                                                    <b>Descrição da Etapa:</b> 
                                                                    <?php echo($rsEtapa['txt_etapa_trabalho']) ?>
                                                                </h4>
                                                            </div> 
                                                            <div class="table-responsive col-md-12">
                                                                <table class="table table-striped" cellspacing="0" cellpadding="0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Etapa SAG</th>                                                                            
                                                                            <th>Produto da Etapa</th>
                                                                            <th>Quantidade da Etapa</th>
                                                                            <th>Unidade</th>
                                                                            <!--<th>Início Previsto</th>
                                                                            <th>Fim Previsto</th>-->
                                                                            <th>Responsável</th>
                                                                            <th>Parceiro</th>                                                                    
                                                                            <th>Empenho</th>
                                                                            <th>Status</th>
                                                                            <th class="actions">Ações</th>
                                                                        </tr>                                                            
                                                                    </thead>
                                                                    <tbody>                                                                   
                                                                        <tr>
                                                                            <td>
                                                                                <!--<a href="#" data-toggle="modal" data-target="#myModal" onclick="SetDadosModal(<?php echo($rsEtapa['cod_sag']) ?>);">-->
                                                                                    <?php echo($rsEtapa['nr_etapa_trabalho']) ?>
                                                                                <!--</a>-->
                                                                            </td>                                                                            
                                                                            <td><?php echo($rsEtapa['txt_produto_etapa']) ?></td>
                                                                            <td><?php echo($rsEtapa['nr_meta']) ?></td>
                                                                            <td><?php echo($rsEtapa['txt_unidade_medida']) ?></td>
                                                                            <!--<td><?php echo($rsEtapa['mes_inicio']) ?></td>
                                                                            <td><?php echo($rsEtapa['mes_fim']) ?></td>-->
                                                                            <td><?php echo($rsEtapa['txt_sigla']) ?></td>
                                                                            <td><?php echo($rsEtapa['txt_parceiro']) ?></td>
                                                                            <td>NÃO</td>
                                                                            <td>
                                                                                <?php
                                                                                $cod_status = $clsSag->RetornaSituacaoSAG($rsEtapa['cod_sag']);
                                                                                $cor = $clsStatus->RetornaCorStatus($cod_status);   
                                                                                $txt_status = $clsStatus->RetornaStatus($cod_status);                                                                             
                                                                                ?>
                                                                                <input type="text" class="form-control_custom" id="cod_status" name="cod_status" style="background-color:<?php echo($cor) ?>" value="<?php echo($txt_status) ?>" disabled="disabled" /> 
                                                                            </td>
                                                                            <td class="actions">	
                                                                                <select name="teste" class="form-control_select" onchange="javascript:go(this)">                                                                            
                                                                                    <option value="">&nbsp;</option>
                                                                                    <?php if (permissao_acesso(81)) { ?> 
                                                                                        <option value="analise.php?cod_sag=<?php echo($rsEtapa['cod_sag']) ?>&cod_objetivo_url=<?php echo($cod_objetivo_url) ?>">Análise</option>                                                                                  
                                                                                    <?php } ?>                            
                                                                                    <?php if (permissao_acesso(78)) { ?>  
                                                                                        <option value="alterar.php?id=<?php echo($rsEtapa['cod_sag']) ?>">Editar</option>  
                                                                                    <?php } ?>                            
                                                                                    <?php if (permissao_acesso(82)) { ?>      
                                                                                        <option value="historico_analise.php?id=<?php echo($rsEtapa['cod_sag']) ?>">Histórico</option>  
                                                                                    <?php } ?>                                                                                                                                                   
                                                                                </select><br /> 
                                                                                <?php if (permissao_acesso(79)) { ?> 								                                                                            
                                                                                    <a class="btn btn-danger btn-xs" onclick="return Excluir(<?php echo($rsEtapa['cod_sag']) ?>);" >Excluir</a>
                                                                                <?php } ?> 
                                                                            </td>
                                                                        </tr>                                                                   
                                                                    </tbody>
                                                                </table> 
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                }
                                                $ct = $ct + 1;
                                            }
                                        }
                                    }
                                } 
                            }                                         
                            ?>
                        </th>								
                    </tr>
                <?php
                } ?>  
            </p>
        <?php
        }        
        else { ?>
            <hr>
            <center><h4>NÃO EXISTEM REGISTROS CADASTRADOS.</h4></center>
        <?php
        }?>
        <br />        
        <div class="row">
            <div class="col-md-12">                
                <a href="../indicador/default.php" class="btn btn-default">Voltar</a>
            </div><!--col-md-12--> 
        </div><!--row--> 
    </form>
</div>
<script src="manter.js" type="text/javascript"></script>
<script type="text/javascript">    
    function SubmitForm() {    
        self.location.href = 'default.php?txt_filtro_etapa=' + $('#txt_filtro_etapa').val() + '&txt_filtro_responsavel=' + $('#txt_filtro_responsavel').val() + '&cod_objetivo_url=' + $('#cod_objetivo_url').val();
    }

    function LimparForm() {    
        self.location.href = 'default.php?cod_objetivo_url=' + $('#cod_objetivo_url').val(); 
    }
</script>
<?php
rodape($dbcon);
?>