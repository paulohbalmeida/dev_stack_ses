<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsIndicador.php");
include_once (__DIR__ . "/../classes/clsStatus.php");
include_once (__DIR__ . "/../classes/clsOrgao.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(60);

$cod_eixo = $_REQUEST['cod_eixo'];
$cod_perspectiva = $_REQUEST['cod_perspectiva'];
$cod_diretriz = $_REQUEST['cod_diretriz'];
$cod_objetivo = $_REQUEST['cod_objetivo'];

$clsIndicador = new clsIndicador();
$clsStatus = new clsStatus();
$clsOrgao = new clsOrgao();

if (empty($_REQUEST['log'])) {
	Auditoria(73, "Detalhar Indicador", "");
}
?>
<div id="main" class="container-fluid" style="margin-top: 50px">
    <form id="frm1">
		<input type="hidden" name="log" id="log" value="1" />
        <div id="top" class="row">
			<div class="col-sm-3">
				<h2>Indicador</h2>
			</div>		
			<div class="col-sm-6">				
                <div class="input-group h2">
                                       
				</div>
			</div>
			<div class="col-sm-3">
				<?php if (permissao_acesso(61)) { ?>
                	<a href="incluir.php" class="btn btn-primary h2">Incluir</a> 
				<?php } ?> 
			</div>	
		</div> <!-- /#top -->
		<br />
		<div class="row">
			<?php
			$sql = "SELECT txt_eixo, txt_perspectiva, txt_diretriz, txt_objetivo, txt_objetivo_ppa, tb_indicador.cod_objetivo_ppa, ";
			$sql .= " codigo_eixo, codigo_perspectiva, codigo_diretriz, codigo_objetivo, codigo_objetivo_ppa";
			$sql .= " FROM tb_indicador ";
			$sql .= " INNER JOIN tb_objetivo_ppa ON tb_objetivo_ppa.cod_objetivo_ppa = tb_indicador.cod_objetivo_ppa  ";
			$sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_indicador.cod_objetivo ";
			$sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo ";
			$sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva ";
			$sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz ";
			$sql .= " WHERE tb_objetivo.cod_eixo = ".$cod_eixo;
			$sql .= " AND tb_objetivo.cod_perspectiva = ".$cod_perspectiva;
			$sql .= " AND tb_objetivo.cod_diretriz = ".$cod_diretriz;
			$sql .= " AND tb_indicador.cod_objetivo = ".$cod_objetivo;
			$sql .= " GROUP BY codigo_eixo, txt_eixo, codigo_diretriz, txt_diretriz, codigo_perspectiva, ";
			$sql .= " txt_perspectiva, codigo_objetivo, txt_objetivo, codigo_objetivo_ppa, txt_objetivo_ppa, ";
			$sql .= " tb_indicador.cod_objetivo_ppa ";
			//echo($sql);
			$q = pg_query($sql);
			if (pg_num_rows($q) > 0) {
				while($rs = pg_fetch_array($q)) { ?>
					<div class="col-md-12">
						<h3><?php echo($rs['codigo_eixo']) ?> - <?php echo($rs['txt_eixo']) ?></h3>
						&nbsp;&nbsp;<strong><?php echo($rs['codigo_perspectiva']) ?> - <?php echo($rs['txt_perspectiva']) ?></strong><br />
						&nbsp;&nbsp;<strong><?php echo($rs['codigo_diretriz']) ?> - <?php echo($rs['txt_diretriz']) ?></strong><br />
						&nbsp;&nbsp;<strong><?php echo($rs['codigo_objetivo']) ?> - <?php echo($rs['txt_objetivo']) ?></strong><br />
						&nbsp;&nbsp;<strong>Objetivo Específico PPA:</strong> <?php echo($rs['codigo_objetivo_ppa']) ?> - <?php echo($rs['txt_objetivo_ppa']) ?>
					</div><!--col-md-12--> 
					<br />
					<div class="row">
						<div class="col-md-12">
							<?php
							$sql = "SELECT tb_indicador.*";
							$sql .= " FROM tb_indicador ";
							$sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_indicador.cod_objetivo ";														
							$sql .= " WHERE tb_objetivo.cod_eixo = ".$cod_eixo;							
							$sql .= " AND tb_objetivo.cod_perspectiva = ".$cod_perspectiva;
							$sql .= " AND tb_objetivo.cod_diretriz = ".$cod_diretriz;
							$sql .= " AND tb_indicador.cod_objetivo = ".$cod_objetivo;
							$sql .= " AND tb_indicador.cod_objetivo_ppa = ".$rs['cod_objetivo_ppa'];
							$q1 = pg_query($sql);
							if (pg_num_rows($q1) > 0) { ?>
									<br />
									<div class="row">
										<div class="table-responsive col-md-12">
											<table class="table table-striped" cellspacing="0" cellpadding="0">
												<thead>
													<tr>																																																							
														<th>Descrição Meta</th>
														<th>Indicadores</th>														
														<th>Instrumentos Pactuados</th>
														<th>Área Responsável</th>
														<!--<th>Unidade Medida</th>
														<th>Polaridade</th>-->
														<th>Status</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
													<?php
													while($rs1 = pg_fetch_array($q1)) { 
														$retorno_array = $clsIndicador->ConsultaIndicador($rs1['cod_indicador']);														
														$cod_ultimo_status = $clsIndicador->RetornaUltimoStatus($rs1['cod_chave']);														
														$txt_ultimo_status = $clsStatus->RetornaStatus($cod_ultimo_status);			
														$txt_cor = $clsStatus->RetornaCorStatus($cod_ultimo_status);
														if (!empty($rs1['cod_responsavel_tecnico'])) {
															$cod_responsavel_tecnico = $clsOrgao->RetornaSigla($rs1['cod_responsavel_tecnico']);
														} else {
															$cod_responsavel_tecnico = '';
														}
														if (!empty($rs1['cod_responsavel_tecnico_2'])) {
															$cod_responsavel_tecnico_2 = $clsOrgao->RetornaSigla($rs1['cod_responsavel_tecnico_2']);
														} else {
															$cod_responsavel_tecnico_2 = '';
														}
														
														?>
														<tr>																
															<td><?=$rs1['txt_descricao_meta']?></td>
															<td>
																<?php																																
																echo("<span title='".$retorno_array->descricao."'>".$retorno_array->titulo."<span>");
																?>
															</td>															
															<td>
																<div id="div_instrumento_<?php echo($rs1['cod_indicador']) ?>"></div>
																<script type="text/javascript">
																	$.ajax({
																		type: 'POST',
																		url: 'manter.php',
																		data: {
																			acao: 'tabela_indicador',                        
																			id: '<?php echo($rs1['cod_indicador']) ?>'
																		},
																		async: false,
																		success: function (data) {                        
																			var obj = JSON.parse(data);            

																			//INSTRUMENTO DE PLANEJAMENTO
																			var instrumento = '';
																			try {
																				for (i = 0; i < obj.Tags.length; i++) { 
																					instrumento += '<button class="btn btn-primary btn-sm" disabled="disabled">' + obj.Tags[i].descricao + '</button>&nbsp;';
																				}
																							
																			}
																			catch(err) {

																			}
																			
																			if (instrumento == '') {
																				instrumento = '';
																			}
																			
																			$('#div_instrumento_<?php echo($rs1['cod_indicador']) ?>').html(instrumento);
																		},				
																		error: function (xhr, status, error) {
																			
																		}
																	});
																</script>															
															</td>															
															<td>
																<?php echo($cod_responsavel_tecnico) ?>
																<?php echo($cod_responsavel_tecnico_2) ?>
															</td>
															<!--<td><?=$clsIndicador->ConsultaUnidadeMedida($retorno_array->UnidadeMedidaCodigo)?></td>
															<td><?=$clsIndicador->ConsultaPolaridade($retorno_array->PolaridadeCodigo)?></td>-->
															<td>																																
																<input type="text" class="form-control_custom" name="txt_ultimo_status" style="background-color:<?php echo($txt_cor) ?>;" value="<?php echo($txt_ultimo_status) ?>" disabled="disabled">
															</td>
															<td class="actions">																										
																<select name="teste" class="form-control_custom" onchange="javascript:go(this)">
																	<option value="">&nbsp;</option>
																	<?php if (permissao_acesso(66) || permissao_acesso(93)) { ?>
																		<option value="analise.php?id=<?php echo($rs1['cod_chave']) ?>">Análise</option>
																	<?php	
                    												} ?>
																	<?php if (permissao_acesso(62)) { ?>
																		<option value="alterar.php?id=<?php echo($rs1['cod_chave']) ?>">Editar</option>		
																	<?php	
                    												} ?>	
																	<?php if (permissao_acesso(65)) { ?>																																
																		<option value="ficha.php?id=<?php echo($rs1['cod_chave']) ?>">Ficha do Indicador</option>	
																	<?php	
                    												} ?>
																	<?php if (permissao_acesso(64)) { ?>
																		<option value="historico_analise.php?id=<?php echo($rs1['cod_chave']) ?>">Histórico</option>	
																	<?php	
                    												} ?>																
																</select><br/>
																<?php if (permissao_acesso(63)) { ?>
																	<a class="btn btn-danger btn-xs" onclick="return ExcluirIndicador(<?php echo($rs1['cod_chave']) ?>);" >Excluir</a><br />
																<?php	
                    											} ?>
															</td>
														</tr>														
													<?php
													} ?>
												</tbody>												
											</table>
										</div><!--table-responsive col-md-12-->
									</div><!--row-->									
								<?php								
							}
							?>
						</div><!--col-md-12-->
					</div><!--row-->
					<br />
				<?php
				}
			}
			?>
		</div><!--row-->
		<br />        
        <div class="row">
            <div class="col-md-12">                
                <a href="default.php" class="btn btn-default">Voltar</a>
            </div><!--col-md-12--> 
        </div><!--row--> 
    </form>
</div><!--main-->
<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>