<?php
include_once (__DIR__ . "/../include/conexao.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(92);

if (empty($_REQUEST['log'])) {
	Auditoria(129, "Listar Ciclo do Planejamento", "");
}

?>

<div id="main" class="container-fluid" style="margin-top: 50px">
    <form id="frm1"> 
        <input type="hidden" name="log" id="log" value="1" />       
        <div class="row">
            <div class="col-md-12">
                <h3>Ciclo Geral do Planejamento SES-DF</h3>
            </div>
        </div>
        <br />  
        <div class="row">
            <div class="col-md-12">                
                <img src="#" alt="Ciclo Geral do Planejamento SES-DF" usemap="#planetmap">
            </div>
        </div>
    </form>      
</div>
<map name="planetmap">  
 
</map>
<?php
rodape($dbcon);
?>