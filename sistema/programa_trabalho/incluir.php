<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();

$id = $_REQUEST['id'];
$verificado = $_REQUEST['verificado'];

if (empty($verificado) && !empty($id)) {
    permissao_acesso_pagina(19);

    $q1 = pg_query("SELECT * FROM tb_programa_trabalho WHERE cod_programa_trabalho = " .$id);
    $rs1 = pg_fetch_array($q1);
    $cod_emenda = limpar_comparacao($rs1['cod_emenda']);
    $cod_ativo = limpar_comparacao($rs1['cod_ativo']);
    $cod_eixo = limpar_comparacao($rs1['cod_eixo']);
    $cod_perspectiva = limpar_comparacao($rs1['cod_perspectiva']); 	
    $cod_diretriz =  limpar_comparacao($rs1['cod_diretriz']); 
    $cod_objetivo =  limpar_comparacao($rs1['cod_objetivo']);
    $cod_objetivo_ppa =  limpar_comparacao($rs1['cod_objetivo_ppa']);
    $nr_programa_trabalho =  limpar_comparacao($rs1['nr_programa_trabalho']);
    $txt_programa_trabalho =  limpar_comparacao($rs1['txt_programa_trabalho']);      
    $txt_titulo_programa = limpar_comparacao($rs1['txt_titulo_programa']);      
}
else {
    permissao_acesso_pagina(18);

    $cod_emenda = $_REQUEST['cod_emenda'];
    $cod_ativo = $_REQUEST['cod_ativo'];
    $cod_eixo = $_REQUEST['cod_eixo'];
    $cod_perspectiva = $_REQUEST['cod_perspectiva'];
    $cod_diretriz = $_REQUEST['cod_diretriz'];
    $cod_objetivo = $_REQUEST['cod_objetivo'];
    $cod_objetivo_ppa = $_REQUEST['cod_objetivo_ppa'];
    $nr_programa_trabalho = $_REQUEST['nr_programa_trabalho'];
    $txt_programa_trabalho = $_REQUEST['txt_programa_trabalho'];
    $txt_titulo_programa = $_REQUEST['txt_titulo_programa'];  
    $cod_continuar = $_REQUEST['cod_continuar'];
    
    if(empty($verificado)) {
        $cod_ativo = 1;
        $cod_emenda = 0;
        $cod_continuar = 1;
    }
}

?>
<div id="main" class="container-fluid">
    <h3 class="page-header">Programa de Trabalho > Incluir</h3>
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
                    if($cod_eixo != "") {
                        $condicao_perspectiva = " AND cod_eixo = " .$cod_eixo;
                    }
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
                <select id="cod_diretriz" name="cod_diretriz" class="form-control" onchange="frm1.submit();">
                    <option></option>
                    <?php
                        if($cod_perspectiva != "") {
                            $condicao_diretriz = " AND cod_perspectiva = " .$cod_perspectiva;
                        } 
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
                <label for="exampleInputEmail1">Objetivo:</label>                
                <select id="cod_objetivo" name="cod_objetivo" class="form-control" onchange="frm1.submit();">
                    <option></option>
                    <?php
                        if($cod_diretriz != "") {
                            $condicao_objetivo = " AND cod_diretriz = " .$cod_diretriz;
                        } 
                        $q = pg_query("SELECT cod_objetivo, txt_objetivo FROM tb_objetivo WHERE cod_ativo = 1 ".$condicao_objetivo." ORDER BY txt_objetivo");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_objetivo"]?>"<?php if ($cod_objetivo == $row["cod_objetivo"]) { echo("selected");}?>><?=$row["txt_objetivo"] ?></option>
                        <?php	
                        } ?>									
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Objetivo PPA:</label>                
                <select id="cod_objetivo_ppa" name="cod_objetivo_ppa" class="form-control">
                    <option></option>
                    <?php
                        if($cod_objetivo != "") {
                            $condicao_objetivo_ppa = " AND cod_objetivo = " .$cod_objetivo;
                        } 
                        $q = pg_query("SELECT cod_objetivo_ppa, txt_objetivo_ppa FROM tb_objetivo_ppa WHERE cod_ativo = 1 ".$condicao_objetivo_ppa." ORDER BY txt_objetivo_ppa");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_objetivo_ppa"]?>"<?php if ($cod_objetivo_ppa == $row["cod_objetivo_ppa"]) { echo("selected");}?>><?=$row["txt_objetivo_ppa"] ?></option>
                        <?php	
                        } ?>									
                </select>
            </div>
        </div>


        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Número do Programa:</label>
                <input type="text" class="form-control nr" id="nr_programa_trabalho" name="nr_programa_trabalho" value="<?=$rs1['nr_programa_trabalho']?>" placeholder="Obrigatório" onkeypress="return isNumberKey(event)" autocomplete="off" />
            </div>	  
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Título do Programa:</label>
                <input type="text" class="form-control" id="txt_titulo_programa" name="txt_titulo_programa" value="<?=$rs1['txt_titulo_programa']?>" placeholder="Obrigatório">
            </div>	  
        </div>	
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Descrição:</label>        
                <textarea class="form-control" rows="5" id="txt_programa_trabalho" name="txt_programa_trabalho"><?=$rs1['txt_programa_trabalho']?></textarea>
            </div>	  
        </div>	
        <div class="row">
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Emenda Parlamentar:</label>			
                <select id="cod_emenda" name="cod_emenda" class="form-control">
                    <option value="1" <?php
                                        if ($cod_emenda == 1) {
                                            echo("selected");
                                        }
                                        ?>>SIM</option>			
                    <option value="0"<?php
                                        if ($cod_emenda == 0) {
                                            echo("selected");
                                        }
                                        ?>>NÃO</option>
                </select>
            </div>
            <div class="form-group col-md-6">
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
        <?php 
        if (empty($id)) { ?>
            <div class="row">            
                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Continuar Cadastrando:</label>			
                    <select id="cod_continuar" name="cod_continuar" class="form-control">
                        <option value="1" <?php
                                            if ($cod_continuar == 1) {
                                                echo("selected");
                                            }
                                            ?>>SIM</option>			
                        <option value="0"<?php
                                            if ($cod_continuar == 0) {
                                                echo("selected");
                                            }
                                            ?>>NÃO</option>
                    </select>
                </div>	  
            </div>    
        <?php
        }
        ?>           
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
<script type="text/javascript">
    $(document).ready(function($){        
        $('.nr').mask('99.999.9999.9999.9999');    
    });
</script>
<?php
rodape($dbcon);
?>