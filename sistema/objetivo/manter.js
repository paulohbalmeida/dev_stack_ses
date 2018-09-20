$(document ).ready(function() {    
    $('#frm1').submit(function(e) {   
        e.preventDefault();
        if($('#acao').val() == 'incluir') {                  
            var retorno = Incluir($(this));
        }    
        if($('#acao').val() == 'alterar') {                       
            var retorno = Alterar($(this));
        }  
    
        return retorno;
    });
});

function ValidarIncluir() {
    var erro = '';

    if(erro == '' && $('#cod_eixo').val() == '') {
        erro = 'O campo EIXO não pode ser vazio.';
    }
    if(erro == '' && $('#cod_perspectiva').val() == '') {
        erro = 'O campo PERSPECTIVA não pode ser vazio.';
    }
    if(erro == '' && $('#cod_diretriz').val() == '') {
        erro = 'O campo DIRETRIZ não pode ser vazio.';
    }
    if(erro == '' && $('#codigo_objetivo').val() == '') {
        erro = 'O campo CÓDIGO OBJETIVO não pode ser vazio.';
    }
    if(erro == '' && $('#txt_objetivo').val() == '') {
        erro = 'O campo OBJETIVO não pode ser vazio.';
    }
    if(erro == '' && $('#cod_ativo').val() == '') {
        erro = 'O campo ATIVO não pode ser vazio.';
    }

    if(erro != '') {
        js_alert('', erro);
        return false;
    }
    else {        
        return true;
    }
}

function Incluir(dados) {    
    $.ajax({
        type:"POST",
        data:dados.serialize(),
        url:"manter.php",
        async:false,
        success: function (data) {            
            js_go('default.php');                
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        } 
    });       
}

function Alterar(dados) {
    $.ajax({
        type:"POST",
        data:dados.serialize(),
        url:"manter.php",
        async:false,
        success: function (data) {            
            //js_alert('', $.parseJSON(data)["mensagem"]); 
            js_go('default.php');
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        } 
    });       
}

function Excluir(id)
{

    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR O OBJETIVO?',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'excluir',
                        cod_objetivo: id              				
                    },
                    async: false,
                    success: function (data) {
            
                        if($.parseJSON(data)["status"] == 'sucesso')
                        {                                       
                            js_go('default.php');
                            return true;
                        }
                        else if($.parseJSON(data)["status"] == 'falha') {
            
                            js_alert('', $.parseJSON(data)["mensagem"]);               
                            return false;
                        }                
                    },				
                    error: function (xhr, status, error) {
                        alert(xhr.responseText);    				
                    }
                });
            },
            NÃO: function () {
                
            }
        }
    });
}