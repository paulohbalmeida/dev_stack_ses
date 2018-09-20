function ValidarModalSag() {
    
    if ($('#cod_inicio_efetivo').val() == '') {
        js_alert('', 'INÍCIO EFETIVO não pode ser vazio.');
        return false;
    }
    if ($('#cod_fim_efetivo').val() == '') {
        js_alert('', 'FIM EFETIVO não pode ser vazio.');
        return false;
    }
    
    $.ajax({
        type: 'POST',
        url: 'manter.php',
        data: {
            acao: 'salvar_dados_modal',
            id: $('#meuid').val(),
            cod_inicio_efetivo: $('#cod_inicio_efetivo').val(),
            cod_fim_efetivo: $('#cod_fim_efetivo').val()                   				
        },
        async: false,
        success: function (data) {
            
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });

    js_go('default.php');
    return true;
}

function SetDadosModal(valor) {
    $('#meuid').val(valor);

    $.ajax({
        type: 'POST',
        url: 'manter.php',
        data: {
            acao: 'popular_modal_sag',
            id: valor                         				
        },
        async: false,
        success: function (data) {
            $('#modal_acao').html(data);
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });
}