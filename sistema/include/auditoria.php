<?php
include_once (__DIR__ . "/conexao.php");

//USAR COLUNA TXT_SQL PARA COMANDOS DE BANCO
//USAR COLUNA TXT_HISTORICO PARA LOG TRATADO

function Auditoria($cod_acao_auditoria, $txt_historico, $txt_sql)
{
    if (strval($_SESSION["cod_auditoria"]) == "1") {
        if(!empty($txt_sql)) {
            $txt_sql = str_replace("'", "''", $txt_sql);
        }

        $sql = "INSERT INTO tb_auditoria(cod_auditoria, cod_acao_auditoria, cod_usuario, cod_orgao, txt_historico, txt_sql) ";
        $sql .= " VALUES(nextval('S_AUDITORIA'), ".$cod_acao_auditoria.", ".$_SESSION["cod_usuario"].", ".$_SESSION["cod_orgao"].", '".trim($txt_historico)."', '".trim($txt_sql)."')";    
        pg_query($sql);    
    }
    
}

?>