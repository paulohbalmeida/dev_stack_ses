<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsIndicador.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(62);

$id = $_REQUEST['id'];

$q1 = pg_query("SELECT * FROM tb_indicador WHERE cod_chave = ".$id);
$rs1 = pg_fetch_array($q1);
$cod_objetivo = $rs1['cod_objetivo'];
$cod_objetivo_ppa = $rs1['cod_objetivo_ppa'];
$txt_descricao = $rs1['txt_descricao_meta'];
$cod_indicador = $rs1['cod_indicador'];
$cod_orgao = $rs1['cod_orgao'];
$cod_meta = $rs1['cod_meta'];
$cod_dados_mgi = $rs1['cod_dados_mgi'];
$txt_monitoramento = $rs1['$txt_monitoramento'];
$cod_responsavel = $rs1['cod_responsavel_tecnico'];
$cod_responsavel_2 = $rs1['cod_responsavel_tecnico_2'];
$cod_regiao = $rs1['cod_regiao_tipo'];
$cod_acumulativo = $rs1['cod_acumulativo'];
?>
<div id="main" class="container-fluid">
    <h3 class="page-header">Indicador > Alterar</h3>
    <form id="frm1"> 
        <input type="hidden" name="id" id="id" value="<?php echo($id) ?>" />
        <input type="hidden" name="acao" id="acao" value="alterar" />
        <input type="hidden" name="cod_objetivo_ppa_" id="cod_objetivo_ppa_" value="<?php echo($cod_objetivo_ppa) ?>" />
        <input type="hidden" name="cod_indicador_" id="cod_indicador_" value="<?php echo($cod_indicador) ?>" />
        <input type="hidden" name="txt_monitoramento" id="txt_monitoramento" value="<?php echo($txt_monitoramento) ?>" />
        <?php
        include_once (__DIR__ . "/../include/combo_objetivo.php"); 
        ?>                
        <div class="row">
            <div class="col-md-12">
                <label for="exampleInputEmail1">Descrição da Meta:</label>
                <textarea class="form-control" rows="5" id="txt_descricao" name="txt_descricao"><?=$txt_descricao?></textarea>
            </div>
        </div>
        <br />   
        <div class="row">
            <div class="col-md-12">
                <label for="exampleInputEmail1">Indicador:</label>
                <?php
                $clsIndicador = new clsIndicador();
                $retorno_array = $clsIndicador->ListaIndicadores();                            
                ?>
                <div id="div_indicador">
                    <select id="cod_indicador" name="cod_indicador" class="chosen-select" data-placeholder="Obrigatório" onchange="setIndicador(this.value);">
                        <option></option>
                        <?php                    
                        foreach ($retorno_array->rows as $valor) { 
                            if ($valor->codigo == $cod_indicador || $valor->ativo) {                                               
                                if (!$clsIndicador->IndicadorVinculado_2($valor->codigo, $id)) { ?>
                                    <option value="<?=$valor->codigo?>"<?php if ($cod_indicador == $valor->codigo) { echo("selected");}?>><?=$valor->codigo?> - <?=$valor->titulo?></option>
                                <?php                 
                                }
                            }
                        }                    
                        ?>
                    </select>
                </div><!--div_indicador-->
            </div><!--col-md-12-->
        </div><!--row-->        
        <br />
        <div class="row">
            <div class="col-md-12">
                <label for="exampleInputEmail1">Meta:</label> 
                <input type="text" class="form-control" id="cod_meta" name="cod_meta" value="<?=$cod_meta?>" placeholder="Obrigatório">
            </div><!--col-md-12-->
        </div><!--row-->
        <br />
        <div class="row">
            <div class="col-md-12">
                <label for="exampleInputEmail1">Instrumento de Planejamento:</label>                
                <div id="div_instrumento">                    
                </div>
            </div><!--col-md-12-->
        </div><!--row-->        
        <br />
        <div class="row">
            <div class="col-md-6">
                <label for="exampleInputEmail1">Responsável Técnico:</label>
                <!--<div id="div_responsavel_tecnico"></div>-->
                <select id="cod_responsavel" name="cod_responsavel" class="chosen-select" data-placeholder="Obrigatório">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_orgao, txt_sigla FROM tb_orgao WHERE cod_ativo = 1 ORDER BY txt_sigla");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_orgao"]?>"<?php if ($cod_responsavel == $row["cod_orgao"]) { echo("selected");}?>><?=$row["txt_sigla"] ?></option>
                        <?php	
                        } ?>									
                </select>
            </div><!--col-md-6-->
            <div class="col-md-6">
                <label for="exampleInputEmail1">Responsável Técnico:</label>                
                <select id="cod_responsavel_2" name="cod_responsavel_2" class="chosen-select" data-placeholder="Responsável Técnico">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_orgao, txt_sigla FROM tb_orgao WHERE cod_ativo = 1 ORDER BY txt_sigla");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_orgao"]?>"<?php if ($cod_responsavel_2 == $row["cod_orgao"]) { echo("selected");}?>><?=$row["txt_sigla"] ?></option>
                        <?php	
                        } ?>									
                </select>
            </div><!--col-md-6-->            
        </div><!--row-->
        <br />
        <div class="row">     
            <div class="col-md-6">
                <label for="exampleInputEmail1">Responsável Gerencial:</label>
                <div id="div_responsavel_gerencial">                    
                </div>
            </div><!--col-md-6-->
            <div class="col-md-6">
                <label for="exampleInputEmail1">Parceiro:</label> 
                <select id="cod_orgao" name="cod_orgao" data-placeholder="Parceiro" class="chosen-select">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_orgao, txt_sigla FROM tb_orgao WHERE cod_ativo = 1 ORDER BY txt_sigla");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_orgao"]?>"<?php if ($cod_orgao == $row["cod_orgao"]) { echo("selected");}?>><?=$row["txt_sigla"] ?></option>
                        <?php	
                        } ?>									
                </select>
            </div><!--col-md-6-->
        </div><!--row-->  
        <br />          
        <div class="row">
            <div class="col-md-6">
                <label for="exampleInputEmail1">Meta/Cálculo Acumulativo:</label>               
                <!--<div id="div_acumulativo"></div>-->       
                <select id="cod_acumulativo" name="cod_acumulativo" class="form-control">
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
            </div><!--col-md-6-->
            <div class="col-md-6">
                <label for="exampleInputEmail1">Monitoramento:</label>               
                <div id="div_monitoramento"></div>                        
            </div><!--col-md-6-->
        </div><!--row--> 
        <br />
        <div class="row">
            <div class="col-md-6">
                <label for="exampleInputEmail1">Dados MGI:</label>               
                <select id="cod_dados_mgi" name="cod_dados_mgi" class="form-control" onchange="CampoFormula();">
                    <option value="1" <?php
                                        if ($cod_dados_mgi == 1) {
                                            echo("selected");
                                        }
                                        ?>>SIM</option>			
                    <option value="0"<?php
                                        if ($cod_dados_mgi == 0) {
                                            echo("selected");
                                        }
                                        ?>>NÃO</option>
                </select>                                        
            </div><!--col-md-6-->
            <div id="div_formula"></div>
        </div><!--row-->
        <br />                
        <div class="row">                         
            <div class="col-md-6">
                <label for="exampleInputEmail1">Unidade de Medida:</label>                
                <div id="div_unidade_medida">                    
                </div>
            </div>
            <div class="col-md-6">
                <label for="exampleInputEmail1">Região:</label>                
                <select id="cod_regiao" name="cod_regiao" class="form-control">                     
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_regiao_tipo, txt_regiao_tipo FROM tb_regiao_tipo WHERE cod_ativo = 1 ORDER BY cod_regiao_tipo");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_regiao_tipo"]?>"<?php if ($cod_regiao == $row["cod_regiao_tipo"]) { echo("selected");}?>><?=$row["txt_regiao_tipo"] ?></option>
                        <?php	
                        } ?>			
                </select>
            </div>
        </div><!--row-->  
        <br />       
        <div class="row">
            <div class="col-md-12">
                <label for="exampleInputEmail1">Meta/Monitoramento:</label>                
                <div id="div_meta_monitoramento"></div>
            </div><!--col-md-12-->
        </div><!--row-->          
        <br />
        <div class="row">
            <div class="col-md-12">
                <button type="submit" id="btn_salvar" class="btn btn-primary" onclick="return ValidarIncluir();">Salvar</button>
                <a href="#" onclick="self.location.href='default.php'" class="btn btn-default">Voltar</a>
            </div><!--col-md-12--> 
        </div><!--row-->      
    </form>
</div><!--main-->
<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>