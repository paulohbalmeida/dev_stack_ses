<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>SESPLAN - WEB</title>    
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="include/js/funcao.js" type="text/javascript"></script>
</head>
<body onload="Mensagem()">
    <div class="overlay">
        <div class="container">
            <div class="col-md-12">            
                <div class="col-md-5">
                    <img src="assets/img/icones-home-page.png" class="img-responsive" />
                </div>                
                <div class="col-md-4">
                    <div class="box--shadow">
                        <div class="box box--body-auth">                           
                            <div class="box__logo">
                                <!--<a href="http://www.brasilia.df.gov.br/" target="blank">
                                    <img src="assets/img/logo_gov_bsb.png" class="img-responsive" alt="SESPLAN - WEB" />                                    
                                </a>-->	                                
                                <img src="assets/img/sesplan-logo-para-fundo-branco.png" class="img-responsive" />
                            </div><!-- / LOGO -->                            
                            <form action="autenticar.php">								
                                <div class="form-group">
                                    <label for="field_login" class="label-control">Login:</label>
                                    <input type="text" id="field_login" name="field_login" class="form-control" placeholder="Usuário LDAP">
                                </div>
                                <div class="form-group">
                                    <label for="field_password" class="label-control">Senha:</label>
                                    <input type="password" id="field_password" name="field_password" class="form-control">
                                </div>
                                <div class="pull-left">
                                    <!--<a href="recuperar-senha/index.html">Esqueceu sua senha?</a>-->
                                </div>                                
                                <div class="text-center">                                    
                                    <button type="submit" class="btn btn--theme" onclick="return Validar();">Entrar</button>
                                </div>                                
                            </form>
                            <div class="clearfix"></div>                            
                        </div><!-- /box body -->                        
                    </div><!-- box shadow -->
                </div><!-- /col -->                  
                <div class="col-md-3">
                    <br /><br /><br /><br /><br /><br />                    
                    <h3 class="display-3">
                        <p align="justify">
                            "O que não pode ser medido, não pode ser gerenciado."​<br />                        
                        </p>
                    </h3>                    
                    <strong>W. Edwards Deming<strong>
                </div>            
            </div>                                         
        </div><!-- /container -->

    </div>
</body>
<script>
    document.getElementById("field_login").focus();

    function Mensagem() {
        var url = window.location.href;
        var res = url.split("?");
        
        if (res[1] == 'mensagem=1') {
            alert('USUÁRIO INATIVO NO SESPLAN.'); 
            self.location.href = 'login.php';  
        } else if (res[1] == 'mensagem=2') {
            alert("FALHA AO AUTENTICAR NO LDAP.");
            self.location.href = 'login.php';
        } else if (res[1] == 'mensagem=3') {
            alert("USUÁRIO NÃO CADASTRADO NO SESPLAN.");
            self.location.href = 'login.php';
        } else if (res[1] == 'mensagem=4') {
            alert("LDAP BIND FAILED.");
            self.location.href = 'login.php';
        }               
    }

    function Validar() {
        var cpf = document.getElementById("field_login").value;
        if (cpf == '') {
            alert('LOGIN OBRIGATÓRIO.');
            document.getElementById("field_login").focus();
            return false;
        }         
        if (document.getElementById("field_password").value == '') {
            alert('SENHA OBRIGATÓRIA.');
            document.getElementById("field_password").focus();
            return false;
        }
        return true;
    }
</script>
</html>
