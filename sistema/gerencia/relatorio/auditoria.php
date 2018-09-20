<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../include/auditoria.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(58);

if (empty($_REQUEST['log'])) {
	Auditoria(41, "Acessar Relatório de Auditoria", "");
}

$cod_usuario = $_REQUEST['cod_usuario'];
$cod_modulo_auditoria = $_REQUEST['cod_modulo_auditoria'];
$cod_acao_auditoria = $_REQUEST['cod_acao_auditoria'];
$dt_inicio = $_REQUEST['dt_inicio'];
$dt_fim = $_REQUEST['dt_fim'];
$acao = $_REQUEST['acao'];
$cod_orgao = $_REQUEST['cod_orgao'];

?>
<script>
	jQuery(function($) {
		$('#dtBasicExample').DataTable();
	});
</script>
<div id="main" class="container-fluid">
    <h3 class="page-header">Relatórios > Auditoria</h3>
    <form id="frm1">
        <input type="hidden" name="log" id="log" value="1" />
        <div align="center">
            <div class="row">
                <div class="col-md-6">                                                           
                    <label for="exampleInputEmail1">Data Início:</label> 
                    <div class="form-group">
                        <div class='input-group date'>
                            <input type="text" class="form-control" id="dt_inicio" name='dt_inicio' autocomplete="off" value="<?=$dt_inicio?>" placeholder='DD/MM/AAAA' onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>  
                        </div>                                           
                    </div>                    
                </div>
                <div class="col-md-6">
                    <label for="exampleInputEmail1">Data Fim:</label>
                    <div class="form-group">
                        <div class='input-group date' >
                            <input type='text' class="form-control" id='dt_fim' name='dt_fim' autocomplete="off" value="<?=$dt_fim?>" placeholder='DD/MM/AAAA' onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div> 
            </div>                 
            <br />
            <div class="row">
                <div class="col-md-6">
                    <label for="exampleInputEmail1">Módulo:</label>
                    <select id="cod_modulo_auditoria" name="cod_modulo_auditoria" class="chosen-select" data-placeholder="Módulo" onchange="frm1.submit();">
                        <option></option>    
                        <?php                        
                        $q = pg_query("SELECT cod_modulo_auditoria, txt_modulo_auditoria FROM tb_auditoria_modulo WHERE cod_ativo = 1 ORDER BY txt_modulo_auditoria");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_modulo_auditoria"]?>"<?php if ($cod_modulo_auditoria == $row["cod_modulo_auditoria"]) { echo("selected");}?>><?=$row["txt_modulo_auditoria"] ?></option>
                        <?php	
                        } ?>                    
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="exampleInputEmail1">Ação:</label>
                    <select id="cod_acao_auditoria" name="cod_acao_auditoria" class="chosen-select" data-placeholder="Ação">
                        <option></option>   
                        <?php 
                        if (!empty($cod_modulo_auditoria)) {
                            $condicao_auditoria = " AND cod_modulo_auditoria = ". $cod_modulo_auditoria;
                        }
                        
                        $q = pg_query("SELECT cod_acao_auditoria, txt_acao_auditoria FROM tb_auditoria_acao WHERE cod_ativo = 1 ".$condicao_auditoria ." ORDER BY txt_acao_auditoria");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_acao_auditoria"]?>"<?php if ($cod_acao_auditoria == $row["cod_acao_auditoria"]) { echo("selected");}?>><?=$row["txt_acao_auditoria"] ?></option>
                        <?php	
                        } ?>                       
                    </select>
                </div>
            </div>  
            <br />
            <div class="row">
                <div class="col-md-6">
                    <label for="exampleInputEmail1">Usuário:</label>
                    <select id="cod_usuario" name="cod_usuario" class="chosen-select" data-placeholder="Usuário">
                        <option></option>    
                        <?php                        
                        $q = pg_query("SELECT cod_usuario, txt_usuario FROM tb_usuario WHERE cod_ativo = 1 ORDER BY txt_usuario");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_usuario"]?>"<?php if ($cod_usuario == $row["cod_usuario"]) { echo("selected");}?>><?=$row["txt_usuario"] ?></option>
                        <?php	
                        } ?>                    
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="exampleInputEmail1">Unidade:</label>
                    <select id="cod_orgao" name="cod_orgao" class="chosen-select" data-placeholder="Unidade">
                        <option></option>    
                        <?php                        
                        $q = pg_query("SELECT cod_orgao, txt_sigla FROM tb_orgao WHERE cod_ativo = 1 ORDER BY txt_sigla");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_orgao"]?>"<?php if ($cod_orgao == $row["cod_orgao"]) { echo("selected");}?>><?=$row["txt_sigla"] ?></option>
                        <?php	
                        } ?>                    
                    </select>
                </div>
            </div>             
            <br />
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" id="btn_pesquisar" name="acao" value="pesquisar" class="btn btn-primary">Pesquisar</button>
                    <a href="auditoria.php" class="btn btn-default">Limpar</a>
                </div><!--col-md-12-->
            </div><!--row-->                        
        </div>
        <?php 
        if (strtolower($acao) == "pesquisar") { ?>
            <hr />	
            <div id="list" class="row">
                <?php          	
                $condicao = "1 = 1 ";

                if(!empty($cod_modulo_auditoria)) {
                    $condicao .= " AND tb_auditoria_acao.cod_modulo_auditoria = ".$cod_modulo_auditoria;
                }
                if(!empty($cod_acao_auditoria)) {
                    $condicao .= " AND tb_auditoria.cod_acao_auditoria = ".$cod_acao_auditoria;
                }
                if(!empty($dt_inicio)) {
                    $condicao .= " AND tb_auditoria.dt_auditoria >= '".DataBanco($dt_inicio)."'";
                }
                if(!empty($dt_fim)) {
                    $condicao .= " AND tb_auditoria.dt_auditoria <= '".DataBanco($dt_fim)." 23:59:59'";
                }
                if(!empty($cod_usuario)) {
                    $condicao .= " AND tb_auditoria.cod_usuario = ".$cod_usuario;
                }
                if(!empty($cod_orgao)) {
                    $condicao .= " AND tb_auditoria.cod_orgao = ".$cod_orgao;
                }

                $sql = " SELECT tb_auditoria.txt_historico, tb_auditoria.txt_sql, TO_CHAR(tb_auditoria.dt_auditoria, 'DD/MM/YYYY HH24:MI:SS') AS dt_auditoria, ";
                $sql .= " txt_acao_auditoria, txt_usuario, txt_sigla, txt_modulo_auditoria ";
                $sql .= " FROM tb_auditoria ";
                $sql .= " INNER JOIN tb_auditoria_acao ON tb_auditoria_acao.cod_acao_auditoria = tb_auditoria.cod_acao_auditoria ";
                $sql .= " INNER JOIN tb_auditoria_modulo ON tb_auditoria_modulo.cod_modulo_auditoria = tb_auditoria_acao.cod_modulo_auditoria ";
                $sql .= " INNER JOIN tb_usuario ON tb_usuario.cod_usuario = tb_auditoria.cod_usuario ";
                $sql .= " INNER JOIN tb_orgao ON tb_orgao.cod_orgao = tb_auditoria.cod_orgao ";
                $sql .= " WHERE ".$condicao." ORDER BY tb_auditoria.dt_auditoria DESC ";	
                //echo($sql);                
                $q1 = pg_query($sql);
                if (pg_num_rows($q1) > 0) {
                ?>
                    <div class="table-responsive col-md-12">
                        <table id="dtBasicExample" class="table table-striped" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th>Módulo</th>
                                    <th>Ação</th>
                                    <th>Usuário</th>
                                    <th>Data</th>
                                    <th>Unidade</th>								
                                    <th>Descrição</th>
                                    <?php if(strval($_SESSION["cod_perfil"]) == '1') { ?>
                                        <th>SQL</th>								
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php												
                                while ($rs1 = pg_fetch_array($q1)) {
                                    $txt_acao_auditoria = $rs1['txt_acao_auditoria'];
                                    $txt_usuario = $rs1['txt_usuario'];
                                    $txt_sigla = $rs1['txt_sigla'];
                                    $txt_historico = $rs1['txt_historico'];
                                    $txt_sql = $rs1['txt_sql'];
                                    $txt_modulo_auditoria = $rs1['txt_modulo_auditoria'];
                                    $dt_auditoria = $rs1['dt_auditoria'];                                    
                                ?>
                                    <tr>
                                        <td><?php echo($txt_modulo_auditoria) ?></td>
                                        <td><?php echo($txt_acao_auditoria) ?></td>				
                                        <td><?php echo($txt_usuario) ?></td>					
                                        <td><?php echo($dt_auditoria) ?></td>
                                        <td><?php echo($txt_sigla) ?></td>
                                        <td><?php echo($txt_historico) ?></td>
                                        <?php if(strval($_SESSION["cod_perfil"]) == '1') { ?>
                                            <td><?php echo($txt_sql) ?></td>
                                        <?php } ?>
                                    </tr>		
                                <?php
                                }
                                ?>											
                            </tbody>
                        </table>
                    </div><!-- #table-responsive -->					
                <?php
                }
                else {
                ?>
                    <hr>
                    <center><h4>NÃO EXISTEM REGISTROS CADASTRADOS.</h4></center>
                <?php
                }
                ?>	
            </div><!-- #list --> <?php
        } ?>        
    </form>
</div>

<?php
rodape($dbcon);
?>

<script type="text/javascript">
  $( function() {
    $( "#dt_inicio" ).datepicker();
    $( "#dt_fim" ).datepicker();
  });
</script>