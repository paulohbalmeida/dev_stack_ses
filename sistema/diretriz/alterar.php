<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(86);

$id = $_REQUEST['id'];
$verificado = $_REQUEST['verificado'];

if (empty($verificado)) {
    $q1 = pg_query("SELECT * FROM tb_diretriz WHERE cod_diretriz = " .$id);
    $rs1 = pg_fetch_array($q1);
    $cod_ativo = limpar_comparacao($rs1['cod_ativo']);
    $cod_eixo = limpar_comparacao($rs1['cod_eixo']);
    $cod_perspectiva = limpar_comparacao($rs1['cod_perspectiva']); 	
    $txt_diretriz =  limpar_comparacao($rs1['txt_diretriz']); 
    $txt_descricao =  limpar_comparacao($rs1['txt_descricao']); 
    $codigo_diretriz =  limpar_comparacao($rs1['codigo_diretriz']); 
}
else {
    $cod_ativo = $_REQUEST['cod_ativo'];
    $cod_eixo = $_REQUEST['cod_eixo'];
    $cod_perspectiva = $_REQUEST['cod_perspectiva'];
    $txt_diretriz = $_REQUEST['txt_diretriz'];
    $txt_descricao = $_REQUEST['txt_descricao'];
    $codigo_diretriz = $_REQUEST['codigo_diretriz'];
}
?>

<div id="main" class="container-fluid">
    <h3 class="page-header">Diretriz > Alterar</h3>

    <form id="frm1">
        <input type="hidden" name="id" id="id" value="<?=$id?>" />
        <input type="hidden" name="verificado" id="verificado" value="1" />
        <input type="hidden" name="acao" id="acao" value="alterar" />

        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Eixo:</label>
                <select id="cod_eixo" name="cod_eixo" class="form-control" onchange="frm1.submit();">
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
                <select id="cod_perspectiva" name="cod_perspectiva" class="form-control">
                    <option></option>
                    <?php $q=pg_query("SELECT cod_perspectiva, txt_perspectiva FROM tb_perspectiva WHERE cod_eixo = " .$cod_eixo. " AND cod_ativo = 1");        
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_perspectiva"]?>"<?php if ($cod_perspectiva == $row["cod_perspectiva"]) { echo("selected");}?>><?=$row["txt_perspectiva"] ?></option>
                    <?php	
                    } ?>									
                </select>                
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
                <label for="">Diretriz:</label>
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
                <button type="submit" id="btn_salvar" class="btn btn-primary" onclick="return ValidarSalvar();">Salvar</button>
                <a href="default.php" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>
</div>
<script src="manterSalvar.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>