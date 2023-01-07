<?php
namespace Jorge\SuenlaceDatA3asesor;
//Funciones para adaptar los datos al requerimiento de SUENLACE.dat

class Datos {

    function DatosClientesArray() //Recibir datos con un array de ejemplo
    {

        $clientesArray = array();

        array_push($clientesArray, (array)
            [
                'fecha_add_cliente' => '22/08/2022',
                'cuenta_contable_cliente' => '430000069',
                'nombre_cliente' => 'Empresa de Ejemplo SL',
                'nif_cliente' => 'B08205373',
                'siglas_via_publica_cliente' => 'CL',
                'via_publica_cliente' => 'Ejemplo',
                'numero_portal_cliente' => '123',
                'escalera_cliente' => '',
                'piso_cliente' => '',
                'puerta_cliente' => '',
                'municipio_cliente' => 'Alicante',
                'codigo_postal_cliente' => '02005',
                'provincia_cliente' => 'Alicante',
                'pais_cliente' => 'España',
                'telefono_cliente' => '66666666',
                'extension_cliente' => '',
                'fax_cliente' => '',
                'email_cliente' => 'ejemplo@email.com'
            ],
            [
                'fecha_add_cliente' => '05/10/2022',
                'cuenta_contable_cliente' => '430000087',
                'nombre_cliente' => 'Otra empresa SL',
                'nif_cliente' => 'B02105349',
                'siglas_via_publica_cliente' => 'CL',
                'via_publica_cliente' => 'Nombre calle',
                'numero_portal_cliente' => '7',
                'escalera_cliente' => '',
                'piso_cliente' => '',
                'puerta_cliente' => '',
                'municipio_cliente' => 'Murcia',
                'codigo_postal_cliente' => '04003',
                'provincia_cliente' => 'Murcia',
                'pais_cliente' => 'España',
                'telefono_cliente' => '69664662',
                'extension_cliente' => '',
                'fax_cliente' => '',
                'email_cliente' => 'otroemail@email.com'
            ]
        );

        $FacturasArray = array();

        array_push($FacturasArray, (array)
            [
                'fecha_factura' => '22/10/2022',
                'cuenta_contable_cliente' => '430000069',
                'nombre_cliente' => 'Empresa de Ejemplo SL',
                'nif_cliente' => 'B08205373',
                'codigo_postal_cliente' => '02005',
                'numero_factura_cliente' => '230000049',
                'importe_total_iva_excl' => 200.00,
                'importe_total_iva_incl' => 231.00, //100.00 + 21% y 100 + 10%
                'importe_iva_excl_4' => 0.00,
                'importe_iva_excl_10' => 100.00,
                'importe_iva_excl_21' => 100.00,
                'importe_iva_4' => 0.00,
                'importe_iva_10' => 10.00,
                'importe_iva_21' => 21.00,
                'requ_equi_iva_4' => 0.00,
                'requ_equi_iva_10' => 0.00,
                'requ_equi_iva_21' => 0.00,
                'porcentaje_de_retencion' => 0.00,
                'cuota_de_retencion' => 0.00

            ]
        );

        $PagosArray = array();

        array_push($PagosArray, (array)
            [
                'fecha_cobro' => '23/10/2022',
                'cuenta_contable_cliente' => '430000069',
                'nombre_cliente' => 'Empresa de Ejemplo SL',
                'numero_factura' => '230000049',
                'importe_de_cobro' => 143.43,
                'forma_de_cobro' => "Transferencia bancaria"
            ]
        );

        return array($clientesArray, $FacturasArray, $PagosArray);

    }

}
?>