<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../include/auditoria.php");
include_once (__DIR__ . "/../../classes/clsStatus.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(21);

if (empty($_REQUEST['log'])) {
	Auditoria(84, "Listar Réguas", "");
}

$clsStatus = new clsStatus();
?>

<div id="main" class="container-fluid" style="margin-top: 50px">
    <form id="frm1"> 
        <input type="hidden" name="log" id="log" value="1" />       
        <div class="row">
            <div class="col-md-12">
                <h3>Régua de Indicadores</h3>
            </div>
        </div>
        <br />        
        <div class="row">
            <div class="col-md-12"><strong>Maior - Melhor</strong></div>
            <div class="table-responsive col-md-12">
                <table class="table table-striped" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>SUPERADO</th>
                            <th>ESPERADO</th>								
                            <th>ALERTA</th>
                            <th>CRÍTICO</th>
                            <th>MUITO CRÍTICO</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        <tr>
                            <th>
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(20)) ?>;" disabled="disabled">                                
                                Acima de 0%
                            </th>
                            <th>
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(19)) ?>;" disabled="disabled">                                
                                Entre -4,99% e 0%
                            </th>
                            <th>
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(16)) ?>;" disabled="disabled">                                
                                Entre -24,99% e -5%
                            </th>
                            <th>
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(18)) ?>;" disabled="disabled">                                
                                Entre -49,99% e -25%
                            </th>
                            <th>
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(17)) ?>;" disabled="disabled">                                
                                Menor ou Igual a -50%
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>                
        <br />
        <div class="row">
            <div class="col-md-12"><strong>Menor - Melhor</strong></div>
            <div class="table-responsive col-md-12">
                <table class="table table-striped" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>SUPERADO</th>
                            <th>ESPERADO</th>								
                            <th>ALERTA</th>
                            <th>CRÍTICO</th>
                            <th>MUITO CRÍTICO</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        <tr>
                            <th>
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(20)) ?>;" disabled="disabled">                                
                                Menor que 0%
                            </th>
                            <th>
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(19)) ?>;" disabled="disabled">                                
                                Entre 0% e 4,99%
                            </th>
                            <th>
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(16)) ?>;" disabled="disabled">                                
                                Entre 5% e 24,99%
                            </th>
                            <th>
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(18)) ?>;" disabled="disabled">                                
                                Entre 25% e 49,99%
                            </th>
                            <th>
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(17)) ?>;" disabled="disabled">                                
                                Maior ou Igual a 50%
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>            
        <div class="row">
            <div class="col-md-12">
                <h3>Régua PAS</h3>
            </div>
        </div>          
        <div class="row">           
            <div class="table-responsive col-md-12">
                <table class="table table-striped" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>A SER INICIADA</th>
                            <th>ANDAMENTO NORMAL</th>								
                            <th>CONCLUÍDA</th>
                            <th>ATRASADA</th>                            
                        </tr>
                    </thead>
                    <tbody>                        
                        <tr>
                            <th>                                                                
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:#FFFFFF;" disabled="disabled">                                                                
                            </th>
                            <th>
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(2)) ?>;" disabled="disabled">                                                                
                            </th>
                            <th>
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(4)) ?>;" disabled="disabled">                                                                
                            </th>
                            <th>
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(5)) ?>;" disabled="disabled">                                                                
                            </th>                            
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>   
        <div class="row">
            <div class="col-md-12">
                <h3>Régua SAG</h3>
            </div>
        </div>  
        <div class="row">           
            <div class="table-responsive col-md-12">
                <table class="table table-striped" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>NORMAL</th>
                            <th>ALERTA</th>								
                            <th>CRÍTICA</th>                                                    
                        </tr>
                    </thead>
                    <tbody>                        
                        <tr>
                            <th>                                                                
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(9)) ?>;" disabled="disabled">                                                                
                                Maior ou Igual a -40%
                            </th>
                            <th>
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(16)) ?>;" disabled="disabled">                                                                
                                Entre -49,99% e -40,01%
                            </th>
                            <th>
                                <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(18)) ?>;" disabled="disabled">                                                                
                                Menor ou igual a -50%
                            </th>                                                   
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>    
        <div class="row">
            <div class="col-md-12">
                <h3>Régua Execução Orçamentária</h3>
            </div>
        </div>   
        <div class="row">           
            <div class="table-responsive col-md-12">
                <?php 
                $ct_execucao = 1;
                while ($ct_execucao <= 6) {
                ?>
                    <h3><?php echo($ct_execucao); ?>º Bimestre</h3>
                    <table class="table table-striped" cellspacing="0" cellpadding="0">
                        <?php if($ct_execucao == 1) { ?>
                            <thead>
                                <tr>
                                    <th>NORMAL</th>
                                    <th>ALERTA</th>								
                                    <th>RECURSO INSUFICIENTE</th>                                                    
                                </tr>
                            </thead>
                            <tbody>                        
                                <tr>
                                    <th>                                                                
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(9)) ?>;" disabled="disabled">                                                                
                                        Menor ou igual a 20%
                                    </th>
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(16)) ?>;" disabled="disabled">                                                                
                                        Entre 20,01% e 49,99%
                                    </th>
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(14)) ?>;" disabled="disabled">                                                                
                                        Maior ou igual a 50%
                                    </th>                                                   
                                </tr>
                            </tbody>
                        <?php } ?>    
                        <?php if($ct_execucao == 2) { ?>  
                            <thead>
                                <tr>
                                    <th>BAIXA EXECUÇÃO</th>
                                    <th>NORMAL</th>
                                    <th>ALERTA</th>								
                                    <th>RECURSO INSUFICIENTE</th>                                                                                          
                                </tr>
                            </thead>
                            <tbody>                        
                                <tr>
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(13)) ?>;" disabled="disabled">                                                                
                                        Menor ou igual a 9,99%
                                    </th> 
                                    <th>                                                                
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(9)) ?>;" disabled="disabled">                                                                
                                        Entre 10% e 30%
                                    </th>
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(16)) ?>;" disabled="disabled">                                                                
                                        Entre 30,01% e 50%
                                    </th>
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(14)) ?>;" disabled="disabled">                                                                
                                        Maior que 50%
                                    </th>                                                                                        
                                </tr>
                            </tbody>
                        <?php } ?>   
                        <?php if($ct_execucao == 3) { ?>  
                            <thead>
                                <tr>
                                    <th>BAIXA EXECUÇÃO</th>
                                    <th>NORMAL</th>
                                    <th>ALERTA</th>								
                                    <th>RECURSO INSUFICIENTE</th>                                                                                          
                                </tr>
                            </thead>
                            <tbody>                        
                                <tr>
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(13)) ?>;" disabled="disabled">                                                                
                                        Menor ou igual a 29,99%
                                    </th> 
                                    <th>                                                                
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(9)) ?>;" disabled="disabled">                                                                
                                        Entre 30% e 49,99%
                                    </th>
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(16)) ?>;" disabled="disabled">                                                                
                                        Entre 50% e 84,99%
                                    </th>
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(14)) ?>;" disabled="disabled">                                                                
                                        Maior ou igual a 85%
                                    </th>                                                                                        
                                </tr>
                            </tbody>
                        <?php } ?>  
                        <?php if($ct_execucao == 4) { ?>  
                            <thead>
                                <tr>
                                    <th>BAIXA EXECUÇÃO</th>
                                    <th>NORMAL</th>
                                    <th>ALERTA</th>								
                                    <th>RECURSO INSUFICIENTE</th>                                                                                          
                                </tr>
                            </thead>
                            <tbody>                        
                                <tr>
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(13)) ?>;" disabled="disabled">                                                                
                                        Menor ou igual a 39,99%
                                    </th> 
                                    <th>                                                                
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(9)) ?>;" disabled="disabled">                                                                
                                        Entre 40% e 70%
                                    </th>
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(16)) ?>;" disabled="disabled">                                                                
                                        Entre 70,01% e 84,99%
                                    </th>
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(14)) ?>;" disabled="disabled">                                                                
                                        Maior ou igual a 85%
                                    </th>                                                                                        
                                </tr>
                            </tbody>
                        <?php } ?>   
                        <?php if($ct_execucao == 5) { ?>  
                            <thead>
                                <tr>
                                    <th>BAIXA EXECUÇÃO</th>
                                    <th>NORMAL</th>
                                    <th>ALERTA</th>	
                                    <th>RECURSO INSUFICIENTE</th>							                                                                                                                             
                                </tr>
                            </thead>
                            <tbody>                        
                                <tr>
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(13)) ?>;" disabled="disabled">                                                                
                                        Menor ou igual a 64,99%
                                    </th> 
                                    <th>                                                                
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(9)) ?>;" disabled="disabled">                                                                
                                        Entre 65% e 85%
                                    </th>
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(16)) ?>;" disabled="disabled">                                                                
                                        Entre 85,01% e 94,99%
                                    </th>  
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(14)) ?>;" disabled="disabled">                                                                
                                        Maior ou igual a 95%
                                    </th>                                                                                                                     
                                </tr>
                            </tbody>
                        <?php } ?>   
                        <?php if($ct_execucao == 6) { ?>  
                            <thead>
                                <tr>
                                    <th>BAIXA EXECUÇÃO</th>
                                    <th>NORMAL</th>
                                    <th>ALERTA</th>								                                                                                                                         
                                </tr>
                            </thead>
                            <tbody>                        
                                <tr>
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(13)) ?>;" disabled="disabled">                                                                
                                        Menor ou igual a 50%
                                    </th> 
                                    <th>                                                                
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(9)) ?>;" disabled="disabled">                                                                
                                        Maior ou igual a 85%
                                    </th>
                                    <th>
                                        <input type="text" class="form-control_custom" name="txt_status" style="background-color:<?php echo($clsStatus->RetornaCorStatus(16)) ?>;" disabled="disabled">                                                                
                                        Entre 50,01% e 84,99%
                                    </th>                                                                                                                        
                                </tr>
                            </tbody>
                        <?php } ?>                            
                    </table> 
                <?php
                    $ct_execucao += 1;
                }
                ?>                 
            </div>
        </div>          
    </form>
</div>
<?php
rodape($dbcon);
?>