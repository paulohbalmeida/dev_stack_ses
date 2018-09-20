<?php
class clsPerfil {    
    public $cod_perfil;
    public $txt_perfil;
    public $cod_ativo;
    public $txt_descricao;
    public $cod_permissao;

    public function IncluirPerfil() {
        $rs=pg_fetch_array(pg_query("SELECT MAX(cod_perfil) FROM tb_perfil"));
        if (!isset($rs[0])) {
            $id = 1;
        } else {
            $id = intval($rs[0]) + 1;
        }

        $sql = "INSERT INTO tb_perfil(cod_perfil, txt_perfil, cod_ativo, txt_descricao) ";
        $sql .= " VALUES(".$id.", '".trim($this->txt_perfil)."', ".$this->cod_ativo.", '".trim($this->txt_descricao)."')";
        pg_query($sql);

        Auditoria(32, "", $sql);
    }

    public function ExcluirPerfil() {
        $rs=pg_fetch_array(pg_query("SELECT txt_perfil FROM tb_perfil WHERE cod_perfil = ".$this->cod_perfil));

        $sql = "DELETE FROM tb_perfil WHERE cod_perfil = ".$this->cod_perfil;               
        $resultado = @pg_query($sql);  
        if (!$resultado) {            
            echo($sql);
        } else {
            Auditoria(34, "EXCLUIR PERFIL DE USUÁRIOS: ".$rs['txt_perfil'], $sql);
        }        
    }    

    public function AlterarPerfil() {
        $sql = "UPDATE tb_perfil SET txt_perfil = '".trim($this->txt_perfil)."', cod_ativo = ".$this->cod_ativo;
        $sql .= " , txt_descricao = '".trim($this->txt_descricao)."'";
        $sql .= " WHERE cod_perfil = ".$this->cod_perfil;
        pg_query($sql);

        Auditoria(33, "", $sql);
    }

    public function ListarPerfil($condicao) {
        if (!empty($condicao)) {
            $condicao = " AND ".$condicao;
        }
        $sql = "SELECT * FROM tb_perfil WHERE 1 = 1 " .$condicao;

        return pg_query($sql);
    }

    public function RetornaPerfil($cod_perfil) {
        $sql = "SELECT txt_perfil FROM tb_perfil WHERE cod_perfil = ".$cod_perfil;
        $q1 = pg_query($sql);
        $rs1 = pg_fetch_array($q1);

        return $rs1['txt_perfil'];
    }

    public function Permissao() {
        $sql = "DELETE FROM tb_permissao_perfil WHERE cod_perfil = ".$this->cod_perfil;
        pg_query($sql);          

        Auditoria(118, "", $sql);
        
        $a_cod_permissao = $this->cod_permissao;

        for($i=0; $i < count($a_cod_permissao); $i++){
            $sql = "INSERT INTO tb_permissao_perfil(cod_permissao, cod_perfil) VALUES(".$a_cod_permissao[$i].", ".$this->cod_perfil.")";
            pg_query($sql);

            Auditoria(118, "", $sql);
        }                  
    }
}
?>