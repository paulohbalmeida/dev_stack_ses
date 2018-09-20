<?php
function cabecalho() {
    extract($GLOBALS);
    global $application;
?>
    <!--https://getbootstrap.com/docs/3.3/examples/justified-nav/-->
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">        
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/imagens/favicon.png">
    
        <title><?php echo($_SESSION["txt_sigla_sistema"]); ?></title>
    
        <!-- Bootstrap core CSS -->
        <link href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/css/bootstrap.min.css" rel="stylesheet">
    
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    
        <!-- Custom styles for this template -->
        <link href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/css/justified-nav.css" rel="stylesheet">
    
        <!-- Estilos -->
        <link href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/css/style.css" rel="stylesheet">
    
        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/js/ie-emulation-modes-warning.js"></script>
    
        <script src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/js/funcao.js" type="text/javascript"></script>
        <script src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/js/jquery-3.3.1.min.js" type="text/javascript"></script>

        <script src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/js/jquery.maskedinput.js" type="text/javascript"></script>
        <script src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/js/jquery.moneymask.js" type="text/javascript"></script>        

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <?php        
        $pos = strrpos(strtoupper($_SERVER["SCRIPT_FILENAME"]), "SISTEMA/INDEX.PHP", 0);
        if ($pos > 0) { ?>
            <!-- Bootstrap 3.3.7 -->
            <link rel="stylesheet" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/bower_components/bootstrap/dist/css/bootstrap.min.css">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/bower_components/font-awesome/css/font-awesome.min.css">  
            <!-- Ionicons -->
            <link rel="stylesheet" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/bower_components/Ionicons/css/ionicons.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/dist/css/AdminLTE.min.css">
            <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
            <link rel="stylesheet" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/dist/css/skins/_all-skins.min.css">

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->

            <!-- Google Font -->
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

            <!-- Estilos Painel -->
            <link href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/css/style_painel.css" rel="stylesheet">
        <?php
        }        
        ?>   
                
        <link rel="stylesheet" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/chosen/style.css">
        <link rel="stylesheet" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/chosen/prism.css">
        <link rel="stylesheet" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/chosen/chosen.css">

        <link rel="stylesheet" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/css/onoffbutton.css">

        <!--PAGINAÇÃO TABELAS -->
        <link rel="stylesheet" type="text/css" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/css/jquery.dataTables.min.css">
        <script type="text/javascript" language="javascript" src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/js/jquery.dataTables.min.js"></script>
        
      </head>

        <body>          
            
            <div class="container">
            <div style="background-image:url(<?php echo($_SESSION["txt_caminho_aplicacao"]) ?>/include/imagens/fundoSESPLANmarcadagua.jpg);" class="img-responsive">              
               <?php menu(); ?>
    
               <div class="container">
                    <center>
                        <h5><strong>FERRAMENTA DE MONITORAMENTO E AVALIAÇÃO DO PLANEJAMENTO ESTRATÉGICO</strong></h5>
                    </center>
                </div>                    
<?php
}
?>