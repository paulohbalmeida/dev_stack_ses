<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsIndicador.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(61);

$cod_objetivo = $_REQUEST['cod_objetivo'];
$cod_objetivo_ppa = $_REQUEST['cod_objetivo_ppa'];
$txt_acao = $_REQUEST['txt_acao'];
$cod_parceiro = $_REQUEST['cod_parceiro'];
$cod_meta = $_REQUEST['cod_meta'];
$cod_meta_parcial = $_REQUEST['cod_meta_parcial'];
$cod_orgao = $_REQUEST['cod_orgao'];
$cod_modulo = $_REQUEST['cod_modulo'];
$cod_numerador = $_REQUEST['cod_numerador'];
$cod_denominador = $_REQUEST['cod_denominador'];
$cod_indicador = $_REQUEST['cod_indicador'];
$cod_dados_mgi = $_REQUEST['cod_dados_mgi'];
$txt_monitoramento = $_REQUEST['txt_monitoramento'];
$cod_acumulativo = $_REQUEST['cod_acumulativo'];

?>
<div id="main" class="container-fluid">
    <h3 class="page-header">Indicador > Incluir</h3>
    <form id="frm1"> 
        <input type="hidden" name="acao" id="acao" value="" />
        <input type="hidden" name="txt_monitoramento" id="txt_monitoramento" value="" />
        <?php
        include_once (__DIR__ . "/../include/combo_objetivo.php"); 
        ?>                
        <div class="row">
            <div class="col-md-12">
                <label for="exampleInputEmail1">Descrição da Meta:</label>
                <textarea class="form-control" rows="5" id="txt_descricao" name="txt_descricao"></textarea>
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
                            if ($valor->ativo) {
                                if (!$clsIndicador->IndicadorVinculado($valor->codigo)) { ?>
                                    <option value="<?=$valor->codigo?>"><?=$valor->codigo?> - <?=$valor->titulo?></option>        
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
                <input type="text" class="form-control" id="cod_meta" name="cod_meta" placeholder="Obrigatório">
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
                <div id="div_unidade_medida"></div>
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
                <button type="submit" id="btn_incluir" class="btn btn-primary" onclick="return ValidarIncluir();">Incluir</button>
                <a href="default.php" class="btn btn-default">Voltar</a>
            </div><!--col-md-12--> 
        </div><!--row--> 
    </form>
</div><!--main-->
<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>