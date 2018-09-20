<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsUsuario.php");
include_once (__DIR__ . "/../classes/clsPas.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(83);

if (empty($_REQUEST['log'])) {
	Auditoria(85, "Listar PAS", "");
}

$cod_pas = $_REQUEST['cod_pas'];
$cod_objetivo_url = $_REQUEST['cod_objetivo_url'];

$sql = "SELECT tb_pas.*, codigo_eixo, txt_eixo, codigo_perspectiva, txt_perspectiva, codigo_diretriz, txt_diretriz, ";
$sql .= " codigo_objetivo, txt_objetivo, codigo_objetivo_ppa, txt_objetivo_ppa ";
$sql .= " FROM tb_pas INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_pas.cod_objetivo ";
$sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo ";
$sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva ";
$sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz ";
$sql .= " INNER JOIN tb_objetivo_ppa ON tb_objetivo_ppa.cod_objetivo_ppa = tb_pas.cod_objetivo_ppa ";
$sql .= " WHERE cod_pas = ".$cod_pas;

$q = pg_query($sql);
$rsAcao = pg_fetch_array($q);

$clsUsuario = new clsUsuario();
$clsPas = new clsPas();

if($clsPas->RegraPeriodo()) {
    $css_periodo = "";
} else {
    $css_periodo = "disabled";
}
?>

<div id="main" class="container-fluid">
    <h3 class="page-header">PAS > Análise</h3>
    <h3><?php echo($rsAcao['codigo_eixo']) ?> - <?php echo($rsAcao['txt_eixo']) ?></h3>
    &nbsp;&nbsp;<strong><?php echo($rsAcao['codigo_perspectiva']) ?> - <?php echo($rsAcao['txt_perspectiva']);?></strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($rsAcao['codigo_diretriz']) ?> - <?php echo($rsAcao['txt_diretriz']);?></strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($rsAcao['codigo_objetivo']) ?> - <?php echo($rsAcao['txt_objetivo']);?></strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($rsAcao['codigo_objetivo_ppa']);?> - <?php echo($rsAcao['txt_objetivo_ppa']);?></strong>
    <br /><br />
    <h4>
        <b>Ação PAS:</b>         
        <?php echo($rsAcao['codigo_acao']) ?> - <?php echo($rsAcao['txt_acao']) ?>    
    </h4>
    <br />
    <form id="frm1"> 
        <input type="hidden" name="log" id="log" value="1" />
        <input type="hidden" name="acao" id="acao" value="" />
        <input type="hidden" name="cod_pas" id="cod_pas" value="<?=$cod_pas?>" />
        <input type="hidden" name="cod_bimestre" id="cod_bimestre"  />       
        <div class="row">&nbsp;</div>
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
                    if ($rs1['cod_mes'] == 1) {
                        $css = "tab-pane fade in active";
                    } else {
                        $css = "tab-pane fade";
                    }   
                    
                    $sql = "SELECT * FROM tb_pas_analise WHERE cod_pas = ".$cod_pas." AND cod_bimestre = ".$rs1['cod_mes'];
                    $q3 = pg_query($sql);
                    if (pg_num_rows($q3) > 0) {
                        $rs3 = pg_fetch_array($q3);
                        $txt_justificativa = $rs3['txt_justificativa'];
                        $cod_usuario_analise = $rs3['cod_usuario'];
                    }     
                    else {
                        $txt_justificativa = '';    
                    }                                   
                ?>                 
                    <div id="menu<?=$rs1['cod_mes']?>" class="<?=$css?>"> 
                        <div class="row">
                            <div class="col-md-12">
                                <label for="exampleInputEmail1">Justificativa:</label>
                                <textarea class="form-control" rows="5" id="txt_justificativa<?=$rs1['cod_mes']?>" name="txt_justificativa<?=$rs1['cod_mes']?>"><?=$txt_justificativa?></textarea>
                            </div>
                        </div><br />
                        <div class="row">
                            <div class="col-md-12">
                                <label for="exampleInputEmail1">Registrado Por:</label>
                                <?php echo($clsUsuario->ConsultaUsuarioId($cod_usuario_analise)) ?>
                            </div>
                        </div>
                    </div>
                <?php                    
                }

                ?>
            </div>                 
        </div><!--row-->         
        <div class="row" align="center">
            <br /><br />
            <div class="col-md-12">
                <?php if (permissao_acesso_unidade(83, $rsAcao['cod_orgao'])) { ?>
                    <button type="button" id="btn_analise" class="btn btn-primary" onclick="return ValidarSalvar();" <?php echo($css_periodo) ?>>Salvar</button>
                <?php
                } ?>
                <a href="default.php?cod_objetivo_url=<?php echo($cod_objetivo_url) ?>" class="btn btn-default">Voltar</a>
            </div><!--col-md-12-->
        </div><!--row-->
    </form>
</div><!--main-->
<script src="manter_consideracao.js" type="text/javascript"></script>

<script type="text/javascript">
    if ($('#cod_bimestre').val() == '') {
        $('#cod_bimestre').val(1);
    }
</script>
<?php
rodape($dbcon);
?>