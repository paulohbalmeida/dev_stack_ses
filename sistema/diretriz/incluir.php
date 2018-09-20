<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(85);

$id = $_REQUEST['id'];
if(empty($cod_ativo)) {
	$cod_ativo = 1;
}
?>

 <div id="main" class="container-fluid">
 	<?php if(empty($id)) {
	?>
		<h3 class="page-header">Diretriz > Incluir</h3>
	<?php
	} 
	else {
	?>
		<h3 class="page-header">Diretriz > Alterar</h3>
	<?php
	}
	?>    
  <form id="frm1">    	
	<?php if(empty($id)) {
	?>
		<input type="hidden" name="acao" id="acao" value="incluir" />
	<?php
	} 
	else {
	?>
		<input type="hidden" name="acao" id="acao" value="alterar" />
		<input type="hidden" name="id" id="id" value="<?=$id?>" />
	<?php
		$q1 = pg_query("SELECT * FROM tb_diretriz WHERE cod_diretriz = '$id'");
		$rs1 = pg_fetch_array($q1);
		$cod_ativo = limpar_comparacao($rs1['cod_ativo']);
		$cod_eixo = limpar_comparacao($rs1['cod_eixo']);
		$cod_perspectiva = limpar_comparacao($rs1['cod_perspectiva']); 	
		$cod_diretriz = limpar_comparacao($rs1['cod_diretriz']); 	
	}
	?>
	<div class="row">
		<div class="form-group col-md-12">
			<label for="exampleInputEmail1">Eixo:</label>
			<select id="cod_eixo" name="cod_eixo" class="form-control">
				<option></option>
				<?php $q = pg_query("SELECT cod_eixo, txt_eixo FROM tb_eixo WHERE cod_ativo = 1 ORDER BY txt_eixo");
                    while ($row = pg_fetch_array($q)) 
					{ ?>
						<option value="<?=$row["cod_eixo"]?>"<?php if ($cod_eixo == $row["cod_eixo"]) { echo("selected");}?>><?=$row["txt_eixo"] ?></option>
					<?php	
					} ?>									
			</select>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-md-12">
			<label for="exampleInputEmail1">Perspectiva:</label>
			<div id="div_perspectiva">
				<?php				
				$q=pg_query("SELECT cod_perspectiva, txt_perspectiva FROM tb_perspectiva WHERE cod_ativo = 1");      
				?>  
            	<select id="cod_perspectiva" name="cod_perspectiva" class="form-control">
					<option></option> 
					<?php 
					if (pg_num_rows($q) > 0) 
					{                
						while ($row = pg_fetch_array($q)) 
						{ ?>
							<option value="<?=$row['cod_perspectiva']?>"><?=$row['txt_perspectiva']?></option>
						<?php
						}
					} ?>
				</select>				
			</div>			
		</div>
	</div>

	<div class="row">
  	  <div class="form-group col-md-12">
  	  	<label for="exampleInputEmail1">Código Diretriz:</label>
  	  	<input type="text" class="form-control" id="codigo_diretriz" name="codigo_diretriz" value="<?=$rs1['codigo_diretriz']?>" placeholder="Obrigatório">
  	  </div>	  
	</div>

  	<div class="row">
  	  <div class="form-group col-md-12">
  	  	<label for="exampleInputEmail1">Diretriz:</label>
  	  	<input type="text" class="form-control" id="txt_diretriz" name="txt_diretriz" value="<?=$rs1['txt_diretriz']?>" placeholder="Obrigatório">
  	  </div>	  
	</div>
	
	<div class="row">
  	  <div class="form-group col-md-12">
  	  	<label for="exampleInputEmail1">Descrição:</label>        
        <textarea class="form-control" rows="5" id="txt_descricao" name="txt_descricao"><?=$rs1['txt_descricao']?></textarea>
  	  </div>	  
	</div>
	
	<div class="row">
  	  <div class="form-group col-md-12">
		<label for="exampleInputEmail1">Ativo:</label>			
		<select id="cod_ativo" name="cod_ativo" class="form-control">
			<option value="1" <?php
                                if ($cod_ativo == 1) {
                                    echo("selected");
                                }
                                ?>>SIM</option>			
			<option value="0"<?php
                                if ($cod_ativo == 0) {
                                    echo("selected");
                                }
                                ?>>NÃO</option>
		</select>
  	  </div>	 
	</div>	
	
	<hr />
	
	<div class="row">
	  <div class="col-md-12">
	  <?php if(empty($id)) {
		?>
			<button type="submit" id="btn_incluir" class="btn btn-primary">Incluir</button>
		<?php
		} 
		else {
		?>
			<button type="submit" id="btn_salvar" class="btn btn-primary">Salvar</button>
		<?php
		}
		?>  	  	
		<a href="default.php" class="btn btn-default">Voltar</a>
	  </div>
	</div>

  </form>
 </div> 
 <script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>
      
