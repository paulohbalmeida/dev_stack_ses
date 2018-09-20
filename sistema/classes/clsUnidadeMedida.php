<?php
class clsUnidadeMedida {    
    public $cod_unidade_medida;
    public $txt_unidade_medida;
    public $cod_ativo;
    
    public function IncluirUnidadeMedida() {       
        $sql = "INSERT INTO tb_unidade_medida(txt_unidade_medida, cod_ativo) ";
        $sql .= " VALUES('".trim($this->txt_unidade_medida)."', ".$this->cod_ativo.")";
        pg_query($sql);

        Auditoria(24, "", $sql);
    }

    public function ExcluirUnidadeMedida() {
        $rs=pg_fetch_array(pg_query("SELECT txt_unidade_medida FROM tb_unidade_medida WHERE cod_unidade_medida = ".$this->cod_unidade_medida));

        $sql = "DELETE FROM tb_unidade_medida WHERE cod_unidade_medida = ".$this->cod_unidade_medida;               
        $resultado = @pg_query($sql);  
        if (!$resultado) {            
            echo($sql);
        } else {
            Auditoria(26, "EXCLUIR UNIDADE DE MEDIDA: ".$rs['txt_unidade_medida'], $sql);
        }    
    }    

    public function AlterarUnidadeMedida() {
        $sql = "UPDATE tb_unidade_medida SET txt_unidade_medida = '".trim($this->txt_unidade_medida)."', cod_ativo = ".$this->cod_ativo;
        $sql .= " WHERE cod_unidade_medida = ".$this->cod_unidade_medida;
        pg_query($sql);

        Auditoria(25, "", $sql);
    }

    public function ListarUnidadeMedida($condicao) {
        if (!empty($condicao)) {
            $condicao = " AND ".$condicao;
        }
        $sql = "SELECT * FROM tb_unidade_medida WHERE 1 = 1 " .$condicao;

        return pg_query($sql);
    }
}
?>