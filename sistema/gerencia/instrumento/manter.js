function ValidarIncluir() {
    var retorno = true;
    var txt_modulo = $('#txt_modulo').val();
    var cod_ativo = $('#cod_ativo').val();
    var cod_exibir_consulta = $('#cod_exibir_consulta').val();

    if(retorno && txt_modulo == '') {
        js_alert('', 'Campo INSTRUMENTO DE PLANEJAMENTO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_ativo == '') {
        js_alert('', 'Campo ATIVO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_exibir_consulta == '') {
        js_alert('', 'Campo EXIBIR NO PAINEL não pode ser vazio.');
        retorno = false;
    }

    if(retorno) 
    {
        $.ajax({
            type: 'POST',
            url: 'manter.php',
            data: {
                acao: 'validacao_incluir',
                txt_modulo: txt_modulo              				
            },
            async: false,
            success: function (data) {                              
                if (data == 'falha') {
                    js_alert('', txt_modulo + ' já está cadastrada.');
                    retorno = false;                    
                }                             
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });
    }

    if(!retorno) {
        return retorno;
    }    
    else {        
        $('#frm1').attr('action', 'manter.php');  
        $('#acao').val('incluir');      
        return retorno;   
    }    
}

function ValidarAlterar() {
    var retorno = true;
    var id = $('#id').val();
    var txt_modulo = $('#txt_modulo').val();
    var cod_ativo = $('#cod_ativo').val();
    var cod_exibir_consulta = $('#cod_exibir_consulta').val();

    if(retorno && txt_modulo == '') {
        js_alert('', 'Campo INSTRUMENTO DE PLANEJAMENTO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_ativo == '') {
        js_alert('', 'Campo ATIVO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_exibir_consulta == '') {
        js_alert('', 'Campo EXIBIR NO PAINEL não pode ser vazio.');
        retorno = false;
    }
    if(retorno) 
    {
        $.ajax({
            type: 'POST',
            url: 'manter.php',
            data: {
                acao: 'validacao_alterar',
                id: id,
                txt_modulo: txt_modulo              				
            },
            async: false,
            success: function (data) {                              
                if (data == 'falha') {
                    js_alert('', txt_modulo + ' já está cadastrada.');
                    retorno = false;                    
                }                             
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });
    }
    if(!retorno) {
        return retorno;
    }    
    else {     
        $('#frm1').attr('action', 'manter.php');  
        $('#acao').val('alterar');      
        return retorno;        
    }    
}

function Excluir(id) {
    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR O INSTRUMENTO DE PLANEJAMENTO?',
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
                        if(data == '') {
                            js_go('default.php');
                        }                        
                        else {
                            js_alert('', 'INSTRUMENTO NÃO PODE SER EXCLUÍDO. POIS, POSSUI VÍNCULOS.');
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

function ValidarIncluirStatus() {
    var retorno = true;
    var id = $('#id').val();
    var cod_status = $('#cod_status').val();
    var cod_exibir_consulta = $('#cod_exibir_consulta').val();
    
    if(retorno && cod_status == '') {
        js_alert('', 'Campo SITUAÇÃO não pode ser vazio.');
        retorno = false;
    }

    if(retorno && cod_exibir_consulta == '') {
        js_alert('', 'Campo EXIBIR NO PAINEL não pode ser vazio.');
        retorno = false;
    }

    if(!retorno) {
        return retorno;
    }    
    else {     
        $('#frm1').attr('action', 'manter.php');  
        $('#acao').val('status');      
        return retorno;        
    }    
}

function ExcluirSituacao(cod_modulo, cod_status) {
    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR A SITUAÇÃO?',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'excluir_status',
                        id: cod_modulo, 
                        cod_status: cod_status              				
                    },
                    async: false,
                    success: function (data) {
                        if (data =='') {
                            js_go('situacao.php?id=' + cod_modulo);                                                             
                        }                        
                        else {
                            js_alert('', 'SITUAÇÃO NÃO PODE SER EXCLUÍDA. POIS, POSSUI VÍNCULOS.');
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

function ValidarModalSituacao() {
    var retorno = true;
    var cod_modulo_modal = $('#cod_modulo_modal').val();    
    var cod_exibir_consulta_modal = $('#cod_exibir_consulta_modal').val();
    var cod_status_modal = $('#cod_status_modal').val();

    if(retorno && cod_modulo_modal == '') {
        js_alert('', 'INSTRUMENTO DE PLANEJAMENTO não informado.');
        retorno = false;
    }    

    if(retorno && cod_status_modal == '') {
        js_alert('', 'SITUAÇÃO não informada.');
        retorno = false;
    }    

    if(retorno && cod_exibir_consulta_modal == '') {
        js_alert('', 'Campo EXIBIR NO PAINEL não pode ser vazio.');
        retorno = false;
    }

    if(!retorno) {
        return retorno;
    }    
    else {     
        $.ajax({
            type: 'POST',
            url: 'manter.php',
            data: {
                acao: 'alterar_status',
                id: cod_modulo_modal, 
                cod_status: cod_status_modal,
                cod_exibir_consulta: cod_exibir_consulta_modal               				
            },
            async: false,
            success: function (data) {
                js_go('situacao.php?id=' + cod_modulo_modal);
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });
    }  
}

function SetModal(cod_status, cod_exibir_consulta) {
    $('#cod_status_modal').val(cod_status);
    $('#cod_exibir_consulta_modal').val(cod_exibir_consulta);
}

$( document ).ready(function() {
    if($('#status').val() == 'sucesso') {
        js_alert('', 'DADOS ALTERADOS.');
        $('#status').val('');
    }
});