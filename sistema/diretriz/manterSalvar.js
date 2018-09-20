function ValidarSalvar() {
    var erro = '';
 
    if(erro == '' && $('#cod_eixo').val() == '') {
        erro = 'O campo EIXO não pode ser vazio.';
    }
    if(erro == '' && $('#cod_perspectiva').val() == '') {
        erro = 'O campo PERSPECTIVA não pode ser vazio.';
    }
    if(erro == '' && $('#codigo_diretriz').val() == '') {
        erro = 'O campo CÓDIGO DIRETRIZ não pode ser vazio.';
    }
    if(erro == '' && $('#txt_diretriz').val() == '') {
        erro = 'O campo DIRETRIZ não pode ser vazio.';
    }
    if(erro == '' && $('#cod_ativo').val() == '') {
        erro = 'O campo ATIVO não pode ser vazio.';
    }
    if(erro == '') {
        return true;
    }
    else
    {
        js_alert('', erro);
        return false;
    }
}

$(document ).ready(function() {
    $('#frm1').submit(function(e) {   
        e.preventDefault();     
        var retorno = Alterar($(this));
    
        return retorno;
    });
});

function Alterar(dados)
{           
    $.ajax({
        type:"POST",
        data:dados.serialize(),
        url:"manter.php",
        async:false
    }).then(sucesso, falha);

    function sucesso(data)
    {                          
        //js_alert('', 'DADOS ALTERADOS.');         
        js_go('default.php');          
    }

    function falha(data)
    {        
        js_alert('', $.parseJSON(data)["mensagem"]);
    } 
}