<?php
namespace app\controllers;

//require_once "./app/views/libreriapdf/dompdf/autoload.inc.php";


use app\models\mainModel;

class facturaController extends mainModel
{


    public function obtenerOpcionesFacturas()
    {
        $consulta_ordenes = "SELECT * FROM facturas ORDER BY id_factura";
        $datos_ordenes = $this->ejecutarConsulta($consulta_ordenes);
        $opciones_ordenes = "";

        while ($orden = $datos_ordenes->fetch()) {
            $opciones_ordenes .= '<option value="' . $orden['num_factura'] . '">'
                . $orden['num_factura'] . '</option>';
        }

        return $opciones_ordenes;
    }

    public function obtenerOpcionesProveedores()
    {
        $consulta_proveedores = "SELECT * FROM proveedores ORDER BY nombre_proveedor";
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
        $consulta_orden_compra = "SELECT * FROM ordenes_compra ORDER BY numero_orden";
        $datos_orden = $this->ejecutarConsulta($consulta_orden_compra);
        $opciones_ordenes = "";

        while ($orden_compra = $datos_orden->fetch()) {
            $opciones_ordenes .= '<option value="' . $orden_compra['id_orden_compra'] . '">'
                . $orden_compra['numero_orden'] . '</option>';
        }

        return $opciones_ordenes;
    }

    public function obtenerOpcionesMonedas()
    {
        $consulta_tipos_moneda = "SELECT * FROM tipos_moneda ORDER BY id_moneda";
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
        $consulta_empleados = "SELECT * FROM empleados ORDER BY nombre_empleado";
        $datos_empleados = $this->ejecutarConsulta($consulta_empleados);
        $opciones_empleados = "";

        while ($empleados = $datos_empleados->fetch()) {
            $opciones_empleados .= '<option value="' . $empleados['id_empleado'] . '">'
                . $empleados['nombre_empleado'] . '</option>';
        }

        return $opciones_empleados;
    }

    /*----------  Controlador registrar usuario  ----------*/
    public function registrarfacturaControlador()
    {
        // Generando número de orden automático
        $ultimoNumeroOrden = $this->obtenerUltimoNumeroOrden();
        $num_factura = 'CF-' . str_pad($ultimoNumeroOrden + 1, 8, '0', STR_PAD_LEFT);

        // Almacenando datos
        $numero_factura = $_POST['numero_factura'];
        $id_proveedor = $_POST['id_proveedor'];
        $id_moneda = $_POST['id_moneda'];
        $id_empleado = $this->limpiarCadena($_POST['id_empleado']);
        $fecha_emision = $_POST['fecha_emision'];
        $fecha_vencimiento = $_POST['fecha_vencimiento'];

        // Verificando campos obligatorios
        if ($id_proveedor == "" || $fecha_emision == "" || $fecha_vencimiento == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        $factura_datos_reg = [
            [
                "campo_nombre" => "num_factura",
                "campo_marcador" => ":NumFactura",
                "campo_valor" => $num_factura
            ],
            [
                "campo_nombre" => "numero_factura",
                "campo_marcador" => ":NumeroFactura",
                "campo_valor" => $numero_factura
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
                "campo_nombre" => "fecha_emision",
                "campo_marcador" => ":FechaEmision",
                "campo_valor" => $fecha_emision
            ],
            [
                "campo_nombre" => "fecha_vencimiento",
                "campo_marcador" => ":FechaVencimiento",
                "campo_valor" => $fecha_vencimiento
            ]
        ];

        $registrar_factura = $this->guardarDatos("facturas", $factura_datos_reg);

        if ($registrar_factura->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Factura registrada",
                "texto" => "La factura $num_factura se registró con éxito",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar la factura, por favor inténtelo nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    private function obtenerUltimoNumeroOrden()
    {
        $consulta_ultimo_numero = "SELECT MAX(SUBSTRING(num_factura, 4)) AS ultimo_numero FROM facturas";
        $resultado = $this->ejecutarConsulta($consulta_ultimo_numero)->fetch();
        return $resultado ? intval($resultado['ultimo_numero']) : 0;
    }

    function numeroALetras($numero)
    {
        // Esta es una función muy básica, considera buscar una más completa
        $unidades = ['cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        if ($numero >= 0 && $numero <= 9) {
            return $unidades[$numero];
        } else {
            return $numero; // Retorna el número sin convertir si no está en el rango de 0-9
        }
    }



    /*----------  Controlador listar productos  ----------*/
    public function listarFacturaControlador($pagina, $registros, $url, $busqueda)
    {
        $pagina = $this->limpiarCadena($pagina);
        $registros = $this->limpiarCadena($registros);
        $url = $this->limpiarCadena($url);
        $url = APP_URL . $url . "/";

        $busqueda = $this->limpiarCadena($busqueda);
        $precioDolar = isset($_POST['precioDolar']) ? (float) $_POST['precioDolar'] : 20; // Precio del dólar por defecto es 18
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        $consulta_datos = "SELECT
            f.*,
            f.numero_factura,
            p.nombre_proveedor,
            p.RFC_proveedor,
            f.fecha,
            SUM(df.precio_sin_IVA) AS precio_sin_iva,
            SUM(df.total) AS total_factura,
            m.nombre_moneda
        FROM
            facturas f
        JOIN
            detalle_factura df ON f.id_factura = df.id_factura
        JOIN
            proveedores p ON f.id_proveedor = p.id_proveedor
        JOIN
            tipos_moneda m ON f.id_moneda = m.id_moneda
        WHERE
            f.num_factura LIKE '%$busqueda%'
            OR f.numero_factura LIKE '%$busqueda%'
        GROUP BY
            f.id_factura, f.num_factura, f.numero_factura, p.nombre_proveedor, p.RFC_proveedor, f.fecha, m.nombre_moneda
        ORDER BY
            f.fecha DESC
        LIMIT
            $inicio, $registros;";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $consulta_total = "SELECT COUNT(*)
        FROM facturas f
        JOIN detalle_factura df ON f.id_factura = df.id_factura
        JOIN proveedores p ON f.id_proveedor = p.id_proveedor
        WHERE f.num_factura LIKE '%$busqueda%'
        OR f.numero_factura LIKE '%$busqueda%';";

        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int) $total->fetchColumn();

        $numeroPaginas = ceil($total / $registros);

        $tabla .= '
        <form method="POST" action="' . $url . '">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="precioDolar" class="form-label">Tipo de cambio (USD a MXN)</label>
                    <input type="number" step="0.01" class="form-control" name="precioDolar" placeholder="Precio del Dólar" value="' . htmlspecialchars($precioDolar) . '">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </form>
        <button class="btn btn-primary" onclick="imprimirArea(\'areaImprimir\')">Imprimir</button>
        <div id="areaImprimir">
        <div class="container-fluid">';

        $totalPesos = 0;
        $totalDolares = 0;
        $totalIvaPesos = 0;
        $totalIvaDolares = 0;
        $totalGeneralPesos = 0;
        $totalGeneralDolares = 0;

        $facturas_agrupadas = [];
        foreach ($datos as $rows) {
            $fecha = new \DateTime($rows['fecha']);
            $año = $fecha->format('Y');
            $mes = $fecha->format('F Y');
            $semana = $fecha->format('W');

            $facturas_agrupadas[$año][$mes][$semana][] = $rows;

            $subtotal = $rows['precio_sin_iva'];
            $iva = $subtotal * 0.16;
            $totalConIva = $subtotal + $iva;

            if (strtolower($rows['nombre_moneda']) == 'pesos' || strtolower($rows['nombre_moneda']) == 'mxn') {
                $totalPesos += $subtotal;
                $totalIvaPesos += $iva;
                $totalGeneralPesos += $totalConIva;
            } else {
                $totalDolares += $subtotal;
                $totalIvaDolares += $iva;
                $totalGeneralDolares += $totalConIva;
            }

            $tabla .= '
             <div class="invoice">
                 <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding: 5px;">
                 <p style="font-size: 14px; text-align: center;"><strong>Captura de Factura</strong></p>
                 <div style="display: flex; align-items: center; justify-content: space-between;">
                     <img src="' . APP_URL . 'app/views/fotos/logo_orden.png" alt="logo" style="width:200px; height:auto;">
                     <div>
                         <p><strong>Registro Número:</strong> ' . $rows['num_factura'] . '</p>
                         <p><strong>Fecha:</strong> ' . $rows['fecha'] . '</p>
                         <p><strong>Fecha de emisión:</strong> ' . $rows['fecha_emision'] . '</p>
                         <p><strong>Fecha de vencimiento:</strong> ' . $rows['fecha_vencimiento'] . '</p>
                         <p style="font-size: 13px;"><strong>Formato:</strong>  PR-12-F07</p>
                     </div>
                 </div>
                     <p style="margin-top: 0; margin-bottom: 0; text-align: left;">RADIOTECNOLOGÍA INDUSTRIAL S.A. DE C.V.</p>
                     <p style="margin-top: 0; margin-bottom: 0; text-align: left;">RFC: RIN070219R38</p>
                     <p style="margin-top: 0; margin-bottom: 0; text-align: left;">Calle Puebla Sur. Manzana 4. Lote 5 Nave B Int. 2 Col. Jardín Industrial</p>
                     <p style="margin-top: 0; margin-bottom: 0; text-align: left;">Ixtapaluca. Edo. de México, C.P. 56535</p>
                 </div>

                
                 <table class="table" style="width: 100%; padding-top: 10; font-size: 13px;">
         <thead>
             <tr>
                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Número de Factura</th>
                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Num Factura</th>
                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Proveedor</th>
                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">RFC</th>
                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Subtotal</th>
                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">IVA</th>
                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Total con IVA</th>
             </tr>
         </thead>

 <tbody>
         <tr>
         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['num_factura'] . '</td>
         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['numero_factura'] . '</td>
         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['nombre_proveedor'] . '</td>
         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['RFC_proveedor'] . '</td>
         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($subtotal, 2)) . '</td>
         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($iva, 2)) . '</td>
         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($totalConIva, 2)) . '</td>
         </tr>
          </tbody>
         </table>
            ';
        }

        $totalDolaresEnPesos = $totalDolares * $precioDolar;
        $totalIvaDolaresEnPesos = $totalIvaDolares * $precioDolar;
        $totalGeneralDolaresEnPesos = $totalGeneralDolares * $precioDolar;

        $subtotalGeneral = $totalPesos + $totalDolaresEnPesos;
        $ivaGeneral = $totalIvaPesos + $totalIvaDolaresEnPesos;
        $totalGeneral = $totalGeneralPesos + $totalGeneralDolaresEnPesos;

        $tabla .= '
        <table class="table" style="width: 100%; padding-top: 10; font-size: 13px;">
            <tr>
                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Subtotal Pesos</th>
                <th style="text-align: center; border: 1px solid #000; padding: 5px;">IVA Pesos</th>
                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Subtotal Dólares en Pesos</th>
                <th style="text-align: center; border: 1px solid #000; padding: 5px;">IVA Dólares en Pesos</th>
                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Subtotal</th>
                <th style="text-align: center; border: 1px solid #000; padding: 5px;">IVA General</th>
                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Total General con IVA</th>
            </tr>
            <tr>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($totalPesos, 2)) . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($totalIvaPesos, 2)) . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($totalDolaresEnPesos, 2)) . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($totalIvaDolaresEnPesos, 2)) . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($subtotalGeneral, 2)) . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($ivaGeneral, 2)) . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($totalGeneral, 2)) . '</td>
            </tr>
        </table>
        </div>
        </div>';

        $tabla .= '
        <script>
        function imprimirArea(id) {
            var contenido = document.getElementById(id).innerHTML;
            var ventanaImpresion = window.open("", "_blank");
            ventanaImpresion.document.write("<html><head><title>Facturas</title>");
            
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

        return [
            'tabla_html' => $tabla,
            'facturas_agrupadas' => $facturas_agrupadas
        ];
    }









}
