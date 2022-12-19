<?php
//Funciones para adaptar los datos al requerimiento de SUENLACE.dat

function func_str_pad_right( $texto_origen, $limite_caracteres, $caracter_add ) {

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

function CodigoPais ( $nombre_pais ) {

    if ( $nombre_pais == "España" || $nombre_pais == "Es" || $nombre_pais == "011" || empty ( $nombre_pais ) ) {

        return ("011");

    }

}

function AdaptaTelefono ( $telefono_cliente ) {

    $telefono = preg_replace('([^0-9])', '', $telefono_cliente);
    $telefono = substr( $telefono, 0, 9 );

    return str_pad( $telefono, 12, " ", STR_PAD_RIGHT );

}

//Datos generales de la empresa
$codigo_de_empresa = 55555;

//Datos supuesto cliente
$fecha_add_cliente = "2022/10/05";
$cuenta_contable_cliente = 430000069;
$nombre_cliente = "Empresa de Ejemplo SL.";
$nif_cliente = "B08205373";
$siglas_via_publica_cliente "CL";
$via_publica_cliente = "Ejemplo";
$numero_portal_cliente = 123;
$escalera_cliente = '';
$piso_cliente = '';
$puerta_cliente = '';
$municipio_cliente "Alicante";
$codigo_postal_cliente = "02005";
$provincia_cliente "Alicante";
$pais_cliente "España";
$telefono_cliente = "66666666";

//Registro C. Alta / Modificación de cuentas y/o clientes y proveedores
$fecha_alta = UnificaFechaAAAAMMDD( $fecha_add_cliente );
$tipo_de_registro = "C";
$cuenta = func_str_pad_right( $cuenta_contable_cliente,12," " );
$descripcion_cuenta = func_str_pad_right( $nombre_cliente,30," " );
$actualiza_saldo_inicial = "N";
$saldo_inicial = "+0000000000.00";
$ampliacion = " "; //1 espacio en blanco
$reserva = "    "; //4 espacios en blanco
$nif = func_str_pad_right( $nif_cliente,14," " );
$siglas_via_publica = func_str_pad_right( $siglas_via_publica_cliente,2," " );
$via_publica = func_str_pad_right( $via_publica_cliente,30," " );
$numero_portal = func_str_pad_right( $numero_portal_cliente,5," " );
$escalera = func_str_pad_right( $escalera_cliente,2," " );
$piso = func_str_pad_right( $piso_cliente,2," " );
$puerta = func_str_pad_right( $puerta_cliente,2," " );
$municipio = func_str_pad_right( $municipio_cliente,20," " );
$codigo_postal = func_str_pad_right( $codigo_postal_cliente,20," " );
$provincia = func_str_pad_right( $codigo_postal_cliente,15," " );
$pais = CodigoPais( $pais_cliente );
$telefono = AdaptaTelefono( $telefono_cliente );

?>