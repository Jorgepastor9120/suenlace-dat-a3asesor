<?php
//Funciones para adaptar los datos al requerimiento de SUENLACE.dat

function funcStrPadRight( $texto_origen, $limite_caracteres, $caracter_add ) {

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

function AdaptaImporteIvaIncl ( $importe_iva_incl ) {

    $importe_iva_incl = number_format($importe_iva_incl, 2, '.', '');

    if ( $importe_iva_incl < 0 ) {

        $importe_iva_incl = explode ( "-", $importe_iva_incl );
        $importe_iva_incl = str_pad($importe_iva_incl[1], 13, "0", STR_PAD_LEFT);
        $importe_iva_incl = "-{$importe_iva_incl}";

    } else {

        $importe_iva_incl = str_pad($importe_iva_incl, 13, "0", STR_PAD_LEFT);
        $importe_iva_incl	= "+{$importe_iva_incl}";

    }

    return( $importe_iva_incl );

}

$nombre_archivo_exportado = "SUENLACE.dat";

unlink($nombre_archivo_exportado); //Se llama a la función unlink por si hubiera un archivo ya creado.

//Datos generales de la empresa
$codigo_de_empresa = 55555;

//TIPO DE REGISTRO C. Alta / Modificación de cuentas y/o clientes y proveedores

//Loop para recorrer todos los clientes que se quieran añadir al registro 

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
    $extension_cliente = '';
    $fax_cliente = '';
    $email_cliente = 'ejemplo@email.com';

    
    $fecha_alta = UnificaFechaAAAAMMDD( $fecha_add_cliente );
    $tipo_de_registro = "C";
    $cuenta = funcStrPadRight( $cuenta_contable_cliente,12," " );
    $descripcion_cuenta = funcStrPadRight( $nombre_cliente,30," " );
    $actualiza_saldo_inicial = "N";
    $saldo_inicial = "+0000000000.00";
    $ampliacion = " "; //1 espacio en blanco
    $reserva = "    "; //4 espacios en blanco
    $nif = funcStrPadRight( $nif_cliente,14," " );
    $siglas_via_publica = funcStrPadRight( $siglas_via_publica_cliente,2," " );
    $via_publica = funcStrPadRight( $via_publica_cliente,30," " );
    $numero_portal = funcStrPadRight( $numero_portal_cliente,5," " );
    $escalera = funcStrPadRight( $escalera_cliente,2," " );
    $piso = funcStrPadRight( $piso_cliente,2," " );
    $puerta = funcStrPadRight( $puerta_cliente,2," " );
    $municipio = funcStrPadRight( $municipio_cliente,20," " );
    $codigo_postal = funcStrPadRight( $codigo_postal_cliente,20," " );
    $provincia = funcStrPadRight( $provincia_cliente,15," " );
    $pais = CodigoPais( $pais_cliente );
    $telefono = AdaptaTelefono( $telefono_cliente );
    $extension = funcStrPadRight( $extension_cliente,4," " );
    $fax = funcStrPadRight( $fax_cliente,12," " );
    $email = funcStrPadRight( $email_cliente,30," " );
    $reservado = "  "; //2 espacios
    $criterio_de_caja = " "; //1 espacio
    $cuenta_contrapartida 	= "            "; //12 espacios
    $codigo_pais = "ES";
    $reserva_1 = "                                                                                                                                                                                                                                                              ";
    $moneda_enlace = "E";

    $linea_cliente = utf8_decode("5{$codigo_de_empresa}{$fecha_alta}{$tipo_de_registro}{$cuenta}{$descripcion_cuenta}{$actualiza_saldo_inicial}{$saldo_inicial}{$ampliacion}{$reserva}{$nif}{$siglas_via_publica}{$via_publica}{$numero_portal}{$escalera}{$piso}{$puerta}{$municipio}{$codigo_postal}{$provincia}{$pais}{$telefono}{$extension}{$fax}{$email}{$reservado}{$criterio_de_caja}{$reservado}{$cuenta_contrapartida}{$codigo_pais}{$reserva_1}{$moneda_enlace}N\r\n");
        
    if ( $archivo == fopen( $nombre_archivo_exportado, "a" ) ) {
        
        fwrite($archivo, $linea_cliente);
        fclose($archivo);

    }

//Finaliza loop 

//Nota: para incluir cada factura se añade un registro tipo 1 que es la cabecera y después tantos Tipos de Registros 9 como tipos de IVA haya en el documento.

//TIPO DE REGISTRO 1,2. Alta de Cabecera de apuntes con IVA Junto con Tipo de registro 9. Detalle de apuntes con IVA

//Loop para recorrer todos los Tipo de registro 1,2 (facturas de venta)

    //Datos supuesta factura (Tipo de registro 1)
    $fecha_factura "22/10/2022";
    $importe_total_iva_excl = 200.00;
    $importe_total_iva_incl = 231.00; //100.00 + 21% y 100 + 10%
    $cuenta_contable_cliente = 430000069;
    $nombre_cliente = "Empresa de Ejemplo SL.";
    $nif_cliente = "B08205373";
    $codigo_postal_cliente = "02005";
    $numero_factura_cliente = 230000049;


    $fecha_apunte = UnificaFechaDDMMAAAA( $fecha_factura );
    $tipo_registro = 1;
    $cuenta = funcStrPadRight( $cuenta_contable_cliente,12," " );
    $descripcion_cuenta = funcStrPadRight( $nombre_cliente,30," " );
    $tipo_de_factura = 1; //Facturas de venta
    $numero_factura = funcStrPadRight( $numero_factura_cliente,10," " );
    $linea_apunte = 'I';
    $descripcion_apunte = $descripcion_cuenta;
    $importe = AdaptaImporteIvaIncl( $importe_total_iva_incl );
    $reserva = "                                                              "; //62 espacios
    $nif = funcStrPadRight( $nif_cliente,14," " );
    $nombre_cliente = funcStrPadRight( $nombre_cliente,30," " );
    $codigo_postal = funcStrPadRight( $codigo_postal_cliente,20," " );
    $reserva_1 = "  "; //2 espacios
    $fecha_operacion = "        "; //8 espacios
    $fecha_de_factura = "        "; //8 espacios
    $numero_ampliado = funcStrPadRight( $numero_factura_cliente,60," " );
    $reserva_2 = "                                                                                                                                                                                                    "; //196 espacios
    $moneda_enlace = "E";

    $linea_factura_cabecera = utf8_decode("5{$codigo_de_empresa}{$fecha_apunte}{$tipo_registro}{$cuenta}{$descripcion_cuenta}{$tipo_de_factura}{$numero_factura}{$linea_apunte}{$descripcion_apunte}{$importe}{$reserva}{$nif}{$nombre_cliente}{$codigo_postal}{$reserva_1}{$fecha_operacion}{$fecha_de_factura}{$numero_ampliado}{$reserva_2}{$moneda_enlace}N\r\n");
        
    if ( $archivo == fopen( $nombre_archivo_exportado, "a" ) ) {
        
        fwrite($archivo, $linea_factura_cabecera);
        fclose($archivo);

    }

//Finaliza loop 
?>