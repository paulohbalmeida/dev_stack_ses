$(document).ready(function() {        
    CarregarFormularioAlterar();                
});

function CarregarFormularioAlterar() {
    if ($('#acao').val() == 'alterar') {   
        var cod_objetivo = $('#cod_objetivo').val();
        var cod_objetivo_ppa = $('#cod_objetivo_ppa_').val();                
        
        monta_arvore(cod_objetivo);

        //MONTAR COMBO OBJETIVO PPA
        combo_ppa(cod_objetivo);
        $('#cod_objetivo_ppa').val(cod_objetivo_ppa);     
        
        //MONTAR COMBO PROGRAMA DE TRABALHO
        combo_programa_trabalho(cod_objetivo_ppa)

        //MONTAR META PARCIAL
        MontaMetaParcial();
    } 
    else if ($('#acao').val() == 'incluir') {        
        var cod_objetivo = $('#cod_objetivo_url').val();
        var cod_objetivo_ppa = $('#cod_objetivo_ppa_url').val();  
       
        if(cod_objetivo != '' && cod_objetivo_ppa != '') {
            monta_arvore(cod_objetivo);

            //MONTAR COMBO OBJETIVO PPA
            combo_ppa(cod_objetivo);            
            $('#cod_objetivo_ppa').val(cod_objetivo_ppa); 
            
            //MONTAR COMBO PROGRAMA DE TRABALHO
            combo_programa_trabalho(cod_objetivo_ppa)            
        }
    }
}

function ValidarIncluir() {
    var retorno = true;  
    var cod_objetivo = $('#cod_objetivo').val();
    var cod_objetivo_ppa = $('#cod_objetivo_ppa').val();

    var cod_programa_trabalho = $('#cod_programa_trabalho').val();
    var nr_etapa_trabalho = $('#nr_etapa_trabalho').val();
    var txt_etapa_trabalho = $('#txt_etapa_trabalho').val();
    var cod_produto_etapa = $('#cod_produto_etapa').val();
    var nr_meta = $('#nr_meta').val();
    var nr_meta_parcial = $('#nr_meta_parcial').val();

    var cod_inicio_previsto = $('#cod_inicio_previsto').val();
    var cod_fim_previsto = $('#cod_fim_previsto').val();
    var cod_orgao = $('#cod_orgao').val();
    var cod_parceiro = $('#cod_parceiro').val();
    var cod_modulo = 2;
    var cod_unidade_medida = $('#cod_unidade_medida').val();
    
    if(retorno && cod_objetivo == '') {
        js_alert('', 'Campo OBJETIVO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_objetivo_ppa == '') {
        js_alert('', 'Campo OBJETIVO PPA não pode ser vazio.');
        retorno = false;
    }

    if(retorno && cod_programa_trabalho == '') {
        js_alert('', 'Campo PROGRAMA DE TRABALHO não pode ser vazio.');
        retorno = false;
    }

    if(retorno && nr_etapa_trabalho == '') {
        js_alert('', 'Campo NÚMERO DA ETAPA não pode ser vazio.');
        retorno = false;
    }
    if(retorno && txt_etapa_trabalho == '') {
        js_alert('', 'Campo DESCRIÇÃO DA ETAPA não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_produto_etapa == '') {
        js_alert('', 'Campo PRODUTO DA ETAPA não pode ser vazio.');
        retorno = false;
    }

    if(retorno && nr_meta == '') {
        js_alert('', 'Campo QUANTIDADE DA ETAPA não pode ser vazio.');
        retorno = false;
    }

    if(retorno && nr_meta_parcial == '') {
        js_alert('', 'Campo QUANTIDADE PARCIAL não pode ser vazio.');
        retorno = false;
    }

    if(retorno && cod_unidade_medida == '') {
        js_alert('', 'Campo UNIDADE DE MEDIDA não pode ser vazio.');
        retorno = false;
    }

    if(retorno && cod_inicio_previsto == '') {
        js_alert('', 'Campo INÍCIO PREVISTO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_fim_previsto == '') {
        js_alert('', 'Campo FIM PREVISTO não pode ser vazio.');
        retorno = false;
    }
    
    if(retorno && cod_orgao == '') {
        js_alert('', 'Campo RESPONSÁVEL não pode ser vazio.');
        retorno = false;
    }        
            
    if(!retorno) {
        return retorno;
    }    
    else {                
        if($('#acao').val() == 'alterar') {           
            $('#frm1').attr('action', 'manter.php');                             
            return retorno;
        } else {                
            $('#frm1').attr('action', 'manter.php');  
            $('#acao').val('incluir');      
            return retorno;
        }                
    }    
}

function Excluir(id) {
    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR A AÇÃO SAG?',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'excluir',
                        id: id              				
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

function MontaMetaParcial() {
    var acumulativo = $('#cod_acumulativo').val();
    if (acumulativo == 1) {
        var bimestre = '';
        var ct = 1;
        var div = '<br />';
        div += '<div class="row">';        
        while (ct <= 6) {
            if (ct == 1) {
                bimestre = 'Janeiro/Fevereiro';
            }
            if (ct == 2) {
                bimestre = 'Março/Abril';
            }
            if (ct == 3) {
                bimestre = 'Maio/Junho';
            }
            if (ct == 4) {
                bimestre = 'Julho/Agosto';
            }
            if (ct == 5) {
                bimestre = 'Setembro/Outrubro';
            }
            if (ct == 6) {
                bimestre = 'Novembro/Dezembro';
            }

            div += '<div class="col-md-2">'
            div += '<label for="exampleInputEmail1">' + bimestre + ':</label>';
            div += '<input type="text" class="form-control" id="nr_meta_'+ct+'" name="nr_meta_'+ct+'" onkeyup="somenteNumeros(this);">';
            div += '</div>';

            ct += 1;
        }        
        div += '</div>';

        $('#div_meta_parcial').html(div); 
    } else {
        $('#div_meta_parcial').html('');        
    }
}
