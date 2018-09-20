<?php
class clsProdutoEtapa {    
    public $cod_produto_etapa;
    public $txt_produto_etapa;
    public $cod_ativo;
    
    public function IncluirProdutoEtapa() {    
        $sql = "INSERT INTO tb_produto_etapa(txt_produto_etapa, cod_ativo) ";
        $sql .= " VALUES('".trim($this->txt_produto_etapa)."', ".$this->cod_ativo.")";
        pg_query($sql);

        Auditoria(20, "", $sql);
    }

    public function ExcluirProdutoEtapa() {
        $rs=pg_fetch_array(pg_query("SELECT txt_produto_etapa FROM tb_produto_etapa WHERE cod_produto_etapa = ".$this->cod_produto_etapa));

        $sql = "DELETE FROM tb_produto_etapa WHERE cod_produto_etapa = ".$this->cod_produto_etapa;               
        $resultado = @pg_query($sql);  
        if (!$resultado) {            
            echo($sql);
        } else {
            Auditoria(22, "EXCLUIR PRODUTO DA ETAPA: ".$rs['txt_produto_etapa'], $sql);
        }        
    }    

    public function AlterarProdutoEtapa() {
        $sql = "UPDATE tb_produto_etapa SET txt_produto_etapa = '".trim($this->txt_produto_etapa)."', cod_ativo = ".$this->cod_ativo;
        $sql .= " WHERE cod_produto_etapa = ".$this->cod_produto_etapa;
        pg_query($sql);

        Auditoria(21, "", $sql);
    }

    public function ListarProdutoEtapa($condicao) {
        if (!empty($condicao)) {
            $condicao = " AND ".$condicao;
        }
        $sql = "SELECT * FROM tb_produto_etapa WHERE 1 = 1 " .$condicao;

        return pg_query($sql);
    }
}
?>