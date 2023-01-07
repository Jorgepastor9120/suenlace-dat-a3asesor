<?php

namespace Jorge\SuenlaceDatA3asesor;
//Funciones para adaptar los datos al requerimiento de SUENLACE.dat

class Adaptaciones {

    function SubstrStrPadRight( $texto_origen, $limite_caracteres, $caracter_add ) {

        $texto = substr( $texto_origen, 0, $limite_caracteres );
        return str_pad( $texto, $limite_caracteres, "$caracter_add", STR_PAD_RIGHT );
    
    }
    
    function UnificaFechaAAAAMMDD ( $fecha_origen ) {
    
        $fecha = explode( "/", $fecha_origen );
    
        return ("$fecha[0]$fecha[1]$fecha[2]");
    
    }
    
    function UnificaFechaDDMMAAAA ( $fecha_origen ) {
    
        $fecha = explode( "/" , $fecha_origen);
    
        return ("$fecha[2]$fecha[1]$fecha[0]");
    
    }
    
    function CompruebaFechaClienteDDMMAAAA ( $fecha_origen ) {
    
        $fecha = explode( "/" , $fecha_origen);
    
        if ( $fecha[2] == date('Y') ) {
    
            return true;
    
        } else {
    
            return false;
    
        }
    
    
    }
    
    function CodigoPais ( $nombre_pais = "España" ) {
    
        if ( $nombre_pais == "España" || $nombre_pais == "Es" || $nombre_pais == "011" || empty ( $nombre_pais ) ) {
    
            return ("011");
    
        }
    
    }
    
    function AdaptaTelefono ( $telefono_cliente = 0 ) {
    
        $telefono = preg_replace('([^0-9])', '', $telefono_cliente);
        $telefono = substr( $telefono, 0, 9 );
    
        return str_pad( $telefono, 12, " ", STR_PAD_RIGHT );
    
    }
    
    function AdaptaImportes ( $importe_iva_incl ) {
    
        $importe_iva_incl = number_format($importe_iva_incl, 2, '.', '');
    
        if ( $importe_iva_incl < 0 ) {
    
            $importe_iva_incl = explode ( "-", $importe_iva_incl );
            $importe_iva_incl = str_pad($importe_iva_incl[1], 13, "0", STR_PAD_LEFT);
            $importe_iva_incl = "-{$importe_iva_incl}";
    
        } else {
    
            $importe_iva_incl = str_pad($importe_iva_incl, 13, "0", STR_PAD_LEFT);
            $importe_iva_incl = "+{$importe_iva_incl}";
    
        }
    
        return( $importe_iva_incl );
    
    }
    
    function AdaptaPorcentajeIVA ( $porcentaje_iva ) {
    
        $porcentaje_iva = number_format($porcentaje_iva, 2, '.', '');
    
        return( str_pad($porcentaje_iva, 5, "0", STR_PAD_LEFT) );
    
    }

    function AdaptaRecargoEqui ( $tipo_iva, $importe_recargo ) {

        if ( $importe_recargo != 0 ) {

            if ( $tipo_iva == 4 ) {
                $porcentaje_recargo = '00.50';
            }
            if ( $tipo_iva == 10 ) {
                $porcentaje_recargo = '01.40';
            }
            if ( $tipo_iva == 21 ) {
                $porcentaje_recargo = '05.20';
            }
            
        } else {

            $porcentaje_recargo = '00.00';

        }

        return ($porcentaje_recargo);

    }
    
    function ImportePagos ( $importe_cobro ) {
    
        if ( $importe_cobro > 0 ) {
    
            $tipo_importe_contable = "H";
            $tipo_importe_tesoreria = "D";
    
        } else {
    
            $tipo_importe_contable = "D";
            $tipo_importe_tesoreria = "H";
    
        }
    
        return array($tipo_importe_contable, $tipo_importe_tesoreria);
    
    }

}

?>