<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsIndicador.php");
include_once (__DIR__ . "/../classes/clsOrgao.php");
include_once (__DIR__ . "/../classes/clsUsuario.php");
include_once (__DIR__ . "/../classes/clsStatus.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina_2("66, 93");

$clsIndicador = new clsIndicador();
$clsOrgao = new clsOrgao();
$clsUsuario = new clsUsuario();
$clsStatus = new clsStatus();

$id = $_REQUEST['id'];
$data_atual = $_REQUEST['periodo'];

if (is_null($data_atual)) {    
    $hidden_periodo = date('n');
} else {    
    $hidden_periodo = $data_atual;
}

$sql = "SELECT tb_indicador.*, txt_eixo, txt_perspectiva, txt_diretriz, txt_objetivo, txt_objetivo_ppa, ";
$sql .= " tb_objetivo.cod_eixo, tb_objetivo.cod_perspectiva, tb_objetivo.cod_diretriz, ";
$sql .= " codigo_eixo, codigo_perspectiva, codigo_diretriz, codigo_objetivo, codigo_objetivo_ppa, txt_regiao_tipo ";
$sql .= " FROM tb_indicador ";
$sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_indicador.cod_objetivo ";
$sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo ";
$sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva ";
$sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz ";
$sql .= " INNER JOIN tb_objetivo_ppa ON tb_objetivo_ppa.cod_objetivo_ppa = tb_indicador.cod_objetivo_ppa  ";
$sql .= " LEFT JOIN tb_regiao_tipo ON tb_regiao_tipo.cod_regiao_tipo = tb_indicador.cod_regiao_tipo ";
$sql .= " WHERE cod_chave = " .$id;

$rs = pg_fetch_array(pg_query($sql));

$cod_eixo = $rs['cod_eixo'];
$cod_perspectiva = $rs['cod_perspectiva'];
$cod_diretriz = $rs['cod_diretriz'];
$cod_objetivo = $rs['cod_objetivo'];
$cod_dados_mgi = $rs['cod_dados_mgi'];
$cod_responsavel_tecnico = $rs['cod_responsavel_tecnico'];
$cod_responsavel_tecnico_2 = $rs['cod_responsavel_tecnico_2'];
$cod_regiao = $rs['cod_regiao_tipo'];
$txt_regiao = $rs['txt_regiao_tipo'];
$acumulativo = $rs['cod_acumulativo'];

//MGI
$retorno_array = $clsIndicador->ConsultaIndicador($rs['cod_indicador']);
$txt_titulo = $retorno_array->titulo;
$fonte = $clsIndicador->ConsultaFonte($retorno_array->ParametroFonteCodigo);
$monitoramento = $retorno_array->PeriodicidadeMonitoramento->descricao;
$acumulativo_mgi = $retorno_array->acumulativo;
$polaridade = $retorno_array->Polaridade->descricao;
$unidade_medida = $retorno_array->UnidadeMedida->descricao;

if (strtolower($unidade_medida) == 'número absoluto') {
    $bloquear_denominador = "disabled";
    $absoluto = "SIM";
} else {
    $bloquear_denominador = "";
    $absoluto = "NÃO";
}

$now = new DateTime;

if($clsIndicador->RegraPeriodoAnalise()) {
    $css_periodo = "";
} else {
    $css_periodo = "disabled";
}

if (empty($_REQUEST['log'])) {
	Auditoria(79, "Análise de Indicador", "");
}
?>
<div id="main" class="container-fluid" style="margin-top: 50px">
    <form id="frm1">
        <input type="hidden" name="log" id="log" value="1" />
        <input type="hidden" name="id" id="id" value="<?=$id?>" />
        <input type="hidden" name="cod_periodo" id="cod_periodo" value="<?php echo($hidden_periodo)?>" /> 
        <input type="hidden" name="polaridade" id="polaridade" value="<?=$polaridade?>" />
        <input type="hidden" name="absoluto" id="absoluto" value="<?=$absoluto?>" />
        <input type="hidden" name="cod_regiao_tipo" id="cod_regiao_tipo" value="<?=$cod_regiao?>" />
        <div id="top" class="row">
			<div class="col-sm-12">
				<h2>Indicador > Análise</h2>
			</div>			
		</div> <!-- /#top -->
		<br />
        <div class="row">
            <div class="col-md-12">
                <h3><?php echo($rs['codigo_eixo']) ?> - <?php echo($rs['txt_eixo']) ?></h3>
                &nbsp;&nbsp;<strong><?php echo($rs['codigo_perspectiva']) ?> - <?php echo($rs['txt_perspectiva']) ?></strong><br />
                &nbsp;&nbsp;<strong><?php echo($rs['codigo_diretriz']) ?> - <?php echo($rs['txt_diretriz']) ?></strong><br />
                &nbsp;&nbsp;<strong><?php echo($rs['codigo_objetivo']) ?> - <?php echo($rs['txt_objetivo']) ?></strong><br />
                &nbsp;&nbsp;<strong>Objetivo Específico PPA:</strong> <?php echo($rs['codigo_objetivo_ppa']) ?> - <?php echo($rs['txt_objetivo_ppa']) ?><br /><br />
                
                <strong>Descrição da Meta:</strong> <?php echo($rs['txt_descricao_meta']); ?><br />
                <strong>Indicador:</strong> <?php echo($txt_titulo); ?><br />
                <strong>Meta Anual:</strong> <?php echo($rs['cod_meta']); ?><br />
                Fonte: <?php echo($fonte); ?>;
                Monitoramento: <?php echo($monitoramento); ?>;
                Acumulativo: <?php echo(destacar_ativo2($acumulativo_mgi)); ?>;
                Polaridade: <?php echo($polaridade); ?>;
                <!--<strong>Dados MGI:</strong> <?php echo(destacar_ativo2($cod_dados_mgi)); ?>-->
                Região: <?php echo($txt_regiao); ?>;
            </div><!--col-md-12--> 					
        </div><!--row-->
        <br />
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-11">
                    <ul class="nav nav-tabs">
                        <?php
                        if (empty($data_atual)) {                        
                            $data_atual = $now->format('n');                        
                        }                    
                        $ct_mes = 1;                    
                        while ($ct_mes <= 12) { 
                            if ($data_atual == $ct_mes) {
                                $css = 'class="active"';                            
                            } else {
                                $css = '';                            
                            }                    
                        ?>
                            <li <?=$css?> onclick="MarcarAba('<?=$ct_mes?>');"><a data-toggle="tab" href="#menu<?=$ct_mes?>"><?=RetornaTextoMes($ct_mes)?></a></li>                                                
                        <?php                                                                
                            $ct_mes += 1;
                        }
                        ?>                       
                    </ul>
                </div>                 
                <div class="col-md-1">
                    <?php
                    if ($acumulativo) {
                        $sql = "SELECT cod_resultado FROM tb_indicador_analise WHERE cod_chave = ".$id." ORDER BY cod_periodo DESC LIMIT 1";
                        $q2 = pg_query($sql);   
                        if (pg_num_rows($q2) > 0) {                            
                            $rs3 = pg_fetch_array($q2);
                            $txt_resultado_ano = $rs3['cod_resultado'];
                        } else {
                            $txt_resultado_ano = '';
                        }                        
                    } else {
                        $rs4 = pg_fetch_array($clsIndicador->ListaIndicador($id));
                        $txt_formula = strtolower($rs4['txt_formula']);

                        $sql = "SELECT cod_numerador, cod_denominador, cod_resultado FROM tb_indicador_analise ";
                        $sql .= " WHERE cod_chave = ".$id." ORDER BY cod_periodo";                                             
                        $q2 = pg_query($sql); 
                        if (pg_num_rows($q2) > 0) { 
                            $txt_numerador_ano = 0;
                            while($rs3 = pg_fetch_array($q2)) {
                                if (!empty($rs3['cod_numerador'])) {
                                    $cod_numerador_ = str_replace(".", "", (string)$rs3['cod_numerador']); 
                                    $cod_numerador_ = str_replace(",", ".", (string)$cod_numerador_);

                                    $txt_numerador_ano = $txt_numerador_ano +  $cod_numerador_;
                                }                                
                                if (!empty($rs3['cod_denominador'])) {
                                    $cod_denominador_ = str_replace(".", "", (string)$rs3['cod_denominador']); 
                                    $cod_denominador_ = str_replace(",", ".", (string)$cod_denominador_);

                                    $txt_denominador_ano = $txt_denominador_ano + $cod_denominador_;
                                }     
                                
                                if (!empty($rs3['cod_resultado'])) {
                                    $cod_resultado_ = str_replace(".", "", (string)$rs3['cod_resultado']); 
                                    $cod_resultado_ = str_replace(",", ".", (string)$cod_resultado_);

                                    $txt_resultado_total = $txt_resultado_total + $cod_resultado_;
                                }  
                            } 
                                                                                                                                              
                            if($absoluto == 'SIM') {                                                              
                                try {                                    
                                    $txt_resultado_ano = $txt_resultado_total / intval($clsIndicador->TipoMonitoramento($monitoramento));
                                    $txt_resultado_ano = @number_format($txt_resultado_ano, 2, ',', '.');
                                } catch (\Exception $e) {
                                    $txt_resultado_ano = '';
                                }    
                            } else {                    
                                $txt_numerador_ano = number_format($txt_numerador_ano, 2, ',', '.');               
                                $txt_denominador_ano = number_format($txt_denominador_ano, 2, ',', '.');  

                                $txt_formula = str_replace("n", (string)$txt_numerador_ano, $txt_formula);
                                $txt_formula = str_replace("d", (string)$txt_denominador_ano, $txt_formula);  
                                $txt_formula = str_replace(".", "", $txt_formula);                                                          
                                $txt_formula = str_replace(",", ".", $txt_formula);  
                                
                                try {                                    
                                    $txt_resultado_ano = eval('return '.$txt_formula.';'); 
                                    $txt_resultado_ano = @number_format($txt_resultado_ano, 2, ',', '.');
    
                                } catch (\Exception $e) {
                                    $txt_resultado_ano = '';
                                }     
                            }                                                                                                                                                   
                        }
                        else {
                            $txt_resultado_ano = '';
                        }    
                    }
                    ?>
                    <strong>Janeiro/Dezembro</strong>
                    <input type="text" class="form-control_custom" id="txt_resultado_ano" name="txt_resultado_ano" value="<?php echo($txt_resultado_ano);?>" disabled="disabled"/>
                </div>               
                <div class="tab-content">
                    <?php
                    //META/MONITORAMENTO
                    $sql = "SELECT * FROM tb_indicador_meta WHERE cod_indicador = ".$id;
                    $q1 = pg_query($sql);                    
                    if (pg_num_rows($q1) > 0) {
                        $rs2 = pg_fetch_array($q1);
                        $qtd_campos = $clsIndicador->TipoMonitoramento($monitoramento);                        
                    }

                    $ct_meta_parcial = 0;
                    $ct_mes = 1;                    
                    while ($ct_mes <= 12) { 
                        if ($data_atual == $ct_mes) {                            
                            $css2 = "tab-pane fade in active";
                        } else {                            
                            $css2 = "tab-pane fade";
                        }     
                        ?>
                        <div id="menu<?=$ct_mes?>" class="<?=$css2?>">
                            <?php                            
                            $sql = "SELECT * FROM tb_indicador_analise WHERE cod_chave = ".$id." AND cod_periodo = ".$ct_mes;
                            $q = pg_query($sql);
                            if (pg_num_rows($q) > 0) {
                                $botao_excluir = true;
                                $rs1 = pg_fetch_array($q);
                                $txt_analise = $rs1['txt_analise'];
                                $txt_analise_2 = $rs1['txt_analise_2'];
                                $txt_encaminhamento = $rs1['txt_encaminhamento'];                                
                                $cod_usuario = $rs1['cod_usuario'];  
                                $cod_numerador = $rs1['cod_numerador'];
                                $cod_denominador = $rs1['cod_denominador'];
                                $cod_resultado = $rs1['cod_resultado'];                                
                                $txt_status = $clsStatus->RetornaStatus($rs1['cod_status']);
                                $txt_cor =  $clsStatus->RetornaCorStatus($rs1['cod_status']);
                                $txt_variacao = $rs1['txt_variacao'];                                                       
                                $dt_extracao = FormataData($rs1['dt_extracao']);
                                $exibir_meta_parcial = true;                                
                                $ct_meta_parcial += 1; 
                            } 
                            else {
                                $botao_excluir = false;
                                $txt_analise = '';
                                $txt_analise_2 = '';
                                $txt_encaminhamento = '';                                
                                $cod_usuario = '';  
                                $cod_numerador = '';
                                $cod_denominador = '';
                                $cod_resultado = ''; 
                                $txt_status = '';
                                $txt_cor = '';
                                $dt_extracao = '';
                                $txt_variacao = '';
                                $exibir_meta_parcial = false;
                            }                            

                            if ($cod_denominador == 0) {
                                $cod_denominador = "";
                            }

                            //PERMITIR OU NÃO EDIÇÃO DOS DADOS
                            if ($cod_dados_mgi) {
                                $disabled = "disabled";
                                $bloquear_denominador = $disabled;
                            }
                            else {
                                $disabled = "";
                            }
                            ?>
                            <br />
                            <div class="table-responsive col-md-12">                                                         
                                <b>Meta/Monitoramento:</b>                                                                                                  
                                <?php
                                //if ($exibir_meta_parcial) { ?>                                                                                    
                                    <table class="table table-striped" cellspacing="0" cellpadding="0"> 
                                        <thead>
                                            <tr>
                                                <?php       
                                                if(!empty($rs2['campo_'.$ct_mes])) { ?>                                                                           
                                                    <th>Meta Parcial</th>
                                                <?php                                                
                                                } 
                                                ?>            
                                                <th>Status</th>                                                
                                                <th>Variação Resultado/Meta</th>                                                
                                            </tr>                                                                   
                                        </thead>                                    
                                        <tbody>
                                            <?php                                            
                                            if ($qtd_campos > 0) { ?>
                                                <tr> 
                                                    <?php
                                                    if(!empty($rs2['campo_'.$ct_mes])) { ?>
                                                        <td>
                                                            <input type="text" class="form-control_custom" id="txt_meta_parcial<?=$ct_mes?>" name="txt_meta_parcial" value="<?php echo($rs2['campo_'.$ct_mes]) ?>" disabled="disabled">
                                                        </td> <?php                                                
                                                    } 
                                                    ?>                                                   
                                                    <td>
                                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($txt_cor) ?>;" value="<?php echo($txt_status) ?>" disabled="disabled">
                                                    </td> 
                                                    <td>
                                                        <input type="text" class="form-control_custom" name="txt_variacao" value="<?php echo($txt_variacao) ?>%" disabled="disabled">
                                                    </td>                                                                                                    
                                                </tr>
                                            <?php
                                            }                                        
                                            ?>
                                        </tbody>
                                    </table> <?php
                                //} ?>
                                <table class="table table-striped" cellspacing="0" cellpadding="0">                                    
                                    <thead>
                                        <tr>                                                                                  
                                            <th>Numerador:</th>
                                            <th>Denominador:</th>
                                            <th>Resultado:</th>                                            
                                            <th>Data Extração:</th>
                                            <!--<th>Análise:</th>-->
                                            <th>Encaminhamento:</th>      
                                            <th>Registrado Por:</th>
                                            <th></th>
                                        </tr>                                        
                                    </thead>
                                    <tbody>
                                        <tr>                                            
                                            <td><input type="text" class="form-control" id="cod_numerador<?=$ct_mes?>" name="cod_numerador" value="<?=$cod_numerador?>" placeholder="Obrigatório" <?php echo($disabled) ?>></td>
                                            <td><input type="text" class="form-control" id="cod_denominador<?=$ct_mes?>" name="cod_denominador" value="<?=$cod_denominador?>" placeholder="Obrigatório" <?php echo($bloquear_denominador) ?>></td>
                                            <td><input type="text" class="form-control" id="cod_resultado<?=$ct_mes?>" name="cod_resultado" value="<?=$cod_resultado?>" placeholder="Obrigatório" disabled="disabled"></td>                                            
                                            <td><input type="text" class="form-control" id="dt_extracao<?=$ct_mes?>" name="dt_extracao" value="<?=$dt_extracao?>" onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)" placeholder="Obrigatório" <?php echo($disabled) ?>></td>
                                            <!--<td><textarea class="form-control" rows="5" id="txt_analise<?=$ct_mes?>" name="txt_analise" placeholder="Obrigatório"><?=$txt_analise?></textarea></td>-->
                                            <td><textarea class="form-control" rows="5" id="txt_encaminhamento<?=$ct_mes?>" name="txt_encaminhamento" placeholder="Obrigatório"><?=$txt_encaminhamento?></textarea></td>                                            
                                            <td>
                                                <?php echo($clsUsuario->ConsultaUsuarioId($cod_usuario)) ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($botao_excluir && (permissao_acesso_unidade(66, $cod_responsavel_tecnico) || permissao_acesso_unidade(66, $cod_responsavel_tecnico_2))) { ?>
                                                    <a class="btn btn-danger btn-xs" onclick="return ExcluirAnalise(<?=$id?>, <?=$ct_mes?>);" >Excluir</a>
                                                <?php
                                                } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <center>
                                    <strong>ANÁLISE:</strong>
                                </center>
                                <table class="table table-striped" cellspacing="0" cellpadding="0"> 
                                    <thead>
                                        <tr>                                                                                                                              
                                            <th>
                                                <center>
                                                    <?php
                                                    if (!empty($cod_responsavel_tecnico)) {
                                                        echo($clsOrgao->RetornaSigla($cod_responsavel_tecnico));
                                                    } 
                                                    ?>   
                                                </center>  
                                            </th>
                                            <?php
                                            if (!empty($cod_responsavel_tecnico_2)) {
                                            ?>
                                                <th>
                                                    <center>
                                                        <?php
                                                        if (!empty($cod_responsavel_tecnico_2)) {
                                                            echo($clsOrgao->RetornaSigla($cod_responsavel_tecnico_2));
                                                        } 
                                                        ?>     
                                                    </center>
                                                </th>                                            
                                            <?php 
                                            }
                                            ?>
                                        </tr>                                        
                                    </thead>
                                    <tbody>
                                        <tr>                                                                                       
                                            <td>
                                            <?php
                                            if (!empty($cod_responsavel_tecnico_2)) {
                                                $placeholder_analise = "";
                                            } else {
                                                $placeholder_analise = "Obrigatório";
                                            }?>
                                                <textarea class="form-control" rows="5" id="txt_analise<?=$ct_mes?>" name="txt_analise" placeholder="<?=$placeholder_analise?>"><?=$txt_analise?></textarea>                                            
                                            </td>
                                            <?php
                                            if (!empty($cod_responsavel_tecnico_2)) {
                                            ?>
                                                <td>
                                                    <textarea class="form-control" rows="5" id="txt_analise_2<?=$ct_mes?>" name="txt_analise_2" placeholder="<?=$placeholder_analise?>"><?=$txt_analise_2?></textarea>
                                                </td>
                                            <?php 
                                            }
                                            ?>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                                if (!empty($cod_responsavel_tecnico_2)) {
                                ?>
                                    <input type="hidden" name="cod_responsavel_tecnico_2_existe<?=$ct_mes?>" id="cod_responsavel_tecnico_2_existe<?=$ct_mes?>" value="1" />
                                <?php 
                                } else { ?>
                                    <input type="hidden" name="cod_responsavel_tecnico_2_existe<?=$ct_mes?>" id="cod_responsavel_tecnico_2_existe<?=$ct_mes?>" value="0" />
                                <?php
                                }
                                ?>
                                <script type="text/javascript">
                                    /*
                                    jQuery(function($){                    
                                        $('#cod_numerador<?=$ct_mes?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                        $('#cod_denominador<?=$ct_mes?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                        $('#cod_resultado<?=$ct_mes?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                    });
                                    */
                                </script>
                            </div>
                             <!--REGIÃO-->
                            <?php                             
                            if (limpar_comparacao($cod_regiao) == 1) {
                                //Região de Saúde/URD
                            ?>
                                <div class="row">
                                    <div class="table-responsive col-md-12">
                                        <center><strong>Região</strong><center>
                                        <table class="table table-striped" cellspacing="0" cellpadding="0">
                                            <thead>
                                                <tr>
                                                    <th>Região de Saúde</th>
                                                    <th>Numerador:</th>
                                                    <th>Denominador:</th>
                                                    <th>Resultado:</th>                                            
                                                    <th>Data Extração:</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php                                                
                                                $sql_regiao = "SELECT * FROM tb_regiao WHERE cod_ativo = 1 ORDER BY cod_regiao";
                                                $q = pg_query($sql_regiao);
                                                $cod_reg_qtd = 0;
                                                while ($rs1 = pg_fetch_array($q)) { 
                                                    $cod_regiao_saude = $rs1['cod_regiao'];
                                                    $txt_regiao = $rs1['txt_regiao'];                                                    
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" id="cod_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$txt_regiao?>" disabled="disabled">
                                                            <input type="hidden" id="cod_regiao_saude<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$cod_regiao_saude?>" />    
                                                        </td>
                                                        <td><input type="text" class="form-control" id="reg_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$clsIndicador->RetornaValorNumeradorReg($id, $ct_mes, $cod_regiao, $cod_regiao_saude)?>" <?php echo($disabled) ?>></td>
                                                        <td><input type="text" class="form-control" id="reg_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$clsIndicador->RetornaValorDenominadorReg($id, $ct_mes, $cod_regiao, $cod_regiao_saude)?>" <?php echo($bloquear_denominador) ?>></td>
                                                        <td><input type="text" class="form-control" id="reg_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$clsIndicador->RetornaValorResultadoReg($id, $ct_mes, $cod_regiao, $cod_regiao_saude)?>" disabled="disabled"></td>                                            
                                                        <td><input type="text" class="form-control" id="reg_dt_extracao_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$clsIndicador->RetornaValorExtracaoReg($id, $ct_mes, $cod_regiao, $cod_regiao_saude)?>" onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)" <?php echo($disabled) ?>></td>  

                                                        <script type="text/javascript">
                                                            /*
                                                            jQuery(function($){                    
                                                                $('#reg_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                                                $('#reg_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                                                $('#reg_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                                            });
                                                            */
                                                        </script>
                                                    </tr> <?php
                                                    $cod_reg_qtd += 1;
                                                }
                                                ?>                                                                                                                                                
                                            </tbody>
                                        </table> 
                                        <input type="hidden" id="cod_reg_qtd" value="<?=$cod_reg_qtd?>" />                                       
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="table-responsive col-md-12">
                                        <center><b>URD</b><center>
                                        <table class="table table-striped" cellspacing="0" cellpadding="0">
                                            <thead>
                                                <tr>
                                                    <th>URD</th>
                                                    <th>Numerador:</th>
                                                    <th>Denominador:</th>
                                                    <th>Resultado:</th>                                            
                                                    <th>Data Extração:</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php                                                
                                                $sql_regiao = "SELECT * FROM tb_urd WHERE cod_ativo = 1 ORDER BY cod_urd";
                                                $q = pg_query($sql_regiao);
                                                $cod_urd_qtd = 0;
                                                while ($rs1 = pg_fetch_array($q)) { 
                                                    $cod_urd = $rs1['cod_urd'];
                                                    $txt_urd = $rs1['txt_urd']; 
                                                    $txt_sigla_urd = $rs1['txt_sigla'];                                                                                            
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" id="cod_urd<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$txt_sigla_urd?>" title="<?=$txt_urd?>" disabled="disabled">
                                                            <input type="hidden" id="cod_urd<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$cod_urd?>" />    
                                                        </td>
                                                        <td><input type="text" class="form-control" id="urd_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$clsIndicador->RetornaValorNumeradorUrd($id, $ct_mes, $cod_regiao, $cod_urd)?>" <?php echo($disabled) ?>></td>
                                                        <td><input type="text" class="form-control" id="urd_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$clsIndicador->RetornaValorDenominadorUrd($id, $ct_mes, $cod_regiao, $cod_urd)?>" <?php echo($bloquear_denominador) ?>></td>
                                                        <td><input type="text" class="form-control" id="urd_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$clsIndicador->RetornaValorResultadoUrd($id, $ct_mes, $cod_regiao, $cod_urd)?>" disabled="disabled"></td>                                            
                                                        <td><input type="text" class="form-control" id="urd_dt_extracao_regiao<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$clsIndicador->RetornaValorExtracaoUrd($id, $ct_mes, $cod_regiao, $cod_urd)?>" onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)" <?php echo($disabled) ?>></td>  

                                                        <script type="text/javascript">
                                                            /*
                                                            jQuery(function($){                    
                                                                $('#urd_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_urd?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                                                $('#urd_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_urd?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                                                $('#urd_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_urd?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                                            });
                                                            */
                                                        </script>
                                                    </tr> <?php
                                                    $cod_urd_qtd += 1;
                                                }
                                                ?>                                                
                                            </tbody>
                                        </table>     
                                        <input type="hidden" id="cod_urd_qtd" value="<?=$cod_urd_qtd?>" />                                    
                                    </div>                                    
                                </div>
                            <?php
                            } else if (limpar_comparacao($cod_regiao) == 2) {
                                //Hospitais/URD
                            ?>
                                <div class="row">
                                    <div class="table-responsive col-md-12">
                                        <center><b>Hospitais</b><center>
                                        <table class="table table-striped" cellspacing="0" cellpadding="0">
                                            <thead>
                                                <tr>
                                                    <th>Região Administrativa</th>
                                                    <th>Numerador:</th>
                                                    <th>Denominador:</th>
                                                    <th>Resultado:</th>                                            
                                                    <th>Data Extração:</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_regiao = "SELECT * FROM tb_hospital WHERE cod_tipo = 1 AND cod_ativo = 1 ORDER BY cod_hospital";
                                                $q = pg_query($sql_regiao);
                                                $cod_hosp_qtd = 0;
                                                while ($rs1 = pg_fetch_array($q)) { 
                                                    $cod_hospital = $rs1['cod_hospital'];
                                                    $txt_hospital = $rs1['txt_hospital'];
                                                    $txt_sigla_hospital = $rs1['txt_sigla_hospital'];
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" id="cod_hospital<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$txt_sigla_hospital?>" title="<?=$txt_hospital?>" disabled="disabled">
                                                            <input type="hidden" id="cod_hospital<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$cod_hospital?>" />    
                                                        </td>
                                                        <td><input type="text" class="form-control" id="hosp_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorNumeradorHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" <?php echo($disabled) ?>></td>
                                                        <td><input type="text" class="form-control" id="hosp_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorDenominadorHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" <?php echo($bloquear_denominador) ?>></td>
                                                        <td><input type="text" class="form-control" id="hosp_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorResultadoHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" disabled="disabled"></td>                                            
                                                        <td><input type="text" class="form-control" id="hosp_dt_extracao_regiao<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorExtracaoHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)" <?php echo($disabled) ?>></td>  

                                                        <script type="text/javascript">
                                                            /*
                                                            jQuery(function($){                    
                                                                $('#hosp_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_hospital?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                                                $('#hosp_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_hospital?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                                                $('#hosp_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_hospital?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                                            });
                                                            */
                                                        </script>
                                                    </tr> <?php
                                                    $cod_hosp_qtd += 1;
                                                }
                                                ?>    
                                                <input type="hidden" id="cod_hosp_qtd" value="<?=$cod_hosp_qtd?>" />                                                                                   
                                            </tbody>
                                        </table>                                        
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="table-responsive col-md-12">
                                        <center><b>URD</b><center>
                                        <table class="table table-striped" cellspacing="0" cellpadding="0">
                                            <thead>
                                                <tr>
                                                    <th>URD</th>
                                                    <th>Numerador:</th>
                                                    <th>Denominador:</th>
                                                    <th>Resultado:</th>                                            
                                                    <th>Data Extração:</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php                                                
                                                $sql_regiao = "SELECT * FROM tb_urd WHERE cod_ativo = 1 ORDER BY cod_urd";
                                                $q = pg_query($sql_regiao);
                                                $cod_urd_qtd = 0;
                                                while ($rs1 = pg_fetch_array($q)) { 
                                                    $cod_urd = $rs1['cod_urd'];
                                                    $txt_urd = $rs1['txt_urd']; 
                                                    $txt_sigla_urd = $rs1['txt_sigla'];                                                                                            
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" id="cod_urd<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$txt_sigla_urd?>" title="<?=$txt_urd?>" disabled="disabled">
                                                            <input type="hidden" id="cod_urd<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$cod_urd?>" />    
                                                        </td>
                                                        <td><input type="text" class="form-control" id="urd_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$clsIndicador->RetornaValorNumeradorUrd($id, $ct_mes, $cod_regiao, $cod_urd)?>" <?php echo($disabled) ?>></td>
                                                        <td><input type="text" class="form-control" id="urd_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$clsIndicador->RetornaValorDenominadorUrd($id, $ct_mes, $cod_regiao, $cod_urd)?>" <?php echo($bloquear_denominador) ?>></td>
                                                        <td><input type="text" class="form-control" id="urd_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$clsIndicador->RetornaValorResultadoUrd($id, $ct_mes, $cod_regiao, $cod_urd)?>" disabled="disabled"></td>                                            
                                                        <td><input type="text" class="form-control" id="urd_dt_extracao_regiao<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$clsIndicador->RetornaValorExtracaoUrd($id, $ct_mes, $cod_regiao, $cod_urd)?>" onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)" <?php echo($disabled) ?>></td>  

                                                        <script type="text/javascript">
                                                            /*
                                                            jQuery(function($){                    
                                                                $('#urd_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_urd?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                                                $('#urd_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_urd?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                                                $('#urd_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_urd?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                                            });
                                                            */
                                                        </script>
                                                    </tr> <?php
                                                    $cod_urd_qtd += 1;
                                                }
                                                ?>                                                
                                            </tbody>
                                        </table>     
                                        <input type="hidden" id="cod_urd_qtd" value="<?=$cod_urd_qtd?>" />                                    
                                    </div>                                    
                                </div>
                            <?php
                            } else if (limpar_comparacao($cod_regiao) == 3) {                                
                                //RA
                            ?>
                                <div class="row">
                                    <div class="table-responsive col-md-12">
                                        <center><b><?php echo($txt_regiao) ?></b><center>
                                        <table class="table table-striped" cellspacing="0" cellpadding="0">
                                            <thead>
                                                <tr>
                                                    <th>Região Administrativa</th>
                                                    <th>Numerador:</th>
                                                    <th>Denominador:</th>
                                                    <th>Resultado:</th>                                            
                                                    <th>Data Extração:</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_regiao = "SELECT tb_regiao_administrativa.* FROM tb_regiao_administrativa ";
                                                $sql_regiao .= " INNER JOIN tb_regiao ON tb_regiao.cod_regiao = tb_regiao_administrativa.cod_regiao ";
                                                $sql_regiao .= " WHERE tb_regiao_administrativa.cod_ativo = 1 ORDER BY txt_regiao, cod_ra";
                                                $q = pg_query($sql_regiao);
                                                $cod_ra_qtd = 0;                                                

                                                $txt_resultado_valor_numerador_ra_total = 0;
                                                $txt_resultado_valor_denominador_ra_total = 0;
                                                $txt_resultado_valor_resultado_ra_total = 0;

                                                while ($rs1 = pg_fetch_array($q)) { 
                                                    $cod_ra = $rs1['cod_ra'];
                                                    $txt_ra = $rs1['txt_ra'];
                                                    $cod_regiao_ra = $rs1['cod_regiao'];                                                                                                        

                                                    if ($cod_ra_qtd == 0 || limpar_comparacao($cod_regiao_ra) != limpar_comparacao($cod_regiao_ra_anterior)) {
                                                        $sql_2 = "SELECT txt_regiao FROM tb_regiao WHERE cod_regiao = ".$cod_regiao_ra;
                                                        $q_2 = pg_query($sql_2);
                                                        $rs1_2 = pg_fetch_array($q_2);  
                                                        
                                                        $sql_3 = "SELECT MAX(cod_ra) AS cod_ra FROM tb_regiao_administrativa WHERE cod_regiao = ".$cod_regiao_ra." AND cod_ativo = 1";
                                                        $q_3 = pg_query($sql_3);
                                                        $rs1_3 = pg_fetch_array($q_3);
                                                        $cod_ra_total = $rs1_3['cod_ra'];
                                                    ?>
                                                        <tr>
                                                            <td colspan="5">
                                                                <center><b>Região <?php echo($rs1_2['txt_regiao']) ?></b><center>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    //NUMERADOR
                                                    $valor_numerador_ra = $clsIndicador->RetornaValorNumeradorRA($id, $ct_mes, $cod_regiao, $cod_ra);
                                                    $valor_denominador_ra = $clsIndicador->RetornaValorDenominadorRA($id, $ct_mes, $cod_regiao, $cod_ra);
                                                    $valor_resultado_ra = $clsIndicador->RetornaValorResultadoRA($id, $ct_mes, $cod_regiao, $cod_ra);                                                                                                    
                                                    
                                                    $valor_numerador_ra_total = str_replace(".", "", (string)$valor_numerador_ra);
                                                    $valor_numerador_ra_total = str_replace(",", ".", (string)$valor_numerador_ra_total);
                                                    if (empty($valor_numerador_ra_total)) {
                                                        $valor_numerador_ra_total = 0;
                                                    }                                                    
                                                    $txt_resultado_valor_numerador_ra_total = $txt_resultado_valor_numerador_ra_total + $valor_numerador_ra_total;                                                                                                        
                                                                                                        
                                                    //DENOMINADOR
                                                    $valor_denominador_ra_total = str_replace(".", "", (string)$valor_denominador_ra);
                                                    $valor_denominador_ra_total = str_replace(",", ".", (string)$valor_denominador_ra_total);
                                                    if (empty($valor_denominador_ra_total)) {
                                                        $valor_denominador_ra_total = 0;
                                                    }
                                                    $txt_resultado_valor_denominador_ra_total = $txt_resultado_valor_denominador_ra_total + $valor_denominador_ra_total;                                                                                                        

                                                    //RESULTADO
                                                    $valor_resultado_ra_total = str_replace(".", "", (string)$valor_resultado_ra);
                                                    $valor_resultado_ra_total = str_replace(",", ".", (string)$valor_resultado_ra_total);                                                    
                                                    if (empty($valor_resultado_ra_total)) {
                                                        $valor_resultado_ra_total = 0;
                                                    }                                                    
                                                    
                                                    $txt_resultado_valor_resultado_ra_total = str_replace(".", "", (string)$txt_resultado_valor_resultado_ra_total);
                                                    $txt_resultado_valor_resultado_ra_total = str_replace(",", ".", (string)$txt_resultado_valor_resultado_ra_total);

                                                    if (!empty($polaridade)) {                                                         
                                                        if($absoluto != 'SIM') {
                                                            $txt_resultado_valor_resultado_ra_total = $clsIndicador->CalcularResultado($id, trim($txt_resultado_valor_numerador_ra_total), trim($txt_resultado_valor_denominador_ra_total));
                                                        }            
                                                        else {
                                                            $txt_resultado_valor_resultado_ra_total = $txt_resultado_valor_numerador_ra_total;                                                                                                                                                                    
                                                        }   

                                                        $txt_resultado_valor_resultado_ra_total = @number_format($txt_resultado_valor_resultado_ra_total, 2, ",", ".");
                                                    } 
                                                    ?>                                                    
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" id="cod_ra<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$txt_ra?>" disabled="disabled">
                                                            <input type="hidden" id="cod_ra<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$cod_ra?>" />    
                                                        </td>
                                                        <td><input type="text" class="form-control" id="ra_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$valor_numerador_ra?>" <?php echo($disabled) ?>></td>
                                                        <td><input type="text" class="form-control" id="ra_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$valor_denominador_ra?>" <?php echo($bloquear_denominador) ?>></td>
                                                        <td><input type="text" class="form-control" id="ra_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$valor_resultado_ra?>" disabled="disabled"></td>                                            
                                                        <td><input type="text" class="form-control" id="ra_dt_extracao_regiao<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$clsIndicador->RetornaValorExtracaoRA($id, $ct_mes, $cod_regiao, $cod_ra)?>" onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)" <?php echo($disabled) ?>></td>                                                         
                                                    </tr> <?php                                                     
                                                    $cod_ra_qtd += 1;
                                                    $cod_regiao_ra_anterior = $cod_regiao_ra;
                                                    
                                                    if(limpar_comparacao($cod_ra) == limpar_comparacao($cod_ra_total)) {
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <center><strong>Total</strong><center>
                                                            </td>
                                                            <td><input type="text" class="form-control" id="ra_cod_numerador_regiao_total<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$txt_resultado_valor_numerador_ra_total?>" disabled="disabled"></td>
                                                            <td><input type="text" class="form-control" id="ra_cod_denominador_regiao_total<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$txt_resultado_valor_denominador_ra_total?>" disabled="disabled"></td>
                                                            <td><input type="text" class="form-control" id="ra_cod_resultado_regiao_total<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$txt_resultado_valor_resultado_ra_total?>" disabled="disabled"></td>                                                                                                        
                                                        </tr>
                                                    <?php
                                                        $txt_resultado_valor_numerador_ra_total = 0;
                                                        $txt_resultado_valor_denominador_ra_total = 0;
                                                        $txt_resultado_valor_resultado_ra_total = 0;
                                                    }                                                                                                        
                                                }
                                                ?>                                                
                                            </tbody>
                                        </table>  
                                        <input type="hidden" id="cod_ra_qtd" value="<?=$cod_ra_qtd?>" />                                     
                                    </div> 
                                </div>   
                            <?php                            
                            } else if (limpar_comparacao($cod_regiao) == 4) {                                
                                //Região de Saúde
                            ?>
                                <div class="row">
                                    <div class="table-responsive col-md-12">
                                        <center><strong>Região</strong><center>
                                        <table class="table table-striped" cellspacing="0" cellpadding="0">
                                            <thead>
                                                <tr>
                                                    <th>Região de Saúde</th>
                                                    <th>Numerador:</th>
                                                    <th>Denominador:</th>
                                                    <th>Resultado:</th>                                            
                                                    <th>Data Extração:</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php                                                
                                                $sql_regiao = "SELECT * FROM tb_regiao WHERE cod_ativo = 1 ORDER BY cod_regiao";
                                                $q = pg_query($sql_regiao);
                                                $cod_reg_qtd = 0;
                                                while ($rs1 = pg_fetch_array($q)) { 
                                                    $cod_regiao_saude = $rs1['cod_regiao'];
                                                    $txt_regiao = $rs1['txt_regiao'];                                                    
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" id="cod_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$txt_regiao?>" disabled="disabled">
                                                            <input type="hidden" id="cod_regiao_saude<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$cod_regiao_saude?>" />    
                                                        </td>
                                                        <td><input type="text" class="form-control" id="reg_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$clsIndicador->RetornaValorNumeradorReg($id, $ct_mes, $cod_regiao, $cod_regiao_saude)?>" <?php echo($disabled) ?>></td>
                                                        <td><input type="text" class="form-control" id="reg_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$clsIndicador->RetornaValorDenominadorReg($id, $ct_mes, $cod_regiao, $cod_regiao_saude)?>" <?php echo($bloquear_denominador) ?>></td>
                                                        <td><input type="text" class="form-control" id="reg_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$clsIndicador->RetornaValorResultadoReg($id, $ct_mes, $cod_regiao, $cod_regiao_saude)?>" disabled="disabled"></td>                                            
                                                        <td><input type="text" class="form-control" id="reg_dt_extracao_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$clsIndicador->RetornaValorExtracaoReg($id, $ct_mes, $cod_regiao, $cod_regiao_saude)?>" onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)" <?php echo($disabled) ?>></td>                                                          
                                                    </tr> <?php
                                                    $cod_reg_qtd += 1;
                                                }
                                                ?>                                                                                                                                                
                                            </tbody>
                                        </table> 
                                        <input type="hidden" id="cod_reg_qtd" value="<?=$cod_reg_qtd?>" />                                       
                                    </div>                                    
                                </div>                                
                            <?php
                            }                        
                            else if (limpar_comparacao($cod_regiao) == 5) {
                                //Hospitais/Hospitais Conveniados
                            ?>
                                <div class="row">
                                    <div class="table-responsive col-md-12">
                                        <center><b>Hospitais</b><center>
                                        <table class="table table-striped" cellspacing="0" cellpadding="0">
                                            <thead>
                                                <tr>
                                                    <th>Região Administrativa</th>
                                                    <th>Numerador:</th>
                                                    <th>Denominador:</th>
                                                    <th>Resultado:</th>                                            
                                                    <th>Data Extração:</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_regiao = "SELECT * FROM tb_hospital WHERE cod_tipo = 1 AND cod_ativo = 1 ORDER BY cod_hospital";
                                                $q = pg_query($sql_regiao);
                                                $cod_hosp_qtd = 0;
                                                while ($rs1 = pg_fetch_array($q)) { 
                                                    $cod_hospital = $rs1['cod_hospital'];
                                                    $txt_hospital = $rs1['txt_hospital'];
                                                    $txt_sigla_hospital = $rs1['txt_sigla_hospital'];
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" id="cod_hospital<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$txt_sigla_hospital?>" title="<?=$txt_hospital?>" disabled="disabled">
                                                            <input type="hidden" id="cod_hospital<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$cod_hospital?>" />    
                                                        </td>
                                                        <td><input type="text" class="form-control" id="hosp_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorNumeradorHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" <?php echo($disabled) ?>></td>
                                                        <td><input type="text" class="form-control" id="hosp_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorDenominadorHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" <?php echo($bloquear_denominador) ?>></td>
                                                        <td><input type="text" class="form-control" id="hosp_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorResultadoHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" disabled="disabled"></td>                                            
                                                        <td><input type="text" class="form-control" id="hosp_dt_extracao_regiao<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorExtracaoHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)" <?php echo($disabled) ?>></td>                                                          
                                                    </tr> <?php
                                                    $cod_hosp_qtd += 1;
                                                }
                                                ?>    
                                                <input type="hidden" id="cod_hosp_qtd" value="<?=$cod_hosp_qtd?>" />                                                                                   
                                            </tbody>
                                        </table>                                        
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="table-responsive col-md-12">
                                        <center><b>Hospitais Conveniados</b><center>
                                        <table class="table table-striped" cellspacing="0" cellpadding="0">
                                            <thead>
                                                <tr>
                                                    <th>Região Administrativa</th>
                                                    <th>Numerador:</th>
                                                    <th>Denominador:</th>
                                                    <th>Resultado:</th>                                            
                                                    <th>Data Extração:</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_regiao = "SELECT * FROM tb_hospital WHERE cod_tipo = 2 AND cod_ativo = 1 ORDER BY cod_hospital";
                                                $q = pg_query($sql_regiao);
                                                $cod_hosp_qtd_conv = 11;
                                                while ($rs1 = pg_fetch_array($q)) { 
                                                    $cod_hospital = $rs1['cod_hospital'];
                                                    $txt_hospital = $rs1['txt_hospital'];
                                                    $txt_sigla_hospital = $rs1['txt_sigla_hospital'];
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" id="cod_hospital_conv<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$txt_hospital?>" title="<?=$txt_hospital?>" disabled="disabled">
                                                            <input type="hidden" id="cod_hospital_conv<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$cod_hospital?>" />    
                                                        </td>
                                                        <td><input type="text" class="form-control" id="hosp_cod_numerador_regiao_conv<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorNumeradorHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" <?php echo($disabled) ?>></td>
                                                        <td><input type="text" class="form-control" id="hosp_cod_denominador_regiao_conv<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorDenominadorHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" <?php echo($bloquear_denominador) ?>></td>
                                                        <td><input type="text" class="form-control" id="hosp_cod_resultado_regiao_conv<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorResultadoHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" disabled="disabled"></td>                                            
                                                        <td><input type="text" class="form-control" id="hosp_dt_extracao_regiao_conv<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorExtracaoHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)" <?php echo($disabled) ?>></td>                                                          
                                                    </tr> <?php
                                                    $cod_hosp_qtd_conv += 1;
                                                }
                                                ?>    
                                                <input type="hidden" id="cod_hosp_qtd_conv" value="<?=$cod_hosp_qtd_conv?>" />                                                                                   
                                            </tbody>
                                        </table>                                        
                                    </div> 
                                </div>
                            <?php
                            }
                            ?>                                                                             
                        </div>                        
                    <?php
                        $ct_mes += 1;
                    }                   
                    ?>                    
                </div><!--tab-content-->
            </div><!--col-md-12-->
        </div><!--row-->       
        <div class="row" align="center">
            <br /><br />
            <div class="col-md-12"> 
                <?php if (permissao_acesso_unidade(66, $cod_responsavel_tecnico) || permissao_acesso_unidade(66, $cod_responsavel_tecnico_2)) { ?>                                         
                    <button type="button" id="btn_salvar" class="btn btn-primary" onclick="return ValidarCamposAnalise();" <?php echo($css_periodo) ?>>Salvar</button>
                <?php } ?>
                <a href="indicador.php?cod_eixo=<?=$cod_eixo?>&cod_perspectiva=<?=$cod_perspectiva?>&cod_diretriz=<?=$cod_diretriz?>&cod_objetivo=<?=$cod_objetivo?>" class="btn btn-default">Voltar</a>
            </div><!--col-md-12-->
        </div><!--row-->
    </form>
</div><!--main-->
<script src="manter.js" type="text/javascript"></script>
<script type="text/javascript">    
    $(document).ready(function() {
        <?php if(permissao_acesso(93) && !permissao_acesso(66)) { ?>            
            // PARA HABILITAR OS CAMPOS DO FORMULÁRIO, MUDAR O true PARA false
            $("#frm1 :input").prop("disabled", true); // DESABILITA TODOS OS CAMPOS    
        <?php } ?>
    });    
</script>
<?php
rodape($dbcon);
?>