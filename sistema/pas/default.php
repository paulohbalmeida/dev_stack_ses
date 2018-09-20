<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsPas.php");
include_once (__DIR__ . "/../classes/clsStatus.php");
verifica_seguranca();
cabecalho();

if (empty($_REQUEST['log'])) {
	Auditoria(85, "Listar PAS", "");
}

$txt_pesquisa = $_REQUEST['txt_pesquisa'];
$cod_objetivo_url = $_REQUEST['cod_objetivo_url'];
$txt_filtro = $_REQUEST['txt_filtro'];
$txt_filtro_responsavel = $_REQUEST['txt_filtro_responsavel'];

if (!empty($cod_objetivo_url)) {
    $condicao = " AND tb_objetivo.cod_objetivo = ".$cod_objetivo_url;
    permissao_acesso_pagina(67);
} else {
    $condicao = "";
    permissao_acesso_pagina(89);
}

if (!empty($txt_filtro)) {
    $condicao .= " AND tb_pas.codigo_acao = '" .trim($txt_filtro). "'";
}

if (!empty($txt_filtro_responsavel)) {
    $condicao .= " AND tb_pas.cod_orgao = ".$txt_filtro_responsavel;
}

$clsPas = new clsPas();
$clsStatus = new clsStatus();

if($clsPas->RegraPeriodo()) {
    $css_periodo = "";
} else {
    $css_periodo = "disabled";
}
?>

<div id="main" class="container-fluid" style="margin-top: 50px">
    <form id="frm1">
        <input type="hidden" name="log" id="log" value="1" />       
        <input type="hidden" name="cod_objetivo_url" id="cod_objetivo_url" value="<?php echo($cod_objetivo_url) ?>" />       
        <div id="top" class="row">
			<div class="col-sm-3">
				<h2>PAS</h2>
			</div>
			<div class="col-sm-6">				
				<div class="input-group h2">
					
				</div>			
			</div>
			<div class="col-sm-3">
                <?php if (permissao_acesso(68)) { ?>
				    <a href="incluir.php" class="btn btn-primary pull-right h2">Incluir</a>
                <?php } ?>
			</div>
		</div> <!-- /#top -->        
        <div class="row">
            <div class="col-sm-6">                
                <select id="txt_filtro" name="txt_filtro" data-placeholder="AÇÃO" class="chosen-select">
                    <option></option>
                    <?php                        
                    $q = pg_query("SELECT txt_acao, codigo_acao FROM tb_pas WHERE cod_ativo = 1 ORDER BY codigo_acao");
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["codigo_acao"]?>"<?php if ($txt_filtro == $row["codigo_acao"]) { echo("selected");}?>><?=$row["codigo_acao"] ?> - <?=$row["txt_acao"] ?></option>
                    <?php	
                    } ?>
                </select>   
            </div> 
            <div class="col-sm-6">                
                <select id="txt_filtro_responsavel" name="txt_filtro_responsavel" class="chosen-select" data-placeholder="RESPONSÁVEL">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT DISTINCT tb_orgao.cod_orgao, txt_sigla FROM tb_orgao INNER JOIN tb_pas ON tb_orgao.cod_orgao = tb_pas.cod_orgao  WHERE tb_orgao.cod_ativo = 1 ORDER BY txt_sigla");
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
        $sql = "SELECT DISTINCT(txt_eixo) AS txt_eixo, tb_objetivo.cod_eixo, codigo_eixo FROM tb_pas ";
        $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_pas.cod_objetivo ";
        $sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo WHERE tb_eixo.cod_ativo = 1 ".$condicao." ORDER BY codigo_eixo";
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
                            $sql = "SELECT DISTINCT(txt_perspectiva) AS txt_perspectiva, tb_perspectiva.cod_perspectiva, codigo_perspectiva FROM tb_pas ";
                            $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_pas.cod_objetivo ";
                            $sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva ";
                            $sql .= " WHERE tb_perspectiva.cod_ativo = 1 AND tb_objetivo.cod_eixo = ".$rs1['cod_eixo'].$condicao." ORDER BY codigo_perspectiva";
                            ?>                            
                            &nbsp;&nbsp;
                            <?php 
                            $q2 = pg_query($sql);
                            while ($rs2 = pg_fetch_array($q2)) { ?>
                                <strong><?php echo($rs2['codigo_perspectiva']) ?> - <?php echo($rs2['txt_perspectiva']);?></strong>
                                <?php
                                //DIRETRIZ
                                $sql = "SELECT DISTINCT(txt_diretriz) AS txt_diretriz, tb_diretriz.cod_diretriz, codigo_diretriz FROM tb_pas ";
                                $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_pas.cod_objetivo ";
                                $sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz ";
                                $sql .= " WHERE tb_diretriz.cod_ativo = 1 AND tb_objetivo.cod_eixo = ".$rs1['cod_eixo'];
                                $sql .= " AND tb_objetivo.cod_perspectiva = ".$rs2['cod_perspectiva'].$condicao." ORDER BY codigo_diretriz";
                                ?>
                                <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php 
                                $q3 = pg_query($sql);
                                while ($rs3 = pg_fetch_array($q3)) { ?>
                                    <strong><?php echo($rs3['codigo_diretriz']) ?> - <?php echo($rs3['txt_diretriz']);?></strong>  
                                    <?php 
                                    //OBJETIVO
                                    $sql = "SELECT DISTINCT(txt_objetivo) AS txt_objetivo, tb_pas.cod_objetivo, codigo_objetivo FROM tb_pas ";
                                    $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_pas.cod_objetivo ";
                                    $sql .= " WHERE tb_objetivo.cod_ativo = 1 AND tb_objetivo.cod_eixo = ".$rs1['cod_eixo'];
                                    $sql .= " AND tb_objetivo.cod_perspectiva = ".$rs2['cod_perspectiva'];
                                    $sql .= " AND tb_objetivo.cod_diretriz = ".$rs3['cod_diretriz'].$condicao." ORDER BY codigo_objetivo";
                                    ?>
                                    <br />
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php 
                                    $q4 = pg_query($sql);
                                    while ($rs4 = pg_fetch_array($q4)) { ?>
                                        <strong><?php echo($rs4['codigo_objetivo']) ?> - <?php echo($rs4['txt_objetivo']);?></strong>
                                        <?php
                                        //OBJETIVO PPA
                                        $sql = "SELECT DISTINCT(txt_objetivo_ppa) AS txt_objetivo_ppa, tb_pas.cod_objetivo_ppa, codigo_objetivo_ppa FROM tb_pas ";
                                        $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_pas.cod_objetivo ";
                                        $sql .= " INNER JOIN tb_objetivo_ppa ON tb_objetivo_ppa.cod_objetivo_ppa = tb_pas.cod_objetivo_ppa ";
                                        $sql .= " WHERE tb_objetivo_ppa.cod_ativo = 1 AND tb_objetivo.cod_eixo = ".$rs1['cod_eixo'];
                                        $sql .= " AND tb_objetivo.cod_perspectiva = ".$rs2['cod_perspectiva'];
                                        $sql .= " AND tb_objetivo.cod_diretriz = ".$rs3['cod_diretriz'];
                                        $sql .= " AND tb_pas.cod_objetivo = ".$rs4['cod_objetivo'].$condicao." ORDER BY codigo_objetivo_ppa";
                                        ?>
                                        <br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php 
                                        $ct = 0;
                                        $q5 = pg_query($sql);
                                        while ($rs5 = pg_fetch_array($q5)) {                                             
                                            if($ct > 0) { ?>
                                                <h3><?php echo($rs1['codigo_eixo']) ?> - <?php echo($rs1['txt_eixo']);?></h3> <br />
                                                &nbsp;&nbsp;<strong><?php echo($rs2['codigo_perspectiva']) ?> - <?php echo($rs2['txt_perspectiva']);?></strong> <br />
                                                &nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($rs3['codigo_diretriz']) ?> - <?php echo($rs3['txt_diretriz']);?></strong> <br />
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($rs4['codigo_objetivo']) ?> - <?php echo($rs4['txt_objetivo']);?></strong> <br />                                                
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php                                           
                                            }
                                            ?>
                                            <strong><?php echo($rs5['codigo_objetivo_ppa']);?> - <?php echo($rs5['txt_objetivo_ppa']);?></strong>
                                            <?php
                                            //AÇÕES
                                            $sql = "SELECT tb_pas.*, tb_orgao.txt_sigla, t1.txt_mes AS mes_inicio, t2.txt_mes AS mes_fim, ";
                                            $sql .= " parceiro.txt_sigla AS txt_parceiro, t3.cod_mes AS cod_inicio_efetivo, ";
                                            $sql .= " t4.cod_mes AS cod_fim_efetivo ";
                                            $sql .= " FROM tb_pas ";
                                            $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_pas.cod_objetivo ";
                                            $sql .= " INNER JOIN tb_orgao ON tb_orgao.cod_orgao = tb_pas.cod_orgao";
                                            $sql .= " LEFT JOIN tb_orgao parceiro ON parceiro.cod_orgao = tb_pas.cod_parceiro";
                                            $sql .= " INNER JOIN tb_pas_mes t1 ON t1.cod_mes = tb_pas.cod_inicio_previsto";
                                            $sql .= " INNER JOIN tb_pas_mes t2 ON t2.cod_mes = tb_pas.cod_fim_previsto";
                                            $sql .= " LEFT JOIN tb_pas_mes t3 ON t3.cod_mes = tb_pas.cod_inicio_efetivo";
                                            $sql .= " LEFT JOIN tb_pas_mes t4 ON t4.cod_mes = tb_pas.cod_fim_efetivo";                                            
                                            $sql .= " WHERE cod_eixo = ".$rs1['cod_eixo'];                                            
                                            $sql .= " AND cod_perspectiva = ".$rs2['cod_perspectiva']. " AND cod_diretriz = ".$rs3['cod_diretriz'];
                                            $sql .= " AND tb_pas.cod_objetivo = ".$rs4['cod_objetivo']. " AND cod_objetivo_ppa = ".$rs5['cod_objetivo_ppa'].$condicao;
                                            $sql .= " ORDER BY CAST(LEFT(tb_pas.codigo_acao||'.', STRPOS(tb_pas.codigo_acao||'.','.') - 1) AS INT)";                                            
                                            //echo($sql);
                                            $qAcao = pg_query($sql);
                                            if (pg_num_rows($qAcao) > 0) { ?>
                                                <br /><br /> 
                                                <?php
                                                while ($rsAcao = pg_fetch_array($qAcao)) {                                                                                                                         
                                                    $id = $rsAcao['cod_pas'];
                                                    $cod_status = $clsPas->SituacaoPAS($id);                                                                                                                                                                                             
                                                    if ($cod_status != '') {
                                                        $txt_cor = $clsStatus->RetornaCorStatus($cod_status);                                                                        
                                                        $txt_status = $clsStatus->RetornaStatus($cod_status);                                                                        
                                                    } else {
                                                        $txt_cor = "";
                                                        $txt_status = "";
                                                    }  
                                                    
                                                    if ($clsPas->VerificaControleCanceladoAutorizado($id)) {
                                                        $disabled_controle = "disabled";
                                                    } else {
                                                        $disabled_controle = "";
                                                    }
                                                    
                                                    ?>                                                    
                                                    <div id="list" class="row">                                               
                                                        <div class="col-md-12">
                                                            <h4>
                                                                <b>Ação PAS:</b> 
                                                                <!--<a href="#" data-toggle="modal" data-target="#myModal" onclick="SetDadosModal(<?php echo($rsAcao['cod_pas']) ?>);">-->
                                                                <?php echo($rsAcao['codigo_acao']) ?> - <?php echo($rsAcao['txt_acao']) ?>
                                                                    <!--</a>-->
                                                            </h4>                                                                                                                        
                                                        </div> 
                                                        <div id="ancora_<?php echo($id) ?>"></div>
                                                        <div class="table-responsive col-md-12">
                                                            <table class="table table-striped" cellspacing="0" cellpadding="0">
                                                                <thead>
                                                                    <tr>                                                                    
                                                                        <th>Meta Física</th>
                                                                        <th>Unidade Medida</th>
                                                                        <th>Resultado/Ano</th>
                                                                        <th>Início Previsto</th>
                                                                        <th>Fim Previsto</th>
                                                                        <th>Início <br /> Efetivo</th>
                                                                        <th>Fim <br /> Efetivo</th>
                                                                        <th>Situação</th>
                                                                        <th>Controle</th>                                                                        
                                                                        <th>Responsável</th>
                                                                        <!--<th>Parceiro</th>-->
                                                                        <th class="actions"></th>                                                                        
                                                                    </tr>                                                            
                                                                </thead>
                                                                <tbody>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                                                                    <tr>                                                                        
                                                                        <td><?php echo($rsAcao['cod_meta']) ?></td>
                                                                        <td><?php echo($rsAcao['txt_medida']) ?></td>
                                                                        <td>
                                                                            <input type="text" class="form-control-pas" id="cod_resultado<?php echo($id) ?>" name="cod_resultado" value="<?php echo($rsAcao['cod_resultado']) ?>" onkeyup="somenteNumeros(this);" onblur="SalvarCompleto('<?php echo($id) ?>', 1);" <?php echo($disabled_controle) ?>>
                                                                        </td>
                                                                        <td>
                                                                            <?php 
                                                                            $mes1 = $rsAcao['mes_inicio'];
                                                                            $mes1 = explode("/",$mes1);
                                                                            echo($mes1[0]."<br />".$mes1[1]); 
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php                                                                             
                                                                            $mes2 = $rsAcao['mes_fim'];
                                                                            $mes2 = explode("/",$mes2);
                                                                            echo($mes2[0]."<br />".$mes2[1]); 
                                                                            ?>                                                                            
                                                                        </td>
                                                                        <td>
                                                                            <select id="cod_inicio_efetivo<?php echo($id) ?>" name="cod_inicio_efetivo" class="form-control_select" onchange="SalvarCompleto('<?php echo($id) ?>', 1);" <?php echo($disabled_controle) ?>>
                                                                                <option></option>
                                                                                <?php                                                                                            
                                                                                $q = pg_query("SELECT cod_mes, txt_mes FROM tb_pas_mes ORDER BY cod_mes");
                                                                                while ($row = pg_fetch_array($q)) 
                                                                                { ?>
                                                                                    <option value="<?=$row["cod_mes"]?>"<?php if ($rsAcao['cod_inicio_efetivo'] == $row["cod_mes"]) { echo("selected");}?>><?=$row["txt_mes"] ?></option>                                                                                    
                                                                                <?php	
                                                                                } ?>
                                                                            </select>                                                                        
                                                                        </td>
                                                                        <td>
                                                                            <select id="cod_fim_efetivo<?php echo($id) ?>" name="cod_fim_efetivo" class="form-control_select" onchange="SalvarCompleto('<?php echo($id) ?>', 1);" <?php echo($disabled_controle) ?>>
                                                                                <option></option>
                                                                                <?php                        
                                                                                $q = pg_query("SELECT cod_mes, txt_mes FROM tb_pas_mes ORDER BY cod_mes");
                                                                                while ($row = pg_fetch_array($q)) 
                                                                                { ?>
                                                                                    <option value="<?=$row["cod_mes"]?>"<?php if ($rsAcao['cod_fim_efetivo'] == $row["cod_mes"]) { echo("selected");}?>><?=$row["txt_mes"] ?></option>                                                                                    
                                                                                <?php	
                                                                                } ?>
                                                                            </select>                                                                        
                                                                        </td> 
                                                                        <td>
                                                                            <div id="div_status<?php echo($id) ?>">
                                                                                <font color="<?php echo($txt_cor); ?>"><b><?php echo($txt_status); ?></b></font>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <select id="cod_controle<?php echo($id) ?>" name="cod_controle" class="form-control_select" onchange="javascript:go_(this, <?php echo($id) ?>)" <?php echo($disabled_controle) ?>>
                                                                                <option></option>
                                                                                <?php                        
                                                                                $q = pg_query("SELECT * FROM tb_pas_controle WHERE cod_ativo = 1 ORDER BY txt_controle");
                                                                                while ($row = pg_fetch_array($q)) 
                                                                                { ?>
                                                                                    <option value="<?=$row["cod_controle"]?>"<?php if ($rsAcao['cod_controle'] == $row["cod_controle"]) { echo("selected");}?>><?=$row["txt_controle"] ?></option>
                                                                                <?php	
                                                                                } ?>	
                                                                            </select>      
                                                                        </td>                                                                                                                                                                                                                                             
                                                                        <td><?php echo($rsAcao['txt_sigla']) ?></td>
                                                                        <!--<td><?php echo($rsAcao['txt_parceiro']) ?></td>-->                                                                        
                                                                        <td class="actions">
                                                                            <select name="teste" class="form-control_select" onchange="javascript:go(this)">                                                                            
                                                                                <option value="">&nbsp;</option>
                                                                                <?php if (permissao_acesso(83)) { ?>
                                                                                    <option value="consideracao.php?cod_pas=<?php echo($rsAcao['cod_pas']) ?>&cod_objetivo_url=<?php echo($cod_objetivo_url) ?>">Análise</option>  
                                                                                <?php } ?>
                                                                                <?php if (permissao_acesso(72)) { ?>
                                                                                    <option value="controle.php?id=<?php echo($rsAcao['cod_pas']) ?>&cod_objetivo_url=<?php echo($cod_objetivo_url) ?>">Controle</option>
                                                                                <?php } ?>
                                                                                <?php if (permissao_acesso(69)) { ?>
                                                                                    <option value="alterar.php?id=<?php echo($rsAcao['cod_pas']) ?>">Editar</option>         
                                                                                <?php } ?>  
                                                                                <?php if (permissao_acesso(73)) { ?>
                                                                                    <option value="historico_analise.php?id=<?php echo($rsAcao['cod_pas']) ?>">Histórico</option>                                                                       
                                                                                <?php } ?>  
                                                                            </select><br />      
                                                                            <?php if (permissao_acesso(74)) { ?>
                                                                                <a class="btn btn-warning btn-xs" onclick="SalvarCompleto('<?php echo($id) ?>', 2);" <?php echo($css_periodo) ?>>Salvar</a>   
                                                                            <?php } ?>                          
                                                                            <?php if (permissao_acesso(75)) { ?>
                                                                                <a class="btn btn-warning btn-xs" onclick="return LimparCampos('<?php echo($id) ?>', '<?php echo($cod_objetivo_url) ?>');" <?php echo($css_periodo) ?>>Limpar</a>
                                                                            <?php } ?>                   
                                                                            <?php if (permissao_acesso(70)) { ?>
                                                                                <a class="btn btn-danger btn-xs" onclick="return Excluir(<?php echo($rsAcao['cod_pas']) ?>);" <?php echo($css_periodo) ?>>Excluir</a>
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
        } ?>
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
    function go_(obj, id) {        
        if (obj.value != '') {
            var txt_pagina = 'controle.php?cod_controle=' + obj.value + '&id=' + id + '&cod_objetivo_url=' + $('#cod_objetivo_url').val();
            obj.selectedIndex = 0;
            obj.disabled = true;

            self.location.href = txt_pagina;

            obj.disabled = false;
        }       
    }        
</script>

<script type="text/javascript">
    function SubmitForm() {    
        self.location.href = 'default.php?txt_filtro=' + $('#txt_filtro').val() + '&cod_objetivo_url=' + $('#cod_objetivo_url').val() + '&txt_filtro_responsavel=' + $('#txt_filtro_responsavel').val();
    }

    function LimparForm() {    
        self.location.href = 'default.php?cod_objetivo_url=' + $('#cod_objetivo_url').val();
    }
</script>
<?php
rodape($dbcon);
?>