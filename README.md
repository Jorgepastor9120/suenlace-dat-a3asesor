# suenlace-dat-a3asesor
Aplicación web para generar el enlace contable de entrada (SUENLACE.dat) con analítica adaptado al SII para a3ASESOR | eco.

La aplicación genera un archivo .dat con 3 tipos de registros: 

-Facturas: Con el registro tipo 1 Alta Cabecera de apuntes con IVA y registro tipo 9 Detalle de apuntes con IVA.

-Clientes: Con el registro tipo C Alta / Modificación de cuentas y/o clientes y proveedores. Aunque en este ejemplo solo vamos a exportar clientes.

-Cobros de facturas: Con el registro tipo 0 Alta de Apuntes sin IVA.


NOTAS:
La aplicación adapta cada uno de los datos al límite de longitud de caracteres para cada campo. También hace la conversión de las fecha y campos numericos entre otros (por ejemplo para un importe de 32,25€ la conversión sería +0000000032.25).
Además está preparada para sustitur los comentarios Loop por tu modo de iteración para recorrer los datos e ir añadiendo las lineas a suenlace.dat.