<?php
include_once (__DIR__ . "/../../include/conexao.php");
verifica_seguranca();
cabecalho();

$id = $_REQUEST['id'];
$verificado = $_REQUEST['verificado'];

if (empty($verificado) && !empty($id)) {
    permissao_acesso_pagina(31);

    $q1 = pg_query("SELECT * FROM tb_cargo WHERE cod_cargo = '$id'");
	$rs1 = pg_fetch_array($q1);
	$cod_ativo = limpar_comparacao($rs1['cod_ativo']);
	$txt_cargo = $rs1['txt_cargo'];
	$txt_descricao = $rs1['txt_descricao'];
}
else {
    permissao_acesso_pagina(30);

    $cod_ativo = $_REQUEST['cod_ativo'];
    $txt_descricao = $_REQUEST['txt_descricao'];   
    $txt_cargo = $_REQUEST['txt_cargo'];   
    
    if(empty($verificado)) {
        $cod_ativo = 1;        
    }
}
?>

<div id="main" class="container-fluid">
    <h3 class="page-header">Cargos > Incluir</h3>
    <form id="frm1">
        <input type="hidden" name="id" id="id" value="<?=$id?>" />
        <input type="hidden" name="verificado" id="verificado" value="1" />
        <input type="hidden" name="acao" id="acao" value="" />
        <input type="hidden" name="status" id="status" value="<?=$_REQUEST['status']?>" />
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Cargo:</label>
                <input type="text" class="form-control" id="txt_cargo" name="txt_cargo" value="<?=$txt_cargo?>" placeholder="Obrigatório">
            </div><!--form-group-->
        </div><!--row-->   
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Descrição:</label>			
                <textarea class="form-control" rows="5" id="txt_descricao" name="txt_descricao"><?=$rs1['txt_descricao']?></textarea>
            </div><!--form-group-->	 
        </div><!--row-->     	
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
            </div><!--form-group-->	 
        </div><!--row-->
        <div class="row">
            <div class="col-md-12">
                <?php if(empty($id)) {
                ?>
                    <button type="submit" id="btn_incluir" class="btn btn-primary" onclick="return ValidarIncluir();">Incluir</button>
                <?php
                } 
                else {
                ?>
                    <button type="submit" id="btn_salvar" class="btn btn-primary" onclick="return ValidarAlterar();">Salvar</button>
                <?php
                }
                ?>  	  	
                <a href="default.php" class="btn btn-default">Voltar</a>
            </div><!--col-md-12-->
        </div><!--row-->
    </form>
</div><!--main-->

<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>