<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsUsuario.php");
include_once (__DIR__ . "/../classes/clsSag.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(81);

$clsSag = new clsSag();

$now = new DateTime;

if($clsSag->RegraPeriodo()) {
    $css_periodo = "";
} else {
    $css_periodo = "disabled";
}

if (empty($_REQUEST['log'])) {
	Auditoria(79, "Análise de Indicador", "");
}

$cod_sag = $_REQUEST['cod_sag'];
$cod_objetivo_url = $_REQUEST['cod_objetivo_url'];
$verificado = $_REQUEST['verificado'];

$sql = "SELECT tb_sag.*, codigo_eixo, txt_eixo, codigo_perspectiva, txt_perspectiva, codigo_diretriz, txt_diretriz, ";
$sql .= " codigo_objetivo, txt_objetivo, codigo_objetivo_ppa, txt_objetivo_ppa, nr_programa_trabalho, txt_titulo_programa ";
$sql .= " FROM tb_sag INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_sag.cod_objetivo ";
$sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo ";
$sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva ";
$sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz ";
$sql .= " INNER JOIN tb_objetivo_ppa ON tb_objetivo_ppa.cod_objetivo_ppa = tb_sag.cod_objetivo_ppa ";
$sql .= " INNER JOIN tb_programa_trabalho ON tb_programa_trabalho.cod_programa_trabalho = tb_sag.cod_programa_trabalho ";
$sql .= " WHERE cod_sag = ".$cod_sag;

$rsEtapa = pg_fetch_array(pg_query($sql));
$nr_etapa_trabalho = $rsEtapa['nr_etapa_trabalho'];
$txt_etapa_trabalho = $rsEtapa['txt_etapa_trabalho'];
$cod_obra = $rsEtapa['cod_obra'];
$nr_meta = $rsEtapa['nr_meta'];
$cod_acumulativo = $rsEtapa['cod_acumulativo'];
$cod_inicio_efetivo = $rsEtapa['cod_inicio_efetivo'];
$cod_fim_efetivo = $rsEtapa['cod_fim_efetivo'];
$cod_inicio_previsto = $rsEtapa['cod_inicio_previsto'];
$cod_fim_previsto = $rsEtapa['cod_fim_previsto'];
$cod_orgao = $rsEtapa['cod_orgao'];
$nr_programa_trabalho = $rsEtapa['nr_programa_trabalho'];
$txt_titulo_programa = $rsEtapa['txt_titulo_programa'];

if (empty($verificado)) {
    $cod_bimestre = 1;
}

$clsUsuario = new clsUsuario();
?>

<div id="main" class="container-fluid">
    <h3 class="page-header">SAG > Análise</h3>
    <h3><?php echo($rsEtapa['codigo_eixo']) ?> - <?php echo($rsEtapa['txt_eixo']) ?></h3>
    &nbsp;&nbsp;<strong><?php echo($rsEtapa['codigo_perspectiva']) ?> - <?php echo($rsEtapa['txt_perspectiva']);?></strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($rsEtapa['codigo_diretriz']) ?> - <?php echo($rsEtapa['txt_diretriz']);?></strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($rsEtapa['codigo_objetivo']) ?> - <?php echo($rsEtapa['txt_objetivo']);?></strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($rsEtapa['codigo_objetivo_ppa']);?> - <?php echo($rsEtapa['txt_objetivo_ppa']);?></strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($nr_programa_trabalho);?> - <?php echo($txt_titulo_programa);?></strong>
    <br /><br />
    <h4>        
        <br />
        <b>Etapa SAG:</b>         
        <?php echo($nr_etapa_trabalho) ?> 
        <br />
        <b>Descrição da Etapa:</b>         
        <?php echo($txt_etapa_trabalho) ?>         
    </h4>    
    Obra: <?php echo(destacar_ativo2($cod_obra)) ?><br />
    Acumulativo: <?php echo(destacar_ativo2($cod_acumulativo)) ?>
    <br /><br />
    <form id="frm1"> 
        <input type="hidden" name="log" id="log" value="1" />
        <input type="hidden" name="acao" id="acao" value="" />
        <input type="hidden" name="cod_sag" id="cod_sag" value="<?=$cod_sag?>" />
        <input type="hidden" name="cod_obra" id="cod_obra" value="<?=$cod_obra?>" />  
        <input type="hidden" name="cod_bimestre" id="cod_bimestre" value="<?=$cod_bimestre?>" />
        <input type="hidden" name="cod_acumulativo" id="cod_acumulativo" value="<?=$cod_acumulativo?>" /> 
        <input type="hidden" name="cod_objetivo_url" id="cod_objetivo_url" value="<?=$cod_objetivo_url?>" /> 
        <input type="hidden" name="verificado" id="verificado" value="1" />     
        <input type="hidden" name="txt_usuario_operacao" id="txt_usuario_operacao" value="<?php echo($clsUsuario->ConsultaUsuarioId($_SESSION['cod_usuario'])) ?>" /> 
        <div class="row"> 
            <div class="table-responsive col-md-12">
                <table class="table table-striped" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>                            
                            <th>
                                <div class="col-md-3">  
                                    Início Previsto
                                </div>
                                <div class="col-md-3">  
                                    Fim Previsto
                                </div>
                                <div class="col-md-3">  
                                    Início Efetivo
                                </div>
                                <div class="col-md-3">  
                                    Fim Efetivo
                                </div>
                            </th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>                            
                            <td>
                                <div class="col-md-3">
                                    <?php echo(RetornaTextoMes($cod_inicio_previsto)); ?>
                                </div>
                                <div class="col-md-3">
                                    <?php echo(RetornaTextoMes($cod_fim_previsto)); ?>
                                </div>
                                <div class="col-md-3">  
                                    <select id="cod_inicio_efetivo" name="cod_inicio_efetivo" class="form-control_select">
                                        <option></option>
                                        <?php                        
                                        $q = pg_query("SELECT cod_mes, txt_mes FROM tb_mes ORDER BY cod_mes");
                                        while ($row = pg_fetch_array($q)) 
                                        { ?>
                                            <option value="<?=$row["cod_mes"]?>"<?php if ($cod_inicio_efetivo == $row["cod_mes"]) { echo("selected");}?>><?=$row["txt_mes"] ?></option>
                                        <?php	
                                        } ?>	
                                    </select>
                                </div>                  
                                <div class="col-md-3">  
                                    <select id="cod_fim_efetivo" name="cod_fim_efetivo" class="form-control_select">
                                        <option></option>
                                        <?php                        
                                        $q = pg_query("SELECT cod_mes, txt_mes FROM tb_mes ORDER BY cod_mes");
                                        while ($row = pg_fetch_array($q)) 
                                        { ?>
                                            <option value="<?=$row["cod_mes"]?>"<?php if ($cod_fim_efetivo == $row["cod_mes"]) { echo("selected");}?>><?=$row["txt_mes"] ?></option>
                                        <?php	
                                        } ?>	
                                    </select>
                                </div>              
                            </td>                            
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row"> 
            <ul class="nav nav-tabs">
                <li class="active" onclick="SetBimestre(1)"><a data-toggle="tab" href="#menu1">Janeiro/Fevereiro</a></li>
                <li><a data-toggle="tab" href="#menu2" onclick="SetBimestre(2)">Março/Abril</a></li>
                <li><a data-toggle="tab" href="#menu3" onclick="SetBimestre(3)">Maio/Junho</a></li>
                <li><a data-toggle="tab" href="#menu4" onclick="SetBimestre(4)">Julho/Agosto</a></li>
                <li><a data-toggle="tab" href="#menu5" onclick="SetBimestre(5)">Setembro/Outrubro</a></li>
                <li><a data-toggle="tab" href="#menu6" onclick="SetBimestre(6)">Novembro/Dezembro</a></li>
            </ul>

            <div class="tab-content">
                <?php
                 $sql = "SELECT * FROM tb_pas_mes";   
                 $q2 = pg_query($sql);              
                 while($rs1 = pg_fetch_array($q2)) 
                 {   
                    $ct_mes = $rs1['cod_mes'];

                     if ($rs1['cod_mes'] == 1) {
                         $css = "tab-pane fade in active";
                     } else {
                         $css = "tab-pane fade";
                     } 
                     
                     $mes = RetornaTextoMesPAS($rs1['cod_mes']);
                     $a_mes = explode("/",$mes); 
                     
                     if (intval($cod_acumulativo) == 1) {
                        $nr_meta_ = 'nr_meta_'.$rs1['cod_mes'];
                        $nr_meta = $rsEtapa[$nr_meta_];
                        
                        if(empty($nr_meta) || strval($nr_meta) == '') {
                            $nr_meta = 0;
                        }                        
                     }
                     ?>
                    <div id="menu<?=$rs1['cod_mes']?>" class="<?=$css?>"> 
                        <?php
                        $sql = "SELECT * FROM tb_sag_analise WHERE cod_sag = ".$cod_sag." AND cod_bimestre = ".$ct_mes;
                        $q1 = pg_query($sql);
                        if (pg_num_rows($q1) > 0) {
                            $rs2 = pg_fetch_array($q1);
                            $nr_mes_1 = $rs2['nr_mes_1'];
                            $nr_mes_2 = $rs2['nr_mes_2'];
                            $txt_analise = $rs2['txt_analise'];
                            $cod_situacao = $rs2['cod_situacao'];
                            $cod_controle = $rs2['cod_controle'];                            
                            $txt_realizado_1 = $rs2['txt_realizado_1'];
                            $txt_realizado_2 = $rs2['txt_realizado_2'];
                            $txt_percentual = $rs2['cod_percentual'];
                            $txt_analise_obra = $rs2['txt_analise_obra'];
                            $cod_usuario_analise = $rs2['cod_usuario'];

                        } else {
                            $nr_mes_1 = '';
                            $nr_mes_2 = '';
                            $txt_analise = '';
                            $cod_situacao = '';
                            $cod_controle = '';                            
                            $txt_realizado_1 = '';
                            $txt_realizado_2 = '';
                            $txt_percentual = '';
                            $txt_analise_obra = '';
                            $cod_usuario_analise = '';
                        }
                        ?>
                        <br />
                        <div class="row">
                            <div class="table-responsive col-md-12">
                                <table class="table table-striped" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr>
                                            <th><label for="exampleInputEmail1">Meta</label></th>
                                            <th><label for="exampleInputEmail1">Total Ano</label></th>
                                            <th><label for="exampleInputEmail1">Status</label></th>
                                            <th><label for="exampleInputEmail1">Variação/Resultado</label></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" class="form-control_custom" id="nr_meta<?=$rs1['cod_mes']?>" name="nr_meta<?=$rs1['cod_mes']?>" value="<?php echo($nr_meta) ?>" disabled="disabled" /></td>
                                            <td><input type="text" class="form-control_custom" id="cod_total_geral<?=$rs1['cod_mes']?>" name="cod_total_geral<?=$rs1['cod_mes']?>" disabled="disabled" /></td>
                                            <td>
                                                <div id = "div_status<?=$rs1['cod_mes']?>">
                                                    <input type="text" class="form-control_custom" id="cod_status<?=$rs1['cod_mes']?>" name="cod_status<?=$rs1['cod_mes']?>" disabled="disabled" /> 
                                                </div>
                                            </td>
                                            <td><input type="text" class="form-control_custom" id="txt_variacao<?=$rs1['cod_mes']?>" name="txt_variacao<?=$rs1['cod_mes']?>" value="<?php echo($txt_variacao) ?>" disabled="disabled" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                            
                        </div>
                        <br /><br />
                        <div class="row">                                                                   
                            <div class="table-responsive col-md-12">
                                <table class="table table-striped" cellspacing="0" cellpadding="0"> 
                                    <thead>
                                        <tr>  
                                            <th>
                                                <label for="exampleInputEmail1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Realizado</label>                                                 
                                            </th>
                                            <th><label for="exampleInputEmail1">Total Bimestre</label></th>                                                
                                            <th><label for="exampleInputEmail1">Análise</label></th>                                                
                                            <th><label for="exampleInputEmail1">Situação</label></th>
                                            <th><label for="exampleInputEmail1">Controle</label></th>
                                            <th><label for="exampleInputEmail1">Registrado Por</label></th>
                                        </tr>                                                                     
                                    </thead>                                          
                                    <tbody>                                               
                                        <tr>
                                            <td>
                                                <div class="col-md-3">  
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($a_mes[0]) ?></strong>
                                                    <input type="text" id="nr_mes_1<?=$rs1['cod_mes']?>" name="nr_mes_1<?=$rs1['cod_mes']?>" value="<?=$nr_mes_1?>" class="form-control_custom" onblur="CalculoTotalVariacao();" placeholder="<?php echo($a_mes[0]) ?>" />
                                                </div>                  
                                                <div class="col-md-1"></div>                              
                                                <div class="col-md-2"> 
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($a_mes[1]) ?></strong>
                                                    <input type="text" id="nr_mes_2<?=$rs1['cod_mes']?>" name="nr_mes_2<?=$rs1['cod_mes']?>" value="<?=$nr_mes_2?>" class="form-control_custom" onblur="CalculoTotalVariacao();" placeholder="<?php echo($a_mes[1]) ?>" />
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control_custom" id="cod_total<?=$rs1['cod_mes']?>" name="cod_total<?=$rs1['cod_mes']?>" disabled="disabled"/> 
                                            </td>
                                            <td><textarea class="form-control" rows="5" id="txt_analise<?=$rs1['cod_mes']?>" name="txt_analise<?=$rs1['cod_mes']?>" placeholder="Obrigatório"><?=$txt_analise?></textarea></td>
                                            <td>
                                                <select id="cod_situacao<?=$rs1['cod_mes']?>" name="cod_situacao<?=$rs1['cod_mes']?>" class="form-control" onchange="FormDesvio(this.value, 1)">
                                                    <option></option>
                                                    <?php                        
                                                        $q = pg_query("SELECT cod_situacao, txt_situacao FROM tb_sag_situacao_analise WHERE cod_ativo = 1 ORDER BY txt_situacao");
                                                        while ($row = pg_fetch_array($q)) 
                                                        { ?>
                                                            <option value="<?=$row["cod_situacao"]?>"<?php if ($cod_situacao == $row["cod_situacao"]) { echo("selected");}?>><?=$row["txt_situacao"] ?></option>
                                                        <?php	
                                                        } ?>									
                                                </select>
                                            </td>
                                            <td>
                                                <select id="cod_controle<?=$rs1['cod_mes']?>" name="cod_controle<?=$rs1['cod_mes']?>" class="form-control" onchange="FormDesvio(this.value, 2)">
                                                    <option></option>
                                                    <?php                        
                                                        $q = pg_query("SELECT cod_controle, txt_controle FROM tb_sag_controle_analise WHERE cod_ativo = 1 ORDER BY txt_controle");
                                                        while ($row = pg_fetch_array($q)) 
                                                        { ?>
                                                            <option value="<?=$row["cod_controle"]?>"<?php if ($cod_controle == $row["cod_controle"]) { echo("selected");}?>><?=$row["txt_controle"] ?></option>
                                                        <?php	
                                                        } ?>									
                                                </select>
                                            </td>
                                            <td>
                                                <div id="div_registrado<?=$rs1['cod_mes']?>">
                                                    <?php echo($clsUsuario->ConsultaUsuarioId($cod_usuario_analise)) ?>
                                                <div>
                                                <input type="hidden" name="cod_usuario_analise<?=$rs1['cod_mes']?>" id="cod_usuario_analise<?=$rs1['cod_mes']?>" value="<?=$cod_usuario_analise?>" />
                                            </td>
                                        </tr>
                                    </tbody>                                  
                                </table>                                                  
                            </div>
                        </div> 
                        <div id="div_desvio<?=$ct_mes?>"></div>
                        <?php
                        if (intval($cod_obra) == 1) {  ?>
                            <br /><br />
                            <div class="row">
                                <center><h2>Obra</h2></center>
                                <div class="table-responsive col-md-12">                                                         
                                    <table class="table table-striped" cellspacing="0" cellpadding="0">                            
                                        <thead>
                                            <tr>
                                                <th><label for="exampleInputEmail1">Realizado</label></th>
                                                <th><label for="exampleInputEmail1">Percentual Realizado(%)</label></th>
                                                <th><label for="exampleInputEmail1">Análise</label></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control_custom" id="txt_realizado_1<?=$rs1['cod_mes']?>" name="txt_realizado_1<?=$rs1['cod_mes']?>" value="<?=$txt_realizado_1?>" placeholder="Obrigatório" />
                                                </td>
                                                <td><input type="text" class="form-control_custom" id="txt_percentual<?=$rs1['cod_mes']?>" name="txt_percentual<?=$rs1['cod_mes']?>" onkeypress="return isNumberKey(event)" value="<?=$txt_percentual?>" placeholder="Obrigatório" /></td>
                                                <td>
                                                    <textarea class="form-control" rows="5" id="txt_analise_obra<?=$rs1['cod_mes']?>" name="txt_analise_obra<?=$rs1['cod_mes']?>" placeholder="Obrigatório"><?=$txt_analise_obra?></textarea> 
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                        <?php
                        }
                        ?>                           
                    </div>
                <?php
                }                                            
                ?>                   
            </div>                                       
        </div><!--row-->         
        <div class="row" align="center">
            <br />
            <div class="col-md-12">                
                <?php if (permissao_acesso_unidade(81, $cod_orgao)) { ?>
                    <button type="button" id="btn_incluir" class="btn btn-primary" onclick="return SalvarAnalise();" <?php echo($css_periodo) ?>>Salvar</button>
                    <a class="btn btn-danger" onclick="return ExcluirAnaliseSAG();" <?php echo($css_periodo) ?>>Excluir</a>
                <?php } ?>                
                <a href="default.php?cod_objetivo_url=<?php echo($cod_objetivo_url) ?>" class="btn btn-default">Voltar</a>
            </div><!--col-md-12-->
        </div><!--row-->
    </form>
</div><!--main-->
<script src="manter_analise.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>