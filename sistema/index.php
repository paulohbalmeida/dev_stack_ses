<?php
include_once(__DIR__ . "/include/conexao.php");
verifica_seguranca();
cabecalho();
?>
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/bower_components/font-awesome/css/font-awesome.min.css">

<div id="main" class="container-fluid" style="margin-top: 50px">
  <form id="frm1">
        
    <div class="row">&nbsp;</div><!--row--> 
    <div class="row">
      <div class="col-md-12">
        <div class="form-check" align="left">                      
          <?php 
          $q1 = pg_query("SELECT * FROM tb_modulo WHERE cod_exibir_consulta = 1"); ?>
          <div class="radio"> <?php
            while ($rs1 = pg_fetch_array($q1)) { ?>          
                <label>
                  <input type="radio" id="cod_modulo_<?=$rs1['cod_modulo']?>" name="cod_modulo" value="<?=$rs1['cod_modulo']?>" onclick="tabelaStatus(this.value);">
                  <strong><?=$rs1['txt_modulo']?></strong>&nbsp;&nbsp;
                </label>
            <?php        
            } ?>
          </div><!--radio-->       
        </div><!--form-check-->
      </div><!--col-md-12--> 
    </div><!--row--> 
    
    <div class="row">
      <div class="col-md-9">         
        <p align="center">       
          <img src="<?php echo($_SESSION["txt_caminho_aplicacao"]) ?>/include/imagens/construcao.jpg" height="400" width="400" class="img-responsive"/>
        </p>
      </div><!--col-md-9-->
      <div class="col-md-3">
          <h4><font color="blue">ÁREA RESPONSÁVEL</font></h4>
          <?php 
          $q1 = pg_query("SELECT * FROM tb_orgao WHERE cod_exibir_consulta = 1");                     
            while ($rs1 = pg_fetch_array($q1)) { ?>     
              <div class="form-check">        
                <input type="checkbox" class="form-check-input" name="cod_orgao" value="<?=$rs1['cod_orgao']?>">&nbsp;<strong><?=$rs1['txt_sigla']?></strong>
              </div><!--form-check--> <?php
            } ?>
      </div><!--col-md-3-->
    </div><!--row-->      
    <div class="row">  
      <div class="col-md-9">
        <div class="box">
          <div id="div_eixo"></div> 
          <div id="div_perspectiva"></div>
          <div id="div_diretriz"></div>
          <div id="div_objetivo"></div> 
          <p>&nbsp;</p>
        </div><!--box-->
      </div><!--col-md-9-->      
      <div class="col-md-3">
        <h4><font color="blue">STATUS</font></h4>
        <div id="div_status"></div>
        <br />
        <button type="button" id="btn_pesquisar" class="btn btn-primary">Pesquisar</button>
      </div><!--col-md-3-->
    </div><!--row-->    
  </form>
</div><!--main-->
     
<script src="include/js/painel.js" type="text/javascript"></script>     
<script type="application/javascript">
  $(document).ready(function() {
    tabelaStatus(3);    
    document.getElementById('cod_modulo_3').checked = true;
  });
</script>     
<?php
rodape($dbcon);
?>
      
