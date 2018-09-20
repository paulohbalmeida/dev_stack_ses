<?php
class clsOrgao {    
    public $cod_orgao;
    public $txt_sigla;
    public $cod_ativo;
    public $cod_exibir_consulta;
    public $txt_descricao;
    public $cod_orgao_superior;

    public function IncluirOrgao() {
        $rs=pg_fetch_array(pg_query("SELECT MAX(cod_orgao) FROM tb_orgao"));
        if (!isset($rs[0])) {
            $id = 1;
        } else {
            $id = intval($rs[0]) + 1;
        }

        if (empty($this->cod_orgao_superior) && strval($this->cod_orgao_superior) != '0') {
            $this->cod_orgao_superior = "NULL";
        }

        $sql = "INSERT INTO tb_orgao(cod_orgao, txt_sigla, cod_ativo, cod_exibir_consulta, txt_descricao, cod_orgao_superior) ";
        $sql .= " VALUES(".$id.", '".trim($this->txt_sigla)."', ".$this->cod_ativo.", ".$this->cod_exibir_consulta.", '".trim($this->txt_descricao)."', ".$this->cod_orgao_superior.")";
        pg_query($sql);        

        Auditoria(4, "", $sql);
    }

    public function ExcluirOrgao() {
        $rs=pg_fetch_array(pg_query("SELECT txt_sigla FROM tb_orgao WHERE cod_orgao = ".$this->cod_orgao));        

        $sql = "DELETE FROM tb_orgao WHERE cod_orgao = ".$this->cod_orgao;               
        pg_query($sql);  

        Auditoria(6, "EXCLUIR ÁREA RESPONSÁVEL: ".$rs['txt_sigla'], $sql);
    }    

    public function AlterarOrgao() {        

        if (empty($this->cod_orgao_superior) && strval($this->cod_orgao_superior) != '0') {
            $this->cod_orgao_superior = "NULL";
        }

        $sql = "UPDATE tb_orgao SET txt_sigla = '".trim($this->txt_sigla)."', cod_ativo = ".$this->cod_ativo;
        $sql .= " , cod_exibir_consulta = ".$this->cod_exibir_consulta. ", txt_descricao = '".trim($this->txt_descricao)."', ";
        $sql .= " cod_orgao_superior = ".$this->cod_orgao_superior." WHERE cod_orgao = ".$this->cod_orgao;            
        pg_query($sql);

        Auditoria(5, "", $sql);
    }

    public function ListarOrgao($condicao) {
        if (!empty($condicao)) {
            $condicao = " AND ".$condicao;
        }
        $sql = "SELECT * FROM tb_orgao WHERE 1 = 1 " .$condicao;
        
        return pg_query($sql);
    }

    public function RetornaSigla($cod_orgao) {
        if (!empty($cod_orgao)) {
            $sql = "SELECT txt_sigla FROM tb_orgao WHERE cod_orgao = ".$cod_orgao;
            $q1 = pg_query($sql);
            $rs1 = pg_fetch_array($q1);
    
            return $rs1['txt_sigla'];
        } else {
            return '';
        }        
    }
}
?>