<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsPas.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(72);

if (empty($_REQUEST['log'])) {
	Auditoria(100, "Listar Controle PAS", "");
}

$clsPas = new clsPas();

if($clsPas->RegraPeriodo()) {
    $css_periodo = "";
} else {
    $css_periodo = "disabled";
}

$verificado = $_REQUEST['verificado'];
$id = $_REQUEST['id'];
$cod_objetivo_url = $_REQUEST['cod_objetivo_url'];
$cod_controle = $_REQUEST['cod_controle'];
$cod_autorizar = $_REQUEST['cod_autorizar'];
$cod_inicio_previsto = $_REQUEST['cod_inicio_previsto'];
$cod_fim_previsto = $_REQUEST['cod_fim_previsto'];

$sql = "SELECT tb_pas.*, codigo_eixo, txt_eixo, codigo_perspectiva, txt_perspectiva, codigo_diretriz, txt_diretriz, ";
$sql .= " codigo_objetivo, txt_objetivo, codigo_objetivo_ppa, txt_objetivo_ppa ";
$sql .= " FROM tb_pas INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_pas.cod_objetivo ";
$sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo ";
$sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva ";
$sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz ";
$sql .= " INNER JOIN tb_objetivo_ppa ON tb_objetivo_ppa.cod_objetivo_ppa = tb_pas.cod_objetivo_ppa ";
$sql .= " WHERE cod_pas = ".$id;

$q = pg_query($sql);
$rs1 = pg_fetch_array($q);

?>

<div id="main" class="container-fluid">
    <h3 class="page-header">PAS > Controle</h3>
    <h3><?php echo($rs1['codigo_eixo']) ?> - <?php echo($rs1['txt_eixo']) ?></h3>
    &nbsp;&nbsp;<strong><?php echo($rs1['codigo_perspectiva']) ?> - <?php echo($rs1['txt_perspectiva']);?></strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($rs1['codigo_diretriz']) ?> - <?php echo($rs1['txt_diretriz']);?></strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($rs1['codigo_objetivo']) ?> - <?php echo($rs1['txt_objetivo']);?></strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo($rs1['codigo_objetivo_ppa']);?> - <?php echo($rs1['txt_objetivo_ppa']);?></strong>
    <br /><br />
    <h4>
        <b>Ação PAS:</b>         
        <?php echo($rs1['codigo_acao']) ?> - <?php echo($rs1['txt_acao']) ?>    
    </h4>
    <br />
    <form id="frm1">
        <input type="hidden" name="log" id="log" value="1" />
        <input type="hidden" name="verificado" id="verificado" value="1" />
        <input type="hidden" name="acao" id="acao" value="controle" />
        <input type="hidden" name="id" id="id" value="<?php echo($id) ?>" />
        <input type="hidden" name="cod_objetivo_url" id="cod_objetivo_url" value="<?php echo($cod_objetivo_url) ?>" />        
        <?php
        $sql = "SELECT txt_justificativa, cod_controle, cod_autorizar, cod_inicio_previsto, cod_fim_previsto FROM tb_pas_controle_historico ";
        $sql .= " INNER JOIN tb_pas ON tb_pas.cod_pas = tb_pas_controle_historico.cod_pas WHERE tb_pas.cod_pas = ".$id;        
        $q1 = pg_query($sql);
        if (pg_num_rows($q1) > 0) {
            $rs = pg_fetch_array($q1);

            if (empty($verificado) && empty($cod_controle)) {
                $cod_controle = $rs['cod_controle'];
            }            
            $txt_justificativa = $rs['txt_justificativa'];  
            $cod_autorizar = $rs['cod_autorizar'];   
            $cod_inicio_previsto = $rs['cod_inicio_previsto'];   
            $cod_fim_previsto = $rs['cod_fim_previsto'];   
        }        
        ?>
        <div class="row">
            <div class="col-md-12">
                <label for="exampleInputEmail1">Controle:</label>
                <select id="cod_controle" name="cod_controle" class="form-control" onchange="frm1.submit();">                        
                    <?php                        
                    $q = pg_query("SELECT * FROM tb_pas_controle WHERE cod_ativo = 1 ORDER BY txt_controle");
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_controle"]?>"<?php if ($cod_controle == $row["cod_controle"]) { echo("selected");}?>><?=$row["txt_controle"] ?></option>
                    <?php	
                    } ?>	
                </select>     
            </div>
        </div> 
        <br />
        <div class="row">
            <div class="col-md-12">
                <label for="exampleInputEmail1">Justificativa:</label>
                <textarea class="form-control" rows="5" id="txt_justificativa" name="txt_justificativa"><?=$txt_justificativa?></textarea>
            </div>
        </div>
        <?php 
        if (strval($cod_controle) == '2') { ?>
            <br />
            <div class="row">
                <div class="col-md-12">
                    <label for="exampleInputEmail1">Autorizar:</label>
                    <select id="cod_autorizar" name="cod_autorizar" class="form-control">
                        <option value="1" <?php
                                            if ($cod_autorizar == 1) {
                                                echo("selected");
                                            }
                                            ?>>SIM</option>			
                        <option value="0"<?php
                                            if ($cod_autorizar == 0) {
                                                echo("selected");
                                            }
                                            ?>>NÃO</option>
                    </select>
                </div>
            </div>
        <?php
        } else if (strval($cod_controle) == '3' || strval($cod_controle) == '4') { ?>
            <br />
            <div class="row">
                <div class="col-md-6">
                    <label for="exampleInputEmail1">Início Previsto:</label>
                    <select id="cod_inicio_previsto" name="cod_inicio_previsto" class="form-control">                                               
                        <?php                                                                                            
                        $q = pg_query("SELECT cod_mes, txt_mes FROM tb_pas_mes ORDER BY cod_mes");
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
                        <?php                                                                                            
                        $q = pg_query("SELECT cod_mes, txt_mes FROM tb_pas_mes ORDER BY cod_mes");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_mes"]?>"<?php if ($cod_fim_previsto == $row["cod_mes"]) { echo("selected");}?>><?=$row["txt_mes"] ?></option>                                                                                    
                        <?php	
                        } ?>
                    </select>  
                </div>
            </div>
        <?php
        }
        ?>
        <br />        
        <div class="row">
            <div class="col-md-12">       
                <button type="submit" id="btn_incluir" class="btn btn-primary" onclick="return ValidarSalvar();" <?php echo($css_periodo) ?>>Salvar</button>         
                <a href="default.php?cod_objetivo_url=<?php echo($cod_objetivo_url) ?>" class="btn btn-default">Voltar</a>
            </div><!--col-md-12--> 
        </div><!--row--> 
    </form>
</div>
<script src="manter_controle.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>