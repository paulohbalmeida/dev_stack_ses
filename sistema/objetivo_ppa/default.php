<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(13);

if (empty($_REQUEST['log'])) {
	Auditoria(62, "Listar Objetivos PPA", "");
}

$txt_pesquisa = $_REQUEST['txt_pesquisa'];
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
				<h2>Objetivos PPA</h2>
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
				<?php if (permissao_acesso(14)) { ?>
					<a href="incluir.php" class="btn btn-primary pull-right h2">Novo Objetivo PPA</a>
				<?php } ?>
			</div>
		</div> <!-- /#top -->
        <hr />
        <div id="list" class="row">
			<?php
			if($txt_pesquisa != "") {
				$condicao = " WHERE (LOWER(txt_objetivo_ppa) LIKE '%" .trim(strtolower($txt_pesquisa)). "%'";
				$condicao .= " OR LOWER(txt_objetivo) LIKE '%" .trim(strtolower($txt_pesquisa)). "%'";
				$condicao .= " OR LOWER(txt_diretriz) LIKE '%" .trim(strtolower($txt_pesquisa)). "%'";
				$condicao .= " OR LOWER(txt_eixo) LIKE '%" .trim(strtolower($txt_pesquisa)). "%'";
				$condicao .= " OR LOWER(txt_perspectiva) LIKE '%" .trim(strtolower($txt_pesquisa)). "%'";
				$condicao .= " OR LOWER(codigo_objetivo_ppa) LIKE '%" .trim(strtolower($txt_pesquisa)). "%')";
            }
            $sql = "SELECT tb_objetivo_ppa.*, txt_eixo, txt_perspectiva, txt_diretriz, txt_objetivo FROM tb_objetivo_ppa ";
            $sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo_ppa.cod_eixo ";
            $sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo_ppa.cod_perspectiva ";
			$sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo_ppa.cod_diretriz ";
			$sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_objetivo_ppa.cod_objetivo " .$condicao;
			$sql .= " ORDER BY txt_objetivo_ppa";			
			$q1 = pg_query($sql);
			if (pg_num_rows($q1) > 0) {
			?>
				<div class="table-responsive col-md-12">
					<table id="dtBasicExample" class="table table-striped" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<th>Código Objetivo PPA</th>
								<th>Eixo</th>
								<th>Perspectiva</th>
								<th>Diretriz</th>
                                <th>Objetivo</th>
								<th>Objetivo PPA</th>
								<th>Descrição</th>
								<th>Ativo</th>
								<th class="actions">Ações</th>
							</tr>
						</thead>					
						<tbody>
							<?php												
							while ($rs1 = pg_fetch_array($q1)) {
							?>
								<tr>
									<td><?php echo($rs1['codigo_objetivo_ppa']) ?></td>
									<td><?php echo($rs1['txt_eixo']) ?></td>
									<td><?php echo($rs1['txt_perspectiva']) ?></td>
									<td><?php echo($rs1['txt_diretriz']) ?></td>
                                    <td><?php echo($rs1['txt_objetivo']) ?></td>
									<td><?php echo($rs1['txt_objetivo_ppa']) ?></td>
									<td><?php echo($rs1['txt_descricao']) ?></td>
									<td><?php echo(destacar_ativo($rs1['cod_ativo'])) ?></td>
									<td class="actions">	
										<?php if (permissao_acesso(15)) { ?>								
											<a class="btn btn-warning btn-xs" href="incluir.php?id=<?php echo($rs1['cod_objetivo_ppa']) ?>">Editar</a>
										<?php } ?>
										<?php if (permissao_acesso(16)) { ?>	
											<a class="btn btn-danger btn-xs" onclick="return Excluir(<?php echo($rs1['cod_objetivo_ppa']) ?>);" >Excluir</a>
										<?php } ?>
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
			else {
			?>
				<hr>
				<center><h4>NÃO EXISTEM REGISTROS CADASTRADOS.</h4></center>
			<?php
			}
			?>			
		</div><!-- /#list -->	
    </form>
</div>
<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>