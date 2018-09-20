function SetBimestre(cod_bimestre) {
    $('#cod_bimestre').val(cod_bimestre);
}

function ValidarSalvar() {
    var cod_bimestre = $('#cod_bimestre').val();
    var txt_justificativa = $('#txt_justificativa' + cod_bimestre).val();

    /*if (txt_justificativa == '') {
        js_alert('', 'O campo JUSTIFICATIVA não pode ser vazio.');
        return false;
    }*/   

    $.ajax({
        type: 'POST',
        url: 'manter.php',
        data: {
            acao: 'incluir_analise',
            id: $('#cod_pas').val(),
            cod_bimeste: cod_bimestre,
            txt_consideracao: txt_justificativa             				
        },
        async: false,
        success: function (data) {
            js_alert('', 'OPERAÇÃO REALIZADA COM SUCESSO.');                                            
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });
    
    return true;
}

function ExcluirConsideracao(cod_pas, cod_bimeste) {
    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR A CONSIDERAÇÃO?',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'excluir_consideracao',
                        id: cod_pas,
                        cod_bimeste: cod_bimeste              				
                    },
                    async: false,
                    success: function (data) {
                        js_go('consideracao.php?cod_pas=' + $('#cod_pas').val());                               
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