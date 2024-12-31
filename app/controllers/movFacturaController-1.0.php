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
 public function listarMovFacturaControlador($pagina, $registros, $url, $busqueda, $fechaInicio = '', $fechaFin = '') {
    $pagina = $this->limpiarCadena($pagina);
    $registros = $this->limpiarCadena($registros);
    $url = $this->limpiarCadena($url);
    $url = APP_URL . $url . "/";

    $busqueda = $this->limpiarCadena($busqueda);
    $fechaInicio = isset($_POST['fechaInicio']) ? $this->limpiarCadena($_POST['fechaInicio']) : '';
    $fechaFin = isset($_POST['fechaFin']) ? $this->limpiarCadena($_POST['fechaFin']) : '';
    $precioDolar = isset($_POST['precioDolar']) ? (float)$_POST['precioDolar'] : 0;

    $iva = 0.16;

    // Verificar si hay una solicitud POST para actualizar el estado de pago
    if (isset($_POST['id_factura']) && isset($_POST['pagada'])) {
        $idFactura = $this->limpiarCadena($_POST['id_factura']);
        $pagada = $this->limpiarCadena($_POST['pagada']) ? 1 : 0;

        $actualizarPago = "UPDATE facturas SET pagada = $pagada WHERE id_factura = $idFactura";
        $resultadoActualizacion = $this->ejecutarConsulta($actualizarPago);

        if ($resultadoActualizacion) {
            echo '<script>alert("Estado de pago actualizado correctamente");</script>';
        } else {
            echo '<script>alert("Error al actualizar el estado de pago");</script>';
        }
    }

    $tabla = '
    <form method="POST" action="' . $url . '">
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="fechaInicio" class="form-label">Fecha de Inicio:</label>
                <input type="date" class="form-control" name="fechaInicio" id="fechaInicio" placeholder="Fecha de Inicio" value="' . htmlspecialchars($fechaInicio) . '">
            </div>
            <div class="col-md-3">
                <label for="fechaFin" class="form-label">Fecha de Fin:</label>
                <input type="date" class="form-control" name="fechaFin" id="fechaFin" placeholder="Fecha de Fin" value="' . htmlspecialchars($fechaFin) . '">
            </div>
            <div class="col-md-3">
                <label for="precioDolar" class="form-label">Tipo de cambio del dólar:</label>
                <input type="number" step="0.01" class="form-control" name="precioDolar" id="precioDolar" placeholder="Precio del Dólar" value="' . htmlspecialchars($precioDolar) . '">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <p class="form-text">Seleccione las fechas de inicio y fin para filtrar las facturas. Además, puede ajustar el tipo de cambio del dólar.</p>
            </div>
        </div>
    </form>';

    if (!empty($fechaInicio) && !empty($fechaFin)) {
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        $consulta_datos = "SELECT
            f.id_factura,
            f.num_factura,
            f.numero_factura,
            p.nombre_proveedor,
            p.rfc_proveedor,
            f.fecha_emision,
            f.fecha_vencimiento,
            m.nombre_moneda,
            f.pagada,
            SUM(df.precio_sin_IVA) AS precio_sin_iva,
            SUM(df.total) AS total_factura
        FROM
            facturas f
        JOIN
            detalle_factura df ON f.id_factura = df.id_factura
        JOIN
            proveedores p ON f.id_proveedor = p.id_proveedor
        JOIN
            tipos_moneda m ON f.id_moneda = m.id_moneda
        WHERE
            f.fecha_emision BETWEEN '$fechaInicio' AND '$fechaFin'
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
        WHERE f.fecha_emision BETWEEN '$fechaInicio' AND '$fechaFin';";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int) $total->fetchColumn();

        $tablaDolares = '';
        $tablaPesos = '';
        $totalDolares = 0;
        $totalPesos = 0;
        $totalIvaDolares = 0;
        $totalIvaPesos = 0;

        foreach ($datos as $rows) {
            $totalIva = $rows['precio_sin_iva'] * $iva;
            $totalConIva = $rows['precio_sin_iva'] + $totalIva;
            $fechaEmisionFormateada = date('d/m/Y', strtotime($rows['fecha_emision']));
            $fechaVencimientoFormateada = date('d/m/Y', strtotime($rows['fecha_vencimiento']));
            $pagada = $rows['pagada'] == 1 ? 'checked' : '';
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
                    <td style="text-align: center; border: 1px solid #000; padding: 5px;">
                        <input type="checkbox" ' . $pagada . ' onchange="actualizarEstadoPago(' . $rows['id_factura'] . ', this.checked)">
                    </td>
                </tr>
            ';

            if (strtolower($rows['nombre_moneda']) == 'dólares' || strtolower($rows['nombre_moneda']) == 'dolares' || strtolower($rows['nombre_moneda']) == 'usd') {
                $tablaDolares .= $fila;
                $totalDolares += $rows['precio_sin_iva'];
                $totalIvaDolares += $totalIva;
            } else {
                $tablaPesos .= $fila;
                $totalPesos += $rows['precio_sin_iva'];
                $totalIvaPesos += $totalIva;
            }
        }

        $tabla .= '
        <button class="btn btn-primary mb-3" onclick="imprimirArea(\'areaImprimir\')">Imprimir</button>
        <div id="areaImprimir">';

        $tabla .= '
        <div class="invoice">
            <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding: 5px;">
                <p style="font-size: 16px; text-align: center;"><strong>Reporte de Facturas por Fecha</strong></p>
                <p style="font-size: 14px; text-align: center;"><strong>Desde ' . htmlspecialchars($fechaInicio) . ' hasta ' . htmlspecialchars($fechaFin) . '</strong></p>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <img src="' . APP_URL . 'app/views/fotos/logo_orden.png" alt="logo" style="width:200px; height:auto;">
                    <div>
                        <p style="font-size: 13px;"><strong>Formato:</strong>  PR-12-F10</p>
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
                    <thead>
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
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>';

        $tabla .= '
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
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>';

        $totalGeneral = $totalPesos + ($totalDolares * $precioDolar);
        $totalIvaGeneral = $totalIvaPesos + ($totalIvaDolares * $precioDolar);
        $totalDolaresEnPesos = $totalDolares * $precioDolar;

        $tabla .= '
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
        </div>';

        $tabla .= '
        <script>
            function imprimirArea(id) {
                var contenido = document.getElementById(id).innerHTML;
                var ventanaImpresion = window.open("", "_blank");
                ventanaImpresion.document.write("<html><head><title>Reporte de Facturas Desde ' . htmlspecialchars($fechaInicio) . ' hasta ' . htmlspecialchars($fechaFin) . '</title>");
                
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

            function actualizarEstadoPago(idFactura, estadoPago) {
                var formData = new FormData();
                formData.append("id_factura", idFactura);
                formData.append("pagada", estadoPago ? 1 : 0);

                fetch("", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    if (data.includes("Estado de pago actualizado correctamente")) {
                        alert("Estado de pago actualizado correctamente");
                    } else {
                        alert("Error al actualizar el estado de pago");
                    }
                })
                .catch(error => {
                    console.error("Error al actualizar el estado de pago:", error);
                });
            }
        </script>';
    }

    return $tabla;
}








}