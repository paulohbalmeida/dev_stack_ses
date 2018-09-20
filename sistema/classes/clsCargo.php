<?php
class clsCargo {       
    public $cod_cargo;
    public $txt_cargo;
    public $cod_ativo;
    public $txt_descricao;

    public function IncluirCargo() {
        $rs=pg_fetch_array(pg_query("SELECT MAX(cod_cargo) FROM tb_cargo"));
        if (!isset($rs[0])) {
            $id = 1;
        } else {
            $id = intval($rs[0]) + 1;
        }

        $sql = "INSERT INTO tb_cargo(cod_cargo, txt_cargo, cod_ativo, txt_descricao) ";
        $sql .= " VALUES(".$id.", '".trim($this->txt_cargo)."', ".$this->cod_ativo.", '".trim($this->txt_descricao)."')";
        pg_query($sql);

        Auditoria(8, "", $sql);
    }

    public function ExcluirCargo() {
        $rs=pg_fetch_array(pg_query("SELECT txt_cargo FROM tb_cargo WHERE cod_cargo = ".$this->cod_cargo)); 

        $sql = "DELETE FROM tb_cargo WHERE cod_cargo = ".$this->cod_cargo;               
        $resultado = @pg_query($sql);  
        if (!$resultado) {            
            echo($sql);            
        } else {
            Auditoria(10, "EXCLUIR CARGO: ".$rs['txt_cargo'], $sql);
        }     
    }    

    public function AlterarCargo() {
        $sql = "UPDATE tb_cargo SET txt_cargo = '".trim($this->txt_cargo)."', cod_ativo = ".$this->cod_ativo;
        $sql .= " , txt_descricao = '".trim($this->txt_descricao)."'";
        $sql .= " WHERE cod_cargo = ".$this->cod_cargo;
        pg_query($sql);

        Auditoria(9, "", $sql);
    }

    public function ListarCargo($condicao) {
        if (!empty($condicao)) {
            $condicao = " AND ".$condicao;
        }
        $sql = "SELECT * FROM tb_cargo WHERE 1 = 1 " .$condicao;

        return pg_query($sql);
    }

    public function RetornaCargo($cod_cargo) {
        $sql = "SELECT txt_cargo FROM tb_cargo WHERE cod_cargo = ".$cod_cargo;
        $q1 = pg_query($sql);
        $rs1 = pg_fetch_array($q1);

        return $rs1['txt_cargo'];
    }
}
?>