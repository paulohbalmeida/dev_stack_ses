<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsOrgao.php");
verifica_seguranca();
cabecalho();

$id = $_REQUEST['id'];
$verificado = $_REQUEST['verificado'];

$clsOrgao = new clsOrgao();

if (empty($verificado) && !empty($id)) {
    permissao_acesso_pagina(55);

    $q1 = pg_query("SELECT * FROM tb_usuario WHERE cod_usuario = '$id'");
	$rs1 = pg_fetch_array($q1);
	$cod_ativo = limpar_comparacao($rs1['cod_ativo']);
	$cod_perfil = $rs1['cod_perfil'];
    $txt_email = $rs1['txt_email'];
    $txt_usuario = $rs1['txt_usuario'];
    $txt_cpf = $rs1['txt_cpf'];
    $txt_login = $rs1['txt_login'];
    $txt_matricula = $rs1['txt_matricula'];
    $cod_cargo = $rs1['cod_cargo'];
    $cod_orgao = $rs1['cod_orgao'];

    $txt_opcao = "Alterar";
}
else {
    permissao_acesso_pagina(54);

    $cod_ativo = $_REQUEST['cod_ativo'];
    $txt_usuario = $_REQUEST['txt_usuario'];   
    $cod_perfil = $_REQUEST['cod_perfil'];
    $txt_cpf = $_REQUEST['txt_cpf'];
    $txt_email = $_REQUEST['txt_email'];   
    $txt_login = $_REQUEST['txt_login'];   
    $txt_matricula = $_REQUEST['txt_matricula'];
    $cod_cargo = $_REQUEST['cod_cargo'];
    $cod_orgao = $_REQUEST['cod_orgao'];
    
    $txt_opcao = "Incluir";

    if(empty($verificado)) {
        $cod_ativo = 1;        
    }
}
?>

<div id="main" class="container-fluid">
    <h3 class="page-header">Usuários > <?php echo($txt_opcao) ?></h3>
    <form id="frm1">
        <input type="hidden" name="id" id="id" value="<?=$id?>" />
        <input type="hidden" name="verificado" id="verificado" value="1" />
        <input type="hidden" name="acao" id="acao" value="" />
        <input type="hidden" name="status" id="status" value="<?=$_REQUEST['status']?>" />
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Login:</label>
                <input type="text" class="form-control" id="txt_login" name="txt_login" value="<?=$txt_login?>" placeholder="Obrigatório">
            </div><!--form-group-->
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">CPF:</label>
                <input type="text" class="cpf form-control" id="txt_cpf" name="txt_cpf" value="<?=$txt_cpf?>" placeholder="Obrigatório">
            </div><!--form-group-->
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Nome:</label>
                <input type="text" class="form-control" id="txt_usuario" name="txt_usuario" value="<?=$txt_usuario?>" placeholder="Obrigatório">
            </div><!--form-group-->
        </div><!--row-->   
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">E-mail:</label>			
                <input type="text" class="form-control" id="txt_email" name="txt_email" value="<?=$txt_email?>" placeholder="Obrigatório">
            </div><!--form-group-->	 
        </div><!--row--> 
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Cargo:</label>			
                <select id="cod_cargo" name="cod_cargo" class="chosen-select" data-placeholder="Obrigatório">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_cargo, txt_cargo FROM tb_cargo WHERE cod_ativo = 1 ORDER BY txt_cargo");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_cargo"]?>"<?php if ($cod_cargo == $row["cod_cargo"]) { echo("selected");}?>><?=$row["txt_cargo"] ?></option>
                        <?php	
                        } ?>
                </select>
            </div><!--form-group-->	 
        </div><!--row-->
        <div class="row">
            <div class="form-group col-md-12">   
                <label for="exampleInputEmail1">Lotação:</label>                            
                <select id="cod_orgao" name="cod_orgao" class="chosen-select" data-placeholder="Obrigatório">
                    <option></option>                            
                    <?php                                                    
                    $sql = "cod_ativo = 1 ORDER BY txt_sigla";
                    $q = $clsOrgao->ListarOrgao($sql);
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_orgao"]?>"<?php if ($cod_orgao == $row["cod_orgao"]) { echo("selected");}?>><?=$row["txt_sigla"] ?></option>
                    <?php	
                    } ?>
                </select>
            </div><!--form-group-->
        </div><!--row-->
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Perfil:</label>			
                <select id="cod_perfil" name="cod_perfil" class="chosen-select" data-placeholder="Obrigatório">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_perfil, txt_perfil FROM tb_perfil WHERE cod_ativo = 1 ORDER BY txt_perfil");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_perfil"]?>"<?php if ($cod_perfil == $row["cod_perfil"]) { echo("selected");}?>><?=$row["txt_perfil"] ?></option>
                        <?php	
                        } ?>
                </select>
            </div><!--form-group-->	 
        </div><!--row-->    	
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Matrícula:</label>
                <input type="text" class="form-control" id="txt_matricula" name="txt_matricula" value="<?=$txt_matricula?>">
            </div><!--form-group-->
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
            </div><!--form-group-->	 
        </div><!--row-->
        <div class="row">
            <div class="col-md-12">
                <?php if(empty($id)) {
                ?>
                    <button type="submit" id="btn_incluir" class="btn btn-primary" onclick="return ValidarIncluir();">Incluir</button>
                <?php
                } 
                else {
                ?>
                    <button type="submit" id="btn_salvar" class="btn btn-primary" onclick="return ValidarAlterar();">Salvar</button>
                <?php
                }
                ?>  	  	
                <a href="default.php" class="btn btn-default">Voltar</a>
            </div><!--col-md-12-->
        </div><!--row-->
    </form>
</div><!--main-->

<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>