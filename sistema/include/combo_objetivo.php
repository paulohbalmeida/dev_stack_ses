<div id="div_arvore"></div>
<div class="row">
    <div class="form-group col-md-12">
        <label for="exampleInputEmail1">Objetivo:</label>                
        <select id="cod_objetivo" name="cod_objetivo" data-placeholder="Obrigatório" class="chosen-select" onchange="monta_arvore(this.value);">
            <option></option>
            <?php                                                       
                $q = pg_query("SELECT codigo_objetivo, cod_objetivo, txt_objetivo FROM tb_objetivo WHERE cod_ativo = 1 ".$condicao_objetivo." ORDER BY txt_objetivo");
                while ($row = pg_fetch_array($q)) 
                { ?>
                    <option value="<?=$row["cod_objetivo"]?>"<?php if ($cod_objetivo == $row["cod_objetivo"]) { echo("selected");}?>><?=$row["codigo_objetivo"] ?>-<?=$row["txt_objetivo"] ?></option>
                <?php	
                } ?>									
        </select>
    </div>
</div>
<div id="div_objetivo_ppa"></div>