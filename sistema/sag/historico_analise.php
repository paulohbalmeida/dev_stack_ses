<?php
include_once (__DIR__ . "/../include/conexao.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(82);

$id = $_REQUEST['id'];

$clsUsuario = new clsUsuario();

if (empty($_REQUEST['log'])) {
	Auditoria(127, "Histórico de Análise SAG", "");
}
?>
<div id="main" class="container-fluid" style="margin-top: 50px">
    <form id="frm1">
        <input type="hidden" name="log" id="log" value="1" />
        <input type="hidden" name="id" id="id" value="<?=$id?>" />

         <div id="top" class="row">
			<div class="col-sm-12">
				<h2>SAG > Análise > Histórico</h2>
			</div>			
		</div> <!-- /#top -->
		<br />
        <div class="row">
            <div class="col-md-12">
                <?php 
                $sql = "SELECT * FROM tb_sag_analise_historico WHERE cod_sag = ".$id;
                $q1 = pg_query($sql);
                if (pg_num_rows($q1) > 0) { ?>
                     <div class="table-responsive col-md-12"> 
                        <?php
                        $ct = 1;
                        while($ct <= 6) {                             
                            $sql = "SELECT * FROM tb_sag_analise_historico WHERE cod_sag = ".$id;
                            $sql .= " AND cod_bimestre = ".$ct." ORDER BY dt_inclusao DESC";
                            $q = pg_query($sql);
                            if (pg_num_rows($q) > 0) {                                 
                            ?>
                                <table class="table table-striped" cellspacing="0" cellpadding="0"> 
                                    <thead>
                                        <tr>                                                                                  
                                            <th><?php echo(RetornaTextoMesPAS($ct)) ?></th>                                                                                      
                                        </tr>                                                                   
                                    </thead>         
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table class="table table-striped" cellspacing="0" cellpadding="0"> 
                                                    <thead>
                                                        <tr>                                                                                  
                                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Realizado</th>                                                                                                                      
                                                            <th>Análise</th>
                                                            <th>Situação</th>
                                                            <th>Controle</th>
                                                            <th>Registrado Por</th>
                                                            <th>Causa do Desvio</th>
                                                            <th>Natureza do Desvio</th>
                                                            <th>Análise/Justificativa</th>
                                                            <th>Realizado Obra</th>
                                                            <th>Percentual Realizado(%) Obra</th>
                                                            <th>Análise Obra</th>
                                                        </tr>                                                       
                                                    </thead>   
                                                    <tbody>
                                                        <?php                                                
                                                        while($rs = pg_fetch_array($q)) { 
                                                            $txt_justificativa = $rs['txt_justificativa'];                                                          
                                                            $cod_usuario = $clsUsuario->ConsultaUsuarioId($rs['cod_usuario']);
                                                            $nr_mes_1 = $rs['nr_mes_1'];
                                                            $nr_mes_2 = $rs['nr_mes_2'];
                                                            $txt_analise = $rs['txt_analise'];
                                                            $txt_analise_desvio = $rs['txt_analise_desvio'];
                                                            $txt_realizado_1 = $rs['txt_realizado_1'];
                                                            $txt_percentual = $rs['cod_percentual'];
                                                            $txt_analise_obra = $rs['txt_analise_obra'];
                                                                                                                          
                                                            if (!empty($rs['cod_situacao'])) {
                                                                $row = pg_fetch_array(pg_query("SELECT txt_situacao FROM tb_sag_situacao_analise WHERE cod_situacao = ".$rs['cod_situacao']));
                                                                $txt_situacao = $row["txt_situacao"]; 
                                                            }                                                                                                                      
                                                            
                                                            if (!empty($rs['cod_controle'])) {
                                                                $row = pg_fetch_array(pg_query("SELECT txt_controle FROM tb_sag_controle_analise WHERE cod_controle = ".$rs['cod_controle']));
                                                                $txt_controle = $row["txt_controle"];
                                                            }                                                            

                                                            if (!empty($rs['cod_causa_desvio'])) {
                                                                $row = pg_fetch_array(pg_query("SELECT txt_causa FROM tb_sag_causa_desvio WHERE cod_causa = ".$rs['cod_causa_desvio']));
                                                                $txt_causa = $row["txt_causa"];
                                                            }
                                                            
                                                            if (!empty($rs['cod_natureza_desvio'])) {
                                                                $row = pg_fetch_array(pg_query("SELECT txt_natureza FROM tb_sag_natureza_desvio WHERE cod_natureza = ".$rs['cod_natureza_desvio']));
                                                                $txt_natureza = $row["txt_natureza"];
                                                            }
                                                            
                                                            ?>
                                                            <tr>                  
                                                                <td>
                                                                    <div class="col-md-3">                                                                          
                                                                        <?=$nr_mes_1?>
                                                                    </div>                  
                                                                    <div class="col-md-1"></div>                              
                                                                    <div class="col-md-2">                                                                         
                                                                        <?=$nr_mes_2?>
                                                                    </div>
                                                                </td>                                                                
                                                                <td><?=$txt_analise?></td>
                                                                <td><?=$txt_situacao?></td>
                                                                <td><?=$txt_controle?></td>                                                               
                                                                <td><?=$cod_usuario?></td>
                                                                <td><?=$txt_causa ?></td>
                                                                <td><?=$txt_natureza ?></td>
                                                                <td><?=$txt_analise_desvio?></td>
                                                                <td><?=$txt_realizado_1?></td>
                                                                <td><?=$txt_percentual?></td>
                                                                <td><?=$txt_analise_obra?></td>
                                                            </tr>                                                            
                                                        <?php
                                                        } ?>                                                        
                                                    </tbody>                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>                                                                
                            <?php                             
                            }                        
                        $ct = $ct + 1;
                        }
                        ?>                        
                    </div><!--table-responsive col-md-12-->   
                <?php                             
                }
                else {
                ?>
                    <hr>
                    <center><h4>NÃO EXISTEM REGISTROS CADASTRADOS.</h4></center>
                <?php
                }
                ?>               					
            </div><!--col-md-12--> 	
            <div class="row" align="center">
                <br /><br />
                <div class="col-md-12">                                                              
                    <a href="#" class="btn btn-default" onclick="window.history.back();">Voltar</a>
                </div><!--col-md-12-->
            </div><!--row-->				
        </div><!--row-->
        <br />
    </form>
</div><!--main-->

<?php
rodape($dbcon);
?>  