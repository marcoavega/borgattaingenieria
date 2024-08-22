<?php
namespace app\controllers;
//require_once "./app/views/libreriapdf/dompdf/autoload.inc.php";


use app\models\mainModel;

class ordenGastoController extends mainModel
{


    public function obtenerOpcionesOrdenes()
    {
        $consulta_ordenes = "SELECT * FROM ordenes_gasto ORDER BY id_orden_gasto DESC";
        $datos_ordenes = $this->ejecutarConsulta($consulta_ordenes);
        $opciones_ordenes = "";

        while ($orden = $datos_ordenes->fetch()) {
            $opciones_ordenes .= '<option value="' . $orden['numero_orden'] . '">'
                . $orden['numero_orden'] . '</option>';
        }

        return $opciones_ordenes;
    }

    public function obtenerOpcionesProveedores()
    {
        $consulta_proveedores = "SELECT * FROM proveedores ORDER BY nombre_proveedor DESC";
        $datos_proveedores = $this->ejecutarConsulta($consulta_proveedores);
        $opciones_proveedores = "";

        while ($proveedor = $datos_proveedores->fetch()) {
            $opciones_proveedores .= '<option value="' . $proveedor['id_proveedor'] . '">'
                . $proveedor['nombre_proveedor'] . '</option>';
        }

        return $opciones_proveedores;
    }

    public function obtenerOpcionesOrdenCompra()
    {
        $consulta_orden_compra = "SELECT * FROM ordenes_gasto ORDER BY numero_orden DESC";
        $datos_orden = $this->ejecutarConsulta($consulta_orden_compra);
        $opciones_ordenes = "";

        while ($orden_compra = $datos_orden->fetch()) {
            $opciones_ordenes .= '<option value="' . $orden_compra['id_orden_gasto'] . '">'
                . $orden_compra['numero_orden'] . '</option>';
        }

        return $opciones_ordenes;
    }

    public function obtenerOpcionesMonedas()
    {
        $consulta_tipos_moneda = "SELECT * FROM tipos_moneda ORDER BY id_moneda DESC";
        $datos_moneda = $this->ejecutarConsulta($consulta_tipos_moneda);
        $opciones_monedas = "";

        while ($moneda = $datos_moneda->fetch()) {
            $opciones_monedas .= '<option value="' . $moneda['id_moneda'] . '">'
                . $moneda['nombre_moneda'] . '</option>';
        }

        return $opciones_monedas;
    }

    public function obtenerEmpleados()
    {
        $consulta_empleados = "SELECT * FROM empleados ORDER BY nombre_empleado DESC";
        $datos_empleados = $this->ejecutarConsulta($consulta_empleados);
        $opciones_empleados = "";

        while ($empleados = $datos_empleados->fetch()) {
            $opciones_empleados .= '<option value="' . $empleados['id_empleado'] . '">'
                . $empleados['nombre_empleado'] . '</option>';
        }

        return $opciones_empleados;
    }

     public function obtenerUsos()
    {
        $consulta = "SELECT * FROM catusoscfdi ORDER BY clave DESC";
        $datos = $this->ejecutarConsulta($consulta);
        $opciones = "";

        while ($datosObt = $datos->fetch()) {
            $opciones .= '<option value="' . $datosObt['id_catusoscfdi'] . '">'
                . $datosObt['Clave'] . ' - '
                . $datosObt['Nombre'] . '</option>';
        }

        return $opciones;
    }

    public function obtenerMetodosPago()
    {
        $consulta = "SELECT * FROM catmetodospago ORDER BY clave DESC";
        $datos = $this->ejecutarConsulta($consulta);
        $opciones = "";

        while ($datosObt = $datos->fetch()) {
            $opciones .= '<option value="' . $datosObt['id_catmetodospago'] . '">'
                . $datosObt['Clave'] . ' - '
                . $datosObt['Descripcion'] . '</option>';
        }

        return $opciones;
    }

    /*----------  Controlador registrar usuario  ----------*/
    public function registrarOrdenGastoControlador()
    {
        # Generando número de orden automático
        /*$ultimoNumeroOrden = $this->obtenerUltimoNumeroOrden();
        $numero_orden = 'ROC-' . str_pad($ultimoNumeroOrden + 1, 3, '0', STR_PAD_LEFT);
    */

        // Generando número de orden automático
        $ultimoNumeroOrden = $this->obtenerUltimoNumeroOrden();
        $numero_orden = 'ROG-' . str_pad($ultimoNumeroOrden + 1, 8, '0', STR_PAD_LEFT);

        # Almacenando datos
        $id_proveedor = $_POST['id_proveedor'];
        $id_moneda = $_POST['id_moneda'];
        $id_empleado = $this->limpiarCadena($_POST['id_empleado']);
         $id_uso = $this->limpiarCadena($_POST['id_uso']);
        $id_metodo = $this->limpiarCadena($_POST['id_metodo']);


        # Verificando campos obligatorios
        if ($id_proveedor == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        $orden_gasto_datos_reg = [
            [
                "campo_nombre" => "numero_orden",
                "campo_marcador" => ":NumeroOrden",
                "campo_valor" => $numero_orden
            ],
            [
                "campo_nombre" => "id_proveedor",
                "campo_marcador" => ":IdProveedor",
                "campo_valor" => $id_proveedor
            ],
            [
                "campo_nombre" => "id_moneda",
                "campo_marcador" => ":IdMoneda",
                "campo_valor" => $id_moneda
            ],
            [
                "campo_nombre" => "id_empleado",
                "campo_marcador" => ":IdEmpleado",
                "campo_valor" => $id_empleado
            ],
            [
                "campo_nombre" => "id_catusoscfdi",
                "campo_marcador" => ":IdUso",
                "campo_valor" => $id_uso
            ],
            [
                "campo_nombre" => "id_catmetodospago",
                "campo_marcador" => ":IdMetodo",
                "campo_valor" => $id_metodo
            ]
        ];

        $registrar_orden_gasto = $this->guardarDatos("ordenes_gasto", $orden_gasto_datos_reg);

        if ($registrar_orden_gasto->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Orden de gasto registrada",
                "texto" => "La orden de gasto $numero_orden se registró con éxito",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar la orden de gasto, por favor inténtelo nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    private function obtenerUltimoNumeroOrden()
    {
        $consulta_ultimo_numero = "SELECT MAX(SUBSTRING(numero_orden, 5)) AS ultimo_numero FROM ordenes_gasto";
        $resultado = $this->ejecutarConsulta($consulta_ultimo_numero)->fetch();
        return $resultado ? intval($resultado['ultimo_numero']) : 0;
    }


    function numeroALetras($numero) {
        // Esta es una función muy básica, considera buscar una más completa
        $unidades = ['cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        if ($numero >= 0 && $numero <= 9) {
            return $unidades[$numero];
        } else {
            return $numero; // Retorna el número sin convertir si no está en el rango de 0-9
        }
    }

    /*----------  Controlador listar productos  ----------*/
    public function listarOrderControlador($pagina, $registros, $url, $busqueda)
    {
       
        $pagina = $this->limpiarCadena($pagina);
        $registros = $this->limpiarCadena($registros);

        $url = $this->limpiarCadena($url);
        $url = APP_URL . $url . "/";

        $busqueda = $this->limpiarCadena($busqueda);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        $consulta_datos = "SELECT
        detalle_orden_gasto.*,
        ordenes_gasto.numero_orden,
        proveedores.nombre_proveedor,
        proveedores.RFC_proveedor,
        proveedores.contacto_proveedor,
        proveedores.telefono_proveedor,
        proveedores.email_proveedor,
        proveedores.direccion_proveedor,
        ordenes_gasto.*,
        unidades_medida.id_unidad,
        unidades_medida.nombre_unidad,
        tipos_moneda.id_moneda,
        tipos_moneda.nombre_moneda,
        empleados.nombre_empleado,
        catusoscfdi.Clave AS clave_uso_cfdi,
        catusoscfdi.Nombre AS nombre_uso_cfdi,
        catmetodospago.Clave AS clave_metodo_pago,
        catmetodospago.Descripcion AS descripcion_metodo_pago
        
    FROM
        detalle_orden_gasto
    LEFT JOIN ordenes_gasto ON detalle_orden_gasto.id_orden_gasto = ordenes_gasto.id_orden_gasto
    LEFT JOIN proveedores ON ordenes_gasto.id_proveedor = proveedores.id_proveedor
    LEFT JOIN unidades_medida ON detalle_orden_gasto.id_unidad = unidades_medida.id_unidad
    LEFT JOIN tipos_moneda ON ordenes_gasto.id_moneda = tipos_moneda.id_moneda
    LEFT JOIN empleados ON ordenes_gasto.id_empleado = empleados.id_empleado
    LEFT JOIN catusoscfdi ON ordenes_gasto.id_catusoscfdi = catusoscfdi.id_catusoscfdi
    LEFT JOIN catmetodospago ON ordenes_gasto.id_catmetodospago = catmetodospago.id_catmetodospago
    WHERE
        detalle_orden_gasto.nombre_producto LIKE '%$busqueda%'
        OR ordenes_gasto.numero_orden LIKE '%$busqueda%'
    ORDER BY
        detalle_orden_gasto.id_orden_gasto DESC, detalle_orden_gasto.id_detalle_orden ASC
    LIMIT
        $inicio, $registros;";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $consulta_total = "SELECT COUNT(*)
    FROM detalle_orden_gasto
    JOIN ordenes_gasto ON detalle_orden_gasto.id_orden_gasto = ordenes_gasto.id_orden_gasto
    JOIN proveedores ON ordenes_gasto.id_proveedor = proveedores.id_proveedor
    JOIN empleados ON ordenes_gasto.id_empleado = empleados.id_empleado
    WHERE detalle_orden_gasto.nombre_producto LIKE '%$busqueda%'
    OR ordenes_gasto.numero_orden LIKE '%$busqueda%';";

        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int) $total->fetchColumn();

        $numeroPaginas = ceil($total / $registros);

        

      

     $tabla .= '
     <button class="btn btn-primary" onclick="imprimirArea(\'areaImprimir\')">Imprimir</button>
     <div id="areaImprimir">
     <div class="container-fluid">';

$ordenActual = '';
foreach ($datos as $rows) {
    if ($ordenActual !== $rows['numero_orden']) {
        if ($ordenActual !== '') {
            // Cierra la tabla anterior si no es la primera orden
            $tabla .= '</tbody>';
    
            $tabla .= '</table><hr>';
        }
        $ordenActual = $rows['numero_orden'];
        $tabla .= '
        <div class="invoice">
        <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding: 5px;">
        <p style="font-size: 14px; text-align: center;"><strong>Orden de Gasto</strong></p>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <img src="' . APP_URL . 'app/views/fotos/logo_orden.png" alt="logo" style="width:200px; height:auto;">
            <div>
                <p style="font-size: 13px;"><strong>Orden de Gasto:</strong> ' . $rows['numero_orden'] . '</p>
                <p style="font-size: 13px;"><strong>Fecha:</strong> ' . date('d/m/Y', strtotime($rows['fecha'])) . '</p>
                <p style="font-size: 13px;"><strong>Formato:</strong>  PR-12-F03</p>
            </div>
        </div>
            <p style="margin-top: 0; margin-bottom: 0;">RADIOTECNOLOGÍA INDUSTRIAL S.A. DE C.V.</p>
            <p style="margin-top: 0; margin-bottom: 0;">RFC: RIN070219R38</p>
            <p style="margin-top: 0; margin-bottom: 0;">Calle Puebla Sur. Manzana 4. Lote 5 Nave B Int. 2 Col. Jardín Industrial</p>
            <p style="margin-top: 0; margin-bottom: 0;">Ixtapaluca. Edo. de México, C.P. 56535</p>
        </div>

    <div class="invoice" style="display: flex; font-size: 13px; border: 1px solid #000; padding: 5px;">
    <div style="flex: 1; margin-top: 1px; margin-bottom: 10px; border: 1px solid #000; padding: 5px;">
        <p style="margin-top: 0; margin-bottom: 0; border: 1px solid #000;"><strong>Datos Proveedor:</strong></p>
        <p style="margin-top: 0; margin-bottom: 0;"><strong>Proveedor:</strong> ' . $rows['nombre_proveedor'] . '</p>
        <p style="margin-top: 0; margin-bottom: 0;"><strong>RFC:</strong> ' . $rows['RFC_proveedor'] . '</p>
        <p style="margin-top: 0; margin-bottom: 0;"><strong>Contacto:</strong> ' . $rows['contacto_proveedor'] . '</p>
        <p style="margin-top: 0; margin-bottom: 0;"><strong>Teléfono:</strong> ' . $rows['telefono_proveedor'] . '</p>
        <p style="margin-top: 0; margin-bottom: 0;"><strong>E-mail:</strong> ' . $rows['email_proveedor'] . '</p>
        <p style="margin-top: 0; margin-bottom: 0;"><strong>Dirección:</strong> ' . $rows['direccion_proveedor'] . '</p>
    </div>
    <div style="flex: 1; margin-right: 10px; margin-top: 1px; margin-bottom: 10px; border: 1px solid #000; padding: 5px;">
        <p style="margin-top: 0; margin-bottom: 0; border: 1px solid #000;"><strong>ENVIAR A:</strong></p>
        <p style="margin-top: 0; margin-bottom: 0;">RADIOTECNOLOGÍA INDUSTRIAL S.A. DE C.V.</p>
        <p style="margin-top: 0; margin-bottom: 0;">RFC: RIN070219R38</p>
        <p style="margin-top: 0; margin-bottom: 0;">Calle Puebla Sur. Manzana 4. Lote 5 Nave B Int. 2 Col. Jardín Industrial</p>
        <p style="margin-top: 0; margin-bottom: 0;">Ixtapaluca. Edo. de México, C.P. 56535</p>
        <p style="margin-top: 0; margin-bottom: 0;">Teléfono: 5551336363 extenciones: 415, 414 ó 418</p>
    </div>
</div>


<div style="font-size: 13px; border: 1px solid #000; padding: 5px; margin-top: 10px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div style="flex: 0 0 20%; text-align: left;">
            <strong>Datos para Facturación:</strong>
        </div>
        <div style="flex: 0 0 40%; text-align: left; padding-left: 10px;">
            <strong>Uso de CFDI:</strong> ' . $rows['clave_uso_cfdi'] . ' - ' . $rows['nombre_uso_cfdi'] . '
        </div>
        <div style="flex: 0 0 40%; text-align: left; padding-left: 10px;">
            <strong>Método de Pago:</strong> ' . $rows['clave_metodo_pago'] . ' - ' . $rows['descripcion_metodo_pago'] . '
        </div>
    </div>
</div>


<table class="table" style="width: 100%; padding-top: 10; font-size: 13px;">
<thead>
    <tr>
        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Partida</th>
        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Producto</th>
        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Cantidad</th>
        <th style="text-align: center; border: 1px solid #000; padding: 5px;">U.M.</th>
        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Precio</th>
        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Importe</th>
    </tr>
</thead>
<tbody>';
    }
// Continúa 
$tabla .= '  
<tr>
<td style="text-align: center; border: 1px solid #000; padding: 5px;" class="numero-partida"></td>
<td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['nombre_producto'] . '</td>
<td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['cantidad'] . '</td>
<td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['nombre_unidad'] . '</td>
<td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['precio_sin_IVA'] . '</td>
<td style="text-align: center; border: 1px solid #000; padding: 5px;" data-importe="' . $rows['total'] . '">' . $rows['total'] . '</td>
</tr>';
}
// Cierra la última tabla
if ($ordenActual !== '') {
    // Agrega la fila de totales
    $tabla .= '<tfoot>
    <tr>
        <td colspan="5" style="text-align: right; border: 1px solid #000; padding: 5px;">Suma de Importes:</td>
        <td style="text-align: center; border: 1px solid #000; padding: 5px;" data-importe="suma" id="sumaImportes_' . $ordenActual . '"></td>
    </tr>
    <tr>
        <td colspan="5" style="text-align: right; border: 1px solid #000; padding: 5px;">IVA (16%):</td>
        <td style="text-align: center; border: 1px solid #000; padding: 5px;" data-importe="iva" id="ivaImportes_' . $ordenActual . '"></td>
    </tr>
    <tr>
        <td colspan="5" style="text-align: right; border: 1px solid #000; padding: 5px;">Total ' . $rows['nombre_moneda'] . ':</td>
        <td style="text-align: center; border: 1px solid #000; padding: 5px;" data-importe="total" id="totalImportes_' . $ordenActual . '"></td>
    </tr>
    <tr>
        <td colspan="6" style="text-align: right; border: 1px solid #000; padding: 5px; white-space: nowrap;">
            <strong>Total en letras:</strong> <span style="margin-left: 20px;"></span><div id="totalLetras_' . $ordenActual . '" style="display: inline;"></div>
        </td>
    </tr>
    <tr>
        <td colspan="6" style="text-align: right; border: 1px solid #000; padding: 5px; white-space: nowrap;">
            <strong>Empleado que solicita:</strong> 
            <span style="margin-left: 20px;"></span>
            <div style="display: inline;">' . $rows['nombre_empleado'] . '</div>
        </td>
    </tr>
    </tfoot>';
    $tabla .= '</tbody></table></div>';
}

$tabla .= '</div>';

// Agregar el texto de "Sello" que solo se verá en la impresión
$tabla .= '
<style>
@media print {
    .sello-impresion {
        position: fixed;
        bottom: 50px;
        width: 100%;
        text-align: center;
        font-weight: bold;
        font-size: 13px;
    }
}
@media screen {
    .sello-impresion {
        display: none;
    }
}
</style>
<div class="sello-impresion">Sello</div>
';


$tabla .= '<script>

document.addEventListener("DOMContentLoaded", function() {
    var ordenes = document.querySelectorAll(".invoice");
    ordenes.forEach(function(orden) {
        var filas = orden.querySelectorAll("tbody tr");
        filas.forEach(function(fila, index) {
            fila.querySelector(".numero-partida").textContent = index + 1;
        });
    });
});

function numeroALetras(numero) {
    const unidades = ["", "un", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve"];
    const decenas = ["", "diez", "veinte", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta", "noventa"];
    const centenas = ["", "ciento", "doscientos", "trescientos", "cuatrocientos", "quinientos", "seiscientos", "setecientos", "ochocientos", "novecientos"];
    const especiales = ["diez", "once", "doce", "trece", "catorce", "quince", "dieciséis", "diecisiete", "dieciocho", "diecinueve"];

    let parteEntera = Math.floor(numero);
    let parteDecimal = Math.round((numero - parteEntera) * 100);
    let resultado = convertirALetras(parteEntera);

    resultado += " con " + convertirALetras(parteDecimal) + (parteDecimal === 1 ? " centavo " : " centavos ") + (parteDecimal < 10 ? "0" : "") + parteDecimal + "/100";

    return resultado;

    function convertirALetras(n) {
        if (n === 0) {
            return "cero";
        } else if (n > 0 && n < 20) {
            return especiales[n - 10] || unidades[n];
        } else if (n >= 20 && n < 100) {
            return decenas[Math.floor(n / 10)] + (n % 10 ? " y " + unidades[n % 10] : "");
        } else if (n === 100) {
            return "cien";
        } else if (n > 100 && n < 1000) {
            return (n < 200 ? "ciento" : centenas[Math.floor(n / 100)]) + (n % 100 ? " " + convertirALetras(n % 100) : "");
        } else if (n >= 1000 && n < 1000000) {
            return convertirALetras(Math.floor(n / 1000)) + " mil" + (n % 1000 ? " " + convertirALetras(n % 1000) : "");
        } else if (n >= 1000000 && n < 1000000000) {
            return convertirALetras(Math.floor(n / 1000000)) + " millones" + (n % 1000000 ? " " + convertirALetras(n % 1000000) : "");
        }
    }
}


    document.addEventListener("DOMContentLoaded", function () {
        var ordenes = document.querySelectorAll(".invoice");
        ordenes.forEach(function (orden) {
            var filas = orden.querySelectorAll("tbody tr");
            var sumaImportes = 0;

            filas.forEach(function (fila) {
                sumaImportes += parseFloat(fila.querySelector("[data-importe]").dataset.importe);
            });

            var iva = sumaImportes * 0.16;
            var total = sumaImportes + iva;

            orden.querySelector("#sumaImportes_' . $ordenActual . '").textContent = sumaImportes.toFixed(2);
            orden.querySelector("#ivaImportes_' . $ordenActual . '").textContent = iva.toFixed(2);
            orden.querySelector("#totalImportes_' . $ordenActual . '").textContent = total.toFixed(2);
        });
    });


    

    document.addEventListener("DOMContentLoaded", function () {
        var ordenes = document.querySelectorAll(".invoice");
        ordenes.forEach(function (orden) {
            var filas = orden.querySelectorAll("tbody tr");
            var sumaImportes = 0;
    
            filas.forEach(function (fila) {
                sumaImportes += parseFloat(fila.querySelector("[data-importe]").dataset.importe);
            });
    
            var iva = sumaImportes * 0.16;
            var total = sumaImportes + iva;
    
            orden.querySelector("#sumaImportes_' . $ordenActual . '").textContent = sumaImportes.toFixed(2);
            orden.querySelector("#ivaImportes_' . $ordenActual . '").textContent = iva.toFixed(2);
            orden.querySelector("#totalImportes_' . $ordenActual . '").textContent = total.toFixed(2);
            // Convertir la parte entera del total a letras y manejar la parte decimal
        var totalEnLetras = numeroALetras(total);
        orden.querySelector("#totalLetras_' . $ordenActual . '").textContent = totalEnLetras;
    });
});


function imprimirArea(id) {
    var contenido = document.getElementById(id).innerHTML;
    var ventanaImpresion = window.open("", "_blank");
    ventanaImpresion.document.write("<html><head><title>' . $rows['numero_orden'] . '</title>");
    
    // Aquí puedes agregar tus estilos CSS
    ventanaImpresion.document.write("<style>");
    ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");

    ventanaImpresion.document.write("</style>");
    
    ventanaImpresion.document.write("</head><body>");
    ventanaImpresion.document.write(contenido);
    ventanaImpresion.document.write("</body></html>");
    ventanaImpresion.document.close();
    ventanaImpresion.print();
}

</script>';


        return $tabla;
        
    }

  

}
