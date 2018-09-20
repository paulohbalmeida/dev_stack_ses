function ValidarSalvar() {
    var retorno = true;
    var cod_controle = $('#cod_controle').val();
    var txt_justificativa = $('#txt_justificativa').val();

    if(retorno && cod_controle == '') {
        js_alert('', 'Campo CONTROLE não pode ser vazio.');
        retorno = false;
    }
    if(retorno && txt_justificativa == '' && cod_controle != 1) {
        js_alert('', 'Campo JUSTIFICATIVA não pode ser vazio.');
        retorno = false;
    }
    if(!retorno) {
        return retorno;
    } else {
        if($('#acao').val() == 'controle') {           
            $('#frm1').attr('action', 'manter.php');                             
            return retorno;
        } 
    }    

    return retorno;
}