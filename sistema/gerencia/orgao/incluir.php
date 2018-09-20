<?php
include_once (__DIR__ . "/../../include/conexao.php");
verifica_seguranca();
cabecalho();

$id = $_REQUEST['id'];
$verificado = $_REQUEST['verificado'];

if (empty($verificado) && !empty($id)) {
    permissao_acesso_pagina(27);

    $q1 = pg_query("SELECT * FROM tb_orgao WHERE cod_orgao = '$id'");
	$rs1 = pg_fetch_array($q1);
	$cod_ativo = limpar_comparacao($rs1['cod_ativo']);
	$txt_sigla = $rs1['txt_sigla'];
    $cod_exibir_consulta = $rs1['cod_exibir_consulta'];
    $txt_descricao = $rs1['txt_descricao'];
    $cod_orgao_superior = $rs1['cod_orgao_superior'];
}
else {
    permissao_acesso_pagina(26);

    $cod_ativo = $_REQUEST['cod_ativo'];
    $cod_exibir_consulta = $_REQUEST['cod_exibir_consulta'];   
    $txt_sigla = $_REQUEST['txt_sigla'];
    $txt_descricao = $_REQUEST['txt_descricao'];  
    $cod_orgao_superior =  $_REQUEST['cod_orgao_superior'];  
    
    if(empty($verificado)) {
        $cod_ativo = 1;        
    }
}
?>

<div id="main" class="container-fluid">
    <h3 class="page-header">Área Responsável > Incluir</h3>
    <form id="frm1">
        <input type="hidden" name="id" id="id" value="<?=$id?>" />
        <input type="hidden" name="verificado" id="verificado" value="1" />
        <input type="hidden" name="acao" id="acao" value="" />
        <input type="hidden" name="status" id="status" value="<?=$_REQUEST['status']?>" />
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Sigla:</label>
                <input type="text" class="form-control" id="txt_sigla" name="txt_sigla" value="<?=$txt_sigla?>" placeholder="Obrigatório">
            </div><!--form-group-->
        </div><!--row-->   
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Descrição:</label>			
                <textarea class="form-control" rows="5" id="txt_descricao" name="txt_descricao"><?=$txt_descricao?></textarea>
            </div><!--form-group-->	 
        </div><!--row--> 
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Área Superior:</label>			
                <select id="cod_orgao_superior" name="cod_orgao_superior" class="chosen-select" data-placeholder="Área Superior">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_orgao, txt_sigla FROM tb_orgao WHERE cod_ativo = 1 ORDER BY txt_sigla");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_orgao"]?>"<?php if ($cod_orgao_superior == $row["cod_orgao"]) { echo("selected");}?>><?=$row["txt_sigla"] ?></option>
                        <?php	
                        } ?>		                   
                </select>
            </div><!--form-group-->	 
        </div><!--row-->   
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Exibir na Consulta:</label>			
                <select id="cod_exibir_consulta" name="cod_exibir_consulta" class="form-control">
                    <option value="1" <?php
                                        if ($cod_exibir_consulta == 1) {
                                            echo("selected");
                                        }
                                        ?>>SIM</option>			
                    <option value="0"<?php
                                        if ($cod_exibir_consulta == 0) {
                                            echo("selected");
                                        }
                                        ?>>NÃO</option>
                </select>
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