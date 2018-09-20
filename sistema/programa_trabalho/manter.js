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

function Incluir(dados) {    
    $.ajax({
        type:"POST",
        data:dados.serialize(),
        url:"manter.php",
        async:false,
        success: function (data) {  
            if ($.parseJSON(data)["status"] == 'falha' && $.parseJSON(data)["mensagem"] != '') {
                js_alert('', $.parseJSON(data)["mensagem"]); 
            } else {
                js_go($.parseJSON(data)["url"]); 
            }                                
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
            if ($.parseJSON(data)["status"] == 'falha' && $.parseJSON(data)["mensagem"] != '') {
                js_alert('', $.parseJSON(data)["mensagem"]);
            } else {
                js_alert('', $.parseJSON(data)["mensagem"]); 
            }            
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        } 
    });       
}

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
    if(erro == '' && $('#cod_objetivo').val() == '') {
        erro = 'O campo OBJETIVO não pode ser vazio.';
    }
    if(erro == '' && $('#cod_objetivo_ppa').val() == '') {
        erro = 'O campo OBJETIVO PPA não pode ser vazio.';
    }
    if(erro == '' && $('#nr_programa_trabalho').val() == '') {
        erro = 'O campo NÚMERO DO PROGRAMA DE TRABALHO não pode ser vazio.';
    }
    if(erro == '' && $('#txt_titulo_programa').val() == '') {
        erro = 'O campo TÍTULO DO PROGRAMA DE TRABALHO não pode ser vazio.';
    }
    if(erro == '' && $('#cod_emenda').val() == '') {
        erro = 'O campo EMENDA PARLAMENTAR não pode ser vazio.';
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

function Excluir(id)
{

    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR O PROGRAMA DE TRABALHO?',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'excluir',
                        cod_programa_trabalho: id              				
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