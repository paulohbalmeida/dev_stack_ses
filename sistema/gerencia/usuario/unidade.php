<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsUsuario.php");
include_once (__DIR__ . "/../../classes/clsOrgao.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(57);

$id = $_REQUEST['id'];

if (empty($id)) {
    js_go_back("Usuário não encontrado.");
}
$clsUsuario = new clsUsuario();
$clsOrgao = new clsOrgao();
?>
<div id="main" class="container-fluid">
    <h3 class="page-header">Usuários > Unidades</h3>
    <form id="frm1">
        <input type="hidden" name="id" id="id" value="<?=$id?>" />
        <input type="hidden" name="acao" id="acao" value="" />
        <div class="row">
            <div class="form-group col-md-12">                
                <center><b><?php echo($clsUsuario->ConsultaUsuarioId($id)) ?></b><center>
            </div><!--form-group-->
            <div class="row">
                <div class="form-group col-md-12">                
                    <center>                        
                        <?php                        
                        $sql = "cod_ativo = 1 AND cod_orgao NOT IN(SELECT t1.cod_orgao FROM tb_usuario_orgao t1 WHERE t1.cod_usuario = ".$id.") ORDER BY txt_sigla";
                        $q = $clsOrgao->ListarOrgao($sql);
                        ?>
                        <select id="cod_orgao" name="cod_orgao" class="chosen-select" data-placeholder="Unidade">
                            <option></option>                            
                            <?php                                                    
                            while ($row = pg_fetch_array($q)) 
                            { ?>
                                <option value="<?=$row["cod_orgao"]?>"><?=$row["txt_sigla"] ?></option>
                            <?php	
                            } ?>
                        </select>
                    <center>
                </div><!--form-group-->
                <div class="form-group col-md-12">                
                    <center>                      
                    <button type="submit" id="btn_incluir" class="btn btn-primary" onclick="return ValidarIncluirUnidade();">Incluir</button>
                    <a href="default.php" class="btn btn-default">Voltar</a>
                    <center>
                </div><!--form-group-->
            </div>
            <div class="row">
                <div class="tab-content">
                    <?php
                    $sql = "SELECT tb_usuario_orgao.*, txt_sigla FROM tb_usuario_orgao "; 
                    $sql .=  " INNER JOIN tb_usuario ON tb_usuario.cod_usuario = tb_usuario_orgao.cod_usuario ";
                    $sql .=  " INNER JOIN tb_orgao ON tb_orgao.cod_orgao = tb_usuario_orgao.cod_orgao ";
                    $sql .= " WHERE tb_usuario_orgao.cod_usuario = " .$id. " ORDER BY txt_sigla";

                    $q1 = pg_query($sql);
                    if (pg_num_rows($q1) > 0) { ?>
                        <div class="table-responsive col-md-12">                                
                            <table class="table table-striped" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>                                                                                  
                                        <th>UNIDADE</th>                            
                                        <th></th>
                                    </tr>                                        
                                </thead>
                                <tbody>
                                    <?php												
                                    while ($rs1 = pg_fetch_array($q1)) {
                                    ?>
                                        <tr>
                                            <td><?php echo($rs1["txt_sigla"]) ?></td>
                                            <td class="actions">
                                                <a class="btn btn-danger btn-xs" onclick="return ExcluirUnidade(<?php echo($id) ?>, <?php echo($rs1["cod_orgao"]) ?>);" >Excluir</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>            
                    <?php 
                    } else {
                        ?>
                            <hr>
                            <center><h4>NÃO EXISTEM REGISTROS CADASTRADOS.</h4></center>
                    <?php
                    } ?>                    
                </div><!--tab-content-->            
            </div><!--row-->            
        </div>
    </form>
</div>
<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>