<?php
include_once (__DIR__ . "/../../include/conexao.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(88);

if (empty($_REQUEST['log'])) {
	Auditoria(27, "Listar Situações", "");
}

$txt_pesquisa = isset($_REQUEST["txt_pesquisa"]) ? $_REQUEST["txt_pesquisa"] : null;
?>
<script>
	jQuery(function($) {
		$('#dtBasicExample').DataTable();
	});
</script>
<div id="main" class="container-fluid" style="margin-top: 50px">
    <form id="frm1">  
		<input type="hidden" name="log" id="log" value="1" />
		<div id="top" class="row">
			<div class="col-sm-3">
				<h2>Situações</h2>
			</div>
			<div class="col-sm-6">
				
				<div class="input-group h2">
					<input name="txt_pesquisa" class="form-control" id="txt_pesquisa" type="text" placeholder="Pesquisar" value="<?=$txt_pesquisa?>">
					<span class="input-group-btn">
						<button class="btn btn-primary" type="button" onclick="frm1.submit();">
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</span>
				</div>
				
			</div>
			<div class="col-sm-3">
				<a href="incluir.php" class="btn btn-primary pull-right h2">Nova Situação</a>
			</div>
		</div><!-- #top -->	
        <hr />	
        <div id="list" class="row">
            <?php
            if (!empty($txt_pesquisa)) {
                $condicao = " WHERE LOWER(txt_status) LIKE '%" .trim(strtolower($txt_pesquisa)). "%'";
            }			
			$q1 = pg_query("SELECT * FROM tb_status " .$condicao. " ORDER BY txt_status");
			if (pg_num_rows($q1) > 0) {
			?>
                <div class="table-responsive col-md-12">
					<table id="dtBasicExample" class="table table-striped" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<th>ID</th>
								<th>Situação</th>								
								<th>Descrição</th>
								<th>Cor</th>
                                <th>Ativo</th>
								<th class="actions">Ações</th>
							</tr>
						</thead>
                        <tbody>
							<?php												
							while ($rs1 = pg_fetch_array($q1)) {
							?>
								<tr>
									<td><?php echo($rs1['cod_status']) ?></td>
									<td><?php echo($rs1['txt_status']) ?></td>				
									<td><?php echo($rs1['txt_descricao']) ?></td>					
									<td><input type="text" id="txt_cor" name="txt_cor" value="<?php echo($rs1['txt_cor']) ?>" style="background-color: <?php echo($rs1['txt_cor']) ?>" disabled/></td>
									<td><?php echo(destacar_ativo($rs1['cod_ativo'])) ?></td>                                    
									<td class="actions">	
										<?php if (permissao_acesso(52)) { ?>																																		
											<a class="btn btn-warning btn-xs" href="incluir.php?id=<?php echo($rs1['cod_status']) ?>">Editar</a>
										<?php } ?>
										<!--<a class="btn btn-danger btn-xs" onclick="return Excluir(<?php echo($rs1['cod_status']) ?>);" >Excluir</a>-->
									</td>
								</tr>		
							<?php
							}
							?>											
						</tbody>
                    </table>
                </div><!-- #table-responsive -->					
            <?php
			}
			else {
			?>
                <hr>
                <center><h4>NÃO EXISTEM REGISTROS CADASTRADOS.</h4></center>
			<?php
			}
			?>	
        </div><!-- #list -->
    </form>
</div><!--main-->
<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>