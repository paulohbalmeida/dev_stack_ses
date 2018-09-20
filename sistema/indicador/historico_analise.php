<?php
include_once (__DIR__ . "/../include/conexao.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(64);

$id = $_REQUEST['id'];

$clsUsuario = new clsUsuario();

if (empty($_REQUEST['log'])) {
	Auditoria(77, "Histórico de Análise de Indicadores", "");
}
?>
<div id="main" class="container-fluid" style="margin-top: 50px">
    <form id="frm1">
        <input type="hidden" name="log" id="log" value="1" />
        <input type="hidden" name="id" id="id" value="<?=$id?>" />

         <div id="top" class="row">
			<div class="col-sm-12">
				<h2>Indicadores > Análise > Histórico</h2>
			</div>			
		</div> <!-- /#top -->
		<br />
        <div class="row">
            <div class="col-md-12">
                <?php 
                $sql = "SELECT * FROM tb_indicador_analise_historico WHERE cod_chave = ".$id;
                $q1 = pg_query($sql);
                if (pg_num_rows($q1) > 0) { ?>
                     <div class="table-responsive col-md-12"> 
                        <?php
                        $ct = 1;
                        while($ct <= 12) {                             
                            $sql = "SELECT * FROM tb_indicador_analise_historico WHERE cod_chave = ".$id;
                            $sql .= " AND cod_periodo = ".$ct." ORDER BY dt_inclusao DESC";
                            $q = pg_query($sql);
                            if (pg_num_rows($q) > 0) {                                 
                            ?>
                                <table class="table table-striped" cellspacing="0" cellpadding="0"> 
                                    <thead>
                                        <tr>                                                                                  
                                            <th><?php echo(RetornaTextoMes($ct)) ?></th>                                                                                      
                                        </tr>                                                                   
                                    </thead>         
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table class="table table-striped" cellspacing="0" cellpadding="0"> 
                                                    <thead>
                                                        <tr>                                                                                  
                                                            <th>Numerador</th>
                                                            <th>Denominador</th>
                                                            <th>Resultado</th>
                                                            <th>Data Extração</th>
                                                            <th>Análise</th>
                                                            <th>Encaminhamento</th>
                                                            <th>Registrado Por</th>
                                                        </tr>                                                       
                                                    </thead>   
                                                    <tbody>
                                                        <?php                                                
                                                        while($rs = pg_fetch_array($q)) { 
                                                            $cod_numerador = $rs['cod_numerador'];
                                                            $cod_denominador = $rs['cod_denominador'];
                                                            $cod_resultado = $rs['cod_resultado'];
                                                            $dt_extracao = FormataData($rs['dt_extracao']);
                                                            $txt_analise = $rs['txt_analise'];
                                                            $txt_encaminhamento = $rs['txt_encaminhamento'];
                                                            $cod_usuario = $clsUsuario->ConsultaUsuarioId($rs['cod_usuario']);
                                                            ?>
                                                            <tr>                  
                                                                <td><?=$cod_numerador?></td>
                                                                <td><?=$cod_denominador?></td>
                                                                <td><?=$cod_resultado?></td>
                                                                <td><?=$dt_extracao?></td>
                                                                <td><?=$txt_analise?></td>
                                                                <td><?=$txt_encaminhamento?></td>
                                                                <td><?=$cod_usuario?></td>
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