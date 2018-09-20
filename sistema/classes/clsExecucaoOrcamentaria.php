<?php
include_once (__DIR__ . "/clsStatus.php");

class clsExecucaoOrcamentaria {     
    public function Situacao($empenhado_autorizado, $mes) {
        $clsStatus = new clsStatus();

        $retorno = "";

        $retorno = trim(str_replace(".", "", $empenhado_autorizado));
        $retorno = trim(str_replace(",", ".", $retorno));        
        $retorno = floatval($retorno);

        switch(strval($mes)) {
            case '1' || '2':
                //NORMAL
                if ($retorno >= 0 && $retorno <= 20) {
                    $txt_cor = $clsStatus->RetornaCorStatus(9);
                    $txt_status = $clsStatus->RetornaStatus(9);  
                    return $txt_cor."|".$txt_status;
                }
                //ALERTA
                if ($retorno >= 20.01 && $retorno <= 49.99) {
                    $txt_cor = $clsStatus->RetornaCorStatus(16);
                    $txt_status = $clsStatus->RetornaStatus(16);  
                    return $txt_cor."|".$txt_status;
                }
                //RECURSO INSUFICIENTE
                if ($retorno >= 50) {
                    $txt_cor = $clsStatus->RetornaCorStatus(16);
                    $txt_status = $clsStatus->RetornaStatus(16);  
                    return $txt_cor."|".$txt_status;
                }
                break;
            case '3' || '4':
                //NORMAL
                if ($retorno >= 10 && $retorno <= 30) {
                    $txt_cor = $clsStatus->RetornaCorStatus(9);
                    $txt_status = $clsStatus->RetornaStatus(9);  
                    return $txt_cor."|".$txt_status;
                }
                //ALERTA
                if ($retorno >= 30.01 && $retorno <= 50) {
                    $txt_cor = $clsStatus->RetornaCorStatus(16);
                    $txt_status = $clsStatus->RetornaStatus(16);  
                    return $txt_cor."|".$txt_status;
                }
                //RECURSO INSUFICIENTE
                if ($retorno >= 50) {
                    $txt_cor = $clsStatus->RetornaCorStatus(16);
                    $txt_status = $clsStatus->RetornaStatus(16);  
                    return $txt_cor."|".$txt_status;
                }
                break;
            case '5' || '6':
                //NORMAL
                if ($retorno >= 30 && $retorno <= 49.99) {
                    $txt_cor = $clsStatus->RetornaCorStatus(9);
                    $txt_status = $clsStatus->RetornaStatus(9);  
                    return $txt_cor."|".$txt_status;
                }
                //ALERTA
                if ($retorno >= 50 && $retorno <= 84.99) {
                    $txt_cor = $clsStatus->RetornaCorStatus(16);
                    $txt_status = $clsStatus->RetornaStatus(16);  
                    return $txt_cor."|".$txt_status;
                }
                //RECURSO INSUFICIENTE
                if ($retorno >= 85) {
                    $txt_cor = $clsStatus->RetornaCorStatus(16);
                    $txt_status = $clsStatus->RetornaStatus(16);  
                    return $txt_cor."|".$txt_status;
                }
                //BAIXA EXECUÇÃO
                if ($retorno <= 29.99) {
                    $txt_cor = $clsStatus->RetornaCorStatus(13);
                    $txt_status = $clsStatus->RetornaStatus(13);  
                    return $txt_cor."|".$txt_status;
                }
                break;
            case '7' ||  '8':
                //NORMAL
                if ($retorno >= 40 && $retorno <= 70) {
                    $txt_cor = $clsStatus->RetornaCorStatus(9);
                    $txt_status = $clsStatus->RetornaStatus(9);  
                    return $txt_cor."|".$txt_status;
                }
                //ALERTA
                if ($retorno >= 70.01 && $retorno <= 84.99) {
                    $txt_cor = $clsStatus->RetornaCorStatus(16);
                    $txt_status = $clsStatus->RetornaStatus(16);  
                    return $txt_cor."|".$txt_status;
                }
                //RECURSO INSUFICIENTE
                if ($retorno >= 85) {
                    $txt_cor = $clsStatus->RetornaCorStatus(16);
                    $txt_status = $clsStatus->RetornaStatus(16);  
                    return $txt_cor."|".$txt_status;
                }
                //BAIXA EXECUÇÃO
                if ($retorno <= 39.99) {
                    $txt_cor = $clsStatus->RetornaCorStatus(13);
                    $txt_status = $clsStatus->RetornaStatus(13);  
                    return $txt_cor."|".$txt_status;
                }
                break;
            case '9' || '10':
                //NORMAL
                if ($retorno >= 65 && $retorno <= 85) {
                    $txt_cor = $clsStatus->RetornaCorStatus(9);
                    $txt_status = $clsStatus->RetornaStatus(9);  
                    return $txt_cor."|".$txt_status;
                }
                //ALERTA
                if ($retorno >= 85.01 && $retorno <= 94.99) {
                    $txt_cor = $clsStatus->RetornaCorStatus(16);
                    $txt_status = $clsStatus->RetornaStatus(16);  
                    return $txt_cor."|".$txt_status;
                }
                //RECURSO INSUFICIENTE
                if ($retorno >= 95) {
                    $txt_cor = $clsStatus->RetornaCorStatus(16);
                    $txt_status = $clsStatus->RetornaStatus(16);  
                    return $txt_cor."|".$txt_status;
                }
                //BAIXA EXECUÇÃO
                if ($retorno <= 64.99) {
                    $txt_cor = $clsStatus->RetornaCorStatus(13);
                    $txt_status = $clsStatus->RetornaStatus(13);  
                    return $txt_cor."|".$txt_status;
                }
                break;
            case '11' || '12':
                //NORMAL
                if ($retorno >= 85) {
                    $txt_cor = $clsStatus->RetornaCorStatus(9);
                    $txt_status = $clsStatus->RetornaStatus(9);  
                    return $txt_cor."|".$txt_status;
                }
                //ALERTA
                if ($retorno >= 50.01 && $retorno <= 84.99) {
                    $txt_cor = $clsStatus->RetornaCorStatus(16);
                    $txt_status = $clsStatus->RetornaStatus(16);  
                    return $txt_cor."|".$txt_status;
                }                
                //BAIXA EXECUÇÃO
                if ($retorno <= 50) {
                    $txt_cor = $clsStatus->RetornaCorStatus(13);
                    $txt_status = $clsStatus->RetornaStatus(13);  
                    return $txt_cor."|".$txt_status;
                }
                break;                
        }
    }

    public function RecursoEmpenhadoAutorizado($empenhado, $autorizado) {
        $retorno = "";

        if ($empenhado == 0 && $autorizado == 0) {
            return 0;
        }

        if ($autorizado == 0) {
            return 0;
        }

        if (strval($empenhado) != "" && strval($autorizado) != "") {                       
            $retorno = ($empenhado / $autorizado) * 100;   
            $retorno = @number_format($retorno, 2, ',', '');      

            if (substr($retorno, -3) == ',00') {
                $retorno = trim(str_replace(substr($retorno, -3), "", $retorno));  
            }
        }
        
        return $retorno;
    }

    public function RecursoLiquidadoEmpenhado($liquidado, $empenhado) {
        $retorno = "";
        
        if ($liquidado == 0 && $empenhado == 0) {
            return 0;
        }
        
        if ($empenhado == 0) {
            return 0;
        }

        if (strval($liquidado) != "" && strval($empenhado) != "") {                                
            $retorno = ($liquidado / $empenhado) * 100;   
            $retorno = @number_format($retorno, 2, ',', ''); 
            
            if (substr($retorno, -3) == ',00') {
                $retorno = trim(str_replace(substr($retorno, -3), "", $retorno));  
            }           
        } 
             
        return $retorno;
    }
}
?>