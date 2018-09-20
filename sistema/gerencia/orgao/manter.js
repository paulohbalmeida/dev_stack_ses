function ValidarIncluir() {
    var retorno = true;
    var txt_sigla = $('#txt_sigla').val();
    var cod_ativo = $('#cod_ativo').val();
    var cod_exibir_consulta = $('#cod_exibir_consulta').val();    

    if(retorno && txt_sigla == '') {
        js_alert('', 'Campo SIGLA não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_ativo == '') {
        js_alert('', 'Campo ATIVO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_exibir_consulta == '') {
        js_alert('', 'Campo EXIBIR NA CONSULTA não pode ser vazio.');
        retorno = false;
    }

    if(retorno) 
    {
        $.ajax({
            type: 'POST',
            url: 'manter.php',
            data: {
                acao: 'validacao_incluir',
                txt_sigla: txt_sigla                              				
            },
            async: false,
            success: function (data) {                              
                if (data == 'falha') {
                    js_alert('', txt_sigla + ' já está cadastrada.');
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
    var txt_sigla = $('#txt_sigla').val();
    var cod_ativo = $('#cod_ativo').val();
    var cod_exibir_consulta = $('#cod_exibir_consulta').val();

    if(retorno && txt_sigla == '') {
        js_alert('', 'Campo SIGLA não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_ativo == '') {
        js_alert('', 'Campo ATIVO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_exibir_consulta == '') {
        js_alert('', 'Campo EXIBIR NA CONSULTA não pode ser vazio.');
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
                txt_sigla: txt_sigla              				
            },
            async: false,
            success: function (data) {                              
                if (data == 'falha') {
                    js_alert('', txt_sigla + ' já está cadastrada.');
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
        content: 'DESEJA EXCLUIR A ÁREA RESPONSÁVEL?',
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

$( document ).ready(function() {
    if($('#status').val() == 'sucesso') {
        js_alert('', 'DADOS ALTERADOS.');
        $('#status').val('');
    }
});