$(document).ready(function() {        
    CarregarFormularioAlterar();                
});

function ValidarCampos() {
    if ($('#cod_periodo').val() == '') {
        js_alert('', 'PERÍODO não pode ser vazio.');
        return false;
    }



    if ($('#nr_meta_analise').val() == '') {
        js_alert('', 'QUANTIDADE PARCIAL não pode ser vazio.');
        return false;
    }

    if ($('#nr_mes_1').val() == '') {
        js_alert('', 'REALIZADO 1 não pode ser vazio.');
        return false;
    }

    if ($('#nr_mes_2').val() == '') {
        js_alert('', 'REALIZADO 2 não pode ser vazio.');
        return false;
    }


    if ($('#txt_analise').val() == '') {
        js_alert('', 'ANALISE/JUSTIFICATIVA não pode ser vazio.');
        return false;
    }

    $.ajax({
        type: 'POST',
        url: 'manter.php',
        data: {
            acao: 'incluir_analise',
            id: $('#cod_sag').val(),
            cod_bimeste: $('#cod_periodo').val(),
            nr_meta_analise: $('#nr_meta_analise').val(),
            nr_mes_1: $('#nr_mes_1').val(),
            nr_mes_2: $('#nr_mes_2').val(),
            txt_analise: $('#txt_analise').val()              				
        },
        async: false,
        success: function (data) {
                                              
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });

    js_go('analise.php?cod_sag=' + $('#cod_sag').val());
    return true;
}

function ExcluirAnaliseSAG() {
    var cod_sag = $('#cod_sag').val();
    var cod_bimestre = $('#cod_bimestre').val();
    var cod_objetivo_url = $('#cod_objetivo_url').val();

    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR REGISTROS NA ETAPA SAG?',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'excluir_analise',
                        id: cod_sag,
                        cod_bimestre: cod_bimestre              				
                    },
                    async: false,
                    success: function (data) {
                        js_go('analise.php?cod_sag=' + $('#cod_sag').val() + '&cod_objetivo_url=' + cod_objetivo_url);                               
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

function FormDesvio(cod_desvio, cod) {
    var cod_bimestre = $('#cod_bimestre').val();

    if (cod_desvio != '') { 
        if ((cod == 1 && (cod_desvio == 5 || cod_desvio == 4)) || (cod == 2 && (cod_desvio == 1 || cod_desvio == 2 || cod_desvio == 3))) {
            var div = '<br /><br />';
            div += '<div class="row">';
            div += '<div class="table-responsive col-md-12">';
            div += '<table class="table table-striped" cellspacing="0" cellpadding="0">';
            div += '<thead><tr>';
            div += '<th><label for="exampleInputEmail1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Causa do Desvio</label></th>';
            div += '<th><label for="exampleInputEmail1">Natureza do Desvio</label></th>';
            div += '<th><label for="exampleInputEmail1">Análise/Justificativa</label></th>';            
            div += '</tr></thead>';
            div += '<tbody><tr>';
            div += '<td><center><br /><div class="col-md-3">';
            div += '<select id="cod_causa_desvio'+cod_bimestre+'" name="cod_causa_desvio'+cod_bimestre+'" class="form-control_select">';            
            div += '<option></option>';

            $.ajax({
                type: 'POST',
                url: 'manter.php',
                data: {
                    acao: 'combo_causa_desvio'            				
                },
                async: false,
                success: function (data) {
                    var obj = JSON.parse(data);                    
                    obj.forEach(function(i, item) {
                        div += '<option value="'+ i.cod_causa +'">'+ i.txt_causa +'</option>';
                    });
                },				
                error: function (xhr, status, error) {
                     				
                }
            });

            div += '</select>';
            div += '</div></center></td>';
            div += '<td><center><br /><div class="col-md-3">';
            div += '<select id="cod_natureza_desvio'+cod_bimestre+'" name="cod_natureza_desvio'+cod_bimestre+'" class="form-control_select">';
            div += '<option></option>';

            $.ajax({
                type: 'POST',
                url: 'manter.php',
                data: {
                    acao: 'combo_natureza_desvio'            				
                },
                async: false,
                success: function (data) {
                    var obj = JSON.parse(data);                    
                    obj.forEach(function(i, item) {
                        div += '<option value="'+ i.cod_natureza +'">'+ i.txt_natureza +'</option>';
                    });
                },				
                error: function (xhr, status, error) {
                    
                }
            });

            div += '</select>';
            div += '</div></center></td>';
            div += '<td><div class="col-md-6">';
            div += '<textarea class="form-control" rows="5" id="txt_analise_desvio'+cod_bimestre+'" name="txt_analise_desvio'+cod_bimestre+'"></textarea>'; 
            div += '</div></td>';
            div += '</tr></tbody>';
            div += '</table></div></div>';
        }              
        else {
            $('#div_desvio'+cod_bimestre).html('');
        }        

        $('#div_desvio'+cod_bimestre).html(div);
    } else {
        $('#div_desvio'+cod_bimestre).html('');
    }
}

function SalvarAnalise() {
    var retorno = true;
    var cod_sag = $('#cod_sag').val();
    var cod_bimestre = $('#cod_bimestre').val();
    var cod_obra = $('#cod_obra').val();
    var txt_realizado_1 = $('#txt_realizado_1' + cod_bimestre).val();
    var txt_realizado_2 = $('#txt_realizado_2' + cod_bimestre).val();
    var txt_percentual = $('#txt_percentual' + cod_bimestre).val();
    var txt_analise_obra = $('#txt_analise_obra' + cod_bimestre).val();
    var nr_mes_1 = $('#nr_mes_1' + cod_bimestre).val();
    var nr_mes_2 = $('#nr_mes_2' + cod_bimestre).val();    
    var txt_analise = $('#txt_analise' + cod_bimestre).val();
    var cod_situacao = $('#cod_situacao' + cod_bimestre).val();
    var cod_controle = $('#cod_controle' + cod_bimestre).val();
    var cod_causa_desvio = $('#cod_causa_desvio' + cod_bimestre).val();
    var cod_natureza_desvio = $('#cod_natureza_desvio' + cod_bimestre).val();
    var txt_analise_desvio = $('#txt_analise_desvio' + cod_bimestre).val();
    var cod_inicio_efetivo = $('#cod_inicio_efetivo').val();
    var cod_fim_efetivo = $('#cod_fim_efetivo').val();
    var cod_status = $('#cod_status_id' + cod_bimestre).val();
    
    if(retorno && cod_inicio_efetivo == '') {
        js_alert('', 'Campo INÍCIO EFETIVO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_fim_efetivo == '' && parseInt(cod_bimestre) == 6) {
        js_alert('', 'Campo FIM EFETIVO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && nr_mes_1 == '') {
        js_alert('', 'Campo REALIZADO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && nr_mes_2 == '') {
        js_alert('', 'Campo REALIZADO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && txt_analise == '') {
        js_alert('', 'Campo ANÁLISE não pode ser vazio.');
        retorno = false;
    }
    
    if (cod_obra == 1) {
        if(retorno && txt_realizado_1 == '') {
            js_alert('', 'Campo REALIZADO não pode ser vazio.');
            retorno = false;
        }
        if(retorno && txt_realizado_2 == '') {
            js_alert('', 'Campo REALIZADO não pode ser vazio.');
            retorno = false;
        }
        if(retorno && txt_percentual == '') {
            js_alert('', 'Campo PERCENTUAL REALIZADO não pode ser vazio.');
            retorno = false;
        }
        if(retorno && txt_analise_obra == '') {
            js_alert('', 'Campo ANÁLISE não pode ser vazio.');
            retorno = false;
        }
        if (retorno && txt_percentual != '') {
            if (!isNumber(txt_percentual)) {
                js_alert('', 'Campo PERCENTUAL REALIZADO deve conter apenas números.');
                retorno = false;
            }
        }
    }    
    
    if(!retorno) {
        return retorno;
    } else {
        $.ajax({
            type: 'POST',
            url: 'manter.php',
            data: {
                acao: 'incluir_analise',
                id: cod_sag,
                cod_bimestre: cod_bimestre,
                cod_obra: cod_obra,
                txt_realizado_1: txt_realizado_1,
                txt_realizado_2: txt_realizado_2,
                txt_percentual: txt_percentual,
                txt_analise_obra: txt_analise_obra,
                nr_mes_1: nr_mes_1,
                nr_mes_2: nr_mes_2,
                txt_analise: txt_analise,
                cod_situacao: cod_situacao,
                cod_controle: cod_controle,
                cod_causa_desvio: cod_causa_desvio,
                cod_natureza_desvio: cod_natureza_desvio,
                txt_analise_desvio: txt_analise_desvio, 
                cod_inicio_efetivo: cod_inicio_efetivo,
                cod_fim_efetivo: cod_fim_efetivo, 
                cod_status_analise: cod_status
            },
            async: false,
            success: function (data) {                 
                //var cod_usuario_analise = $('#cod_usuario_analise' + cod_bimestre).val();
                //if (cod_usuario_analise.toString() == '') {
                    $('#div_registrado' + cod_bimestre).html($('#txt_usuario_operacao').val());
                //}
                js_alert('', 'OPERAÇÃO REALIZADA COM SUCESSO'); 
                return true;                               
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });
    }
}

function CalculoTotalVariacao() {
    var cod_sag = $('#cod_sag').val();
    var cod_bimestre = $('#cod_bimestre').val();
    var cod_acumulativo = $('#cod_acumulativo').val(); 
    var nr_mes_1 = $('#nr_mes_1' + cod_bimestre).val();
    var nr_mes_2 = $('#nr_mes_2' + cod_bimestre).val(); 
    var total_geral = 0;     
    var total = parseInt(nr_mes_1) + parseInt(nr_mes_2);;
    
    if (nr_mes_1 != '' && nr_mes_2 != '') {       
        if (parseInt(cod_acumulativo) == 1) {                       
            $.ajax({
                type: 'POST',
                url: 'manter.php',
                data: {
                    acao: 'sag_total',
                    id: cod_sag,
                    cod_bimestre: cod_bimestre                        
                },
                async: false,
                success: function (data) {  
                    total_geral = parseInt(total) + parseInt(data);
                },				
                error: function (xhr, status, error) {                        

                }
            });

        } else {
            total = parseInt(nr_mes_2);

            if (total == 0) {
                total = parseInt(nr_mes_1);
            }            
            total_geral = total;
        }
                
        $('#cod_total' + cod_bimestre).val(total);        
        $('#cod_total_geral' + cod_bimestre).val(total_geral);        

        if (total != '') {
            var meta = $('#nr_meta' + cod_bimestre).val();
            var resultado = ((parseInt(total_geral) / parseInt(meta) - 1) * 100);
            resultado = parseFloat(resultado.toFixed(2));  
            resultado = resultado.toString().replace(".", ",");          

            $('#txt_variacao' + cod_bimestre).val(resultado + '%');
            
            if (resultado.toString() != '') {                
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'sag_status',
                        txt_variacao: resultado                        
                    },
                    async: false,
                    success: function (data) {  
                        var a_data = data.split('|'); 

                        var div = '<div id = "div_status">';
                        div +=  '<input type="text" class="form-control_custom" id="cod_status'+cod_bimestre+'" name="cod_status'+cod_bimestre+'" style="background-color:'+ a_data[1] +'" value="'+ a_data[0] +'" disabled="disabled" />'; 
                        div += '<input type="hidden" class="form-control" name="cod_status_id'+cod_bimestre+'" id="cod_status_id'+cod_bimestre+'" value="'+ a_data[2] +'" />';
                        div += '</div>';

                        $('#div_status' + cod_bimestre).html(div);                        
                    },				
                    error: function (xhr, status, error) {                        

                    }
                });
            }
        }
    }
}

function CarregarFormularioAlterar() {
    var cod_sag = $('#cod_sag').val();
    var cod_bimestre = $('#cod_bimestre').val();
    var cod_bimestre = $('#cod_bimestre').val();
    var cod_situacao = $('#cod_situacao' + cod_bimestre).val();
    var cod_controle = $('#cod_controle' + cod_bimestre).val();
    var cod_obra = $('#cod_obra').val();

    CalculoTotalVariacao();
    FormDesvio(cod_situacao, 1);
    FormDesvio(cod_controle, 2);

    $.ajax({
        type: 'POST',
        url: 'manter.php',
        data: {
            acao: 'form_alterar_analise',
            id: cod_sag,
            cod_bimestre: cod_bimestre
        },
        async: false,
        success: function (data) {                    
            var obj = JSON.parse(data);                    
            obj.forEach(function(i, item) {
                $('#cod_causa_desvio' + cod_bimestre).val(i.cod_causa_desvio);
                $('#cod_natureza_desvio' + cod_bimestre).val(i.cod_natureza_desvio);
                $('#txt_analise_desvio' + cod_bimestre).val(i.txt_analise_desvio);
            });                    
        }
    });    
}

function SetBimestre(cod_bimestre) {
    $('#cod_bimestre').val(cod_bimestre);
    CarregarFormularioAlterar();
}
