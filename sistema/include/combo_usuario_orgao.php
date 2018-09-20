<?php 
include_once (__DIR__ . "/conexao.php");
include_once (__DIR__ . "/../classes/clsUsuario.php");
verifica_seguranca();

$clsUsuario = new clsUsuario();
$qU = $clsUsuario->ListaUsuarioOrgao($_SESSION["cod_usuario"]);
?>
<select id="_cod_orgao" name="_cod_orgao" class="form-control" onchange="AlterarUnidade(this.value)">    
    <?php
    while ($rr = pg_fetch_array($qU)) { ?>
        <option value="<?=$rr["cod_orgao"]?>"<?php if ($rr["cod_orgao"] == $_SESSION["cod_orgao"]) { echo("selected");}?>><?=$rr["txt_sigla"] ?></option> <?php
    }
    ?>
</select> 

<script type="text/javascript">
    function AlterarUnidade(unidade) {
        $.ajax({
            type: 'POST',
            url: '<?php echo($_SESSION["txt_caminho_aplicacao"]) ?>/include/arvore.php',
            data: {
                acao: 'alterar_unidade',
                cod_orgao: unidade
            },
            async: false,
            success: function (data) {                              
                if (data == '') {
                    js_go('<?php echo($_SESSION["txt_pagina_inicial"]) ?>');
                }
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });        
    }
</script>