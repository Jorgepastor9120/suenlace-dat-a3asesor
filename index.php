<?php
//Funciones para adaptar los datos al requerimiento de SUENLACE.dat

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

    return( str_pad($porcentaje_iva, 2, "0", STR_PAD_LEFT) );

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

$nombre_archivo_exportado = "SUENLACE.dat";

unlink($nombre_archivo_exportado); //Se llama a la función unlink por si hubiera un archivo ya creado.

//Datos generales de la empresa
$codigo_de_empresa = 55555;

//TIPO DE REGISTRO C. Alta / Modificación de cuentas y/o clientes y proveedores

//Loop para recorrer todos los clientes que se quieran añadir al registro 

    //Datos supuesto cliente
    $fecha_add_cliente = "05/10/2022";
    $cuenta_contable_cliente = 430000069;
    $nombre_cliente = "Empresa de Ejemplo SL.";
    $nif_cliente = "B08205373";
    $siglas_via_publica_cliente = "CL";
    $via_publica_cliente = "Ejemplo";
    $numero_portal_cliente = 123;
    $escalera_cliente = '';
    $piso_cliente = '';
    $puerta_cliente = '';
    $municipio_cliente = "Alicante";
    $codigo_postal_cliente = "02005";
    $provincia_cliente = "Alicante";
    $pais_cliente = "España";
    $telefono_cliente = "66666666";
    $extension_cliente = '';
    $fax_cliente = '';
    $email_cliente = 'ejemplo@email.com';


    //La fecha de alta del cliente debe ser en el mismo año que el ejercicio al que hace referencia
    if ( CompruebaFechaClienteDDMMAAAA( $fecha_add_cliente ) ) {

        $fecha_alta = UnificaFechaDDMMAAAA( $fecha_add_cliente );

    } else {

        $fecha_alta = date('Ymd');

    }

    $tipo_de_registro = "C";
    $cuenta = SubstrStrPadRight( $cuenta_contable_cliente,12," " );
    $descripcion_cuenta = SubstrStrPadRight( $nombre_cliente,30," " );
    $actualiza_saldo_inicial = "N";
    $saldo_inicial = "+0000000000.00";
    $ampliacion = " "; //1 espacio en blanco
    $reserva = "    "; //4 espacios en blanco
    $nif = SubstrStrPadRight( $nif_cliente,14," " );
    $siglas_via_publica = SubstrStrPadRight( $siglas_via_publica_cliente,2," " );
    $via_publica = SubstrStrPadRight( $via_publica_cliente,30," " );
    $numero_portal = SubstrStrPadRight( $numero_portal_cliente,5," " );
    $escalera = SubstrStrPadRight( $escalera_cliente,2," " );
    $piso = SubstrStrPadRight( $piso_cliente,2," " );
    $puerta = SubstrStrPadRight( $puerta_cliente,2," " );
    $municipio = SubstrStrPadRight( $municipio_cliente,20," " );
    $codigo_postal = SubstrStrPadRight( $codigo_postal_cliente,20," " );
    $provincia = SubstrStrPadRight( $provincia_cliente,15," " );
    $pais = CodigoPais( $pais_cliente );
    $telefono = AdaptaTelefono( $telefono_cliente );
    $extension = SubstrStrPadRight( $extension_cliente,4," " );
    $fax = SubstrStrPadRight( $fax_cliente,12," " );
    $email = SubstrStrPadRight( $email_cliente,30," " );
    $reservado = "  "; //2 espacios
    $criterio_de_caja = " "; //1 espacio
    $cuenta_contrapartida = "            "; //12 espacios
    $codigo_pais = "ES";
    $reserva_1 = "                                                                                                                                                                                                                                                              ";
    $moneda_enlace = "E";

    $linea_cliente = utf8_decode("5{$codigo_de_empresa}{$fecha_alta}{$tipo_de_registro}{$cuenta}{$descripcion_cuenta}{$actualiza_saldo_inicial}{$saldo_inicial}{$ampliacion}{$reserva}{$nif}{$siglas_via_publica}{$via_publica}{$numero_portal}{$escalera}{$piso}{$puerta}{$municipio}{$codigo_postal}{$provincia}{$pais}{$telefono}{$extension}{$fax}{$email}{$reservado}{$criterio_de_caja}{$reservado}{$cuenta_contrapartida}{$codigo_pais}{$reserva_1}{$moneda_enlace}N\r\n");
        
    $archivo = fopen( $nombre_archivo_exportado, "a" );
        
    fwrite($archivo, $linea_cliente);
    fclose($archivo);

//Finaliza loop 

//Nota: para incluir cada factura se añade un registro tipo 1 que es la cabecera y después tantos Tipos de Registros 9 como tipos de IVA haya en el documento.

//TIPO DE REGISTRO 1,2. Alta de Cabecera de apuntes con IVA Junto con Tipo de registro 9. Detalle de apuntes con IVA

//Loop para recorrer todos los Tipo de registro 1,2 (facturas de venta)

    //Datos supuesta factura (Tipo de registro 1)
    $fecha_factura = "22/10/2022";
    $importe_total_iva_excl = 200.00;
    $importe_total_iva_incl = 231.00; //100.00 + 21% y 100 + 10%
    $cuenta_contable_cliente = 430000069;
    $nombre_cliente = "Empresa de Ejemplo SL.";
    $nif_cliente = "B08205373";
    $codigo_postal_cliente = "02005";
    $numero_factura_cliente = 230000049;


    $fecha_apunte = UnificaFechaDDMMAAAA( $fecha_factura );
    $tipo_registro = 1;
    $cuenta = SubstrStrPadRight( $cuenta_contable_cliente,12," " );
    $descripcion_cuenta = SubstrStrPadRight( $nombre_cliente,30," " );
    $tipo_de_factura = 1; //Facturas de venta
    $numero_factura = SubstrStrPadRight( $numero_factura_cliente,10," " );
    $linea_apunte = 'I';
    $descripcion_apunte = $descripcion_cuenta;
    $importe = AdaptaImportes( $importe_total_iva_incl );
    $reserva = "                                                              "; //62 espacios
    $nif = SubstrStrPadRight( $nif_cliente,14," " );
    $nombre_cliente = SubstrStrPadRight( $nombre_cliente,30," " );
    $codigo_postal = SubstrStrPadRight( $codigo_postal_cliente,20," " );
    $reserva_1 = "  "; //2 espacios
    $fecha_operacion = "        "; //8 espacios
    $fecha_de_factura = "        "; //8 espacios
    $numero_ampliado = SubstrStrPadRight( $numero_factura_cliente,60," " );
    $reserva_2 = "                                                                                                                                                                                                    "; //196 espacios
    $moneda_enlace = "E";

    $linea_factura_cabecera = utf8_decode("5{$codigo_de_empresa}{$fecha_apunte}{$tipo_registro}{$cuenta}{$descripcion_cuenta}{$tipo_de_factura}{$numero_factura}{$linea_apunte}{$descripcion_apunte}{$importe}{$reserva}{$nif}{$nombre_cliente}{$codigo_postal}{$reserva_1}{$fecha_operacion}{$fecha_de_factura}{$numero_ampliado}{$reserva_2}{$moneda_enlace}N\r\n");
        
    $archivo = fopen( $nombre_archivo_exportado, "a" );
        
    fwrite($archivo, $linea_factura_cabecera);
    fclose($archivo);

    //TIPO DE REGISTRO 9. Detalle de apuntes con IVA
    /* 
    *Suponemos que en la factura a añadir tenemos 2 lineas, una con iva 10% y otra con iva 21%. 
    *La primera línea de apunte (todas menos la última) tendrá el valor M y la útlima linea tendrá el valor U.
    */

    //Linea 1 (M):
    $importe_total_iva_excl = 100.00;
    $importe_total_iva_incl = 110.00; // 100 + 10%
    $cuota_de_iva = 10.00;
    $porcentaje_de_iva = 10;
    $porcentaje_de_recargo = 0;
    $cuota_de_recargo = 0;
    $porcentaje_de_retencion = 0;
    $cuota_de_retencion = 0;


    $fecha_apunte = UnificaFechaDDMMAAAA( $fecha_factura );
    $tipo_registro = 9;
    $cuenta = SubstrStrPadRight( $cuenta_contable_cliente,12," " );
    $descripcion_cuenta = SubstrStrPadRight( $nombre_cliente,30," " );
    $tipo_importe = "C";
    $numero_factura = SubstrStrPadRight( $numero_factura_cliente,10," " );
    $linea_apunte = "M";
    $descripcion_apunte = SubstrStrPadRight( $nombre_cliente,30," " );
    $subtipo_factura = "01"; //Operaciones interiores sujetas a IVA
    $base_imponible = AdaptaImportes( $importe_total_iva_excl );
    $porcentaje_iva = AdaptaPorcentajeIVA( $porcentaje_de_iva );
    $cuota_iva = AdaptaImportes( $cuota_de_iva );
    $porcentaje_recargo = AdaptaPorcentajeIVA( $porcentaje_de_recargo );
    $cuota_recargo = AdaptaImportes( $cuota_de_recargo );
    $porcentaje_retencion = AdaptaPorcentajeIVA( $porcentaje_de_retencion );
    $cuota_retencion = AdaptaImportes( $cuota_de_retencion );
    $impreso = "01"; //Impreso 347
    $operacion_sujeta_iva = "S"; //Es una operación con IVA
    $marca_afecta_415 = "N"; //No afecta
    $critero_de_caja = " "; //1 espacio
    $reserva = "              "; //14 espacios
    $cuenta_iva_soportado = "477000000000";
    $cuenta_recargo_soportado = "000000000000";
	$cuenta_retencion = "000000000000";
    $cuenta_iva_2_repercutido = "000000000000";
    $cuenta_recargo_2_repercutido = "000000000000";
    $registro_analitico = " "; //1 espacio
	$reserva_1 = "                                                                                                                                                                                                                                                                "; //256 espacios
	$moneda_enlace = "E";
    
    $linea_iva_factura = utf8_decode("5{$codigo_de_empresa}{$fecha_apunte}{$tipo_registro}{$cuenta}{$descripcion_cuenta}{$tipo_importe}{$numero_factura}{$linea_apunte}{$descripcion_apunte}{$subtipo_factura}{$base_imponible}{$porcentaje_iva}{$cuota_iva}{$porcentaje_recargo}{$cuota_recargo}{$porcentaje_retencion}{$cuota_retencion}{$impreso}{$operacion_sujeta_iva}{$marca_afecta_415}{$critero_de_caja}{$reserva}{$cuenta_iva_soportado}{$cuenta_recargo_soportado}{$cuenta_retencion}{$cuenta_iva_2_repercutido}{$cuenta_recargo_2_repercutido}{$registro_analitico}{$reserva_1}{$moneda_enlace}N\r\n");

    $archivo = fopen( $nombre_archivo_exportado, "a" );
        
    fwrite($archivo, $linea_iva_factura);
    fclose($archivo);

    //Linea 2 (U):
    $importe_total_iva_excl = 100.00;
    $importe_total_iva_incl = 121.00; // 100 + 10%
    $cuota_de_iva = 21.00;
    $porcentaje_de_iva = 21;
    $porcentaje_de_recargo = 0;
    $cuota_de_recargo = 0;
    $porcentaje_de_retencion = 0;
    $cuota_de_retencion = 0;


    $fecha_apunte = UnificaFechaDDMMAAAA( $fecha_factura );
    $tipo_registro = 9;
    $cuenta = SubstrStrPadRight( $cuenta_contable_cliente,12," " );
    $descripcion_cuenta = SubstrStrPadRight( $nombre_cliente,30," " );
    $tipo_importe = "C";
    $numero_factura = SubstrStrPadRight( $numero_factura_cliente,10," " );
    $linea_apunte = "U";
    $descripcion_apunte = SubstrStrPadRight( $nombre_cliente,30," " );
    $subtipo_factura = "01"; //Operaciones interiores sujetas a IVA
    $base_imponible = AdaptaImportes( $importe_total_iva_excl );
    $porcentaje_iva = AdaptaPorcentajeIVA( $porcentaje_de_iva );
    $cuota_iva = AdaptaImportes( $cuota_de_iva );
    $porcentaje_recargo = AdaptaPorcentajeIVA( $porcentaje_de_recargo );
    $cuota_recargo = AdaptaImportes( $cuota_de_recargo );
    $porcentaje_retencion = AdaptaPorcentajeIVA( $porcentaje_de_retencion );
    $cuota_retencion = AdaptaImportes( $cuota_de_retencion );
    $impreso = "01"; //Impreso 347
    $operacion_sujeta_iva = "S"; //Es una operación con IVA
    $marca_afecta_415 = "N"; //No afecta
    $critero_de_caja = " "; //1 espacio
    $reserva = "              "; //14 espacios
    $cuenta_iva_soportado = "477000000000";
    $cuenta_recargo_soportado = "000000000000";
	$cuenta_retencion = "000000000000";
    $cuenta_iva_2_repercutido = "000000000000";
    $cuenta_recargo_2_repercutido = "000000000000";
    $registro_analitico = " "; //1 espacio
	$reserva_1 = "                                                                                                                                                                                                                                                                "; //256 espacios
	$moneda_enlace = "E";
    
    $linea_iva_factura = utf8_decode("5{$codigo_de_empresa}{$fecha_apunte}{$tipo_registro}{$cuenta}{$descripcion_cuenta}{$tipo_importe}{$numero_factura}{$linea_apunte}{$descripcion_apunte}{$subtipo_factura}{$base_imponible}{$porcentaje_iva}{$cuota_iva}{$porcentaje_recargo}{$cuota_recargo}{$porcentaje_retencion}{$cuota_retencion}{$impreso}{$operacion_sujeta_iva}{$marca_afecta_415}{$critero_de_caja}{$reserva}{$cuenta_iva_soportado}{$cuenta_recargo_soportado}{$cuenta_retencion}{$cuenta_iva_2_repercutido}{$cuenta_recargo_2_repercutido}{$registro_analitico}{$reserva_1}{$moneda_enlace}N\r\n");

    $archivo = fopen( $nombre_archivo_exportado, "a" );
        
    fwrite($archivo, $linea_iva_factura);
    fclose($archivo);

//Finaliza loop 

//TIPO DE REGISTRO 0. Alta de Apuntes sin IVA (Para los cobros de las facturas)
    /* 
    *Cada cobro incluirá dos lineas: linea de la cuenta contable del cliente y linea de la cuenta de tesorería
    */

//Loop para recorrer todos los pagos

    //Datos de un supuesto cobro
    $cuenta_contable_cliente = 430000069;
    $nombre_cliente = "Empresa de Ejemplo SL.";
    $id_cobro = 1234;
    $numero_factura = 23000324;
    $fecha_cobro = "15/12/2022";
    $importe_de_cobro = 143.32;
    $forma_de_cobro = "Transferencia bancaria";

    $fecha_apunte = UnificaFechaDDMMAAAA( $fecha_cobro );
    $tipo_registro = 0;
    $cuenta = SubstrStrPadRight( $cuenta_contable_cliente,12," " );
    $descripcion_cuenta = SubstrStrPadRight( $nombre_cliente,30," " );
    list($tipo_importe_contable, $tipo_importe_tesoreria) = ImportePagos($importe_de_cobro);
    $referencia_documento = SubstrStrPadRight( $numero_factura,10," " );
    $linea_apunte_contable = "I";
    $descripcion_apunte_contable = SubstrStrPadRight( "Cobro $nombre_cliente",30," " );
    $importe = AdaptaImportes( $importe_de_cobro );
    $reserva = "                                                                                                                                         "; //137 espacios
    $indicador_asiento = " ";
    $registro_analitico = " ";
    $reserva_1 = "                                                                                                                                                                                                                                                                "; //256 espacios
    $moneda_enlace = "E";

    $cuenta_tesoreria = "570000001   ";
    $linea_apunte_tesoreria = "U";
    $descripcion_apunte_tesoreria = SubstrStrPadRight( "Cobro Fra $numero_factura $forma_de_cobro",30," " );
    

    $linea_cobro_1 = utf8_decode("5{$codigo_de_empresa}{$fecha_apunte}{$tipo_registro}{$cuenta}{$descripcion_cuenta}{$tipo_importe_contable}{$referencia_documento}{$linea_apunte_contable}{$descripcion_apunte_contable}{$importe}{$reserva}{$indicador_asiento}{$registro_analitico}{$reserva_1}{$moneda_enlace}N\r\n");
    $linea_cobro_2 = utf8_decode("5{$codigo_de_empresa}{$fecha_apunte}{$tipo_registro}{$cuenta_tesoreria}{$descripcion_cuenta}{$tipo_importe_tesoreria}{$referencia_documento}{$linea_apunte_tesoreria}{$descripcion_apunte_tesoreria}{$importe}{$reserva}{$indicador_asiento}{$registro_analitico}{$reserva_1}{$moneda_enlace}N\r\n");

    $linea_registro_tipo_0 = $linea_cobro_1;
    $linea_registro_tipo_0 .= $linea_cobro_2;

    $archivo = fopen( $nombre_archivo_exportado, "a" );
        
    fwrite($archivo, $linea_registro_tipo_0);
    fclose($archivo);

//Finaliza Loop

?>