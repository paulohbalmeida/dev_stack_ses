<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsPerfil.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(50);

if (empty($_REQUEST['log'])) {
	Auditoria(119, "Listar Permissões de Perfis de Usuários", "");
}

$id = $_REQUEST['id'];

$clsPerfil = new clsPerfil();
?>

<div id="main" class="container-fluid">
    <h3 class="page-header">Perfis de Usuários > Permissões</h3>
    <form id="frm1">
        <input type="hidden" name="id" id="id" value="<?=$id?>" />
        <input type="hidden" name="verificado" id="verificado" value="1" />
        <input type="hidden" name="acao" id="acao" value="" />
        <input type="hidden" name="log" id="log" value="1" />
        <div class="row">
            <div class="form-group col-md-12">
                <center><h3><?php echo($clsPerfil->RetornaPerfil($id)) ?></h3></center>
            </div><!--form-group-->
        </div><!--row--> 
        <div class="row">
            <?php
            $sql = "SELECT * FROM tb_modulo_sistema WHERE cod_ativo = 1 AND cod_modulo_superior IS NULL ORDER BY txt_modulo_sistema";
            $q = pg_query($sql);
            while ($rs = pg_fetch_array($q)) 
            { 
                $cod_modulo_sistema = $rs['cod_modulo_sistema'];
                $cod_tipo = $rs['cod_tipo'];
            ?>
                <div class="row">
                    <div class="form-group col-md-12">
                        <h3>Módulo: <strong><?php echo($rs['txt_modulo_sistema']) ?></strong></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12"> 
                        <?php
                        $sql = "SELECT tb_sistema_modulo_acao.*, txt_modulo_sistema_acao FROM tb_sistema_modulo_acao ";
                        $sql .= " INNER JOIN tb_modulo_sistema_acao ON tb_modulo_sistema_acao.cod_modulo_sistema_acao = tb_sistema_modulo_acao.cod_modulo_sistema_acao";
                        $sql .= " WHERE tb_sistema_modulo_acao.cod_modulo_sistema = ".$cod_modulo_sistema." ORDER BY tb_sistema_modulo_acao.cod_chave";
                        $q1 = pg_query($sql);
                        while ($rs1 = pg_fetch_array($q1)) 
                        { 
                            $txt_modulo_sistema_acao = $rs1['txt_modulo_sistema_acao'];
                            $cod_modulo_sistema = $rs1['cod_modulo_sistema'];   
                            $cod_chave = $rs1['cod_chave'];

                            if (empty($cod_modulo_sistema_old)) {
                                $cod_modulo_sistema_old = 0;
                            }

                            $sql = "SELECT * FROM tb_permissao_perfil WHERE cod_perfil = ".$id." AND cod_permissao = ".$cod_chave;
                            $q2 = pg_query($sql);
                            if (pg_num_rows($q2) > 0) {
                                $rs2 = pg_fetch_array($q2);
                                $cod_permissao_perfil = $rs2['cod_permissao'];
                                $checked = "checked";
                            } else {
                                $cod_permissao_perfil = '';
                                $checked = '';                                
                            }
                        
                            if (intval($cod_tipo == 1)) { ?>                                
                                <div class="form-group col-md-2">
                                    <div class="checkbox">
                                        <label><input type="checkbox" id="cod_permissao" name="cod_permissao[]" value="<?php echo($cod_chave) ?>"<?=$checked?>><strong><?php echo($txt_modulo_sistema_acao); ?></strong></label>
                                    </div>                                                                        
                                </div> <?php                                      
                            } else if (intval($cod_tipo == 2)) { ?> 
                                <div class="form-group col-md-2">
                                    <div class="checkbox">
                                        <label><input type="checkbox" id="cod_permissao" name="cod_permissao[]" value="<?php echo($cod_chave) ?>"<?=$checked?>><strong><?php echo($txt_modulo_sistema_acao); ?></strong></label>
                                    </div>                                                                        
                                </div> <?php   
                                $sql = "SELECT * FROM tb_modulo_sistema WHERE cod_ativo = 1 AND cod_modulo_superior = ".$cod_modulo_sistema." ORDER BY txt_modulo_sistema";
                                $q3 = pg_query($sql);                                
                                while ($rs3 = pg_fetch_array($q3)) { 
                                    $cod_modulo_sistema = $rs3['cod_modulo_sistema']; ?>
                                    <div class="table-responsive col-md-12">
                                        <table class="table table-striped" cellspacing="0" cellpadding="0">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <h4>Funcionalidade: <strong><?php echo($rs3['txt_modulo_sistema']) ?></strong></h4>
                                                            </div>
                                                        </div> 
                                                        <?php
                                                        $sql = "SELECT tb_sistema_modulo_acao.*, txt_modulo_sistema_acao FROM tb_sistema_modulo_acao ";
                                                        $sql .= " INNER JOIN tb_modulo_sistema_acao ON tb_modulo_sistema_acao.cod_modulo_sistema_acao = tb_sistema_modulo_acao.cod_modulo_sistema_acao";
                                                        $sql .= " WHERE tb_sistema_modulo_acao.cod_modulo_sistema = ".$cod_modulo_sistema." ORDER BY tb_sistema_modulo_acao.cod_chave";
                                                        $q4 = pg_query($sql);
                                                        $ct = 1;
                                                        while ($rs4 = pg_fetch_array($q4)) {
                                                            $txt_modulo_sistema_acao = $rs4['txt_modulo_sistema_acao'];
                                                            $cod_modulo_sistema = $rs4['cod_modulo_sistema'];   
                                                            $cod_chave = $rs4['cod_chave'];                                        

                                                            $sql = "SELECT * FROM tb_permissao_perfil WHERE cod_perfil = ".$id." AND cod_permissao = ".$cod_chave;
                                                            $q5 = pg_query($sql);
                                                            if (pg_num_rows($q5) > 0) {
                                                                $rs5 = pg_fetch_array($q5);
                                                                $cod_permissao_perfil = $rs5['cod_permissao'];
                                                                $checked = "checked";
                                                            } else {
                                                                $cod_permissao_perfil = '';
                                                                $checked = '';                                
                                                            } 
                                                            
                                                            if ($ct <= 4) { ?>
                                                                <div class="form-group col-md-2">
                                                                    <div class="checkbox">
                                                                        <label><input type="checkbox" id="cod_permissao" name="cod_permissao[]" value="<?php echo($cod_chave) ?>"<?=$checked?>><strong><?php echo($txt_modulo_sistema_acao); ?></strong></label>
                                                                    </div>                                                                        
                                                                </div> <?php

                                                                $ct += 1;
                                                            } 
                                                            else { ?>
                                                                <div class="row">
                                                                    <div class="form-group col-md-2">
                                                                        <div class="checkbox">
                                                                            <label><input type="checkbox" id="cod_permissao" name="cod_permissao[]" value="<?php echo($cod_chave) ?>"<?=$checked?>><strong><?php echo($txt_modulo_sistema_acao); ?></strong></label>
                                                                        </div>                                                                        
                                                                    </div> 
                                                                </div> <?php
                                        
                                                                $ct = 0;
                                                            }                                                                                                                                                                               
                                                        }  ?>
                                                    </th>
                                                </tr>
                                            <thead>
                                        </table>
                                    </div> <?php                                  
                                }
                            }                                                   
                        }
                    ?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div> <br />
        <div class="row">
            <div class="col-md-12">
                <center>
                    <button type="submit" id="btn_salvar_permissao" class="btn btn-primary" onclick="Permissao();">Salvar</button>
                    <a href="default.php" class="btn btn-default">Voltar</a>
                </center>
            </div><!--col-md-12-->
        </div><!--row-->
    </form>
</div>

<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>