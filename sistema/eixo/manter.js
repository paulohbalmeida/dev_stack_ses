$( document ).ready(function() {    
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

function Incluir(dados)
{        
    $.ajax({
        type:"POST",
        data:dados.serialize(),
        url:"manter.php",
        async:false
    }).then(sucesso, falha);

    function sucesso(data)
    {      
        if($.parseJSON(data)["status"] == 'sucesso')
        {                               
            //js_go('incluir.php?id=' + $.parseJSON(data)["id"]);
            js_go('default.php');
            return true;
        }
        else if($.parseJSON(data)["status"] == 'falha') {

            js_alert('', $.parseJSON(data)["mensagem"]);
            return false;
        }                         
                 
    }

    function falha(data)
    {        
        js_alert('', $.parseJSON(data)["mensagem"]);
    }
}

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
        if($.parseJSON(data)["status"] == 'sucesso')
        {                        
            //js_alert('', $.parseJSON(data)["mensagem"]); 
            js_go('default.php');           
            return true;
        }
        else if($.parseJSON(data)["status"] == 'falha') {

            js_alert('', $.parseJSON(data)["mensagem"]);
            return false;
        }                         
                 
    }

    function falha(data)
    {        
        js_alert('', $.parseJSON(data)["mensagem"]);
    }
}

function Excluir(id)
{

    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR O EIXO?',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'excluir',
                        cod_eixo: id              				
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