<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsIndicador.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(65);

$id = $_REQUEST['id'];
$pagina_voltar = $_REQUEST['pagina_voltar'];

if (isset($pagina_voltar) || empty($pagina_voltar)) {
    $pagina_voltar = $_SERVER['HTTP_REFERER'];
}

$sql = "SELECT * FROM tb_indicador WHERE cod_chave = ".$id;
$rs = pg_fetch_array(pg_query($sql));

//MGI
$clsIndicador = new clsIndicador();
$retorno_array = $clsIndicador->ConsultaIndicador($rs['cod_indicador']);

if (empty($_REQUEST['log'])) {
	Auditoria(78, "Ficha Técnica de Indicador", "");
}
?>

<div id="main" class="container-fluid" style="margin-top: 50px">
    <form id="frm1">
        <input type="hidden" name="log" id="log" value="1" />
        <input type="hidden" name="pagina_voltar" id="pagina_voltar" value="<?=$pagina_voltar?>" />
        <div id="top" class="row">
			<div class="col-sm-12">
				<h2>Indicador > Ficha Técnica</h2>
			</div>			
		</div> <!-- /#top -->
		<br />
        <div class="row">
            <div class="col-md-12">
                <strong>
                    <center>
                        Secretaria de Estado de Saúde do Distrito Federal<br />
                        Subsecretaria de Planejamento em Saúde - SUPLANS<br />
                        FICHA TÉCNICA DE QUALIFICAÇÃO DE INDICADORES E INFORMAÇÕES
                    <center>
                </strong>
            </div><!--col-md-12-->
        </div><!--row-->
        <br />
        <div class="row">
            <div class="table-responsive col-md-12">
                <table class="table table-striped" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>																																										
                            <th>Campo</th>
                            <th>&nbsp;</th>
                            <!--<th><center>Descrição</center></th>-->
                        </tr>                        
                    </thead>
                    <tbody>
                        <tr>
                            <td>Código:</td>
                            <td><?php echo($retorno_array->codigo); ?>&nbsp;</td>
                            <!--<td>Trata-se de uma identificação única para o indicador em questão servindo para fins de rastreabilidade e de referência do indicador pelos sistemas que o consulta.  Pode-se adotar um padrão para esse campo.</td>-->
                        <tr>
                        <tr>
                            <td>Título:</td>
                            <td><?php echo($retorno_array->titulo); ?>&nbsp;</td>
                            <!--<td>trata-se de uma identificação única para o indicador em questão servindo para fins de rastreabilidade e de referência do indicador pelos sistemas que o consulta.  Pode-se adotar um padrão para esse campo.</td>-->
                        <tr>
                        <tr>
                            <td>Descrição:</td>
                            <td><?php echo($retorno_array->descricao); ?>&nbsp;</td>
                            <!--<td>Informação expressando as intenções de dimensionamento (determinado espaço geográfico, no periódo considerado)do indicador</td>-->
                        <tr>
                        <tr>
                            <td>Conceituação:</td>
                            <td><?php echo($retorno_array->conceituacao); ?>&nbsp;</td>
                            <!--<td>Informações que definem o indicador e a forma como ele se expressa, se necessário agregando elementos para a compreensão de seu conteúdo.</td>-->
                        <tr>
                        <tr>
                            <td>Interpretação:</td>
                            <td><?php echo($retorno_array->interpretacao); ?>&nbsp;</td>
                            <!--<td>Explicação sucinta do tipo de informação obtida e seu significado.</td>-->
                        <tr>
                        <tr>
                            <td>Usos:</td>
                            <td><?php echo($retorno_array->usos); ?>&nbsp;</td>
                            <!--<td>Principais finalidades de utilização dos dados a serem consideradas na análise do indicador.</td>-->
                        <tr>
                        <tr>
                            <td>Limitações:</td>
                            <td><?php echo($retorno_array->limitacoes); ?>&nbsp;</td>
                            <!--<td>Fatores que restringem a interpretação do indicador, referentes tanto ao próprio conceito quanto as fontes utilizadas.</td>-->
                        <tr>
                        <tr>
                            <td>Fonte:</td>
                            <td><?php echo($retorno_array->fonte_dados); ?>&nbsp;</td>
                            <!--<td>Arquivos, bases de dados ou sistemas informatizados ou instituições/unidades responsáveis pela produção dos dados utilizados no cálculo do indicador.</td>-->
                        <tr>
                        <tr>
                            <td>Fórmula de Cálculo:</td>
                            <td>&nbsp;</td>
                            <!--<td>Fórmula utilizada para calcular o indicador, definindo o tipo de relação matemática e os elementos que a compõem</td>-->
                        <tr>
                        <tr>
                            <td>Metodologia de Cálculo:</td>
                            <td><?php echo($retorno_array->metodo_calculo); ?>&nbsp;</td>
                            <!--<td>Descritivo da forma que se calcula o indicador</td>-->
                        <tr>
                        <tr>
                            <td>Periodicidade de Atualização:</td>
                            <td><?php echo($retorno_array->PeriodicidadeAtualizacao->descricao); ?>&nbsp;</td>
                            <!--<td>Frequência de atualização do resultado do indicador segundo sua granularidade</td>-->
                        <tr>
                        <tr>
                            <td>Periodicidade de Monitoramento:</td>
                            <td><?php echo($retorno_array->PeriodicidadeMonitoramento->descricao); ?>&nbsp;</td>
                            <!--<td>Frequência de monitoramento do resultado do indicador</td>-->
                        <tr>
                        <tr>
                            <td>Periodicidade de Apuração:</td>
                            <td>&nbsp;</td>
                            <!--<td>Freqûencia de apuração do resultado do indicador na qual o resultado é considerado  concluído para avaliação final</td>-->
                        <tr>
                        <tr>
                            <td>Unidade de Medida:</td>
                            <td><?php echo($retorno_array->UnidadeMedida->descricao); ?>&nbsp;</td>
                            <!--<td>A unidade de medida utilizada para a apresentação do indicador.</td>-->
                        <tr>
                        <tr>
                            <td>Parâmetro:</td>
                            <td><?php echo($retorno_array->parametro); ?>&nbsp;</td>
                            <!--<td>Valor de referência nacional ou internacional para o indicador</td>-->
                        <tr>
                        <tr>
                            <td>Fonte do Parâmetro:</td>
                            <td><?php echo($retorno_array->ParametroFonteCodigo); ?>&nbsp;</td>
                            <!--<td>Fonte do parâmetro (se especificado)</td>-->
                        <tr>
                        <tr>
                            <td>Polaridade:</td>
                            <td><?php echo($retorno_array->Polaridade->descricao); ?>&nbsp;</td>
                            <!--<td>Indica o sentido do indicador. Ex.: quanto maior melhor, quanto menor, melhor</td>-->
                        <tr>
                        <tr>
                            <td>Visibilidade:</td>
                            <td>&nbsp;</td>
                            <!--<td>Indica se a visibilidade  do indicador é pública ou privada (nessa última a visualização do resultado do indicador é restrita aos gestores credenciados ).</td>-->
                        <tr>
                        <tr>
                            <td>Indicador Acumulativo:</td>
                            <td>
                                <?php 
                                if ($retorno_array->acumulativo) {
                                    echo("SIM");
                                } else {
                                    echo("NÃO");
                                }
                                ?>&nbsp;
                            </td>
                            <!--<td>o resultado do Indicador demonstra o somatório de ocorrências ao longo do período de tempo de sua atualização.</td>-->
                        <tr>
                        <tr>
                            <td>Estratificação:</td>
                            <td>&nbsp;</td>
                            <!--<td>Recorte espacial/territorial de referência do indicador  (Distrital, Região de Saúde,  por RA, por CNES)</td>-->
                        <tr>
                        <tr>
                            <td>Critérios de Análise:</td>
                            <td>&nbsp;</td>
                            <!--<td>Referem-se às possíveis desagregações que os dados têm nas suas bases(ex.: faixa etária, sexo, raça/cor).</td>-->
                        <tr>
                        <tr>
                            <td>Indicador Relacionado/Referências:</td>
                            <td>
                                <?php
                                $array = $retorno_array->IndicadoresRelacionados; 
                                if ($array != NULL) { 
                                    $size = count($array);                                
                                    for ($i = 0; $i < $size; $i++) {
                                        $titulo .= "[".$array[$i]->titulo."]";
                                    }
                                    $titulo = str_replace("][", "<br />", $titulo);
                                    $titulo = str_replace("]", "", $titulo);
                                    $titulo = str_replace("[", "", $titulo);
    
                                    echo($titulo);
                                }                                                               
                                ?>
                                &nbsp;
                            </td>
                            <!--<td>Relações com outros indicadores</td>-->
                        <tr>
                        <tr>
                            <td>Observações/Comentários:</td>
                            <td>&nbsp;</td>
                            <!--<td>Informação adicional sobre o indicador</td>-->
                        <tr>
                        <tr>
                            <td>Área Responsável Técnica na ADMC:</td>
                            <td>
                                <?php  
                                $array = $retorno_array->ResponsavelTecnico[0]->ancestors;                                
                                if ($array != NULL) {                                    
                                    $size = count($array) - 1;
                                    for ($i = $size; $i >= 0; $i--) {
                                        $sigla_tec .= "[".$array[$i]->sigla."]";
                                    }       
                                    $sigla_tec .= "[".$retorno_array->ResponsavelTecnico[0]->sigla."]";  
    
                                    $sigla_tec = str_replace("][", "/", $sigla_tec);
                                    $sigla_tec = str_replace("]", "", $sigla_tec);
                                    $sigla_tec = str_replace("[", "", $sigla_tec);
    
                                    echo($sigla_tec);    
                                }                                                                                                                                                   
                                ?>&nbsp;
                            </td>
                            <!--<td>Responsável técnico pelo indicador na ADMC</td>-->
                        <tr>
                        <tr>
                            <td>Área Responsável Gerencial na ADMC:</td>
                            <td>
                                <?php   
                                $array = $retorno_array->ResponsavelGerencial[0]->ancestors;
                                if ($array != NULL) {                                    
                                    $size = count($array) - 1;
                                    for ($i = $size; $i >= 0; $i--) {
                                        $sigla_ger .= "[".$array[$i]->sigla."]";
                                    }     
                                    $sigla_ger .= "[".$retorno_array->ResponsavelGerencial[0]->sigla."]";

                                    $sigla_ger = str_replace("][", "/", $sigla_ger);
                                    $sigla_ger = str_replace("]", "", $sigla_ger);
                                    $sigla_ger = str_replace("[", "", $sigla_ger);
                                                                
                                    echo($sigla_ger);
                                }                             
                                ?>&nbsp;
                            </td>
                            <!--<td>Responsável pelo monitoramento do indicador na ADMC</td>-->
                        <tr>
                        <tr>
                            <td>Área Responsável Técnica na Região:</td>
                            <td><?php echo($sigla_tec); ?>&nbsp;</td>
                            <!--<td>Responsável técnico pelo indicador na Região</td>-->
                        <tr>
                        <tr>
                            <td>Área Responsável Gerencial na Região:</td>
                            <td><?php echo($sigla_ger); ?>&nbsp;</td>
                            <!--<td>Responsável pelo monitoramento do indicador na Região</td>-->
                        <tr>
                    </tbody>
                </table>
            </div><!--table-responsive col-md-12-->
        </div><!--row-->
        <br />           
        <div class="row">
            <div class="col-md-12">  
                <center>
                    <!--<button type="button" id="btn_exportar_pdf" class="btn btn-primary">Exportar PDF</button>
                    <button type="button" id="btn_exportar_excel" class="btn btn-primary">Exportar Excel</button>-->
                    <a href="#" class="btn btn-default" onclick="Voltar();">Voltar</a>
                </center>
            </div><!--col-md-12--> 
        </div><!--row--> 
    </form>
</div><!--main-->
<script>
    function Voltar() {        
        var url = $('#pagina_voltar').val();        
        self.location.href = url;
    }
</script>
<?php
rodape($dbcon);
?>