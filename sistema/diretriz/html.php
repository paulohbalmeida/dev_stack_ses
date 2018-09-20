<?php
include_once (__DIR__ . "/../include/conexao.php");

if(isset($_REQUEST["acao"]))
{
    $acao = utf8_decode($_REQUEST["acao"]);

    if($acao == "div_perspectiva")
    {       
        $cod_eixo = $_REQUEST["cod_eixo"];        

        if(empty($cod_eixo)) {
            $html = "SELECIONE O EIXO";
        }
        else {            
            $q=pg_query("SELECT cod_perspectiva, txt_perspectiva FROM tb_perspectiva WHERE cod_eixo = " .$cod_eixo. " AND cod_ativo = 1");        
            $html = "<select id='cod_perspectiva' name='cod_perspectiva' class='form-control'>";
            $html .= "<option></option>";  
            if (pg_num_rows($q) > 0) {                
                while ($row = pg_fetch_array($q)) {                                              
                    $html .= "<option value='".$row['cod_perspectiva']."'>".$row['txt_perspectiva']."</option>";            
                }
            } 
            $html .= "</select>";
        }       
        
        echo($html);        
    }    
}

?>