
$(document ).ready(function() {
    /*if($("#id").val() != '' && $("#cod_eixo").val() != '' && $("#cod_perspectiva").val() != '') {       
        var cod_eixo = $("#cod_eixo").val();                 
        
        $.ajax({
            type: 'POST',
            url: 'html.php',            
            data: {
                acao: 'div_perspectiva',
                cod_eixo: cod_eixo,
                cod_perspectiva: $("#cod_perspectiva_").val()
            },
            async: false,
            success: function (data) {                             
                $('#div_perspectiva').html(data);
            }
        });
    };*/    

    $( "#cod_eixo" ).change(function() {
        var cod_eixo = $( "#cod_eixo" ).val();
        
        $.ajax({
            type: 'POST',
            url: 'html.php',            
            data: {
                acao: 'div_perspectiva',
                cod_eixo: cod_eixo
            },
            async: false,
            success: function (data) {                             
                $('#div_perspectiva').html(data);
            }
        });
    });

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
        content: 'DESEJA EXCLUIR A DIRETRIZ?',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'excluir',
                        cod_diretriz: id              				
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