<div class="row">
    <div class="form-group col-md-12">
        <label for="exampleInputEmail1">Eixo:</label>
        <select id="cod_eixo" name="cod_eixo" class="form-control" onchange="frm1.submit();">
            <option></option>
            <?php                         
                $q = pg_query("SELECT cod_eixo, txt_eixo FROM tb_eixo WHERE cod_ativo = 1 ORDER BY txt_eixo");
                while ($row = pg_fetch_array($q)) 
                { ?>
                    <option value="<?=$row["cod_eixo"]?>"<?php if ($cod_eixo == $row["cod_eixo"]) { echo("selected");}?>><?=$row["txt_eixo"] ?></option>
                <?php	
                } ?>									
        </select>
    </div>	  
</div>
<div class="row">
    <div class="form-group col-md-12">
        <label for="exampleInputEmail1">Perspectiva:</label>                
        <select id="cod_perspectiva" name="cod_perspectiva" class="form-control" onchange="frm1.submit();">
            <option></option>
            <?php
            if($cod_eixo != "") {
                $condicao_perspectiva = " AND cod_eixo = " .$cod_eixo;
            }
            $q = pg_query("SELECT cod_perspectiva, txt_perspectiva FROM tb_perspectiva WHERE cod_ativo = 1 ".$condicao_perspectiva." ORDER BY txt_perspectiva");
            while ($row = pg_fetch_array($q)) 
            { ?>
                <option value="<?=$row["cod_perspectiva"]?>"<?php if ($cod_perspectiva == $row["cod_perspectiva"]) { echo("selected");}?>><?=$row["txt_perspectiva"] ?></option>
            <?php	
            } ?>									
        </select>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        <label for="exampleInputEmail1">Diretriz:</label>                
        <select id="cod_diretriz" name="cod_diretriz" class="form-control" onchange="frm1.submit();">
            <option></option>
            <?php
                if($cod_perspectiva != "") {
                    $condicao_diretriz = " AND cod_perspectiva = " .$cod_perspectiva;
                } 
                $q = pg_query("SELECT cod_diretriz, txt_diretriz FROM tb_diretriz WHERE cod_ativo = 1 ".$condicao_perspectiva." ORDER BY txt_diretriz");
                while ($row = pg_fetch_array($q)) 
                { ?>
                    <option value="<?=$row["cod_diretriz"]?>"<?php if ($cod_diretriz == $row["cod_diretriz"]) { echo("selected");}?>><?=$row["txt_diretriz"] ?></option>
                <?php	
                } ?>									
        </select>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        <label for="exampleInputEmail1">Objetivo:</label>                
        <select id="cod_objetivo" name="cod_objetivo" class="form-control" onchange="frm1.submit();">
            <option></option>
            <?php                
                if($cod_diretriz != "") {
                    $condicao_objetivo = " AND cod_diretriz = " .$cod_diretriz;
                } 
                $q = pg_query("SELECT cod_objetivo, txt_objetivo FROM tb_objetivo WHERE cod_ativo = 1 ".$condicao_objetivo." ORDER BY txt_objetivo");
                while ($row = pg_fetch_array($q)) 
                { ?>
                    <option value="<?=$row["cod_objetivo"]?>"<?php if ($cod_objetivo == $row["cod_objetivo"]) { echo("selected");}?>><?=$row["txt_objetivo"] ?></option>
                <?php	
                } ?>									
        </select>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        <label for="exampleInputEmail1">Objetivo PPA:</label>
        <select id="cod_objetivo_ppa" name="cod_objetivo_ppa" class="form-control">
            <option></option>
            <?php
                if($cod_objetivo != "") {
                    $condicao_objetivo_ppa = " AND cod_objetivo = " .$cod_objetivo;
                } 
                $q = pg_query("SELECT cod_objetivo_ppa, txt_objetivo_ppa FROM tb_objetivo_ppa WHERE cod_ativo = 1 ".$condicao_objetivo_ppa." ORDER BY txt_objetivo_ppa");
                while ($row = pg_fetch_array($q)) 
                { ?>
                    <option value="<?=$row["cod_objetivo_ppa"]?>"<?php if ($cod_objetivo_ppa == $row["cod_objetivo_ppa"]) { echo("selected");}?>><?=$row["txt_objetivo_ppa"] ?></option>
                <?php	
                } ?>									
        </select>
    </div>	  
</div>	