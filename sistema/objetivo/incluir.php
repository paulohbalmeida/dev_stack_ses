<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();

$id = $_REQUEST['id'];
$verificado = $_REQUEST['verificado'];

if (empty($verificado) && !empty($id)) {
    permissao_acesso_pagina(11);

    $q1 = pg_query("SELECT * FROM tb_objetivo WHERE cod_objetivo = " .$id);
    $rs1 = pg_fetch_array($q1);
    $cod_ativo = limpar_comparacao($rs1['cod_ativo']);
    $cod_eixo = limpar_comparacao($rs1['cod_eixo']);
    $cod_perspectiva = limpar_comparacao($rs1['cod_perspectiva']); 	
    $cod_diretriz =  limpar_comparacao($rs1['cod_diretriz']); 
    $txt_objetivo =  limpar_comparacao($rs1['txt_objetivo']);
    $txt_descricao =  limpar_comparacao($rs1['txt_descricao']);
    $codigo_objetivo =  limpar_comparacao($rs1['codigo_objetivo']);      
}
else {
    permissao_acesso_pagina(10);

    $cod_ativo = $_REQUEST['cod_ativo'];
    $cod_eixo = $_REQUEST['cod_eixo'];
    $cod_perspectiva = $_REQUEST['cod_perspectiva'];
    $cod_diretiz = $_REQUEST['cod_diretiz'];
    $txt_objetivo = $_REQUEST['txt_objetivo'];
    $txt_descricao = $_REQUEST['txt_descricao'];
    $codigo_objetivo = $_REQUEST['codigo_objetivo'];   
    
    if(empty($verificado)) {
        $cod_ativo = 1;
    }
}

?>
<div id="main" class="container-fluid">
    <h3 class="page-header">Objetivo > Incluir</h3>
    <form id="frm1">  
        <input type="hidden" name="verificado" id="verificado" value="1" />
        <?php if(empty($id)) {
	    ?>
		    <input type="hidden" name="acao" id="acao" value="incluir" />
        <?php
        }
        else { ?>
            <input type="hidden" name="acao" id="acao" value="alterar" />         
            <input type="hidden" name="id" id="id" value="<?=$id?>" /> <?php        
        }
        ?>
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
                <select id="cod_perspectiva" name="cod_perspectiva" class="form-control" onchange="frm1.submit();">
                    <option></option>
                    <?php
                    $condicao_perspectiva = " AND cod_eixo = " .$cod_eixo;
                    $q = pg_query("SELECT cod_perspectiva, txt_perspectiva FROM tb_perspectiva WHERE cod_ativo = 1 ".$condicao_perspectiva." ORDER BY txt_perspectiva");
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
                <label for="exampleInputEmail1">Diretriz:</label>                
                <select id="cod_diretriz" name="cod_diretriz" class="form-control">
                    <option></option>
                    <?php
                        $condicao_diretriz = " AND cod_perspectiva = " .$cod_perspectiva; 
                        $q = pg_query("SELECT cod_diretriz, txt_diretriz FROM tb_diretriz WHERE cod_ativo = 1 ".$condicao_diretriz." ORDER BY txt_diretriz");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_diretriz"]?>"<?php if ($cod_diretriz == $row["cod_diretriz"]) { echo("selected");}?>><?=$row["txt_diretriz"] ?></option>
                        <?php	
                        } ?>									
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Código Objetivo:</label>
                <input type="text" class="form-control" id="codigo_objetivo" name="codigo_objetivo" value="<?=$rs1['codigo_objetivo']?>" placeholder="Obrigatório">
            </div>	  
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Objetivo:</label>
                <input type="text" class="form-control" id="txt_objetivo" name="txt_objetivo" value="<?=$rs1['txt_objetivo']?>" placeholder="Obrigatório">
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
        <div class="row">
            <div class="col-md-12">
            <?php if(empty($id)) {
                ?>
                    <button type="submit" id="btn_incluir" class="btn btn-primary" onclick="return ValidarIncluir();">Incluir</button>
                <?php
                } 
                else {
                ?>
                    <button type="submit" id="btn_salvar" class="btn btn-primary" onclick="return ValidarIncluir();">Salvar</button>
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