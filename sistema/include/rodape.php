<?php
function rodape($dbcon) {
   
?>

<!-- Site footer -->    
        </div>             
        <footer class="footer">
            <p>&nbsp;</p>
        </footer>
         
    </div> <!-- /container -->        
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/js/jquery.min.js"></script>
    <script src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/css/jquery-confirm.min.css">
    <script src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/js/jquery-confirm.min.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/js/ie10-viewport-bug-workaround.js"></script>

    <script src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/chosen/chosen.jquery.js" type="text/javascript"></script>
    <script src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/chosen/prism.js" type="text/javascript"></script>
    <script src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/chosen/init.js" type="text/javascript"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">    
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/js/ui.datepicker-pt-BR.js" type="text/javascript"></script>
  </body>
</html>

<?php
@pg_close($dbcon);
}
?>
