<?php
class clsInstrumento {    
    public $cod_modulo;
    public $txt_modulo;
    public $cod_ativo;
    public $cod_exibir_consulta;
    public $cod_status;    

    public function ConsultaPorId($cod_modulo) {
        if (!empty($cod_modulo)) {
            $sql = "SELECT txt_modulo FROM tb_modulo WHERE cod_modulo = " .$cod_modulo;
            $q = pg_query($sql);
            if (pg_num_rows($q) > 0)
            {
                $rs1 = pg_fetch_array($q);

                return $rs1["txt_modulo"];
            }
            else {
                return "";
            }
        }
        else {
            return "";
        }                                
    }

    public function IncluirModulo() {
        $rs=pg_fetch_array(pg_query("SELECT MAX(cod_modulo) FROM tb_modulo"));
        if (!isset($rs[0])) {
            $id = 1;
        } else {
            $id = intval($rs[0]) + 1;
        }

        $sql = "INSERT INTO tb_modulo(cod_modulo, txt_modulo, cod_ativo, cod_exibir_consulta) ";
        $sql .= " VALUES(".$id.", '".trim($this->txt_modulo)."', ".$this->cod_ativo.", ".$this->cod_exibir_consulta.")";
        pg_query($sql);

        Auditoria(12, "", $sql);
    }

    public function ExcluirModulo() {
        $rs=pg_fetch_array(pg_query("SELECT txt_modulo FROM tb_modulo WHERE cod_modulo = ".$this->cod_modulo)); 

        $sql = "DELETE FROM tb_modulo WHERE cod_modulo = ".$this->cod_modulo;               
        $resultado = @pg_query($sql);  
        if (!$resultado) {            
            echo($sql);
        } else {
            Auditoria(14, "EXCLUIR INSTRUMENTO DE PLANEJAMENTO: ".$rs['txt_modulo'], $sql);
        }            
    }    

    public function AlterarModulo() {
        $sql = "UPDATE tb_modulo SET txt_modulo = '".trim($this->txt_modulo)."', cod_ativo = ".$this->cod_ativo;
        $sql .= " , cod_exibir_consulta = ".$this->cod_exibir_consulta;
        $sql .= " WHERE cod_modulo = ".$this->cod_modulo;
        pg_query($sql);

        Auditoria(13, "", $sql);
    }

    public function ListarModulo($condicao) {
        if (!empty($condicao)) {
            $condicao = " AND ".$condicao;
        }
        $sql = "SELECT * FROM tb_modulo WHERE 1 = 1 " .$condicao;

        return pg_query($sql);
    }

    public function IncluirStatus() {
        $sql = "INSERT INTO tb_status_modulo(cod_status, cod_modulo, cod_exibir_consulta) VALUES(".$this->cod_status.", ".$this->cod_modulo.", ".$this->cod_exibir_consulta.")";
        $resultado = @pg_query($sql);  
        if (!$resultado) {            
            return $sql;
        }     
        else {
            Auditoria(16, "", $sql);

            return "";
        }
    }

    public function ExcluirStatus() {
        $sql = "DELETE FROM tb_status_modulo WHERE cod_modulo = ".$this->cod_modulo." AND cod_status = ".$this->cod_status;               
        $resultado = @pg_query($sql);  
        if (!$resultado) {            
            echo($sql);
        } else {
            Auditoria(18, "", $sql);
        }    
    }

    public function AlterarStatus() { 
        $sql = "UPDATE tb_status_modulo SET cod_exibir_consulta = ".$this->cod_exibir_consulta." WHERE cod_modulo = ".$this->cod_modulo." AND cod_status = ".$this->cod_status;
        $resultado = @pg_query($sql);  
        if (!$resultado) {            
            return $sql;
        }     
        else {        
            Auditoria(17, "", $sql);
            
            return "";
        }
    }
}
?>