$(document).ready(function($){        
    $('.cpf').mask('999.999.999-99');    
  });

  function ValidarIncluir() {
    var retorno = true;
    var txt_cpf = $('#txt_cpf').val();
    var cod_ativo = $('#cod_ativo').val(); 
    var txt_usuario = $('#txt_usuario').val();
    var txt_email = $('#txt_email').val();
    var cod_perfil = $('#cod_perfil').val();
    var txt_login = $('#txt_login').val();
    var txt_matricula = $('#txt_matricula').val();
    var cod_cargo = $('#cod_cargo').val();
    var cod_orgao = $('#cod_orgao').val();

    if(retorno && txt_login == '') {
        js_alert('', 'Campo LOGIN não pode ser vazio.');
        retorno = false;
    }
    if(retorno && txt_cpf == '') {
        js_alert('', 'Campo CPF não pode ser vazio.');
        retorno = false;
    }
    if(retorno && txt_usuario == '') {
        js_alert('', 'Campo USUÁRIO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && txt_email == '') {
        js_alert('', 'Campo E-MAIL não pode ser vazio.');
        retorno = false;
    } 
    if(retorno && cod_cargo == '') {
        js_alert('', 'Campo CARGO não pode ser vazio.');
        retorno = false;
    }   
    if(retorno && cod_orgao == '') {
        js_alert('', 'Campo LOTAÇÃO não pode ser vazio.');
        retorno = false;
    }   
    if(retorno && cod_perfil == '') {
        js_alert('', 'Campo PERFIL não pode ser vazio.');
        retorno = false;
    } 
    if(retorno && cod_ativo == '') {
        js_alert('', 'Campo ATIVO não pode ser vazio.');
        retorno = false;
    }    

    if(retorno) 
    {
        txt_cpf = txt_cpf.replace(/[^\d]+/g, '');                        
        $.ajax({
            type: 'POST',
            url: 'manter.php',
            data: {
                acao: 'validacao_incluir',
                txt_cpf: txt_cpf,
                txt_usuario: txt_usuario,
                txt_email: txt_email,
                cod_perfil: cod_perfil,
                cod_ativo: cod_ativo,
                txt_login: txt_login,
                txt_matricula: txt_matricula,
                cod_cargo: cod_cargo,
                cod_orgao: cod_orgao
            },
            async: false,
            success: function (data) {                              
                if (data == 'falha') {
                    js_alert('', txt_cpf + ' já está cadastrado.');
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
    var txt_cpf = $('#txt_cpf').val();
    var cod_ativo = $('#cod_ativo').val(); 
    var txt_usuario = $('#txt_usuario').val();
    var txt_email = $('#txt_email').val();
    var cod_perfil = $('#cod_perfil').val();
    var txt_login = $('#txt_login').val();
    var txt_matricula = $('#txt_matricula').val();    
    var cod_cargo = $('#cod_cargo').val();  
    var cod_orgao = $('#cod_orgao').val();    

    if(retorno && txt_login == '') {
        js_alert('', 'Campo LOGIN não pode ser vazio.');
        retorno = false;
    }
    if(retorno && txt_cpf == '') {
        js_alert('', 'Campo CPF não pode ser vazio.');
        retorno = false;
    }
    if(retorno && txt_usuario == '') {
        js_alert('', 'Campo USUÁRIO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && txt_email == '') {
        js_alert('', 'Campo E-MAIL não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_cargo == '') {
        js_alert('', 'Campo CARGO não pode ser vazio.');
        retorno = false;
    }   
    if(retorno && cod_orgao == '') {
        js_alert('', 'Campo LOTAÇÃO não pode ser vazio.');
        retorno = false;
    }    
    if(retorno && cod_perfil == '') {
        js_alert('', 'Campo PERFIL não pode ser vazio.');
        retorno = false;
    } 
    if(retorno && cod_ativo == '') {
        js_alert('', 'Campo ATIVO não pode ser vazio.');
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
                txt_cpf: txt_cpf,
                txt_usuario: txt_usuario,
                txt_email: txt_email,
                cod_perfil: cod_perfil,
                cod_ativo: cod_ativo,
                txt_login: txt_login,
                txt_matricula: txt_matricula,
                cod_cargo: cod_cargo,
                cod_orgao: cod_orgao
            },
            async: false,
            success: function (data) {                              
                if (data == 'falha') {
                    js_alert('', txt_cpf + ' já está cadastrado.');
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
        content: 'DESEJA EXCLUIR O USUÁRIO?',
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
                            js_alert('', 'USUÁRIO NÃO PODE SER EXCLUÍDO. POIS, POSSUI VÍNCULOS.');
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

function ValidarIncluirUnidade() {
    var retorno = true;
    var id = $('#id').val();
    var cod_orgao = $('#cod_orgao').val();
    
    if(retorno && cod_orgao == '') {
        js_alert('', 'Campo UNIDADE não pode ser vazio.');
        retorno = false;
    }

    if(!retorno) {
        return retorno;
    }    
    else {     
        $('#frm1').attr('action', 'manter.php');  
        $('#acao').val('unidade');      
        return retorno;        
    }    
}

function ExcluirUnidade(cod_usuario, cod_orgao) {
    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR A UNIDADE?',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'excluir_unidade',
                        id: cod_usuario, 
                        cod_orgao: cod_orgao              				
                    },
                    async: false,
                    success: function (data) {
                        js_go('unidade.php?id=' + cod_usuario);                                                             
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