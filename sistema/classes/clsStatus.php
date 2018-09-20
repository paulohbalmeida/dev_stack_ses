<?php
class clsStatus {    
    public $cod_status;
    public $txt_status;
    public $cod_ativo;
    public $txt_descricao;
    public $txt_cor;

    public function IncluirStatus() {
        $rs=pg_fetch_array(pg_query("SELECT MAX(cod_status) FROM tb_status"));
        if (!isset($rs[0])) {
            $id = 1;
        } else {
            $id = intval($rs[0]) + 1;
        }

        $sql = "INSERT INTO tb_status(cod_status, txt_status, cod_ativo, txt_descricao, txt_cor) ";
        $sql .= " VALUES(".$id.", '".trim($this->txt_status)."', ".$this->cod_ativo.", '".trim($this->txt_descricao)."', '".trim($this->txt_cor)."')";
        pg_query($sql);

        Auditoria(28, "", $sql);
    }

    public function ExcluirStatus() {
        $rs=pg_fetch_array(pg_query("SELECT txt_status FROM tb_status WHERE cod_status = ".$this->cod_status));

        $sql = "DELETE FROM tb_status WHERE cod_status = ".$this->cod_status;               
        $resultado = @pg_query($sql);  
        if (!$resultado) {            
            echo($sql);
        } else {
            Auditoria(30, "EXCLUIR SITUAÇÃO: ".$rs['txt_status'], $sql);
        }         
    }    

    public function AlterarStatus() {
        $sql = "UPDATE tb_status SET txt_status = '".trim($this->txt_status)."', cod_ativo = ".$this->cod_ativo;
        $sql .= " , txt_descricao = '".trim($this->txt_descricao)."', txt_cor = '".trim($this->txt_cor)."'";
        $sql .= " WHERE cod_status = ".$this->cod_status;
        pg_query($sql);

        Auditoria(29, "", $sql);
    }

    public function ListarStatus($condicao) {
        if (!empty($condicao)) {
            $condicao = " AND ".$condicao;
        }
        $sql = "SELECT * FROM tb_status WHERE 1 = 1 " .$condicao;

        return pg_query($sql);
    }

    public function RetornaStatus($cod_status) {
        if (!empty($cod_status)) {
            $sql = "SELECT txt_status FROM tb_status WHERE cod_status = ".$cod_status;
            $q1 = pg_query($sql);
            $rs1 = pg_fetch_array($q1);
    
            return $rs1['txt_status'];
        }
        else {
            return "";
        }
    }

    public function RetornaCorStatus($cod_status) {
        if (!empty($cod_status)) {
            $sql = "SELECT txt_cor FROM tb_status WHERE cod_status = ".$cod_status;
            $q1 = pg_query($sql);
            $rs1 = pg_fetch_array($q1);

            if (strtoupper($rs1['txt_cor']) != '#FFFFFF') {
                return $rs1['txt_cor'];
            } else {
                return "black";
            }            
        }
        
        return "";
    }
}
?>