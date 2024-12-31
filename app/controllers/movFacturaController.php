<?php

namespace app\controllers;

use app\models\mainModel;

class movFacturaController extends mainModel
{

    public function obtenerOpcionesProductos()
    {
        $consulta_productos = "SELECT * FROM productos ORDER BY id_producto";
        $datos_productos = $this->ejecutarConsulta($consulta_productos);
        $opciones_productos = "";

        while ($productos = $datos_productos->fetch()) {
            $opciones_productos .= '<option value="' . $productos['id_producto'] . '">'
                . $productos['codigo_producto'] . " " . $productos['nombre_producto'] . '</option>';
        }

        return $opciones_productos;
    }
    public function obtenerOpcionesAlmacenes()
    {
        $consulta_almacenes = "SELECT * FROM almacenes ORDER BY nombre_almacen";
        $datos_almacenes = $this->ejecutarConsulta($consulta_almacenes);
        $opciones_almacenes = "";

        while ($almacenes = $datos_almacenes->fetch()) {
            $opciones_almacenes .= '<option value="' . $almacenes['id_almacen'] . '">'
                . $almacenes['nombre_almacen'] . '</option>';
        }

        return $opciones_almacenes;
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

    public function obtenerMovimientos()
    {
        $consulta_movimientos = "SELECT * FROM movimientos ORDER BY id_movimiento";
        $datos_movimientos = $this->ejecutarConsulta($consulta_movimientos);
        $opciones_movimientos = "";

        while ($movimientos = $datos_movimientos->fetch()) {
            $opciones_movimientos .= '<option value="' . $movimientos['id_movimiento'] . '">'
                . $movimientos['fecha_movimiento'] . '</option>';
        }

        return $opciones_movimientos;
    }

    public function obtenerOpcionesProveedores()
    {
        $consulta_proveedores = "SELECT * FROM proveedores ORDER BY id_proveedor";
        $datos_proveedores = $this->ejecutarConsulta($consulta_proveedores);
        $opciones_proveedores = "";

        while ($proveedores = $datos_proveedores->fetch()) {
            $opciones_proveedores .= '<option value="' . $proveedores['id_proveedor'] . '">'
                 . $proveedores['nombre_proveedor'] . '</option>';
        }

        return $opciones_proveedores;
    }

    /*----------  Controlador registrar proveedor  ----------*/
    public function registrarMovimientoControlador()
    {

        $id = $this->limpiarCadena($_POST['id_producto']);

        # Verificando usuario #
        $datos = $this->ejecutarConsulta("SELECT * FROM productos WHERE id_producto='$id'");
        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado el productos en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $datos = $datos->fetch();
        }


        # Almacenando datos#

        $id_producto = $this->limpiarCadena($_POST['id_producto']);
        $id_almacen_origen = $this->limpiarCadena($_POST['id_almacen_origen']);
        $id_almacen_destino = $this->limpiarCadena($_POST['id_almacen_destino']);
        $cantidad = $this->limpiarCadena($_POST['cantidad']);
        $id_empleado = $this->limpiarCadena($_POST['id_empleado']);
        $nota = $this->limpiarCadena($_POST['nota']);


        // Validar que los campos no estén vacíos
        if (empty($id_producto) || empty($id_almacen_origen) || empty($id_almacen_destino) || empty($cantidad) || empty($nota) || empty($id_empleado)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios" ,
                "icono" => "error"
            ];

            return json_encode($alerta);
        }


        $movimiento_datos_reg = [

            [
                "campo_nombre" => "id_producto",
                "campo_marcador" => ":Producto",
                "campo_valor" => $id_producto
            ],
            [
                "campo_nombre" => "id_almacen_origen ",
                "campo_marcador" => ":Origen",
                "campo_valor" => $id_almacen_origen
            ],
            [
                "campo_nombre" => "id_almacen_destino",
                "campo_marcador" => ":Destino",
                "campo_valor" => $id_almacen_destino
            ],
            [
                "campo_nombre" => "cantidad",
                "campo_marcador" => ":Cantidad",
                "campo_valor" => $cantidad
            ],
            [
                "campo_nombre" => "id_empleado",
                "campo_marcador" => ":Empleado",
                "campo_valor" => $id_empleado
            ],
            [
                "campo_nombre" => "nota_movimiento",
                "campo_marcador" => ":Nota",
                "campo_valor" => $nota
            ]

        ];



        $registrar_movimiento = $this->guardarDatos("movimientos", $movimiento_datos_reg);

        if ($registrar_movimiento->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Movimiento registrado",
                "texto" => "El movimiento se registro con exito",
                "icono" => "success"
            ];
        } else {

            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar el movimiento, por favor intente nuevamente",
                "icono" => "error"
            ];
        }



        # Verificando #
        $check_inventario = $this->ejecutarConsulta("SELECT * FROM stock_almacen");
        if ($check_inventario->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hay registros favor de contactar con el administrador",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        //Restar stock del almacén de origen
        $restarStockOrigen = "UPDATE stock_almacen SET stock = stock - $cantidad WHERE id_producto = $id_producto AND id_almacen = $id_almacen_origen";


        $resultadoRestar = $this->ejecutarConsulta($restarStockOrigen);
        if ($resultadoRestar->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Movimiento registrado",
                "texto" => "El movimiento de salida se registro con exito",
                "icono" => "success"
            ];
        } else {

            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar el movimiento de salida, por favor intente nuevamente",
                "icono" => "error"
            ];
        }
        //Sumar stock al almacén de destino
        $sumarStockDestino = "UPDATE stock_almacen SET stock = stock + $cantidad WHERE id_producto = $id_producto AND id_almacen = $id_almacen_destino";

        $resultadoSumar = $this->ejecutarConsulta($sumarStockDestino);
        if ($resultadoSumar->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Movimiento registrado",
                "texto" => "El movimiento de entrada se registro con exito",
                "icono" => "success"
            ];
        } else {

            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar el movimiento de entrada, por favor intente nuevamente",
                "icono" => "error"
            ];
        }


        return json_encode($alerta);

    }



 /*----------  Controlador listar  ----------*/
public function listarMovFacturaControlador($pagina, $registros, $url, $busqueda, $fechaInicio = '', $fechaFin = '', $idProveedor = '')
{
    // Limpiar variables
    $pagina = $this->limpiarCadena($pagina);
    $registros = $this->limpiarCadena($registros);
    $url = $this->limpiarCadena($url);
    $url = APP_URL . $url . "/";
    $busqueda = $this->limpiarCadena($busqueda);

    // Obtener variables de POST si existen
    $fechaInicio = !empty($_POST['fechaInicio']) ? $this->limpiarCadena($_POST['fechaInicio']) : $fechaInicio;
    $fechaFin = !empty($_POST['fechaFin']) ? $this->limpiarCadena($_POST['fechaFin']) : $fechaFin;
    $precioDolar = isset($_POST['precioDolar']) ? (float)$_POST['precioDolar'] : 0;
    $idProveedor = !empty($_POST['idProveedor']) ? $this->limpiarCadena($_POST['idProveedor']) : $idProveedor;

    $iva = 0.16;

    // Manejo de actualización de pago
    if (isset($_POST['actualizarPago']) && isset($_POST['id_factura']) && isset($_POST['pagada'])) {
        $idFactura = (int)$_POST['id_factura'];
        $pagada = (int)$_POST['pagada'];

        $actualizacion = "UPDATE facturas SET pagada = $pagada WHERE id_factura = $idFactura";
        $resultadoActualizacion = $this->ejecutarConsulta($actualizacion);

        if ($resultadoActualizacion) {
            echo "Estado de pago actualizado correctamente.";
        } else {
            echo "Error al actualizar el estado de pago.";
        }
        exit;
    }

    // Obtener lista de proveedores para el selector
    $proveedoresConsulta = "SELECT id_proveedor, nombre_proveedor FROM proveedores";
    $proveedores = $this->ejecutarConsulta($proveedoresConsulta)->fetchAll();

    // Generar el formulario de filtros
    $tabla = '
    <form method="POST" action="' . $url . '">
        <div class="row mb-3">
            <div class="col-md-2">
                <label for="fechaInicio" class="form-label">Fecha de Inicio:</label>
                <input type="date" class="form-control" name="fechaInicio" id="fechaInicio" placeholder="Fecha de Inicio" value="' . htmlspecialchars($fechaInicio) . '">
            </div>
            <div class="col-md-2">
                <label for="fechaFin" class="form-label">Fecha de Fin:</label>
                <input type="date" class="form-control" name="fechaFin" id="fechaFin" placeholder="Fecha de Fin" value="' . htmlspecialchars($fechaFin) . '">
            </div>
            <div class="col-md-2">
                <label for="precioDolar" class="form-label">Tipo de cambio del dólar:</label>
                <input type="number" step="0.01" class="form-control" name="precioDolar" id="precioDolar" placeholder="Precio del Dólar" value="' . htmlspecialchars($precioDolar) . '">
            </div>
            <div class="col-md-2">
                <label for="idProveedor" class="form-label">Proveedor:</label>
                <select class="form-control" name="idProveedor" id="idProveedor">
                    <option value="">Todos los proveedores</option>';

    foreach ($proveedores as $proveedor) {
        $tabla .= '<option value="' . $proveedor['id_proveedor'] . '"' . ($idProveedor == $proveedor['id_proveedor'] ? ' selected' : '') . '>' . htmlspecialchars($proveedor['nombre_proveedor']) . '</option>';
    }

    $tabla .= '
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <p class="form-text">Seleccione las fechas de inicio y fin para filtrar las facturas. Además, puede ajustar el tipo de cambio del dólar y filtrar por proveedor.</p>
            </div>
        </div>
    </form>';

//consulta para vencimientos y pagos de las facturas por mes:
if (!empty($fechaInicio) && !empty($fechaFin)) {
        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

       $condiciones = "(f.fecha_emision BETWEEN '$fechaInicio' AND '$fechaFin' OR f.fecha_vencimiento BETWEEN '$fechaInicio' AND '$fechaFin')";
        if (!empty($idProveedor)) {
            $condiciones .= " AND f.id_proveedor = '$idProveedor'";
        }

        $consulta_datos = "SELECT
            f.id_factura,
            f.num_factura,
            f.numero_factura,
            p.nombre_proveedor,
            p.rfc_proveedor,
            f.fecha_emision,
            f.fecha_vencimiento,
            m.nombre_moneda,
            SUM(df.precio_sin_IVA) AS precio_sin_iva,
            SUM(df.total) AS total_factura,
            f.pagada
        FROM
            facturas f
        JOIN
            detalle_factura df ON f.id_factura = df.id_factura
        JOIN
            proveedores p ON f.id_proveedor = p.id_proveedor
        JOIN
            tipos_moneda m ON f.id_moneda = m.id_moneda
        WHERE
            $condiciones
        GROUP BY
            f.id_factura, f.num_factura, f.numero_factura, p.nombre_proveedor, p.rfc_proveedor, f.fecha_emision, f.fecha_vencimiento, m.nombre_moneda, f.pagada
        ORDER BY
            f.fecha_vencimiento ASC
        LIMIT
            $inicio, $registros;";

        $consulta_total = "SELECT COUNT(DISTINCT f.id_factura)
        FROM facturas f
        JOIN detalle_factura df ON f.id_factura = df.id_factura
        JOIN proveedores p ON f.id_proveedor = p.id_proveedor
        JOIN tipos_moneda m ON f.id_moneda = m.id_moneda
        WHERE $condiciones;";

/*
 // Si se han especificado fechas de inicio y fin
if (!empty($fechaInicio) && !empty($fechaFin)) {
    $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
    $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

    // Cambiar la condición para que solo considere la fecha de emisión
    $condiciones = "(f.fecha_emision BETWEEN '$fechaInicio' AND '$fechaFin')";
    if (!empty($idProveedor)) {
        $condiciones .= " AND f.id_proveedor = '$idProveedor'";
    }

          $consulta_datos = "SELECT
        f.id_factura,
        f.num_factura,
        f.numero_factura,
        p.nombre_proveedor,
        p.rfc_proveedor,
        f.fecha_emision,
        f.fecha_vencimiento,
        m.nombre_moneda,
        SUM(df.precio_sin_IVA) AS precio_sin_iva,
        SUM(df.total) AS total_factura,
        f.pagada
    FROM
        facturas f
    JOIN
        detalle_factura df ON f.id_factura = df.id_factura
    JOIN
        proveedores p ON f.id_proveedor = p.id_proveedor
    JOIN
        tipos_moneda m ON f.id_moneda = m.id_moneda
    WHERE
        $condiciones
    GROUP BY
        f.id_factura, f.num_factura, f.numero_factura, p.nombre_proveedor, p.rfc_proveedor, f.fecha_emision, f.fecha_vencimiento, m.nombre_moneda, f.pagada
    ORDER BY
        f.fecha_emision ASC
    LIMIT
        $inicio, $registros;";

    $consulta_total = "SELECT COUNT(DISTINCT f.id_factura)
    FROM facturas f
    JOIN detalle_factura df ON f.id_factura = df.id_factura
    JOIN proveedores p ON f.id_proveedor = p.id_proveedor
    JOIN tipos_moneda m ON f.id_moneda = m.id_moneda
    WHERE $condiciones;";
*/

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int)$total->fetchColumn();
        $tablaDolares = '';
        $tablaPesos = '';
        $totalDolares = 0;
        $totalPesos = 0;
        $totalIvaDolares = 0;
        $totalIvaPesos = 0;
        $subtotalPagadas = 0;
        $totalIvaPagadas = 0;
        $totalPagadas = 0;
        $subtotalNoPagadas = 0;
        $totalIvaNoPagadas = 0;
        $totalNoPagadas = 0;

        foreach ($datos as $rows) {
            $totalIva = $rows['precio_sin_iva'] * $iva;
            $totalConIva = $rows['precio_sin_iva'] + $totalIva;
            $fechaEmisionFormateada = date('d/m/Y', strtotime($rows['fecha_emision']));
            $fechaVencimientoFormateada = date('d/m/Y', strtotime($rows['fecha_vencimiento']));
            $pagada = $rows['pagada'] ? 'checked' : '';

            $fila = '
            <tr>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['num_factura'] . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['numero_factura'] . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['nombre_proveedor'] . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['rfc_proveedor'] . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($fechaEmisionFormateada) . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($fechaVencimientoFormateada) . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($rows['precio_sin_iva'], 2)) . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($totalIva, 2)) . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($totalConIva, 2)) . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;"><input type="checkbox" onchange="actualizarEstadoPago(' . $rows['id_factura'] . ', this.checked)" ' . $pagada . '></td>
            </tr>';

            if (strtolower($rows['nombre_moneda']) == 'dólares' || strtolower($rows['nombre_moneda']) == 'dolares' || strtolower($rows['nombre_moneda']) == 'usd') {
                $tablaDolares .= $fila;
                $totalDolares += $rows['precio_sin_iva'];
                $totalIvaDolares += $totalIva;
            } else {
                $tablaPesos .= $fila;
                $totalPesos += $rows['precio_sin_iva'];
                $totalIvaPesos += $totalIva;
            }

            if ($rows['pagada']) {
                $subtotalPagadas += (strtolower($rows['nombre_moneda']) == 'dólares' || strtolower($rows['nombre_moneda']) == 'dolares' || strtolower($rows['nombre_moneda']) == 'usd') ? $rows['precio_sin_iva'] * $precioDolar : $rows['precio_sin_iva'];
                $totalIvaPagadas += (strtolower($rows['nombre_moneda']) == 'dólares' || strtolower($rows['nombre_moneda']) == 'dolares' || strtolower($rows['nombre_moneda']) == 'usd') ? $totalIva * $precioDolar : $totalIva;
                $totalPagadas += (strtolower($rows['nombre_moneda']) == 'dólares' || strtolower($rows['nombre_moneda']) == 'usd') ? $totalConIva * $precioDolar : $totalConIva;
            } else {
                $subtotalNoPagadas += (strtolower($rows['nombre_moneda']) == 'dólares' || strtolower($rows['nombre_moneda']) == 'dolares' || strtolower($rows['nombre_moneda']) == 'usd') ? $rows['precio_sin_iva'] * $precioDolar : $rows['precio_sin_iva'];
                $totalIvaNoPagadas += (strtolower($rows['nombre_moneda']) == 'dólares' || strtolower($rows['nombre_moneda']) == 'dolares' || strtolower($rows['nombre_moneda']) == 'usd') ? $totalIva * $precioDolar : $totalIva;
                $totalNoPagadas += (strtolower($rows['nombre_moneda']) == 'dólares' || strtolower($rows['nombre_moneda']) == 'usd') ? $totalConIva * $precioDolar : $totalConIva;
            }
        }

        $totalGeneral = $totalPesos + ($totalDolares * $precioDolar);
        $totalIvaGeneral = $totalIvaPesos + ($totalIvaDolares * $precioDolar);
        $totalDolaresEnPesos = $totalDolares * $precioDolar;

        $tabla .= '
        <button class="btn btn-primary mb-3" onclick="imprimirArea(\'areaImprimir\')">Imprimir</button>
        <div id="areaImprimir">
        <div class="invoice">
            <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding: 5px;">
                <p style="font-size: 16px; text-align: center;"><strong>Reporte de Facturas por Fecha</strong></p>
                <p style="font-size: 14px; text-align: center;"><strong>Desde ' . htmlspecialchars($fechaInicio) . ' hasta ' . htmlspecialchars($fechaFin) . '</strong></p>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <img src="' . APP_URL . 'app/views/fotos/logo_orden.png" alt="logo" style="width:200px; height:auto;">
                    <div>
                        <p style="font-size: 13px;"><strong>Formato:</strong> PR-12-F10</p>
                    </div>
                </div>
                <p style="margin-top: 0; margin-bottom: 0; text-align: left;">RADIOTECNOLOGÍA INDUSTRIAL S.A. DE C.V.</p>
                <p style="margin-top: 0; margin-bottom: 0; text-align: left;">RFC: RIN070219R38</p>
                <p style="margin-top: 0; margin-bottom: 0; text-align: left;">Calle Puebla Sur. Manzana 4. Lote 5 Nave B Int. 2 Col. Jardín Industrial</p>
                <p style="margin-top: 0; margin-bottom: 0; text-align: left;">Ixtapaluca. Edo. de México, C.P. 56535</p>
            </div>

            <div class="table-responsive">
                <h3>Facturas en Pesos</h3>
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Registro de Factura</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Num Factura</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Proveedor</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">RFC</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Fecha de Emisión</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Fecha de Vencimiento</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Subtotal</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">IVA</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Total con IVA</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Pagada</th>
                        </tr>
                    </thead>
                    <tbody>' . $tablaPesos . '
                    <tr>
                        <td colspan="6" style="text-align: center; border: 1px solid #000; padding: 5px;" class="text-end"><strong>Totales:</strong></td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;"><strong>' . htmlspecialchars(number_format($totalPesos, 2)) . '</strong></td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;"><strong>' . htmlspecialchars(number_format($totalIvaPesos, 2)) . '</strong></td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;"><strong>' . htmlspecialchars(number_format($totalPesos + $totalIvaPesos, 2)) . '</strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-responsive">
                <h3>Facturas en Dólares</h3>
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Registro de Factura</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Num Factura</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Proveedor</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">RFC</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Fecha de Emisión</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Fecha de Vencimiento</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Subtotal</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">IVA</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Total con IVA</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Pagada</th>
                        </tr>
                    </thead>
                    <tbody>' . $tablaDolares . '
                    <tr>
                        <td colspan="6" style="text-align: center; border: 1px solid #000; padding: 5px;" class="text-end"><strong>Total:</strong></td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;"><strong>' . htmlspecialchars(number_format($totalDolares, 2)) . '</strong></td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;"><strong>' . htmlspecialchars(number_format($totalIvaDolares, 2)) . '</strong></td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;"><strong>' . htmlspecialchars(number_format($totalDolares + $totalIvaDolares, 2)) . '</strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-responsive">
                <h3>Total General en Pesos</h3>
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Subtotal Pesos</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">IVA Pesos</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Subtotal Dólares en Pesos</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">IVA Dólares en Pesos</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Subtotal General</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">IVA de ambos</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Total con IVA ambos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;"><strong>' . htmlspecialchars(number_format($totalPesos, 2)) . '</strong></td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;"><strong>' . htmlspecialchars(number_format($totalIvaPesos, 2)) . '</strong></td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;"><strong>' . htmlspecialchars(number_format($totalDolaresEnPesos, 2)) . '</strong></td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;"><strong>' . htmlspecialchars(number_format($totalIvaDolares * $precioDolar, 2)) . '</strong></td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;"><strong>' . htmlspecialchars(number_format($totalPesos + $totalDolaresEnPesos, 2)) . '</strong></td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;"><strong>' . htmlspecialchars(number_format($totalIvaGeneral, 2)) . '</strong></td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;"><strong>' . htmlspecialchars(number_format($totalGeneral + $totalIvaGeneral, 2)) . '</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-responsive">
                <h3>Resumen de Facturas Pagadas y No Pagadas</h3>
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Estado</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Subtotal</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">IVA</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;">Pagadas</td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($subtotalPagadas, 2)) . '</td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($totalIvaPagadas, 2)) . '</td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($totalPagadas, 2)) . '</td>
                        </tr>
                        <tr>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;">No Pagadas</td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($subtotalNoPagadas, 2)) . '</td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($totalIvaNoPagadas, 2)) . '</td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars(number_format($totalNoPagadas, 2)) . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>';

        $tabla .= '
        <script>
        function actualizarEstadoPago(idFactura, pagada) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "' . $url . '", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                }
            };
            xhr.send("actualizarPago=true&id_factura=" + idFactura + "&pagada=" + (pagada ? 1 : 0));
        }

        function imprimirArea(id) {
            var contenido = document.getElementById(id).innerHTML;
            var ventanaImpresion = window.open("", "_blank");
            ventanaImpresion.document.write("<html><head><title>Reporte de Facturas Desde ' . htmlspecialchars($fechaInicio) . ' hasta ' . htmlspecialchars($fechaFin) . '</title>");
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
    }

    return $tabla;
}



public function listarMovFacturaReportControlador($pagina, $registros, $url) {
    $url = APP_URL . $this->limpiarCadena($url) . "/";
    
    $anioSeleccionado = isset($_POST['anio']) ? $this->limpiarCadena($_POST['anio']) : date('Y');
    $precioDolar = isset($_POST['precioDolar']) ? (float)$_POST['precioDolar'] : 0;
    $iva = 0.16;

    $consulta_datos = "SELECT 
        p.nombre_proveedor,
        MONTH(f.fecha_emision) AS mes,
        m.nombre_moneda,
        SUM(df.precio_sin_IVA) AS total_sin_iva
    FROM 
        facturas f
    JOIN 
        detalle_factura df ON f.id_factura = df.id_factura
    JOIN 
        proveedores p ON f.id_proveedor = p.id_proveedor
    JOIN 
        tipos_moneda m ON f.id_moneda = m.id_moneda
    WHERE 
        YEAR(f.fecha_emision) = '$anioSeleccionado'
    GROUP BY 
        p.nombre_proveedor, 
        MONTH(f.fecha_emision),
        m.nombre_moneda
    ORDER BY 
        mes, p.nombre_proveedor";

    $datos = $this->ejecutarConsulta($consulta_datos);
    $resultados = $datos->fetchAll();

    $datosPorMes = [];
    $mesesNombres = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];

    $totalAnualPorProveedor = [];
    $totalAnual = 0;

    foreach ($resultados as $fila) {
        $mes = $fila['mes'];
        $proveedor = $fila['nombre_proveedor'];
        $moneda = strtolower($fila['nombre_moneda']);
        
        if ($moneda === 'dólares' || $moneda === 'dolares' || $moneda === 'usd') {
            $total = $fila['total_sin_iva'] * $precioDolar;
            $monedaFinal = 'USD';
        } elseif ($moneda === 'pesos' || $moneda === 'mxn') {
            $total = $fila['total_sin_iva'];
            $monedaFinal = 'MXN';
        } else {
            $total = $fila['total_sin_iva'];
            $monedaFinal = 'Otra';
        }

        if (!isset($datosPorMes[$mes])) {
            $datosPorMes[$mes] = [];
        }

        if (!isset($datosPorMes[$mes][$proveedor])) {
            $datosPorMes[$mes][$proveedor] = [
                'total' => 0,
                'moneda' => $monedaFinal
            ];
        }
        $datosPorMes[$mes][$proveedor]['total'] += $total;

        if (!isset($totalAnualPorProveedor[$proveedor])) {
            $totalAnualPorProveedor[$proveedor] = 0;
        }
        $totalAnualPorProveedor[$proveedor] += $total;
    }

    $tabla = '
    <form method="POST" action="' . $url . '">
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="anio" class="form-label">Año:</label>
                <select class="form-control" name="anio" id="anio">';
    
    $anioActual = date('Y');
    for ($i = $anioActual; $i >= $anioActual - 4; $i--) {
        $selected = ($i == $anioSeleccionado) ? 'selected' : '';
        $tabla .= "<option value='$i' $selected>$i</option>";
    }
    
    $tabla .= '
                </select>
            </div>
            <div class="col-md-3">
                <label for="precioDolar" class="form-label">Tipo de cambio del dólar:</label>
                <input type="number" step="0.01" class="form-control" name="precioDolar" id="precioDolar" placeholder="Precio del Dólar" value="' . htmlspecialchars($precioDolar) . '">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>
    <button class="btn btn-primary mb-3" onclick="imprimirArea(\'areaImprimir\')">Imprimir</button>
    <div id="areaImprimir">
    <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding: 5px;">
        <p style="font-size: 16px; text-align: center;"><strong>Reporte de Gastos por Proveedor</strong></p>
        <p style="font-size: 14px; text-align: center;"><strong>Año ' . htmlspecialchars($anioSeleccionado) . '</strong></p>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <img src="' . APP_URL . 'app/views/fotos/logo_orden.png" alt="logo" style="width:200px; height:auto;">
            <div>
                <p style="font-size: 13px;"><strong>Formato:</strong> PR-12-F11</p>
            </div>
        </div>
    </div>';

    $totalAnual = 0;
    foreach ($mesesNombres as $numMes => $nombreMes) {
        if (isset($datosPorMes[$numMes]) && !empty($datosPorMes[$numMes])) {
            $tabla .= '<div class="table-responsive mt-3">';
            $tabla .= '<h3>' . $nombreMes . '</h3>';
            $tabla .= '<table class="table table-striped table-bordered">';
            $tabla .= '<thead class="table-dark">';
            $tabla .= '<tr><th>Proveedor</th><th>Total (MXN)</th><th>Moneda Original</th></tr>';
            $tabla .= '</thead><tbody>';
            
            $totalMes = 0;
            foreach ($datosPorMes[$numMes] as $proveedor => $datos) {
                $tabla .= '<tr>';
                $tabla .= '<td>' . htmlspecialchars($proveedor) . '</td>';
                $tabla .= '<td>$' . number_format($datos['total'], 2) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($datos['moneda']) . '</td>';
                $tabla .= '</tr>';
                
                $totalMes += $datos['total'];
            }
            
            $tabla .= '<tr class="table-active">';
            $tabla .= '<td><strong>Total ' . $nombreMes . '</strong></td>';
            $tabla .= '<td><strong>$' . number_format($totalMes, 2) . '</strong></td>';
            $tabla .= '<td><strong>MXN</strong></td>';
            $tabla .= '</tr>';
            
            $tabla .= '</tbody></table>';
            $tabla .= '</div>';
            
            $totalAnual += $totalMes;
        }
    }

    $tabla .= '<div class="table-responsive mt-3">';
    $tabla .= '<h3>Totales Anuales por Proveedor</h3>';
    $tabla .= '<table class="table table-striped table-bordered">';
    $tabla .= '<thead class="table-dark">';
    $tabla .= '<tr><th>Proveedor</th><th>Total Anual (MXN)</th></tr>';
    $tabla .= '</thead><tbody>';
    
    arsort($totalAnualPorProveedor);

    foreach ($totalAnualPorProveedor as $proveedor => $total) {
        $tabla .= '<tr>';
        $tabla .= '<td>' . htmlspecialchars($proveedor) . '</td>';
        $tabla .= '<td>$' . number_format($total, 2) . '</td>';
        $tabla .= '</tr>';
    }
    
    $tabla .= '<tr class="table-active">';
    $tabla .= '<td><strong>Total General</strong></td>';
    $tabla .= '<td><strong>$' . number_format($totalAnual, 2) . '</strong></td>';
    $tabla .= '</tr>';
    
    $tabla .= '</tbody></table>';
    $tabla .= '</div>';

    // Agregar el contenedor y scripts para la gráfica
    $tabla .= '<div class="mt-4">
        <canvas id="grafica" style="width: 100%; height: 400px;"></canvas>
    </div>';



// Obtener lista única de proveedores
$proveedoresUnicos = [];
foreach ($datosPorMes as $mes => $proveedores) {
    foreach ($proveedores as $proveedor => $datos) {
        if (!in_array($proveedor, $proveedoresUnicos)) {
            $proveedoresUnicos[] = $proveedor;
        }
    }
}
sort($proveedoresUnicos);

// Crear tabla con el nuevo formato
$tabla .= '<div class="table-responsive mt-3">';
$tabla .= '<h3>Resumen Anual de Gastos por Proveedor</h3>';
$tabla .= '<table class="table table-striped table-bordered">';
$tabla .= '<thead class="table-dark">';
$tabla .= '<tr><th>Mes</th>';

// Encabezados con nombres de proveedores
foreach ($proveedoresUnicos as $proveedor) {
    $tabla .= '<th>' . htmlspecialchars($proveedor) . '</th>';
}
$tabla .= '<th>Total Mensual</th></tr>';
$tabla .= '</thead><tbody>';

// Filas para cada mes
$totalesPorProveedor = array_fill_keys($proveedoresUnicos, 0);

foreach ($mesesNombres as $numMes => $nombreMes) {
    $tabla .= '<tr>';
    $tabla .= '<td>' . $nombreMes . '</td>';
    
    $totalMes = 0;
    foreach ($proveedoresUnicos as $proveedor) {
        $gasto = isset($datosPorMes[$numMes][$proveedor]) ? 
                 $datosPorMes[$numMes][$proveedor]['total'] : 
                 'Sin gasto';
                 
        if ($gasto !== 'Sin gasto') {
            $totalMes += $gasto;
            $totalesPorProveedor[$proveedor] += $gasto;
            $tabla .= '<td>$' . number_format($gasto, 2) . '</td>';
        } else {
            $tabla .= '<td>' . $gasto . '</td>';
        }
    }
    
    $tabla .= '<td><strong>$' . number_format($totalMes, 2) . '</strong></td>';
    $tabla .= '</tr>';
}

// Fila de totales
$tabla .= '<tr class="table-active">';
$tabla .= '<td><strong>Total por Proveedor</strong></td>';

$granTotal = 0;
foreach ($proveedoresUnicos as $proveedor) {
    $total = $totalesPorProveedor[$proveedor];
    $granTotal += $total;
    $tabla .= '<td><strong>$' . number_format($total, 2) . '</strong></td>';
}

$tabla .= '<td><strong>$' . number_format($granTotal, 2) . '</strong></td>';
$tabla .= '</tr>';

$tabla .= '</tbody></table>';
$tabla .= '</div>';






    $tabla .= '</div>'; // Cierre de areaImprimir

    // Convertir datos para la gráfica
    $chartData = json_encode($datosPorMes);
    $proveedoresData = json_encode($totalAnualPorProveedor);
    $mesesNombresData = json_encode($mesesNombres);

    // Scripts necesarios
    $tabla .= '
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
    function imprimirArea(id) {
        var contenido = document.getElementById(id).innerHTML;
        var ventanaImpresion = window.open("", "_blank");
        ventanaImpresion.document.write("<html><head><title>Reporte de Gastos Año ' . htmlspecialchars($anioSeleccionado) . '</title>");
        ventanaImpresion.document.write("<style>");
        ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
        ventanaImpresion.document.write("table { width: 100%; border-collapse: collapse; }");
        ventanaImpresion.document.write("table, th, td { border: 1px solid black; padding: 5px; }");
        ventanaImpresion.document.write("</style>");
        ventanaImpresion.document.write("</head><body>");
        ventanaImpresion.document.write(contenido);
        ventanaImpresion.document.write("</body></html>");
        ventanaImpresion.document.close();
        ventanaImpresion.print();
    }

    // Crear la gráfica
    const datos = ' . $chartData . ';
    const mesesNombres = ' . $mesesNombresData . ';
    const proveedores = ' . $proveedoresData . ';

    const ctx = document.getElementById("grafica").getContext("2d");
    const datasets = Object.keys(proveedores).map((proveedor, index) => ({
        label: proveedor,
        data: Object.keys(mesesNombres).map(mes => 
            datos[mes]?.[proveedor]?.total || 0
        ),
        backgroundColor: `hsl(${index * (360 / Object.keys(proveedores).length)}, 70%, 50%)`
    }));

    new Chart(ctx, {
        type: "bar",  
        data: {
            labels: Object.values(mesesNombres),
            datasets: datasets
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    stacked: false,  // Cambié a false para separar las barras
                    ticks: {
                        maxRotation: 45  // Rotar etiquetas para mejor lectura
                    }
                },
                y: { 
                    stacked: false,  // Cambié a false para separar las barras
                    ticks: {
                        callback: value => `$${(value/1000).toLocaleString()}k`
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: context => `${context.dataset.label}: $${context.raw.toLocaleString()}`
                    }
                }
            },
            barPercentage: 0.8,  // Ajusta el ancho de las barras
            categoryPercentage: 0.9  // Ajusta el espacio entre grupos de barras
        }
    });
    </script>';

    return $tabla;
}






}