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
    } 
    else if ($('#acao').val() == 'incluir') {        
        var cod_objetivo = $('#cod_objetivo_url').val();
        var cod_objetivo_ppa = $('#cod_objetivo_ppa_url').val();  
       
        if(cod_objetivo != '' && cod_objetivo_ppa != '') {
            monta_arvore(cod_objetivo);

            combo_ppa(cod_objetivo);            
            $('#cod_objetivo_ppa').val(cod_objetivo_ppa);            
        }
    }
}

function ValidarIncluir() {
    var retorno = true;
    var cod_objetivo = $('#cod_objetivo').val();
    var cod_objetivo_ppa = $('#cod_objetivo_ppa').val();
    var codigo_acao = $('#codigo_acao').val();
    var txt_acao = $('#txt_acao').val();
    var cod_orgao = $('#cod_orgao').val();
    var cod_mes_inicio = $('#cod_mes_inicio').val();
    var cod_mes_fim = $('#cod_mes_fim').val();
    var cod_meta = $('#cod_meta').val();
    var txt_medida = $('#txt_medida').val();    
    
    if(retorno && cod_objetivo == '') {
        js_alert('', 'Campo OBJETIVO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_objetivo_ppa == '') {
        js_alert('', 'Campo OBJETIVO PPA não pode ser vazio.');
        retorno = false;
    }
    if(retorno && codigo_acao == '') {
        js_alert('', 'Campo CÓDIGO DA AÇÃO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && txt_acao == '') {
        js_alert('', 'Campo AÇÃO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_orgao == '') {
        js_alert('', 'Campo RESPONSÁVEL não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_mes_inicio == '') {
        js_alert('', 'Campo INÍCIO PREVISTO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_mes_fim == '') {
        js_alert('', 'Campo FIM PREVISTO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_meta == '') {
        js_alert('', 'Campo META não pode ser vazio.');
        retorno = false;
    }        
    if(retorno && (parseInt(cod_mes_fim) < parseInt(cod_mes_inicio))) {
        js_alert('', 'FIM PREVISTO não pode ser menor que o INÍCIO PREVISTO.');
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
        content: 'DESEJA EXCLUIR A AÇÃO PAS?',
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

function LimparCampos(id, cod_objetivo_url) {
    $.confirm({
        title: '',
        content: 'DESEJA LIMPAR OS DADOS DA AÇÃO PAS?',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'limpar_campos',
                        id: id              				
                    },
                    async: false,
                    success: function (data) {
                        js_go('default.php?cod_objetivo_url='+ cod_objetivo_url +'&#ancora_' + id);                                  
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

function SalvarCompleto(cod_pas, cod) {    
    var cod_resultado = $('#cod_resultado' + cod_pas).val();
    var cod_inicio_efetivo = $('#cod_inicio_efetivo' + cod_pas).val();
    var cod_fim_efetivo = $('#cod_fim_efetivo' + cod_pas).val();    
    var cod_objetivo_url = $('#cod_objetivo_url').val();
    var cod_controle = $('#cod_controle' + cod_pas).val();
    
    if (cod == 2) {
        /*if (cod_controle == '') {
            js_alert('', 'Campo CONTROLE não pode ser vazio.');
            return false;
        }*/
        if (cod_fim_efetivo != '' && cod_inicio_efetivo == '') {
            js_alert('', 'Campo INÍCIO EFETIVO não pode ser vazio.');
            return false;
        }
        if (cod_fim_efetivo != '' && cod_inicio_efetivo != '') {
            if (parseInt(cod_inicio_efetivo) > parseInt(cod_fim_efetivo)) {
                js_alert('', 'O FIM EFETIVO não pode ser maior que o INÍCIO EFETIVO.');
                return false;
            }            
        }

        //NÃO SALVAR SE NÃO HOUVER ANÁLISE NO BIMESTRE
        $.ajax({
            type: 'POST',
            url: 'manter.php',
            data: {
                acao: 'validar_salvar_pas_analise',
                id: cod_pas
            },
            async: false,
            success: function (data) { 
                var ret = parseInt(data);                
                if (ret == 0) {
                    js_alert('', 'NÃO EXISTE ANÁLISE CADASTRADA PARA O BIMESTRE ATUAL.');

                    return false;                 
                }  
                else {
                    $.ajax({
                        type: 'POST',
                        url: 'manter.php',
                        data: {
                            acao: 'salvar_completo',
                            id: cod_pas,
                            cod_resultado: cod_resultado,
                            cod_inicio_efetivo: cod_inicio_efetivo,
                            cod_fim_efetivo: cod_fim_efetivo,
                            cod_controle: cod_controle            
                        },
                        async: false,
                        success: function (data) {                    
                            var str = data.split('|');            
                            var div = '<div id="div_status"><font color="'+ str[0] +'"><b>'+ str[1] +'</b></font></div>';            
                            $('#div_status' + cod_pas).html(div);
                
                            js_alert('', 'DADOS ALTERADOS.');
            
                            return true;               
                            /*if (cod_objetivo_url != '') {
                                js_go('default.php?cod_objetivo_url=' + cod_objetivo_url);                                  
                            } else {
                                js_go('default.php');                                  
                            }*/         
                        },				
                        error: function (xhr, status, error) {
                            alert(xhr.responseText);    				
                        }
                    });
                }              
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });                        
    } else {
        $.ajax({
            type: 'POST',
            url: 'manter.php',
            data: {
                acao: 'atualizar_situacao',
                id: cod_pas,
                cod_inicio_efetivo: cod_inicio_efetivo,
                cod_fim_efetivo: cod_fim_efetivo                       
            },
            async: false,
            success: function (data) {                                    
                var str = data.split('|');            
                var div = '<div id="div_status"><font color="'+ str[0] +'"><b>'+ str[1] +'</b></font></div>';            
                $('#div_status' + cod_pas).html(div);                

                return true;                                
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });
    } 
}