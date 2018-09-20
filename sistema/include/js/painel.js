$(document).ready(function() {    
    dashboard_eixo();
});

function tabelaStatus(valor) {
    if (valor != '') {                  
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'tabela_status',
                cod_modulo: valor              				
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);                

                var div = '';

                obj.forEach(function(i, item){
                    div += '<input type="checkbox" class="form-check-input" name="cod_status" value="'+ i.cod_status +'">'
                    div += '&nbsp;<strong>' + i.txt_status + '</strong><br />';
                });
                
                $('#div_status').html(div);
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });                  
    }    
}

function dashboard_objetivo(cod_eixo, cod_perspectiva, cod_diretriz) {
    if (cod_eixo != '' && cod_perspectiva != '' && cod_diretriz != '') {
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'tabela_objetivo',
                cod_eixo: cod_eixo,
                cod_perspectiva: cod_perspectiva,
                cod_diretriz: cod_diretriz
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);                                            
                var div = '<br />';            
                obj.forEach(function(i, item){                
                    div += '<div class="btn btn-app">';
                        div += '<i class="fa" title="'+ i.txt_objetivo +'"><p></p>'+ i.codigo_objetivo +'</i>';                
                    div += '</div>';                                              
                });            
    
                $('#div_objetivo').html(div);
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        }); 
    }
}

function dashboard_diretriz(cod_eixo, cod_perspectiva) {     
    $('#div_objetivo').html('');
    
    if (cod_eixo != '' && cod_perspectiva != '') {
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'tabela_diretriz',
                cod_eixo: cod_eixo,
                cod_perspectiva: cod_perspectiva            
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);                                            
                var div = '<br />';            
                obj.forEach(function(i, item){                
                    div += '<div class="btn btn-app" onclick="dashboard_objetivo('+ cod_eixo +', '+ cod_perspectiva +', '+ i.cod_diretriz +');">';
                        div += '<i class="fa" title="'+ i.txt_diretriz +'"><p></p>'+ i.codigo_diretriz +'</i>';                
                    div += '</div>';                                              
                });            
    
                $('#div_diretriz').html(div);
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        }); 
    }
}

function dashboard_perspectiva(valor) {    
    $('#div_diretriz').html('');
    $('#div_objetivo').html('');

    if (valor != '') {
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'tabela_perspectiva',
                cod_eixo: valor            
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);                                            
                var div = '<br />';            
                obj.forEach(function(i, item){                
                    div += '<div class="btn btn-app" onclick="dashboard_diretriz('+ valor +', '+ i.cod_perspectiva +');">';
                        div += '<i class="fa" title="'+ i.txt_perspectiva +'"><p></p>'+ i.codigo_perspectiva +'</i>';                
                    div += '</div>';                                              
                });            
    
                $('#div_perspectiva').html(div);
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        }); 
    }
}

function dashboard_eixo() {
    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'tabela_eixo'                
        },
        async: false,
        success: function (data) {                              
            var obj = JSON.parse(data);                                            
            var div = '';            
            obj.forEach(function(i, item) {
                div += '<div class="btn btn-app" onclick="dashboard_perspectiva('+ i.cod_eixo +');">';
                    div += '<i class="fa" title="'+ i.txt_eixo +'"><p></p>'+ i.codigo_eixo +'</i>';                
                div += '</div>';                                              
            });            

            $('#div_eixo').html(div);            
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });    
}
