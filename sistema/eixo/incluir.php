<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();

$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;
if(empty($cod_ativo)) {
	$cod_ativo = 1;
}
if(!empty($id)) {
	permissao_acesso_pagina(3);

	$q1 = pg_query("SELECT * FROM tb_eixo WHERE cod_eixo = '$id'");
	$rs1 = pg_fetch_array($q1);
	$cod_ativo = limpar_comparacao($rs1['cod_ativo']);
	$txt_eixo = $rs1['txt_eixo'];
	$txt_descricao = $rs1['txt_descricao'];
	$codigo_eixo = $rs1['codigo_eixo'];
}	
else 
{
	permissao_acesso_pagina(2);

	$txt_eixo = "";
	$txt_descricao = "";
}
?>

 <div id="main" class="container-fluid">
 	<?php if(empty($id)) {
	?>
		<h3 class="page-header">Eixo > Incluir</h3>
	<?php
	} 
	else {
	?>
		<h3 class="page-header">Eixo > Alterar</h3>
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
	}
	?> 
	<div class="row">
  	  <div class="form-group col-md-12">
  	  	<label for="exampleInputEmail1">Código Eixo:</label>
  	  	<input type="text" class="form-control" id="codigo_eixo" name="codigo_eixo" value="<?=$codigo_eixo?>" placeholder="Obrigatório">
  	  </div>	  
	</div>
	
  	<div class="row">
  	  <div class="form-group col-md-12">
  	  	<label for="exampleInputEmail1">Eixo:</label>
  	  	<input type="text" class="form-control" id="txt_eixo" name="txt_eixo" value="<?=$txt_eixo?>" placeholder="Obrigatório">
  	  </div>	  
	</div>
	
	<div class="row">
  	  <div class="form-group col-md-12">
  	  	<label for="exampleInputEmail1">Descrição:</label>        
        <textarea class="form-control" rows="5" id="txt_descricao" name="txt_descricao"><?=$txt_descricao?></textarea>
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
      
