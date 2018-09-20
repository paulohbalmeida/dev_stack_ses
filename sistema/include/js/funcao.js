function js_alert(titulo, mensagem)
{
    $.alert({
        title: titulo,
        content: mensagem,
    });
}

function js_go(txt_pagina)
{
    self.location.href=txt_pagina;
}

function somenteNumeros(num) {
    var er = /[^0-9.]/;
    er.lastIndex = 0;
    var campo = num;
    if (er.test(campo.value)) {
      campo.value = "";
    }
}

function monta_arvore(valor) {
    if (valor != '') {
        $.ajax({
            type: 'POST',
            url: '../include/arvore.php',
            data: {
                acao: 'tabela_arvore',
                cod_objetivo: valor              				
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);                
    
                var div = '<div class="row">';  
                div += '<div class="form-group col-md-12">';
                
                obj.forEach(function(i, item) {
                    div += '<strong>' + i.codigo_eixo + ' - ' + i.txt_eixo +'</strong><br />';
                    div += '&nbsp;&nbsp;<strong>' + i.codigo_perspectiva + ' - ' + i.txt_perspectiva +'</strong><br />';    
                    div += '&nbsp;&nbsp;&nbsp;&nbsp;<strong>' + i.codigo_diretriz + ' - ' + i.txt_diretriz +'</strong>';    
                });
                div += '</div></div>'
    
                $('#div_arvore').html(div);                

                //MONTAR COMBO OBJETIVO PPA
                combo_ppa(valor);
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });         
    }
    else {
        $('#div_arvore').html('');
        combo_ppa('')
    }
}

function combo_ppa(cob_objetivo) {
    if (cob_objetivo != '') {
        $.ajax({
            type: 'POST',
            url: '../include/arvore.php',
            data: {
                acao: 'tabela_objetivo_ppa',
                cod_objetivo: cob_objetivo              				
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);                
    
                var div = '<div class="row">';  
                div += '<div class="form-group col-md-12">';
                div += '<label for="exampleInputEmail1">Objetivo PPA:</label>';
                div += '<select id="cod_objetivo_ppa" name="cod_objetivo_ppa" class="form-control" onchange="combo_programa_trabalho(this.value);">';
                div += '<option></option>';

                obj.forEach(function(i, item) {
                    div += '<option value="'+ i.cod_objetivo_ppa +'">'+ i.codigo_objetivo_ppa + '-' + i.txt_objetivo_ppa +'</option>'
                });
                
                div += '</select>';
                div += '</div></div>'
    
                $('#div_objetivo_ppa').html(div);    
                            
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        }); 
    }
    else {
        $('#div_objetivo_ppa').html('');
    }
}

function label_titulo_programa(cod_programa, cod_objetivo_ppa) {
    var pagina_atual = window.location.href;
    pagina_atual = pagina_atual.toLowerCase();
    var n = pagina_atual.indexOf('sag/incluir.php');
    var m = pagina_atual.indexOf('sag/alterar.php');
    if (n > 0 || m > 0) {
        if (cod_objetivo_ppa != '' && cod_programa != '') {
            $.ajax({
                type: 'POST',
                url: '../include/arvore.php',
                data: {
                    acao: 'tabela_programa_trabalho',
                    cod_objetivo_ppa: cod_objetivo_ppa,
                    cod_programa: cod_programa  				
                },
                async: false,
                success: function (data) {                              
                    var obj = JSON.parse(data);                
        
                    var div = '<div class="row">';  
                    div += '<div class="form-group col-md-12">';
                    div += '<label for="exampleInputEmail1">Título do Programa de Trabalho:</label><br />';
                    obj.forEach(function(i, item) {   
                        div += i.txt_titulo_programa;
                    });                    
                    div += '</div></div>';                    
        
                    $('#div_programa_trabalho_2').html(div);    
                                
                },				
                error: function (xhr, status, error) {
                    alert(xhr.responseText);    				
                }
            }); 
        } else {
            $('#div_programa_trabalho').html('');
            $('#div_programa_trabalho_2').html('');
        }
    } else {
        $('#div_programa_trabalho').html('');
        $('#div_programa_trabalho_2').html('');
    }
}

function combo_programa_trabalho(cod_objetivo_ppa) {
    var pagina_atual = window.location.href;
    pagina_atual = pagina_atual.toLowerCase();
    var n = pagina_atual.indexOf('sag/incluir.php');
    var m = pagina_atual.indexOf('sag/alterar.php');
    if (n > 0 || m > 0) {
        if (cod_objetivo_ppa != '') {
            $.ajax({
                type: 'POST',
                url: '../include/arvore.php',
                data: {
                    acao: 'tabela_programa_trabalho',
                    cod_objetivo_ppa: cod_objetivo_ppa              				
                },
                async: false,
                success: function (data) {                              
                    var obj = JSON.parse(data);                
        
                    var div = '<div class="row">';  
                    div += '<div class="form-group col-md-12">';
                    div += '<label for="exampleInputEmail1">Programa de Trabalho:</label>';
                    div += '<select id="cod_programa_trabalho" name="cod_programa_trabalho" class="form-control" onchange="label_titulo_programa(this.value, '+ cod_objetivo_ppa +');">';                    
                    div += '<option value=""></option>';
                    obj.forEach(function(i, item) {                        
                        div += '<option value="'+ i.cod_programa_trabalho +'">'+ i.nr_programa_trabalho +'</option>'
                    });
                    
                    div += '</select>';
                    div += '</div></div>';                    
        
                    $('#div_programa_trabalho').html(div);    
                                
                },				
                error: function (xhr, status, error) {
                    alert(xhr.responseText);    				
                }
            }); 
        }
        else {
            $('#div_programa_trabalho').html('');
            $('#div_programa_trabalho_2').html('');
        }
    }      
}

function FormataData(campo, teclapres) {
	var tecla = teclapres.keyCode;
	vr = campo.value;
	vr = vr.replace( ".", "" );
	vr = vr.replace( "/", "" );
	vr = vr.replace( "/", "" );
	tam = vr.length + 1;
	
	if ( tecla != 9 && tecla != 8 ){
		if ( tam > 2 && tam < 5 )
			campo.value = vr.substr( 0, tam - 2  ) + '/' + vr.substr( tam - 2, tam );
		if ( tam >= 5 && tam <= 10 )
			campo.value = vr.substr( 0, 2 ) + '/' + vr.substr( 2, 2 ) + '/' + vr.substr( 4, 4 );
	}
}

function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if ((charCode > 47 && charCode < 58) || (charCode > 92 && charCode < 106) || charCode == 8 || charCode == 9 || charCode == 13 || charCode == 17 || charCode == 35 || charCode == 36 || charCode == 37 || charCode == 39 || charCode == 46)
		return true;
	return false;
}

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function validateDate(dataentrada) {
    var patternData = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;

    if(!patternData.test(dataentrada)) {        
        return false;
    } else {
        return true;
    }
}

function go(obj) {
	var txt_pagina = obj.value;
	obj.selectedIndex = 0;
	obj.disabled = true;

	self.location.href = txt_pagina;

	obj.disabled = false;
}