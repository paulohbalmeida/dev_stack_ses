<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(77);

$cod_objetivo = $_REQUEST['cod_objetivo'];
$cod_objetivo_ppa = $_REQUEST['cod_objetivo_ppa'];
$cod_programa_trabalho = $_REQUEST['cod_programa_trabalho'];
$nr_etapa_trabalho = $_REQUEST['nr_etapa_trabalho'];
$txt_etapa_trabalho  =$_REQUEST['txt_etapa_trabalho'];
$cod_produto_etapa = $_REQUEST['cod_produto_etapa'];
$nr_meta = $_REQUEST['nr_meta'];
$cod_inicio_previsto = $_REQUEST['cod_inicio_previsto'];
$cod_fim_previsto = $_REQUEST['cod_fim_previsto'];
$cod_orgao = $_REQUEST['cod_orgao'];
$cod_parceiro = $_REQUEST['cod_parceiro'];
$cod_modulo = 2;
$cod_unidade_medida = $_REQUEST['cod_unidade_medida'];
$cod_continuar = $_REQUEST['cod_continuar'];
$cod_obra = $_REQUEST['cod_obra'];
$nr_meta_parcial  = $_REQUEST['nr_meta_parcial'];
$cod_acumulativo = $_REQUEST['cod_acumulativo'];

if(empty($verificado)) {    
    $cod_continuar = 1;
    $cod_obra = 0;
    $cod_acumulativo = 0;
}

?>

<div id="main" class="container-fluid">
    <h3 class="page-header">SAG > Incluir</h3>
    <form id="frm1"> 
        <input type="hidden" name="acao" id="acao" value="incluir" /> 
        <input type="hidden" name="verificado" id="verificado" value="1" />  
        <input type="hidden" name="cod_objetivo_url" id="cod_objetivo_url" value="<?php echo($_REQUEST['cod_objetivo_url']) ?>" />
        <input type="hidden" name="cod_objetivo_ppa_url" id="cod_objetivo_ppa_url" value="<?php echo($_REQUEST['cod_objetivo_ppa_url']) ?>" />     
        <?php
        include_once (__DIR__ . "/../include/combo_objetivo.php"); 
        ?>    
        <div id="div_programa_trabalho"></div>
        <div id="div_programa_trabalho_2"></div>        	
        <div class="row">
            <div class="col-md-4">
                <label for="exampleInputEmail1">Etapa SAG:</label> 
                <input type="text" class="form-control" id="nr_etapa_trabalho" name="nr_etapa_trabalho" placeholder="Obrigatório" onkeyup="somenteNumeros(this);">
                <br />
                <label for="exampleInputEmail1">Obra:</label> 
                <select id="cod_obra" name="cod_obra" class="form-control">
                    <option value="1" <?php
                                        if ($cod_obra == 1) {
                                            echo("selected");
                                        }
                                        ?>>SIM</option>			
                    <option value="0"<?php
                                        if ($cod_obra == 0) {
                                            echo("selected");
                                        }
                                        ?>>NÃO</option>
                </select>
            </div>              
            <div class="col-md-8">
                <label for="exampleInputEmail1">Descrição da Etapa:</label> 
                <textarea class="form-control" rows="5" id="txt_etapa_trabalho" name="txt_etapa_trabalho"><?=$txt_etapa_trabalho?></textarea>  
            </div>
        </div>
        <br />              
        <div class="row">
            <div class="col-md-4">
                <label for="exampleInputEmail1">Produto da Etapa:</label> 
                <select id="cod_produto_etapa" name="cod_produto_etapa" class="form-control">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_produto_etapa, txt_produto_etapa FROM tb_produto_etapa WHERE cod_ativo = 1 ORDER BY txt_produto_etapa");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_produto_etapa"]?>"<?php if ($cod_produto_etapa == $row["cod_produto_etapa"]) { echo("selected");}?>><?=$row["txt_produto_etapa"] ?></option>
                        <?php	
                        } ?>									
                </select>
            </div>
            <div class="col-md-2">
                <label for="exampleInputEmail1">Quantidade por Etapa:</label> 
                <input type="text" class="form-control" id="nr_meta" name="nr_meta" placeholder="Obrigatório" onkeyup="somenteNumeros(this);">                        
            </div>            
            <div class="col-md-4">
                <label for="exampleInputEmail1">Unidade de Medida:</label> 
                <select id="cod_unidade_medida" name="cod_unidade_medida" class="form-control">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_unidade_medida, txt_unidade_medida FROM tb_unidade_medida WHERE cod_ativo = 1 ORDER BY txt_unidade_medida");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_unidade_medida"]?>"<?php if ($cod_unidade_medida == $row["cod_unidade_medida"]) { echo("selected");}?>><?=$row["txt_unidade_medida"] ?></option>
                        <?php	
                        } ?>									
                </select>
            </div>
        </div>   
       
        <br />  

        <div class="row">
            <div class="col-md-6">
                <label for="exampleInputEmail1">Início Previsto:</label> 
                <select id="cod_inicio_previsto" name="cod_inicio_previsto" class="form-control">
                    <option></option>
                    <?php                        
                    $q = pg_query("SELECT cod_mes, txt_mes FROM tb_mes ORDER BY cod_mes");
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_mes"]?>"<?php if ($cod_inicio_previsto == $row["cod_mes"]) { echo("selected");}?>><?=$row["txt_mes"] ?></option>
                    <?php	
                    } ?>	
                </select>
            </div>
            <div class="col-md-6">
                <label for="exampleInputEmail1">Fim Previsto:</label>   
                <select id="cod_fim_previsto" name="cod_fim_previsto" class="form-control">
                    <option></option>
                    <?php                        
                    $q = pg_query("SELECT cod_mes, txt_mes FROM tb_mes ORDER BY cod_mes");
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_mes"]?>"<?php if ($cod_fim_previsto == $row["cod_mes"]) { echo("selected");}?>><?=$row["txt_mes"] ?></option>
                    <?php	
                    } ?>	
                </select>             
            </div>
        </div> 
        <br /> 
        <div class="row">
            <div class="col-md-6">
                <label for="exampleInputEmail1">Responsável:</label> 
                <select id="cod_orgao" name="cod_orgao" class="chosen-select" data-placeholder="Obrigatório">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_orgao, txt_sigla FROM tb_orgao WHERE cod_ativo = 1 ORDER BY txt_sigla");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_orgao"]?>"<?php if ($cod_orgao == $row["cod_orgao"]) { echo("selected");}?>><?=$row["txt_sigla"] ?></option>
                        <?php	
                        } ?>									
                </select>
            </div>
            <div class="col-md-6">
                <label for="exampleInputEmail1">Parceiro:</label> 
                <select id="cod_parceiro" name="cod_parceiro" class="form-control">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_orgao, txt_sigla FROM tb_orgao WHERE cod_ativo = 1 ORDER BY txt_sigla");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_orgao"]?>"<?php if ($cod_parceiro == $row["cod_orgao"]) { echo("selected");}?>><?=$row["txt_sigla"] ?></option>
                        <?php	
                        } ?>									
                </select>
            </div>
        </div>    
        <br />
        <div class="row">
            <div class="col-md-6">
                <label for="exampleInputEmail1">Acumulativo:</label> 
                <select id="cod_acumulativo" name="cod_acumulativo" class="form-control" onchange="MontaMetaParcial();">
                    <option value="1" <?php
                                        if ($cod_acumulativo == 1) {
                                            echo("selected");
                                        }
                                        ?>>SIM</option>			
                    <option value="0"<?php
                                        if ($cod_acumulativo == 0) {
                                            echo("selected");
                                        }
                                        ?>>NÃO</option>
                </select>
            </div>
            <div class="col-md-6">
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
        <div id='div_meta_parcial'></div>                     
        <br />
        <div class="row">
            <div class="col-md-12">
                <button type="submit" id="btn_incluir" class="btn btn-primary" onclick="return ValidarIncluir();">Incluir</button>
                <a href="default.php" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>
</div>
<script src="manter.js" type="text/javascript"></script>
<script type="text/javascript">
   

    //MARCAR O OBJETIVO QUANDO A OPÇÃO CONTINUAR CADASTRANDO FOR IGUAL A 1
    if ($('#cod_objetivo_url').val() != '') {
        $('#cod_objetivo').val($('#cod_objetivo_url').val());
    }
    
</script>
<?php
rodape($dbcon);
?>
      