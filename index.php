<?php

require 'vendor/autoload.php';

use Jorge\SuenlaceDatA3asesor\Adaptaciones;
use Jorge\SuenlaceDatA3asesor\Datos;

$misAdaptaciones = new Adaptaciones();
$misDatos = new Datos();

list($datosClientes, $datosFacturas, $datosPagos) = $misDatos->DatosClientesArray();

//Datos generales de la empresa
define('CODIGO_DE_EMPRESA', 55555);
define('NOMBRE_ARCHIVO_EXPORTADO', "SUENLACE.dat");

if ( file_exists ( NOMBRE_ARCHIVO_EXPORTADO ) ) {

    unlink(NOMBRE_ARCHIVO_EXPORTADO); //Se llama a la función unlink por si hubiera un archivo ya creado.

}
//TIPO DE REGISTRO C. Alta / Modificación de cuentas y/o clientes y proveedores



foreach ($datosClientes as $cliente) {

    //La fecha de alta del cliente debe ser en el mismo año que el ejercicio al que hace referencia
    if ($misAdaptaciones->CompruebaFechaClienteDDMMAAAA($cliente['fecha_add_cliente'])) {

        $fecha_alta = $misAdaptaciones->UnificaFechaDDMMAAAA($cliente['fecha_add_cliente']);

    } else {

        $fecha_alta = date('Ymd');

    }

    $tipo_de_registro = "C";
    $cuenta = $misAdaptaciones->SubstrStrPadRight($cliente['cuenta_contable_cliente'], 12, " ");
    $descripcion_cuenta = $misAdaptaciones->SubstrStrPadRight($cliente['nombre_cliente'], 30, " ");
    $actualiza_saldo_inicial = "N";
    $saldo_inicial = "+0000000000.00";
    $ampliacion = " "; //1 espacio en blanco
    $reserva = "    "; //4 espacios en blanco
    $nif = $misAdaptaciones->SubstrStrPadRight($cliente['nif_cliente'], 14, " ");
    $siglas_via_publica = $misAdaptaciones->SubstrStrPadRight($cliente['siglas_via_publica_cliente'], 2, " ");
    $via_publica = $misAdaptaciones->SubstrStrPadRight($cliente['via_publica_cliente'], 30, " ");
    $numero_portal = $misAdaptaciones->SubstrStrPadRight($cliente['numero_portal_cliente'], 5, " ");
    $escalera = $misAdaptaciones->SubstrStrPadRight($cliente['escalera_cliente'], 2, " ");
    $piso = $misAdaptaciones->SubstrStrPadRight($cliente['piso_cliente'], 2, " ");
    $puerta = $misAdaptaciones->SubstrStrPadRight($cliente['puerta_cliente'], 2, " ");
    $municipio = $misAdaptaciones->SubstrStrPadRight($cliente['municipio_cliente'], 20, " ");
    $codigo_postal = $misAdaptaciones->SubstrStrPadRight($cliente['codigo_postal_cliente'], 5, " ");
    $provincia = $misAdaptaciones->SubstrStrPadRight($cliente['provincia_cliente'], 15, " ");
    $pais = $misAdaptaciones->CodigoPais($cliente['pais_cliente']);
    $telefono = $misAdaptaciones->AdaptaTelefono($cliente['telefono_cliente']);
    $extension = $misAdaptaciones->SubstrStrPadRight($cliente['extension_cliente'], 4, " ");
    $fax = $misAdaptaciones->SubstrStrPadRight($cliente['fax_cliente'], 12, " ");
    $email = $misAdaptaciones->SubstrStrPadRight($cliente['email_cliente'], 30, " ");
    $reservado = "  "; //2 espacios
    $criterio_de_caja = " "; //1 espacio
    $cuenta_contrapartida = "            "; //12 espacios
    $codigo_pais = "ES";
    $reserva_1 = "                                                                                                                                                                                                                                                              ";
    $moneda_enlace = "E";

    $linea_cliente = utf8_decode("5" . CODIGO_DE_EMPRESA . "{$fecha_alta}{$tipo_de_registro}{$cuenta}{$descripcion_cuenta}{$actualiza_saldo_inicial}{$saldo_inicial}{$ampliacion}{$reserva}{$nif}{$siglas_via_publica}{$via_publica}{$numero_portal}{$escalera}{$piso}{$puerta}{$municipio}{$codigo_postal}{$provincia}{$pais}{$telefono}{$extension}{$fax}{$email}{$reservado}{$criterio_de_caja}{$reservado}{$cuenta_contrapartida}{$codigo_pais}{$reserva_1}{$moneda_enlace}N\r\n");

    $archivo = fopen(NOMBRE_ARCHIVO_EXPORTADO, "a");

    fwrite($archivo, $linea_cliente);
    fclose($archivo);

}

//Nota: para incluir cada factura se añade un registro tipo 1 que es la cabecera y después tantos Tipos de Registros 9 como tipos de IVA haya en el documento.

//TIPO DE REGISTRO 1,2. Alta de Cabecera de apuntes con IVA Junto con Tipo de registro 9. Detalle de apuntes con IVA

foreach ($datosFacturas as $factura) {

    $fecha_apunte = $misAdaptaciones->UnificaFechaDDMMAAAA( $factura['fecha_factura'] );
    $tipo_registro = 1;
    $cuenta = $misAdaptaciones->SubstrStrPadRight( $factura['cuenta_contable_cliente'],12," " );
    $descripcion_cuenta = $misAdaptaciones->SubstrStrPadRight( $factura['nombre_cliente'],30," " );
    $tipo_de_factura = 1; //Facturas de venta
    $numero_factura = $misAdaptaciones->SubstrStrPadRight( $factura['numero_factura_cliente'],10," " );
    $linea_apunte = 'I';
    $descripcion_apunte = $descripcion_cuenta;
    $importe = $misAdaptaciones->AdaptaImportes( $factura['importe_total_iva_incl'] );
    $reserva = "                                                              "; //62 espacios
    $nif = $misAdaptaciones->SubstrStrPadRight( $factura['nif_cliente'],14," " );
    $nombre_cliente = $misAdaptaciones->SubstrStrPadRight( $factura['nombre_cliente'],40," " );
    $codigo_postal = $misAdaptaciones->SubstrStrPadRight( $factura['codigo_postal_cliente'],5," " );
    $reserva_1 = "  "; //2 espacios
    $fecha_operacion = "        "; //8 espacios
    $fecha_de_factura = "        "; //8 espacios
    $numero_ampliado = $misAdaptaciones->SubstrStrPadRight( $factura['numero_factura_cliente'],60," " );
    $reserva_2 = "                                                                                                                                                                                                    "; //196 espacios
    $moneda_enlace = "E";

    $linea_factura_cabecera = utf8_decode("5" . CODIGO_DE_EMPRESA . "{$fecha_apunte}{$tipo_registro}{$cuenta}{$descripcion_cuenta}{$tipo_de_factura}{$numero_factura}{$linea_apunte}{$descripcion_apunte}{$importe}{$reserva}{$nif}{$nombre_cliente}{$codigo_postal}{$reserva_1}{$fecha_operacion}{$fecha_de_factura}{$numero_ampliado}{$reserva_2}{$moneda_enlace}N\r\n");
        
    $archivo = fopen( NOMBRE_ARCHIVO_EXPORTADO, "a" );
        
    fwrite($archivo, $linea_factura_cabecera);
    fclose($archivo);

    //TIPO DE REGISTRO 9. Detalle de apuntes con IVA
    /* 
    *Suponemos que en la factura a añadir tenemos 2 lineas, una con iva 10% y otra con iva 21%. 
    *La primera línea de apunte (todas menos la última) tendrá el valor M y la útlima linea tendrá el valor U.
    */


    if ( $factura['importe_iva_excl_10'] != 0.00 || $factura['importe_iva_excl_21'] != 0.00 ) {
        
        $linea_apunte_iva_4 = "M";

    } else {

        $linea_apunte_iva_4 = "U";

    }

    if ( $factura['importe_iva_excl_21'] != 0.00 ) {
        
        $linea_apunte_iva_10 = "M";

    } else {

        $linea_apunte_iva_10 = "U";

    }


    $linea_apunte_iva_21 = "U";


    $fecha_apunte = $misAdaptaciones->UnificaFechaDDMMAAAA( $factura['fecha_factura'] );
    $tipo_registro = 9;
    $cuenta = $misAdaptaciones->SubstrStrPadRight( $factura['cuenta_contable_cliente'],12," " );
    $descripcion_cuenta = $misAdaptaciones->SubstrStrPadRight( $factura['nombre_cliente'],30," " );
    $tipo_importe = "C";
    $numero_factura = $misAdaptaciones->SubstrStrPadRight( $factura['numero_factura_cliente'],10," " );
    $descripcion_apunte = $misAdaptaciones->SubstrStrPadRight( $nombre_cliente,30," " );
    $subtipo_factura = "01"; //Operaciones interiores sujetas a IVA
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


    if ( $factura['importe_iva_excl_4'] != 0.00 ) {

        $base_imponible = $misAdaptaciones->AdaptaImportes( $factura['importe_iva_excl_4'] );
        $porcentaje_iva = $misAdaptaciones->AdaptaPorcentajeIVA(4);
        $cuota_iva = $misAdaptaciones->AdaptaImportes( $factura['importe_iva_4'] );
        $porcentaje_recargo = $misAdaptaciones->AdaptaRecargoEqui( 4, $factura['requ_equi_iva_4'] );
        $cuota_recargo = $misAdaptaciones->AdaptaImportes( $factura['requ_equi_iva_4'] );
        $porcentaje_retencion = $misAdaptaciones->AdaptaPorcentajeIVA(0);
        $cuota_retencion = $misAdaptaciones->AdaptaImportes(0);
        

        $linea_iva_factura = utf8_decode("5" . CODIGO_DE_EMPRESA . "{$fecha_apunte}{$tipo_registro}{$cuenta}{$descripcion_cuenta}{$tipo_importe}{$numero_factura}{$linea_apunte_iva_4}{$descripcion_apunte}{$subtipo_factura}{$base_imponible}{$porcentaje_iva}{$cuota_iva}{$porcentaje_recargo}{$cuota_recargo}{$porcentaje_retencion}{$cuota_retencion}{$impreso}{$operacion_sujeta_iva}{$marca_afecta_415}{$critero_de_caja}{$reserva}{$cuenta_iva_soportado}{$cuenta_recargo_soportado}{$cuenta_retencion}{$cuenta_iva_2_repercutido}{$cuenta_recargo_2_repercutido}{$registro_analitico}{$reserva_1}{$moneda_enlace}N\r\n");

        $archivo = fopen( NOMBRE_ARCHIVO_EXPORTADO, "a" );
            
        fwrite($archivo, $linea_iva_factura);
        fclose($archivo);

    }

    if ( $factura['importe_iva_excl_10'] != 0.00 ) {

        $base_imponible = $misAdaptaciones->AdaptaImportes( $factura['importe_iva_excl_10'] );
        $porcentaje_iva = $misAdaptaciones->AdaptaPorcentajeIVA(10);
        $cuota_iva = $misAdaptaciones->AdaptaImportes( $factura['importe_iva_10'] );
        $porcentaje_recargo = $misAdaptaciones->AdaptaRecargoEqui( 10, $factura['requ_equi_iva_10'] );
        $cuota_recargo = $misAdaptaciones->AdaptaImportes( $factura['requ_equi_iva_10'] );
        $porcentaje_retencion = $misAdaptaciones->AdaptaPorcentajeIVA(0);
        $cuota_retencion = $misAdaptaciones->AdaptaImportes(0);
        

        $linea_iva_factura = utf8_decode("5" . CODIGO_DE_EMPRESA . "{$fecha_apunte}{$tipo_registro}{$cuenta}{$descripcion_cuenta}{$tipo_importe}{$numero_factura}{$linea_apunte_iva_10}{$descripcion_apunte}{$subtipo_factura}{$base_imponible}{$porcentaje_iva}{$cuota_iva}{$porcentaje_recargo}{$cuota_recargo}{$porcentaje_retencion}{$cuota_retencion}{$impreso}{$operacion_sujeta_iva}{$marca_afecta_415}{$critero_de_caja}{$reserva}{$cuenta_iva_soportado}{$cuenta_recargo_soportado}{$cuenta_retencion}{$cuenta_iva_2_repercutido}{$cuenta_recargo_2_repercutido}{$registro_analitico}{$reserva_1}{$moneda_enlace}N\r\n");

        $archivo = fopen( NOMBRE_ARCHIVO_EXPORTADO, "a" );
            
        fwrite($archivo, $linea_iva_factura);
        fclose($archivo);

    }

    if ( $factura['importe_iva_excl_21'] != 0.00 ) {

        $base_imponible = $misAdaptaciones->AdaptaImportes( $factura['importe_iva_excl_21'] );
        $porcentaje_iva = $misAdaptaciones->AdaptaPorcentajeIVA(21);
        $cuota_iva = $misAdaptaciones->AdaptaImportes( $factura['importe_iva_21'] );
        $porcentaje_recargo = $misAdaptaciones->AdaptaRecargoEqui( 21, $factura['requ_equi_iva_21'] );
        $cuota_recargo = $misAdaptaciones->AdaptaImportes( $factura['requ_equi_iva_21'] );
        $porcentaje_retencion = $misAdaptaciones->AdaptaPorcentajeIVA(0);
        $cuota_retencion = $misAdaptaciones->AdaptaImportes(0);
        

        $linea_iva_factura = utf8_decode("5" . CODIGO_DE_EMPRESA . "{$fecha_apunte}{$tipo_registro}{$cuenta}{$descripcion_cuenta}{$tipo_importe}{$numero_factura}{$linea_apunte_iva_21}{$descripcion_apunte}{$subtipo_factura}{$base_imponible}{$porcentaje_iva}{$cuota_iva}{$porcentaje_recargo}{$cuota_recargo}{$porcentaje_retencion}{$cuota_retencion}{$impreso}{$operacion_sujeta_iva}{$marca_afecta_415}{$critero_de_caja}{$reserva}{$cuenta_iva_soportado}{$cuenta_recargo_soportado}{$cuenta_retencion}{$cuenta_iva_2_repercutido}{$cuenta_recargo_2_repercutido}{$registro_analitico}{$reserva_1}{$moneda_enlace}N\r\n");

        $archivo = fopen( NOMBRE_ARCHIVO_EXPORTADO, "a" );
            
        fwrite($archivo, $linea_iva_factura);
        fclose($archivo);

    }

}

//TIPO DE REGISTRO 0. Alta de Apuntes sin IVA (Para los cobros de las facturas)
    /* 
    *Cada cobro incluirá dos lineas: linea de la cuenta contable del cliente y linea de la cuenta de tesorería
    */

foreach ($datosPagos as $pago) {

    $fecha_apunte = $misAdaptaciones->UnificaFechaDDMMAAAA($pago['fecha_cobro']);
    $tipo_registro = 0;
    $cuenta = $misAdaptaciones->SubstrStrPadRight($pago['cuenta_contable_cliente'], 12, " ");
    $descripcion_cuenta = $misAdaptaciones->SubstrStrPadRight($pago['nombre_cliente'], 30, " ");
    list($tipo_importe_contable, $tipo_importe_tesoreria) = $misAdaptaciones->ImportePagos($pago['importe_de_cobro']);
    $referencia_documento = $misAdaptaciones->SubstrStrPadRight($pago['numero_factura'], 10, " ");
    $linea_apunte_contable = "I";
    $descripcion_apunte_contable = $misAdaptaciones->SubstrStrPadRight("Cobro {$pago['nombre_cliente']}", 30, " ");
    $importe = $misAdaptaciones->AdaptaImportes($pago['importe_de_cobro']);
    $reserva = "                                                                                                                                         "; //137 espacios
    $indicador_asiento = " ";
    $registro_analitico = " ";
    $reserva_1 = "                                                                                                                                                                                                                                                                "; //256 espacios
    $moneda_enlace = "E";

    $cuenta_tesoreria = "570000001   ";
    $linea_apunte_tesoreria = "U";
    $descripcion_apunte_tesoreria = $misAdaptaciones->SubstrStrPadRight("Cobro Fra {$pago['numero_factura']} {$pago['forma_de_cobro']}", 30, " ");


    $linea_cobro_1 = utf8_decode("5" . CODIGO_DE_EMPRESA . "{$fecha_apunte}{$tipo_registro}{$cuenta}{$descripcion_cuenta}{$tipo_importe_contable}{$referencia_documento}{$linea_apunte_contable}{$descripcion_apunte_contable}{$importe}{$reserva}{$indicador_asiento}{$registro_analitico}{$reserva_1}{$moneda_enlace}N\r\n");
    $linea_cobro_2 = utf8_decode("5" . CODIGO_DE_EMPRESA . "{$fecha_apunte}{$tipo_registro}{$cuenta_tesoreria}{$descripcion_cuenta}{$tipo_importe_tesoreria}{$referencia_documento}{$linea_apunte_tesoreria}{$descripcion_apunte_tesoreria}{$importe}{$reserva}{$indicador_asiento}{$registro_analitico}{$reserva_1}{$moneda_enlace}N\r\n");

    $linea_registro_tipo_0 = $linea_cobro_1;
    $linea_registro_tipo_0 .= $linea_cobro_2;

    $archivo = fopen(NOMBRE_ARCHIVO_EXPORTADO, "a");

    fwrite($archivo, $linea_registro_tipo_0);
    fclose($archivo);

}

?>