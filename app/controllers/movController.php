<?php

namespace app\controllers;

use app\models\mainModel;

class movController extends mainModel
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
 public function listarMovControlador($pagina, $registros, $url, $busqueda, $fechaInicio = '', $fechaFin = '')
{
    $pagina = $this->limpiarCadena($pagina);
    $registros = $this->limpiarCadena($registros);
    $url = $this->limpiarCadena($url);
    $url = APP_URL . $url . "/";

    $busqueda = $this->limpiarCadena($busqueda);
    $fechaInicio = isset($_POST['fechaInicio']) ? $this->limpiarCadena($_POST['fechaInicio']) : '';
    $fechaFin = isset($_POST['fechaFin']) ? $this->limpiarCadena($_POST['fechaFin']) : '';

    $tabla = '
    <div class="container-fluid">
        <div class="row">
            <!-- Menú lateral -->
            <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'movList/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Movimientos
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'movSearch/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Por Nombre
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'movSearch2/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Por Movimiento
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contenido principal -->
            <div class="col-12 col-md-9 col-lg-10">
                <div class="container-fluid mb-4">
                    <h4 class="text-center">Movimientos</h4>
                    <h5 class="lead text-center">Lista de movimientos entre almacenes por fecha</h5>
                </div>
                
                <!-- Formulario de filtro por fechas -->
                <form method="POST" action="' . $url . '" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="fechaInicio" placeholder="Fecha Inicio" value="' . htmlspecialchars($fechaInicio) . '">
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="fechaFin" placeholder="Fecha Fin" value="' . htmlspecialchars($fechaFin) . '">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </div>
                    </div>
                </form>';

    if (!empty($fechaInicio) && !empty($fechaFin)) {
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        $consulta_datos = "SELECT
            movimientos.id_movimiento,
            productos.nombre_producto,
            productos.codigo_producto,
            origen.nombre_almacen AS nombre_almacen_origen,
            destino.nombre_almacen AS nombre_almacen_destino,
            empleados.nombre_empleado,
            empleados.id_empleado,
            movimientos.cantidad,
            movimientos.nota_movimiento,
            movimientos.fecha_movimiento
        FROM
            movimientos
        JOIN
            productos ON movimientos.id_producto = productos.id_producto
        JOIN
            almacenes AS origen ON movimientos.id_almacen_origen = origen.id_almacen
        JOIN
            almacenes AS destino ON movimientos.id_almacen_destino = destino.id_almacen
        JOIN
            empleados ON movimientos.id_empleado = empleados.id_empleado
        WHERE
            movimientos.fecha_movimiento BETWEEN '$fechaInicio' AND '$fechaFin'
        GROUP BY
            movimientos.id_movimiento
        ORDER BY
            movimientos.id_movimiento DESC
        LIMIT
            $inicio, $registros;";

        $consulta_total = "SELECT COUNT(DISTINCT movimientos.id_movimiento)
        FROM movimientos
        JOIN productos ON movimientos.id_producto = productos.id_producto
        JOIN almacenes AS origen ON movimientos.id_almacen_origen = origen.id_almacen
        JOIN almacenes AS destino ON movimientos.id_almacen_destino = destino.id_almacen
        JOIN empleados ON movimientos.id_empleado = empleados.id_empleado
        WHERE movimientos.fecha_movimiento BETWEEN '$fechaInicio' AND '$fechaFin';";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int) $total->fetchColumn();

        $tabla .= '
        <button class="btn btn-primary mb-3" onclick="imprimirArea(\'areaImprimir\')">Imprimir</button>
        <div id="areaImprimir" style="font-size: 13px;">
            <div class="container-fluid">
                <div class="invoice">
                    <div style="margin-top: 1px; border: 1px solid #000; padding: 5px;">
                        <p style="font-size: 14px; text-align: center;"><strong>Reporte de Movimientos de Almacén <br> Desde ' . htmlspecialchars($fechaInicio) . ' hasta ' . htmlspecialchars($fechaFin) . '</strong></p>
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <img src="' . APP_URL . 'app/views/fotos/logo_orden.png" alt="logo" style="width:200px; height:auto;">
                            <div>
                                <p style="font-size: 13px;"><strong>Formato:</strong>MA-12-F016</p>
                            </div>
                        </div>
                        <p style="margin-top: 0; margin-bottom: 0; text-align: left;">RADIOTECNOLOGÍA INDUSTRIAL S.A. DE C.V.</p>
                        <p style="margin-top: 0; margin-bottom: 0; text-align: left;">RFC: RIN070219R38</p>
                        <p style="margin-top: 0; margin-bottom: 0; text-align: left;">Calle Puebla Sur. Manzana 4. Lote 5 Nave B Int. 2 Col. Jardín Industrial</p>
                        <p style="margin-top: 0; margin-bottom: 0; text-align: left;">Ixtapaluca. Edo. de México, C.P. 56535</p>
                    </div>

                    <table class="table" style="width: 100%; padding-top: 10px; font-size: 13px;">
                        <thead>
                            <tr>
                                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Código Producto</th>
                                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Artículo</th>
                                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Almacén origen</th>
                                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Almacén destino</th>
                                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Cantidad</th>
                                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Nombre Empleado</th>
                                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($total >= 1) {
            foreach ($datos as $rows) {
                $fechaFormateada = date('d/m/Y', strtotime($rows['fecha_movimiento']));
                $tabla .= '
                    <tr>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['codigo_producto']) . '</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['nombre_producto']) . '</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['nombre_almacen_origen']) . '</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['nombre_almacen_destino']) . '</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['cantidad']) . '</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['nombre_empleado']) . '</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($fechaFormateada) . '</td>
                    </tr>';
            }
        } else {
            $tabla .= '<tr><td colspan="7" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
        }

        $tabla .= '
                        </tbody>
                    </table>
                </div>
            </div>
        </div>';

        $tabla .= '
        <script>
        function imprimirArea(id) {
            var contenido = document.getElementById(id).innerHTML;
            var ventanaImpresion = window.open("", "_blank");
            ventanaImpresion.document.write("<html><head><title> </title>");
            
            // Estilos CSS
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

    $tabla .= '</div></div></div>'; // Cierra el contenido principal

    return $tabla;
}
 

/*----------  Controlador listar  ----------*/
public function listarMovControladorEmpleado($pagina, $registros, $url, $busqueda, $fechaInicio = '', $fechaFin = '', $id_empleado = '')
{
    $pagina = $this->limpiarCadena($pagina);
    $registros = $this->limpiarCadena($registros);
    $url = $this->limpiarCadena($url);
    $url = APP_URL . $url . "/";

    $busqueda = $this->limpiarCadena($busqueda);
    $fechaInicio = isset($_POST['fechaInicio']) ? $this->limpiarCadena($_POST['fechaInicio']) : '';
    $fechaFin = isset($_POST['fechaFin']) ? $this->limpiarCadena($_POST['fechaFin']) : '';
    $id_empleado = isset($_POST['id_empleado']) ? $this->limpiarCadena($_POST['id_empleado']) : '';

    $tabla = '
    <div class="container-fluid">
        <div class="row">
            <!-- Menú lateral -->
            <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'movList/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Movimientos
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'movSearch/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Por Nombre
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'movSearch2/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Por Movimiento
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contenido principal -->
            <div class="col-12 col-md-9 col-lg-10">
                <!-- El contenido original comienza aquí -->
                <div class="container-fluid mb-4">
                    <h4 class="text-center">Movimientos</h4>
                    <h5 class="lead text-center">Lista de movimientos entre almacenes por empleados</h5>
                </div>
                <form method="POST" action="' . $url . '">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="fechaInicio" placeholder="Fecha Inicio" value="' . htmlspecialchars($fechaInicio) . '">
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="fechaFin" placeholder="Fecha Fin" value="' . htmlspecialchars($fechaFin) . '">
                        </div>';

    // Consulta para obtener la lista de empleados
    $consulta_empleados = "SELECT * FROM empleados ORDER BY nombre_empleado";
    $datos_empleados = $this->ejecutarConsulta($consulta_empleados);
    $opciones_empleados = "";

    while ($empleados = $datos_empleados->fetch()) {
        $selected = ($empleados['id_empleado'] == $id_empleado) ? 'selected' : '';
        $opciones_empleados .= '<option value="' . $empleados['id_empleado'] . '" ' . $selected . '>'
                             . htmlspecialchars($empleados['nombre_empleado']) . '</option>';
    }

    // Continuación del formulario en la cadena $tabla
    $tabla .= '
                        <div class="col-md-4">
                            <select class="form-control" name="id_empleado" required>
                                <option value="">Seleccione Empleado</option>
                                ' . $opciones_empleados . '
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </div>
                    </div>
                </form>';

    // El resto del código permanece exactamente igual
    if (!empty($fechaInicio) && !empty($fechaFin)) {
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        // Condiciones para la consulta SQL
        $condiciones = "movimientos.fecha_movimiento BETWEEN '$fechaInicio' AND '$fechaFin'";
        if (!empty($id_empleado)) {
            $condiciones .= " AND empleados.id_empleado = $id_empleado";
        }

        $consulta_datos = "SELECT
            movimientos.id_movimiento,
            productos.nombre_producto,
            productos.codigo_producto,
            origen.nombre_almacen AS nombre_almacen_origen,
            destino.nombre_almacen AS nombre_almacen_destino,
            empleados.nombre_empleado,
            empleados.id_empleado,
            movimientos.cantidad,
            movimientos.nota_movimiento,
            movimientos.fecha_movimiento
        FROM
            movimientos
        JOIN
            productos ON movimientos.id_producto = productos.id_producto
        JOIN
            almacenes AS origen ON movimientos.id_almacen_origen = origen.id_almacen
        JOIN
            almacenes AS destino ON movimientos.id_almacen_destino = destino.id_almacen
        JOIN
            empleados ON movimientos.id_empleado = empleados.id_empleado
        WHERE
            $condiciones
        GROUP BY
            movimientos.id_movimiento
        ORDER BY
            movimientos.id_movimiento DESC
        LIMIT
            $inicio, $registros;";

        $consulta_total = "SELECT COUNT(DISTINCT movimientos.id_movimiento)
        FROM movimientos
        JOIN productos ON movimientos.id_producto = productos.id_producto
        JOIN almacenes AS origen ON movimientos.id_almacen_origen = origen.id_almacen
        JOIN almacenes AS destino ON movimientos.id_almacen_destino = destino.id_almacen
        JOIN empleados ON movimientos.id_empleado = empleados.id_empleado
        WHERE
            $condiciones;";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int) $total->fetchColumn();

        $tabla .= '
<button class="btn btn-primary mb-3" onclick="imprimirArea(\'areaImprimir\')">Imprimir</button>
<div id="areaImprimir">

<div class="container-fluid"><div class="invoice">
                 <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding: 5px;">
                 <p style="font-size: 14px; text-align: center;"><strong>Consulta de Movimientos Por Fecha y Empleado
<br> Desde ' . htmlspecialchars($fechaInicio) . ' hasta ' . htmlspecialchars($fechaFin) . '</strong></p>
                 <div style="display: flex; align-items: center; justify-content: space-between;">
                     <img src="' . APP_URL . 'app/views/fotos/logo_orden.png" alt="logo" style="width:200px; height:auto;">
                     <div>
                         <p style="font-size: 13px;"><strong>Formato: </strong>  MA-12-F016</p> 
                         <p style="font-size: 13px;"><strong>Empleado: </strong>'.$datos[0]['nombre_empleado'].'</p>
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
                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Código Producto</th>
                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Artículo</th>
                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Almacén origen</th>
                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Almacén destino</th>
                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Cantidad</th>
                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Nombre Empleado</th>
                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Fecha</th>
            </tr>
        </thead>
        <tbody>';

        if ($total >= 1) {
            foreach ($datos as $rows) {
                $fechaFormateada = date('d/m/Y', strtotime($rows['fecha_movimiento']));
                $tabla .= '
<tr>
    <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['codigo_producto']) . '</td>
    <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['nombre_producto']) . '</td>
    <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['nombre_almacen_origen']) . '</td>
    <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['nombre_almacen_destino']) . '</td>
    <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['cantidad']) . '</td>
    <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['nombre_empleado']) . '</td>
    <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($fechaFormateada) . '</td>
</tr>';
            }
        } else {
            $tabla .= '<tr><td colspan="7" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
        }

        $tabla .= '
        </tbody>
    </table>
</div>
</div>';

        $tabla .= '
<script>
 function imprimirArea(id) {
    var contenido = document.getElementById(id).innerHTML;
    var ventanaImpresion = window.open("", "_blank");
    ventanaImpresion.document.write("<html><head><title>Id_'.$datos[0]['id_movimiento'].'</title>");
    
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
    }

    $tabla .= '</div></div></div>'; // Cierra el contenido principal y las filas/contenedores

    return $tabla;
}



}