<?php
include_once (__DIR__ . "/../../include/conexao.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(53);

if (empty($_REQUEST['log'])) {
	Auditoria(35, "Listar Usuários", "");
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
				<h2>Usuários</h2>
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
				<?php if (permissao_acesso(54)) { ?>
					<a href="incluir.php" class="btn btn-primary pull-right h2">Novo Usuário</a>
				<?php } ?>
			</div>
		</div><!-- #top -->	
        <hr />	
        <div id="list" class="row">
            <?php
            if (!empty($txt_pesquisa)) {
				$txt_pesquisa = str_replace("'", "''", $txt_pesquisa);

				$condicao = " WHERE (LOWER(txt_perfil) LIKE '%" .trim(strtolower($txt_pesquisa)). "%' OR LOWER(txt_usuario) LIKE '%" .trim(strtolower($txt_pesquisa)). "%' ";
				$condicao .= " OR txt_cpf LIKE '%" .preg_replace('/\W+/u', '', trim($txt_pesquisa)). "%' OR LOWER(txt_cargo) LIKE '%" .trim(strtolower($txt_pesquisa)). "%' OR LOWER(txt_sigla) LIKE '%" .trim(strtolower($txt_pesquisa)). "%')";
            }			
			$sql = "SELECT tb_usuario.*, txt_perfil, txt_cargo, txt_sigla FROM tb_usuario "; 
			$sql .= " INNER JOIN tb_perfil ON tb_perfil.cod_perfil = tb_usuario.cod_perfil ";
			$sql .= " LEFT JOIN tb_orgao ON tb_orgao.cod_orgao = tb_usuario.cod_orgao ";
			$sql .= " LEFT JOIN tb_cargo ON tb_cargo.cod_cargo = tb_usuario.cod_cargo " .$condicao. " ORDER BY txt_usuario";
			$q1 = pg_query($sql);
			if (pg_num_rows($q1) > 0) {
			?>
                <div class="table-responsive col-md-12">
					<table id="dtBasicExample" class="table table-striped" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<th>Login</th>
								<th>CPF</th>
                                <th>Usuário</th>								
                                <th>E-mail</th>
								<th>Matrícula</th>
								<th>Perfil</th>
								<!--<th>Cargo</th>-->
								<th>Lotação</th>
                                <th>Ativo</th>
								<th class="actions">Ações</th>
							</tr>
						</thead>
                        <tbody>
							<?php												
							while ($rs1 = pg_fetch_array($q1)) {
							?>
								<tr>
									<td><?php echo($rs1['txt_login']) ?></td>				
									<td><?php echo(MascaraCPF($rs1['txt_cpf'])) ?></td>
									<td><?php echo($rs1['txt_usuario']) ?></td>				
									<td><?php echo($rs1['txt_email']) ?></td>
									<td><?php echo($rs1['txt_matricula']) ?></td>					
									<td><?php echo($rs1['txt_perfil']) ?></td>					
									<!--<td><?php echo($rs1['txt_cargo']) ?></td>-->
									<td><?php echo($rs1['txt_sigla']) ?></td>					
									<td><?php echo(destacar_ativo($rs1['cod_ativo'])) ?></td>                                    
									<td class="actions">	
										<select name="teste" class="form-control_select" onchange="javascript:go(this)">                                                                            
											<option value="">&nbsp;</option>
											<?php if (permissao_acesso(55)) { ?>
												<option value="incluir.php?id=<?php echo($rs1['cod_usuario']) ?>">Editar</option>											
											<?php } ?>
											<?php if (permissao_acesso(57)) { ?>
												<option value="unidade.php?id=<?php echo($rs1['cod_usuario']) ?>">Unidades</option> 
											<?php } ?> 											
										</select><br />
										<?php if (permissao_acesso(56)) { ?>
											<a class="btn btn-danger btn-xs" onclick="return Excluir(<?php echo($rs1['cod_usuario']) ?>);" >Excluir</a>
										<?php } ?>
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