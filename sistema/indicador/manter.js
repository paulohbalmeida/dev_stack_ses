$(document).ready(function() {
    CarregarFormularioAlterar();       
    CampoFormula();    
});

function MarcarAba(cod_aba) {
    $('#cod_periodo').val(cod_aba);
}

function ValidarIncluir() {
    var retorno = true;    
    var cod_objetivo = $('#cod_objetivo').val();
    var cod_objetivo_ppa = $('#cod_objetivo_ppa').val();
    var txt_acao = $('#txt_acao').val();
    var cod_indicador = $('#cod_indicador').val();    
    var cod_orgao = $('#cod_orgao').val();
    var cod_meta = $('#cod_meta').val();
    var txt_descricao = $('#txt_descricao').val();    
    var cod_dados_mgi = $('#cod_dados_mgi').val();    
    var txt_monitoramento = $('#txt_monitoramento').val();    
    var cod_responsavel = $('#cod_responsavel').val();
    var cod_responsavel_2 = $('#cod_responsavel_2').val();      
    
    if(retorno && cod_objetivo == '') {
        js_alert('', 'Campo OBJETIVO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_objetivo_ppa == '') {
        js_alert('', 'Campo OBJETIVO PPA não pode ser vazio.');
        retorno = false;
    }
    if(retorno && txt_descricao == '') {
        js_alert('', 'Campo DESCRIÇÃO DA META não pode ser vazio.');
        retorno = false;
    } 
    if(retorno && cod_indicador == '') {
        js_alert('', 'Campo INDICADOR não pode ser vazio.');
        retorno = false;
    }        
    if(retorno && cod_meta == '') {
        js_alert('', 'Campo META não pode ser vazio.');
        retorno = false;
    } 
    if(retorno && cod_responsavel == '') {
        js_alert('', 'Campo RESPONSÁVEL TÉCNICO não pode ser vazio.');
        retorno = false;
    } 
    if(retorno && cod_dados_mgi == '') {
        js_alert('', 'Campo DADOS MGI não pode ser vazio.');
        retorno = false;
    } 
    if(retorno && txt_monitoramento == '') {
        js_alert('', 'Campo MONITORAMENTO não pode ser vazio.');
        retorno = false;
    }
    if(retorno) {
        var qtd_campos = 0;        
        switch(txt_monitoramento.toLowerCase()) {
            case 'mensal':
                qtd_campos = 12/1;            
                
                break;
            case 'bimestral':
                qtd_campos = 12/2;
    
                break;
            case 'trimestral':
                qtd_campos = 12/3;
    
                break;
            case 'quadrimestral':
                qtd_campos = 12/4;
    
                break;
            case 'semestral':
                qtd_campos = 12/6;
    
                break;
            default:
                qtd_campos = 0;                
        }
        /*if (qtd_campos > 0) {
            var ct = 1;
            var campo = '';
            while (ct <= qtd_campos) {
                campo = $('#cod_meta' + ct).val();
                if (campo == '') {
                    js_alert('', 'Campo META/MONITORAMENTO não pode ser vazio.');
                    retorno = false;
                    break;
                }
                ct += 1;
            }
        }*/
    }    
    if(!retorno) {
        return retorno;
    }  else {
        $('#frm1').attr('action', 'manter.php');
        if ($('#acao').val() != 'alterar') {
            $('#acao').val('incluir');       
        } else {
            $('#acao').val('alterar');  
        }                          
        return retorno;
    }
}

function Excluir(cod_objetivo) {
    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR O REGISTRO? TODOS OS REGISTROS DE INDICADORES SERÃO APAGADOS.',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'excluir',                        
                        cod_objetivo: cod_objetivo
                    },
                    async: false,
                    success: function (data) {                        
                        js_go('default.php');                                  
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

function ValidarCamposDetalhamento() {    
    if ($('#cod_periodo').val() == '') {
        js_alert('', 'PERÍODO não pode ser vazio.');
        return false;
    }
    if ($('#cod_numerador').val() == '') {
        js_alert('', 'NUMERADOR não pode ser vazio.');
        return false;
    }
    if ($('#cod_denominador').val() == '') {
        js_alert('', 'DENOMINADOR não pode ser vazio.');
        return false;
    }
    if ($('#cod_resultado').val() == '') {
        js_alert('', 'RESULTADO não pode ser vazio.');
        return false;
    }

    $.ajax({
        type: 'POST',
        url: 'manter.php',
        data: {
            acao: 'incluir_detalhe',
            id: $('#id').val(),
            cod_periodo: $('#cod_periodo').val(),
            cod_numerador: $('#cod_numerador').val(),
            cod_denominador: $('#cod_denominador').val(),
            cod_resultado: $('#cod_resultado').val()               				
        },
        async: false,
        success: function (data) {
                                              
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });

    js_go('detalhamento.php?id=' + $('#id').val());    
    return true;
}

function ExcluirDetalhe(cod_chave, cod_periodo) {
    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR O REGISTRO?',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'excluir_detalhe',
                        id: cod_chave,
                        cod_periodo: cod_periodo              				
                    },
                    async: false,
                    success: function (data) {
                        js_go('detalhamento.php?id=' + $('#id').val());                               
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

function ValidarCamposAnalise() {   
    var cod_periodo = $('#cod_periodo').val(); 
    var txt_analise = $('#txt_analise' + cod_periodo).val(); 
    var txt_analise_2 = ''; 
    var cod_responsavel_tecnico_2_existe = $('#cod_responsavel_tecnico_2_existe' + cod_periodo).val();
    var txt_encaminhamento = $('#txt_encaminhamento' + cod_periodo).val();         
    var cod_numerador = $('#cod_numerador' + cod_periodo).val();
    var cod_denominador = $('#cod_denominador' + cod_periodo).val();
    var cod_resultado = 0; //$('#cod_resultado' + cod_periodo).val(); 
    var polaridade = $('#polaridade').val();  
    var dt_extracao = $('#dt_extracao' + cod_periodo).val();    
    var txt_meta_parcial = $('#txt_meta_parcial' + cod_periodo).val();   
    var absoluto = $('#absoluto').val();   
    var data = new Date();      
    var mes = data.getMonth(); // 0-11 (zero=janeiro)
    mes = mes + 1;    

    if (txt_meta_parcial == undefined) {
        txt_meta_parcial = '';
    }

    if (cod_periodo == '') {
        js_alert('', 'PERÍODO não pode ser vazio.');
        return false;
    }    
    if (cod_numerador == '') {
        js_alert('', 'NUMERADOR não pode ser vazio.');
        return false;
    }
    if (cod_denominador == '' && absoluto != 'SIM') {
        js_alert('', 'DENOMINADOR não pode ser vazio.');
        return false;        
    } 
    if (cod_denominador.toString() == '0' && absoluto != 'SIM') {
        js_alert('', 'Informe um valor maior que zero no campo DENOMINADOR.');
        return false;  
    }
    if(cod_denominador == '' && absoluto == 'SIM') {
        cod_denominador = 0;
    }   
    if (dt_extracao == '') {
        js_alert('', 'DATA EXTRAÇÃO não pode ser vazio.');
        return false;
    } else {
        if (!validateDate(dt_extracao)) {
            js_alert('', 'DATA EXTRAÇÃO inválida.');
            return false;
        }
    }    
    if (txt_encaminhamento == '' && txt_meta_parcial != '') {
        js_alert('', 'ENCAMINHAMENTO não pode ser vazio.');
        return false;
    }  
    if (txt_analise == '' && txt_meta_parcial != '' && cod_responsavel_tecnico_2_existe.toString() == '0') {
        js_alert('', 'ANÁLISE não pode ser vazio.');
        return false;
    }
    if (cod_responsavel_tecnico_2_existe.toString() == '1') {
        txt_analise_2 = $('#txt_analise_2' + cod_periodo).val(); 

        /*if (txt_analise_2 == '' && txt_meta_parcial != '') {
            js_alert('', 'ANÁLISE não pode ser vazio.');
            return false;
        }*/
    }      
    
    if (cod_periodo > mes) {
        var r = confirm("Você está salvando informações em mês superior a data atual, deseja continuar?");
        if (!r) {            
            return false;
        }                    
    }
    
    //REGIÃO      
    var cod_regiao_tipo = $('#cod_regiao_tipo').val();      

    if (parseInt(cod_regiao_tipo) == 3) {
        //RA
        var cod_ra_qtd = 0;
        var ra_cod_numerador_regiao = '';           
        var ra_numerador = '';     
        var ra_cod_denominador_regiao = '';
        var ra_denominador = '';  
        var ra_dt_extracao_regiao = '';
        var ra_extracao = ''; 

        cod_ra_qtd = $('#cod_ra_qtd').val();        
        var ct_ra = 1;        

        while (parseInt(ct_ra) <= parseInt(cod_ra_qtd)) {
            ra_numerador = $('#ra_cod_numerador_regiao' + cod_periodo + '_' + ct_ra).val();
            ra_denominador = $('#ra_cod_denominador_regiao' + cod_periodo + '_' + ct_ra).val();
            ra_extracao = $('#ra_dt_extracao_regiao' + cod_periodo + '_' + ct_ra).val();

            if (ra_numerador != '') {
                ra_cod_numerador_regiao += '[' + ct_ra + '_' + ra_numerador + ']';
            }      
            if (ra_denominador != '') {
                ra_cod_denominador_regiao += '[' + ct_ra + '_' + ra_denominador + ']';
            }     
            if (ra_extracao != '') {
                ra_dt_extracao_regiao += '[' + ct_ra + '_' + ra_extracao + ']';
            }    
            
            if (ra_numerador != '' && ra_denominador != '' && ra_extracao == '') {
                js_alert('', 'Campo DATA EXTRAÇÃO da RA não pode ser vazio.');
                return false;
            }

            ct_ra += 1;
        }
    }     
    else if (parseInt(cod_regiao_tipo) == 2) {
        //Hospitais/URD        
        var cod_hosp_qtd = 0;
        var hosp_cod_numerador_regiao = '';           
        var hosp_numerador = '';     
        var hosp_cod_denominador_regiao = '';
        var hosp_denominador = '';  
        var hosp_dt_extracao_regiao = '';
        var hosp_extracao = ''; 

        cod_hosp_qtd = $('#cod_hosp_qtd').val();        
        var ct_hosp = 1;

        while (parseInt(ct_hosp) <= parseInt(cod_hosp_qtd)) {
            hosp_numerador = $('#hosp_cod_numerador_regiao' + cod_periodo + '_' + ct_hosp).val();
            hosp_denominador = $('#hosp_cod_denominador_regiao' + cod_periodo + '_' + ct_hosp).val();
            hosp_extracao = $('#hosp_dt_extracao_regiao' + cod_periodo + '_' + ct_hosp).val();           

            if (hosp_numerador != '') {
                hosp_cod_numerador_regiao += '[' + ct_hosp + '_' + hosp_numerador + ']';
            }      
            if (hosp_denominador != '') {
                hosp_cod_denominador_regiao += '[' + ct_hosp + '_' + hosp_denominador + ']';
            }     
            if (hosp_extracao != '') {
                hosp_dt_extracao_regiao += '[' + ct_hosp + '_' + hosp_extracao + ']';
            }     

            if (hosp_numerador != '' && hosp_denominador != '' && hosp_extracao == '') {
                js_alert('', 'Campo DATA EXTRAÇÃO da RA não pode ser vazio.');
                return false;
            }

            ct_hosp += 1;
        }
       
        var cod_urd_qtd = 0;
        var urd_cod_numerador_regiao = '';           
        var urd_numerador = '';     
        var urd_cod_denominador_regiao = '';
        var urd_denominador = '';  
        var urd_dt_extracao_regiao = '';
        var urd_extracao = ''; 

        //cod_urd_qtd = $('#cod_urd_qtd').val();        
        cod_urd_qtd = 6;
        var ct_urd = 3;

        while (parseInt(ct_urd) >= 3 && parseInt(ct_urd) <= parseInt(cod_urd_qtd)) {
            urd_numerador = $('#urd_cod_numerador_regiao' + cod_periodo + '_' + ct_urd).val();
            urd_denominador = $('#urd_cod_denominador_regiao' + cod_periodo + '_' + ct_urd).val();
            urd_extracao = $('#urd_dt_extracao_regiao' + cod_periodo + '_' + ct_urd).val();

            if (urd_numerador != '') {
                urd_cod_numerador_regiao += '[' + ct_urd + '_' + urd_numerador + ']';
            }      
            if (urd_denominador != '') {
                urd_cod_denominador_regiao += '[' + ct_urd + '_' + urd_denominador + ']';
            }     
            if (urd_extracao != '') {
                urd_dt_extracao_regiao += '[' + ct_urd + '_' + urd_extracao + ']';
            }    
            
            if (urd_numerador != '' && urd_denominador != '' && urd_extracao == '') {
                js_alert('', 'Campo DATA EXTRAÇÃO da RA não pode ser vazio.');
                return false;
            }

            ct_urd += 1;
        }
        
    } else if (parseInt(cod_regiao_tipo) == 1) {      
        //Região de Saúde/URD        
        var cod_reg_qtd = 0;
        var reg_cod_numerador_regiao = '';           
        var reg_numerador = '';     
        var reg_cod_denominador_regiao = '';
        var reg_denominador = '';  
        var reg_dt_extracao_regiao = '';
        var reg_extracao = ''; 

        cod_reg_qtd = $('#cod_reg_qtd').val();        
        var ct_reg = 1;        

        while (parseInt(ct_reg) <= parseInt(cod_reg_qtd)) {
            reg_numerador = $('#reg_cod_numerador_regiao' + cod_periodo + '_' + ct_reg).val();
            reg_denominador = $('#reg_cod_denominador_regiao' + cod_periodo + '_' + ct_reg).val();
            reg_extracao = $('#reg_dt_extracao_regiao' + cod_periodo + '_' + ct_reg).val();

            if (reg_numerador != '') {
                reg_cod_numerador_regiao += '[' + ct_reg + '_' + reg_numerador + ']';
            }      
            if (reg_denominador != '') {
                reg_cod_denominador_regiao += '[' + ct_reg + '_' + reg_denominador + ']';
            }     
            if (reg_extracao != '') {
                reg_dt_extracao_regiao += '[' + ct_reg + '_' + reg_extracao + ']';
            }   
            
            if (reg_numerador != '' && reg_denominador != '' && reg_extracao == '') {
                js_alert('', 'Campo DATA EXTRAÇÃO da RA não pode ser vazio.');
                return false;
            }

            ct_reg += 1;
        }

        var cod_urd_qtd = 0;
        var urd_cod_numerador_regiao = '';           
        var urd_numerador = '';     
        var urd_cod_denominador_regiao = '';
        var urd_denominador = '';  
        var urd_dt_extracao_regiao = '';
        var urd_extracao = ''; 

        //cod_urd_qtd = $('#cod_urd_qtd').val();        
        cod_urd_qtd = 6;
        var ct_urd = 3;

        while (parseInt(ct_urd) >= 3 && parseInt(ct_urd) <= parseInt(cod_urd_qtd)) {
            urd_numerador = $('#urd_cod_numerador_regiao' + cod_periodo + '_' + ct_urd).val();
            urd_denominador = $('#urd_cod_denominador_regiao' + cod_periodo + '_' + ct_urd).val();
            urd_extracao = $('#urd_dt_extracao_regiao' + cod_periodo + '_' + ct_urd).val();

            if (urd_numerador != '') {
                urd_cod_numerador_regiao += '[' + ct_urd + '_' + urd_numerador + ']';
            }      
            if (urd_denominador != '') {
                urd_cod_denominador_regiao += '[' + ct_urd + '_' + urd_denominador + ']';
            }     
            if (urd_extracao != '') {
                urd_dt_extracao_regiao += '[' + ct_urd + '_' + urd_extracao + ']';
            } 
            
            if (urd_numerador != '' && urd_denominador != '' && urd_extracao == '') {
                js_alert('', 'Campo DATA EXTRAÇÃO da RA não pode ser vazio.');
                return false;
            }

            ct_urd += 1;
        }
    } 
    else if (parseInt(cod_regiao_tipo) == 4) {      
        //Região de Saúde        
        var cod_reg_qtd = 0;
        var reg_cod_numerador_regiao = '';           
        var reg_numerador = '';     
        var reg_cod_denominador_regiao = '';
        var reg_denominador = '';  
        var reg_dt_extracao_regiao = '';
        var reg_extracao = ''; 

        cod_reg_qtd = $('#cod_reg_qtd').val();        
        var ct_reg = 1;        

        while (parseInt(ct_reg) <= parseInt(cod_reg_qtd)) {
            reg_numerador = $('#reg_cod_numerador_regiao' + cod_periodo + '_' + ct_reg).val();
            reg_denominador = $('#reg_cod_denominador_regiao' + cod_periodo + '_' + ct_reg).val();
            reg_extracao = $('#reg_dt_extracao_regiao' + cod_periodo + '_' + ct_reg).val();

            if (reg_numerador != '') {
                reg_cod_numerador_regiao += '[' + ct_reg + '_' + reg_numerador + ']';
            }      
            if (reg_denominador != '') {
                reg_cod_denominador_regiao += '[' + ct_reg + '_' + reg_denominador + ']';
            }     
            if (reg_extracao != '') {
                reg_dt_extracao_regiao += '[' + ct_reg + '_' + reg_extracao + ']';
            }     

            if (reg_numerador != '' && reg_denominador != '' && reg_extracao == '') {
                js_alert('', 'Campo DATA EXTRAÇÃO da REGIÃO não pode ser vazio.');
                return false;
            }

            ct_reg += 1;
        }

    } else if (parseInt(cod_regiao_tipo) == 5) {
        //Hospitais/Hospitais Conveniados
        var cod_hosp_qtd = 0;
        var hosp_cod_numerador_regiao = '';           
        var hosp_numerador = '';     
        var hosp_cod_denominador_regiao = '';
        var hosp_denominador = '';  
        var hosp_dt_extracao_regiao = '';
        var hosp_extracao = ''; 

        cod_hosp_qtd = $('#cod_hosp_qtd').val();        
        var ct_hosp = 1;

        while (parseInt(ct_hosp) <= parseInt(cod_hosp_qtd)) {
            hosp_numerador = $('#hosp_cod_numerador_regiao' + cod_periodo + '_' + ct_hosp).val();
            hosp_denominador = $('#hosp_cod_denominador_regiao' + cod_periodo + '_' + ct_hosp).val();
            hosp_extracao = $('#hosp_dt_extracao_regiao' + cod_periodo + '_' + ct_hosp).val();           

            if (hosp_numerador != '') {
                hosp_cod_numerador_regiao += '[' + ct_hosp + '_' + hosp_numerador + ']';
            }      
            if (hosp_denominador != '') {
                hosp_cod_denominador_regiao += '[' + ct_hosp + '_' + hosp_denominador + ']';
            }     
            if (hosp_extracao != '') {
                hosp_dt_extracao_regiao += '[' + ct_hosp + '_' + hosp_extracao + ']';
            }     

            if (hosp_numerador != '' && hosp_denominador != '' && hosp_extracao == '') {
                js_alert('', 'Campo DATA EXTRAÇÃO da RA não pode ser vazio.');
                return false;
            }

            ct_hosp += 1;
        }

        var cod_hosp_qtd_conv = 0;
        var hosp_cod_numerador_regiao_conv = '';           
        var hosp_numerador_conv = '';     
        var hosp_cod_denominador_regiao_conv = '';
        var hosp_denominador_conv = '';  
        var hosp_dt_extracao_regiao_conv = '';
        var hosp_extracao_conv = ''; 

        cod_hosp_qtd_conv = $('#cod_hosp_qtd_conv').val();        
        var ct_hosp_conv = 12;

        while (parseInt(ct_hosp_conv) <= parseInt(cod_hosp_qtd_conv)) {
            hosp_numerador_conv = $('#hosp_cod_numerador_regiao_conv' + cod_periodo + '_' + ct_hosp_conv).val();
            hosp_denominador_conv = $('#hosp_cod_denominador_regiao_conv' + cod_periodo + '_' + ct_hosp_conv).val();
            hosp_extracao_conv = $('#hosp_dt_extracao_regiao_conv' + cod_periodo + '_' + ct_hosp_conv).val();           

            if (hosp_numerador_conv != '') {
                hosp_cod_numerador_regiao_conv += '[' + ct_hosp_conv + '_' + hosp_numerador_conv + ']';
            }      
            if (hosp_denominador_conv != '') {
                hosp_cod_denominador_regiao_conv += '[' + ct_hosp_conv + '_' + hosp_denominador_conv + ']';
            }     
            if (hosp_extracao_conv != '') {
                hosp_dt_extracao_regiao_conv += '[' + ct_hosp_conv + '_' + hosp_extracao_conv + ']';
            }   
            
            if (hosp_numerador_conv != '' && hosp_denominador_conv != '' && hosp_extracao_conv == '') {
                js_alert('', 'Campo DATA EXTRAÇÃO da RA não pode ser vazio.');
                return false;
            }

            ct_hosp_conv += 1;
        }
    } 
   
    $.ajax({
        type: 'POST',
        url: 'manter.php',
        data: {
            acao: 'incluir_analise',
            id: $('#id').val(),
            cod_periodo: cod_periodo,
            txt_analise: txt_analise,
            txt_analise_2: txt_analise_2,
            txt_encaminhamento: txt_encaminhamento,                        
            cod_numerador: cod_numerador,
            cod_denominador: cod_denominador,
            cod_resultado: cod_resultado,
            polaridade: polaridade,
            dt_extracao: dt_extracao,
            txt_meta_parcial: txt_meta_parcial,
            absoluto: absoluto, 
            cod_ra_qtd: cod_ra_qtd,
            cod_regiao_tipo: cod_regiao_tipo,
            ra_cod_numerador_regiao: ra_cod_numerador_regiao,
            ra_cod_denominador_regiao: ra_cod_denominador_regiao,
            ra_dt_extracao_regiao: ra_dt_extracao_regiao,
            cod_reg_qtd: cod_reg_qtd,
            reg_cod_numerador_regiao: reg_cod_numerador_regiao,
            reg_cod_denominador_regiao: reg_cod_denominador_regiao,
            reg_dt_extracao_regiao: reg_dt_extracao_regiao,
            cod_urd_qtd: cod_urd_qtd,
            urd_cod_numerador_regiao: urd_cod_numerador_regiao,
            urd_cod_denominador_regiao: urd_cod_denominador_regiao,
            urd_dt_extracao_regiao: urd_dt_extracao_regiao,
            cod_hosp_qtd: cod_hosp_qtd,
            hosp_cod_numerador_regiao: hosp_cod_numerador_regiao,
            hosp_cod_denominador_regiao: hosp_cod_denominador_regiao,
            hosp_dt_extracao_regiao: hosp_dt_extracao_regiao,
            cod_hosp_qtd_conv: cod_hosp_qtd_conv,
            hosp_cod_numerador_regiao_conv: hosp_cod_numerador_regiao_conv,
            hosp_cod_denominador_regiao_conv: hosp_cod_denominador_regiao_conv,
            hosp_dt_extracao_regiao_conv: hosp_dt_extracao_regiao_conv
        },
        async: false,
        success: function (data) {                                                                          
            js_go('analise.php?id=' + $('#id').val() + '&periodo=' + cod_periodo);  
            return true;                                             
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
            return false;
        }
    });                  
}

function ExcluirAnalise(cod_chave, cod_periodo) {
    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR AS INFORMAÇÕES REGISTRADAS?',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'excluir_analise',
                        id: cod_chave,
                        cod_periodo: cod_periodo              				
                    },
                    async: false,
                    success: function (data) {
                        js_go('analise.php?id=' + $('#id').val());                               
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

function setIndicador(codigo_indicador) {
    if (codigo_indicador != '') { 
        RecuperarDadosMGI(codigo_indicador);
    } 
    else {
            $('#cod_responsavel_gerencial').val('');
            $('#cod_responsavel_tecnico').val(''); 
            $('#div_instrumento').html('');
            $('#div_unidade_medida').html('');
            //$('#div_acumulativo').html('');         
            $('#div_monitoramento').html('');
            $('#div_meta_monitoramento').html('');         
    }                  
}

function RecuperarDadosMGI(id) {
    $.ajax({
        type: 'POST',
        url: 'manter.php',
        data: {
            acao: 'tabela_indicador',                        
            id: id
        },
        async: false,
        success: function (data) {                        
            var obj = JSON.parse(data);

            var div = '';  
            try {                                
                for (i = 0; i < obj.ResponsavelGerencial[0].ancestors.length; i++) {                    
                    div += obj.ResponsavelGerencial[0].ancestors[i].sigla + '/';                    
                }                 
                div = div.substr(0,(div.length - 1));                  
            }            
            catch(err) {
                
            }            

            $('#div_responsavel_gerencial').html(div);

            div = '';            
            try {                                                                
                for (i = 0; i < obj.ResponsavelTecnico[0].ancestors.length; i++) {                    
                    div += obj.ResponsavelTecnico[0].ancestors[i].sigla + '/';                    
                }                 
                div = div.substr(0,(div.length - 1));                  
            }
            catch(err) {

            }            

            //$('#div_responsavel_tecnico').html(div);

            //INSTRUMENTO DE PLANEJAMENTO
            var instrumento = '';
            try {
                for (i = 0; i < obj.Tags.length; i++) { 
                    instrumento += '<button class="btn btn-primary btn-sm" disabled="disabled">' + obj.Tags[i].descricao + '</button>&nbsp;';
                }
                            
            }
            catch(err) {

            }
            
            if (instrumento == '') {
                instrumento = '';
            }
            
            $('#div_instrumento').html(instrumento);

            //UNIDADE DE MEDIDA
            var unidade = '';  
            try {
                unidade += obj.UnidadeMedida.descricao;
            }            
            catch(err) {
                
            }            
            
            $('#div_unidade_medida').html(unidade);   
            
            //ACUMULATIVO
            /*
            var acumulativo = '';            
            try {
                var acumulativo_checked = '';
                if (obj.acumulativo) {                 
                    acumulativo = 'SIM';
                }
                else 
                {
                    acumulativo = 'NÃO';
                }                
            }            
            catch(err) {
                
            }                        
            */
           
            //$('#div_acumulativo').html(acumulativo);             

            //MONITORAMENTO
            var monitoramento = '';
            try {
                monitoramento += obj.PeriodicidadeMonitoramento.descricao;
                $('#txt_monitoramento').val(obj.PeriodicidadeMonitoramento.descricao);    
            }            
            catch(err) {
                $('#txt_monitoramento').val('');
            }

            $('#div_monitoramento').html(monitoramento); 

            //META MONITORAMENTO
            MetaMonitoramento(data);

        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });
}

function MetaMonitoramento(data) {
    /* 
    TIPOS DE MONITORAMENTO    
    MENSAL -> 12/12 = 1
    BIMESTRAL -> 12/2 = 6
    TRIMESTRAL -> 12/3 = 4
    QUADRIMESTRAL -> 12/4 = 3    
    SEMESTRAL -> 12/6 = 2
    */
    var meta_monitoramento = '';
    var qtd_campos = 0;
    var ct = 1;
    var obj = JSON.parse(data);
    var txt_monitoramento = obj.PeriodicidadeMonitoramento.descricao.toLowerCase();    
    switch(txt_monitoramento) {
        case 'mensal':
            qtd_campos = 12/1;            
            qtd_ct = 1;
            qtd_soma = qtd_ct;
            break;
        case 'bimestral':
            qtd_campos = 12/2;
            qtd_ct = 2;
            qtd_soma = qtd_ct;
            break;
        case 'trimestral':
            qtd_campos = 12/3;
            qtd_ct = 3;
            qtd_soma = qtd_ct;
            break;
        case 'quadrimestral':
            qtd_campos = 12/4;
            qtd_ct = 4;
            qtd_soma = qtd_ct;
            break;
        case 'semestral':
            qtd_campos = 12/6;
            qtd_ct = 6;
            qtd_soma = qtd_ct;
            break;
        default:
            qtd_campos = 0;
            qtd_ct = qtd_campos;
            qtd_soma = qtd_ct;
            meta_monitoramento = '';
    }
    if (qtd_campos > 0) {
        meta_monitoramento += '<div class="table-responsive col-md-12">';
        meta_monitoramento += '<table class="table table-striped" cellspacing="0" cellpadding="0">';
        meta_monitoramento += '<tbody><tr>';
        while (ct <= qtd_campos) {
            meta_monitoramento += '<td>';
            meta_monitoramento += '<input type="text" class="form-control_custom" id="cod_meta' + qtd_ct + '" name="cod_meta' + qtd_ct + '">';
            meta_monitoramento += '</td>';
            ct += 1;
            qtd_ct += qtd_soma;
        }
        meta_monitoramento += '</tbody></tr>';
        meta_monitoramento += '</table>';
        meta_monitoramento += '</div>';
    }                    

    $('#div_meta_monitoramento').html(meta_monitoramento); 

    //POPULAR CAMPOS META/MONITORAMENTO
    var str = window.location.href;
    var n = str.indexOf("indicador/alterar.php");
    if (n > 0) {
        $.ajax({
            type: 'POST',
            url: 'manter.php',
            data: {
                acao: 'tabela_meta_monitoramento',
                id: $('#id').val()
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);                                

                obj.forEach(function(i, item){
                    if(i.campo_1 != '') {
                        $('#cod_meta1').val(i.campo_1);
                    }
                    if(i.campo_2 != '') {
                        $('#cod_meta2').val(i.campo_2);
                    }
                    if(i.campo_3 != '') {
                        $('#cod_meta3').val(i.campo_3);
                    }
                    if(i.campo_4 != '') {
                        $('#cod_meta4').val(i.campo_4);
                    }
                    if(i.campo_5 != '') {
                        $('#cod_meta5').val(i.campo_5);
                    }
                    if(i.campo_6 != '') {
                        $('#cod_meta6').val(i.campo_6);
                    }
                    if(i.campo_7 != '') {
                        $('#cod_meta7').val(i.campo_7);
                    }
                    if(i.campo_8 != '') {
                        $('#cod_meta8').val(i.campo_8);
                    }
                    if(i.campo_9 != '') {
                        $('#cod_meta9').val(i.campo_9);
                    }
                    if(i.campo_10 != '') {
                        $('#cod_meta10').val(i.campo_10);
                    }
                    if(i.campo_11 != '') {
                        $('#cod_meta11').val(i.campo_11);
                    }
                    if(i.campo_12 != '') {
                        $('#cod_meta12').val(i.campo_12);
                    }                    
                });                                
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });     
    }        
}

function ExcluirIndicador(cod_chave) {
    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR O REGISTRO? TODOS OS REGISTROS DE ANÁLISE E DETALHAMENTO SERÃO APAGADOS.',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'excluir_indicador',                        
                        id: cod_chave
                    },
                    async: false,
                    success: function (data) {                        
                        js_go('default.php');                                  
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


function CarregarFormularioAlterar() {
    if ($('#acao').val() == 'alterar') {   
        var cod_objetivo = $('#cod_objetivo').val();
        var cod_objetivo_ppa = $('#cod_objetivo_ppa_').val(); 
        var cod_indicador = $('#cod_indicador_').val();       
        
        monta_arvore(cod_objetivo);

        //MONTAR COMBO OBJETIVO PPA
        combo_ppa(cod_objetivo);
        $('#cod_objetivo_ppa').val(cod_objetivo_ppa);

        //DADOS MGI        
        $('#cod_indicador').val(cod_indicador);
        setIndicador(cod_indicador);        
    }
}

function CampoFormula() {    
    var str = window.location.href;
    str = str.toLowerCase();
    var n = str.indexOf('sistema/indicador/incluir.php');
    var m = str.indexOf('sistema/indicador/alterar.php');    
    if(n > 0 || m > 0) {
        var cod_dados_mgi_ = $('#cod_dados_mgi').val();        
        if (cod_dados_mgi_.toString() == '1') {
            $('#div_formula').html('');
        } else {
            var div = '';            
            div += '<div class="col-md-6">';
            div += '<label for="exampleInputEmail1">Fórmula:</label>';
            div += '<textarea class="form-control" rows="5" id="txt_formula" name="txt_formula"></textarea>';
            div += '</div>';                        

            $('#div_formula').html(div);
        }
    }
    
    if (m > 0) {
        $.ajax({
            type: 'POST',
            url: 'manter.php',
            data: {
                acao: 'retorna_formula',                        
                id: $('#id').val()
            },
            async: false,
            success: function (data) {                        
                $('#txt_formula').val(data);                       
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });
    }
}

function SubmitForm() {    
    document.getElementById('frm1').submit();
}

function LimparForm() {    
    self.location.href = 'default.php'; 
}

function FormRA() {    
    var cod_periodo = $('#cod_periodo').val();
    var cod_regiao = $('#cod_regiao').val();
    var disabled = $('#disabled').val();
    var bloquear_denominador = $('#bloquear_denominador').val();
    var div = '';
    
    if (cod_regiao == 1) {
        div += '<div class="row">';
            div += '<div class="table-responsive col-md-12">';
                div += '<center><h3><b>Região</b></h3></center>';

                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'combo_regiao'            
                    },
                    async: false,
                    success: function (data) {                                               
                        var obj = JSON.parse(data);     
                        div += '<center>';                                                                                 
                        div += '<select id="cod_regiao_analise'+ cod_periodo +'" name="cod_regiao_analise'+ cod_periodo +'" class="form-control" onchange="ComboRA(this.value);">';
                        div += '<option></option>';
                        obj.forEach(function(i, item) {                        
                            div += '<option value="'+ i.cod_regiao +'">'+ i.txt_regiao +'</option>'
                        });
                        div += '</select>';
                        div += '</center>';
                    },				
                    error: function (xhr, status, error) {
                        alert(xhr.responseText);    				
                    }
                });                
            div += '</div>';
        div += '</div>';

        $('#div_regiao' + cod_periodo).html(div);  
               
    } else {
        $('#div_regiao' + cod_periodo).html('');
        $('#div_ra' + cod_periodo).html('');
    }
}

function ComboRA(cod) {
    var cod_periodo = $('#cod_periodo').val();

    if (cod != '') {
        $.ajax({
            type: 'POST',
            url: 'manter.php',
            data: {
                acao: 'combo_ra',
                cod_regiao: cod
            },
            async: false,
            success: function (data) {
                var ct = 1                                         
                var a = data.split('|');
                var obj = JSON.parse(a[0]);
                var div = '';

                div += '<table class="table table-striped" cellspacing="0" cellpadding="0">';
                    div += '<thead>';
                        div += '<tr>';                                                                                                             
                            div += '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RA:</th>';
                            div += '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Numerador:</th>';
                            div += '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Denominador:</th>';
                            div += '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Resultado:</th>';
                            div += '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data Extração:</th>';        
                        div += '</tr>';
                    div += '</thead>';        
                    div += '<tbody>';                                                
                        obj.forEach(function(j, item) {                        
                            div += '<tr>';                                                                    
                                div += '<td><input type="text" class="form-control" id="cod_ra_analise'+ cod_periodo +'-'+ j.cod_ra +'" name="cod_ra_analise'+ cod_periodo +'-'+ j.cod_ra +'" value="'+ j.txt_ra +'" disabled="disabled"></td>';                                
                                div += '<td><input type="text" class="form-control" id="cod_regiao_numerador'+ cod_periodo +'-'+ j.cod_ra +'" name="cod_regiao_numerador'+ cod_periodo +'-'+ j.cod_ra +'" '+ disabled +'></td>';
                                div += '<td><input type="text" class="form-control" id="cod_regiao_denominador'+ cod_periodo +'-'+ j.cod_ra +'" name="cod_regiao_denominador'+ cod_periodo +'-'+ j.cod_ra +'" '+ bloquear_denominador +'></td>';
                                div += '<td><input type="text" class="form-control" id="cod_regiao_resultado'+ cod_periodo +'-'+ j.cod_ra +'" name="cod_regiao_resultado'+ cod_periodo +'-'+ j.cod_ra +'" disabled="disabled"></td>';
                                div += '<td><input type="text" class="form-control" id="dt_regiao_extracao'+ cod_periodo +'-'+ j.cod_ra +'" name="dt_regiao_extracao'+ cod_periodo +'-'+ j.cod_ra +'" onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)" '+ disabled +'></td>';                                
                            div += '</tr>';                             
                        });                                                                 
                    div += '</tbody>';
                div += '</table>';                
                
                $('#div_ra' + cod_periodo).html(div);                       
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });
    } else {
        $('#div_ra' + cod_periodo).html('');
    }
}