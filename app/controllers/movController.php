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
     <!DOCTYPE html>
     <html lang="es">
     <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <style>
             @media print {
                 .no-print { 
                     display: none; 
                 }
                 body { 
                     margin: 0;
                     padding: 15px;
                 }
                 table { 
                     page-break-inside: avoid; 
                 }
                 #menuLateral {
                     display: none;
                 }
                 .btn {
                     display: none;
                 }
             }
         </style>
         <script>
             function imprimirArea(elementId) {
                 const contenido = document.getElementById(elementId);
                 const ventanaImpresion = window.open("", "", "height=600,width=800");
                 
                 ventanaImpresion.document.write("<html><head><title>Reporte de Movimientos</title>");
                 
                 // Agregar estilos CSS para la impresión
                 ventanaImpresion.document.write(`
                     <style>
                         body { 
                             font-family: Arial, sans-serif;
                             margin: 0;
                             padding: 15px;
                         }
                         table { 
                             width: 100%;
                             border-collapse: collapse;
                             margin-top: 20px;
                         }
                         th, td { 
                             border: 1px solid #000;
                             padding: 5px;
                             text-align: center;
                         }
                         th { 
                             background-color: #f2f2f2;
                         }
                         .invoice {
                             padding: 15px;
                         }
                         .logo-container {
                             text-align: center;
                             margin-bottom: 20px;
                         }
                         .company-info {
                             margin-bottom: 20px;
                         }
                         @media print {
                             .no-print { 
                                 display: none; 
                             }
                         }
                     </style>
                 `);
                 
                 ventanaImpresion.document.write("</head><body>");
                 ventanaImpresion.document.write(contenido.innerHTML);
                 ventanaImpresion.document.write("</body></html>");
                 
                 ventanaImpresion.document.close();
                 ventanaImpresion.focus();
                 
                 // Esperar a que el contenido se cargue antes de imprimir
                 setTimeout(() => {
                     ventanaImpresion.print();
                     ventanaImpresion.close();
                 }, 250);
             }
         </script>
     </head>
     <body>
     <div class="container-fluid">
         <div class="row">
             <!-- Menú lateral -->
             <div id="menuLateral" class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
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
                 <hr>
                 <ul class="nav flex-column">
                     <li class="nav-item">
                         <a href="'.APP_URL.'movSearch3/" class="nav-link active" aria-current="page">
                             <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                             Maquinados por Empleado
                         </a>
                     </li>
                 </ul>
                 <hr>
                 <ul class="nav flex-column">
                     <li class="nav-item">
                         <a href="'.APP_URL.'movSearch4/" class="nav-link active" aria-current="page">
                             <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                             Maquinados por herramientas
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
             productos.id_producto,
             productos.nombre_producto,
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
         <div id="areaImprimir">
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
                                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">ID Producto</th>
                                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Producto</th>
                                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Cantidad</th>
                                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Empleado</th>
                                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Fecha movimiento</th>
                                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Nota movimiento</th>
                             </tr>
                         </thead>
                         <tbody>';
 
         if ($total >= 1) {
             foreach ($datos as $rows) {
                 $fechaFormateada = date('d/m/Y', strtotime($rows['fecha_movimiento']));
                 $tabla .= '
                     <tr>
                         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['id_producto']) . '</td>
                         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['nombre_producto']) . '</td>
                         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['cantidad']) . '</td>
                         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['nombre_empleado']) . '</td>
                         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $fechaFormateada . '</td>
                         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['nota_movimiento']) . '</td>
                     </tr>';
             }
         } else {
             $tabla .= '
                 <tr>
                     <td colspan="6" style="text-align: center; border: 1px solid #000; padding: 5px;">No hay registros en el sistema</td>
                 </tr>';
         }
 
         $tabla .= '
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>';
     }
 
     $tabla .= '
             </div>
         </div>
     </div>
     </body>
     </html>';
 
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
                <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="'.APP_URL.'movSearch3/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Maquinados por Empleado
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="'.APP_URL.'movSearch4/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Maquinados por herramientas
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

            // Agregar fila de total después del foreach
            $tabla .= '
<tr>
    <td colspan="3" style="text-align: right; border: 1px solid #000; padding: 5px;"><strong>Total:</strong></td>
    <td colspan="2" style="border: 1px solid #000; padding: 5px;"></td>
</tr>';
        } else {
            $tabla .= '<tr><td colspan="6" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
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
    ventanaImpresion.document.write("<html><head><title>Id_'.(isset($datos[0]) ? $datos[0]['id_movimiento'] : '').'</title>");
    
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



/*----------  Controlador listar  ----------*/
public function listarMovControladorEmpleado3($pagina, $registros, $url, $busqueda, $fechaInicio = '', $fechaFin = '', $id_empleado = '')
{
    // Inicialización de variables
    $tipo_cambio = isset($_POST['tipo_cambio']) ? floatval($_POST['tipo_cambio']) : 20;
    $herramientas_resumen = [];
    $tipos_herramientas = [
        'CORTADOR' => [],
        'INSERTO' => [],
        'BROCA' => [],
        'MACHUELO' => [],
        'BARRA' => [],
        'OTROS' => []
    ];

    $pagina = $this->limpiarCadena($pagina);
    $registros = $this->limpiarCadena($registros);
    $url = $this->limpiarCadena($url);
    $url = APP_URL . $url . "/";

    $busqueda = $this->limpiarCadena($busqueda);
    $fechaInicio = isset($_POST['fechaInicio']) ? $this->limpiarCadena($_POST['fechaInicio']) : '';
    $fechaFin = isset($_POST['fechaFin']) ? $this->limpiarCadena($_POST['fechaFin']) : '';
    $id_empleado = isset($_POST['id_empleado']) ? $this->limpiarCadena($_POST['id_empleado']) : '';

    // Add sorting parameters
    $orderBy = isset($_GET['orderBy']) ? $this->limpiarCadena($_GET['orderBy']) : 'fecha_movimiento';
    $orderDir = isset($_GET['orderDir']) ? $this->limpiarCadena($_GET['orderDir']) : 'DESC';
    
    // Validate sorting parameters
    $validColumns = ['producto', 'categoria', 'moneda', 'costo_herramienta', 'empleado', 'fecha_movimiento'];
    if (!in_array($orderBy, $validColumns)) {
        $orderBy = 'fecha_movimiento';
    }
    if (!in_array(strtoupper($orderDir), ['ASC', 'DESC'])) {
        $orderDir = 'DESC';
    }

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
               <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="'.APP_URL.'movSearch3/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Maquinados por Empleado
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="'.APP_URL.'movSearch4/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Maquinados por herramientas
                    </a>
                </li>
            </ul>
            </div>

            <!-- Contenido principal -->
            <div class="col-12 col-md-9 col-lg-10">
                <div class="container-fluid mb-4">
                    <h4 class="text-center">Movimientos</h4>
                    <h5 class="lead text-center">Lista de movimientos de herramientas por empleados</h5>
                </div>
                <form method="POST" action="' . $url . '">
                    ';

    // Consulta para obtener la lista de empleados
    $consulta_empleados = "SELECT * FROM empleados WHERE id_empleado IN (7, 8, 9) ORDER BY nombre_empleado";
    $datos_empleados = $this->ejecutarConsulta($consulta_empleados);
    $opciones_empleados = "";

    while ($empleados = $datos_empleados->fetch()) {
        $selected = ($empleados['id_empleado'] == $id_empleado) ? 'selected' : '';
        $opciones_empleados .= '<option value="' . $empleados['id_empleado'] . '" ' . $selected . '>'
                             . htmlspecialchars($empleados['nombre_empleado']) . '</option>';
    }

    $tabla .= '
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="date" class="form-control" name="fechaInicio" placeholder="Fecha Inicio" value="' . htmlspecialchars($fechaInicio) . '">
        </div>
        <div class="col-md-3">
            <input type="date" class="form-control" name="fechaFin" placeholder="Fecha Fin" value="' . htmlspecialchars($fechaFin) . '">
        </div>
        <div class="col-md-3">
            <select class="form-control" name="id_empleado" required>
                <option value="">Seleccione Empleado</option>
                ' . $opciones_empleados . '
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" class="form-control" name="presupuesto" placeholder="Presupuesto" value="' . (isset($_POST['presupuesto']) ? htmlspecialchars($_POST['presupuesto']) : '') . '" min="0" step="0.01">
        </div>
        <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </div>
';

// Process budget input
$presupuesto = isset($_POST['presupuesto']) ? floatval($this->limpiarCadena($_POST['presupuesto'])) : 0;

    if (!empty($fechaInicio) && !empty($fechaFin)) {
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        // Condiciones para la consulta SQL
        $condiciones = "mov.fecha_movimiento BETWEEN '$fechaInicio' AND '$fechaFin' 
                       AND c.nombre_categoria = 'Herramientas maquinados'
                       AND e.id_empleado IN (7, 8, 9)";
        if (!empty($id_empleado)) {
            $condiciones .= " AND e.id_empleado = $id_empleado";
        }

        $consulta_datos = "SELECT 
            p.nombre_producto AS producto,
            c.nombre_categoria AS categoria,
            CASE 
                WHEN p.id_moneda = 1 THEN 'MXN'
                WHEN p.id_moneda = 2 THEN 'USD'
                ELSE 'Otra moneda'
            END AS moneda,
            p.precio AS costo_herramienta,
            e.nombre_empleado AS empleado,
            mov.fecha_movimiento,
            mov.id_movimiento,
            mov.cantidad
        FROM 
            productos p
            JOIN categorias c ON p.id_categoria = c.id_categoria
            JOIN movimientos mov ON p.id_producto = mov.id_producto
            JOIN empleados e ON mov.id_empleado = e.id_empleado
        WHERE 
            $condiciones
        ORDER BY 
            $orderBy $orderDir
        LIMIT 
            $inicio, $registros";

        $consulta_total = "SELECT COUNT(*)
        FROM productos p
            JOIN categorias c ON p.id_categoria = c.id_categoria
            JOIN movimientos mov ON p.id_producto = mov.id_producto
            JOIN empleados e ON mov.id_empleado = e.id_empleado
        WHERE $condiciones";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int) $total->fetchColumn();

        // Función para generar enlaces de ordenamiento
        function getSortingLink($column, $currentOrderBy, $currentOrderDir, $url) {
            $newDir = ($currentOrderBy === $column && $currentOrderDir === 'ASC') ? 'DESC' : 'ASC';
            $arrow = '';
            if ($currentOrderBy === $column) {
                $arrow = ($currentOrderDir === 'ASC') ? ' ↑' : ' ↓';
            }
            return '<a href="' . $url . '?orderBy=' . $column . '&orderDir=' . $newDir . '" 
                      class="text-dark text-decoration-none">' . ucfirst($column) . $arrow . '</a>';
        }

        $tabla .= '
<button class="btn btn-primary mb-3" onclick="imprimirArea(\'areaImprimir\')">Imprimir</button>
<div id="areaImprimir">
<div class="container-fluid"><div class="invoice">
                 <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding: 5px;">
                 <p style="font-size: 14px; text-align: center;"><strong>Consulta de Movimientos de Herramientas
<br> Desde ' . htmlspecialchars($fechaInicio) . ' hasta ' . htmlspecialchars($fechaFin) . '</strong></p>
                 <div style="display: flex; align-items: center; justify-content: space-between;">
                     <img src="' . APP_URL . 'app/views/fotos/logo_orden.png" alt="logo" style="width:200px; height:auto;">
                     <div>
                         <p style="font-size: 13px;"><strong>Formato: </strong>  MA-12-F016</p>
                         <p style="font-size: 13px;"><strong>Empleado: </strong>'.(isset($datos[0]) ? $datos[0]['empleado'] : '').'</p>
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
                <th style="text-align: center; border: 1px solid #000; padding: 5px; color: white;">Producto</th>
                <th style="text-align: center; border: 1px solid #000; padding: 5px; color: white;">Cantidad</th>
                <th style="text-align: center; border: 1px solid #000; padding: 5px; color: white;">Empleado</th>
                <th style="text-align: center; border: 1px solid #000; padding: 5px; color: white;">Fecha Movimiento</th>
            </tr>
        </thead>
        <tbody>';

        $total_costos = 0;

        if ($total >= 1) {
            foreach ($datos as $rows) {
                $fechaFormateada = date('d/m/Y', strtotime($rows['fecha_movimiento']));
                $tabla .= '
<tr>
    <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['producto']) . '</td>
    <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['cantidad']) . '</td>
    <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($rows['empleado']) . '</td>
    <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($fechaFormateada) . '</td>
</tr>';
                
                // Sumar al total
                $total_costos += floatval($rows['costo_herramienta']);

                // Crear o actualizar el resumen de herramientas
                $nombre_herramienta = $rows['producto'];
                $cantidad_movimiento = intval($rows['cantidad']); // Obtener la cantidad del movimiento

                if (!isset($herramientas_resumen[$nombre_herramienta])) {
                    $herramientas_resumen[$nombre_herramienta] = [
                        'cantidad' => $cantidad_movimiento, // Inicializar con la cantidad del movimiento
                        'costo_unitario' => $rows['costo_herramienta'],
                        'moneda' => $rows['moneda']
                    ];
                } else {
                    // Sumar la cantidad del movimiento actual
                    $herramientas_resumen[$nombre_herramienta]['cantidad'] += $cantidad_movimiento;
                }

                // También modificar la parte de tipos_herramientas (líneas 237-261)
                $clasificado = false;
                foreach ($tipos_herramientas as $tipo => &$grupo) {
                    if (stripos($nombre_herramienta, $tipo) !== false) {
                        if (!isset($grupo[$nombre_herramienta])) {
                            $grupo[$nombre_herramienta] = [
                                'cantidad' => $cantidad_movimiento, // Inicializar con la cantidad del movimiento
                                'costo_unitario' => $rows['costo_herramienta'],
                                'moneda' => $rows['moneda']
                            ];
                        } else {
                            $grupo[$nombre_herramienta]['cantidad'] += $cantidad_movimiento; // Sumar la cantidad del movimiento
                        }
                        $clasificado = true;
                        break;
                    }
                }
                if (!$clasificado) {
                    if (!isset($tipos_herramientas['OTROS'][$nombre_herramienta])) {
                        $tipos_herramientas['OTROS'][$nombre_herramienta] = [
                            'cantidad' => $cantidad_movimiento, // Inicializar con la cantidad del movimiento
                            'costo_unitario' => $rows['costo_herramienta'],
                            'moneda' => $rows['moneda']
                        ];
                    } else {
                        $tipos_herramientas['OTROS'][$nombre_herramienta]['cantidad'] += $cantidad_movimiento; // Sumar la cantidad del movimiento
                    }
                }
            }

            // Generar la segunda tabla (resumen de herramientas)
            $tabla .= '
            <div style="margin-top: 30px;">
                <h4 style="text-align: center; margin-bottom: 15px;">Resumen de Herramientas</h4>
                <table class="table" style="width: 100%; padding-top: 10; font-size: 13px;">
                    <thead>
                        <tr>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Herramienta</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Cantidad Total</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Moneda</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Costo Unitario</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>';

            $gran_total = 0;
            foreach ($herramientas_resumen as $herramienta => $datos) {
                $costo_pesos = ($datos['moneda'] == 'USD') ? 
                    $datos['costo_unitario'] * $tipo_cambio : 
                    $datos['costo_unitario'];
                
                $total_herramienta = $datos['cantidad'] * $costo_pesos;
                $gran_total += $total_herramienta;
                
                $tabla .= '
                <tr>
                    <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($herramienta) . '</td>
                    <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $datos['cantidad'] . '</td>
                    <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($datos['moneda']) . '</td>
                    <td style="text-align: center; border: 1px solid #000; padding: 5px;">$' . number_format($datos['costo_unitario'], 2) . '</td>
                    <td style="text-align: center; border: 1px solid #000; padding: 5px;">$' . number_format($total_herramienta, 2) . '</td>
                </tr>';
            }

            // Agregar fila de total
            $tabla .= '
                <tr>
                    <td colspan="4" style="text-align: right; border: 1px solid #000; padding: 5px;"><strong>Total General:</strong></td>
                    <td style="text-align: center; border: 1px solid #000; padding: 5px;"><strong>$' . number_format($gran_total, 2) . '</strong></td>
                </tr>
                </tbody>
            </table>
            </div>';

            // Después de la segunda tabla, agregar la tercera con la conversión correcta:
            $tabla .= '
            <div style="margin-top: 30px;">
                <h4 style="text-align: center; margin-bottom: 15px;">Resumen por Tipo de Herramienta</h4>
                <table class="table" style="width: 100%; padding-top: 10; font-size: 13px;">
                    <thead>
                        <tr>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Tipo</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Herramienta</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Cantidad</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Moneda</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Costo Unitario</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>';

            $gran_total_tipos = 0;
            $tipos_mostrar = ["CORTADOR", "INSERTO", "MACHUELO", "RIMA", "BROCA", "BOQUILLA", "OTROS"];
            $productos_procesados = [];

            foreach ($tipos_mostrar as $tipo) {
                $subtotal_tipo = 0;
                $hay_items = false;

                foreach ($herramientas_resumen as $herramienta => $datos) {
                    // Si es la categoría OTROS, mostrar solo los productos no procesados
                    if ($tipo === "OTROS") {
                        if (!in_array($herramienta, $productos_procesados)) {
                            $hay_items = true;
                            
                            $costo_pesos = ($datos["moneda"] == "USD") ? 
                                $datos["costo_unitario"] * $tipo_cambio : 
                                $datos["costo_unitario"];
                            
                            $total_herramienta = $datos["cantidad"] * $costo_pesos;
                            $subtotal_tipo += $total_herramienta;

                            $tabla .= "
                            <tr>
                                <td style=\"text-align: center; border: 1px solid #000; padding: 5px;\">{$tipo}</td>
                                <td style=\"text-align: center; border: 1px solid #000; padding: 5px;\">" . htmlspecialchars($herramienta) . "</td>
                                <td style=\"text-align: center; border: 1px solid #000; padding: 5px;\">{$datos["cantidad"]}</td>
                                <td style=\"text-align: center; border: 1px solid #000; padding: 5px;\">{$datos["moneda"]}</td>
                                <td style=\"text-align: center; border: 1px solid #000; padding: 5px;\">$" . number_format($datos["costo_unitario"], 2) . "</td>
                                <td style=\"text-align: center; border: 1px solid #000; padding: 5px;\">$" . number_format($total_herramienta, 2) . "</td>
                            </tr>";
                        }
                    } 
                    // Para las demás categorías, procesar normalmente
                    else if (stripos($herramienta, $tipo) !== false) {
                        $hay_items = true;
                        $productos_procesados[] = $herramienta;
                        
                        $costo_pesos = ($datos["moneda"] == "USD") ? 
                            $datos["costo_unitario"] * $tipo_cambio : 
                            $datos["costo_unitario"];
                        
                        $total_herramienta = $datos["cantidad"] * $costo_pesos;
                        $subtotal_tipo += $total_herramienta;

                        $tabla .= "
                        <tr>
                            <td style=\"text-align: center; border: 1px solid #000; padding: 5px;\">{$tipo}</td>
                            <td style=\"text-align: center; border: 1px solid #000; padding: 5px;\">" . htmlspecialchars($herramienta) . "</td>
                            <td style=\"text-align: center; border: 1px solid #000; padding: 5px;\">{$datos["cantidad"]}</td>
                            <td style=\"text-align: center; border: 1px solid #000; padding: 5px;\">{$datos["moneda"]}</td>
                            <td style=\"text-align: center; border: 1px solid #000; padding: 5px;\">$" . number_format($datos["costo_unitario"], 2) . "</td>
                            <td style=\"text-align: center; border: 1px solid #000; padding: 5px;\">$" . number_format($total_herramienta, 2) . "</td>
                        </tr>";
                    }
                }

                if ($hay_items) {
                    $tabla .= "
                    <tr>
                        <td colspan=\"5\" style=\"text-align: right; border: 1px solid #000; padding: 5px;\">
                            <strong>Subtotal {$tipo}:</strong>
                        </td>
                        <td style=\"text-align: center; border: 1px solid #000; padding: 5px;\">
                            <strong>$" . number_format($subtotal_tipo, 2) . "</strong>
                        </td>
                    </tr>";
                    
                    $gran_total_tipos += $subtotal_tipo;
                }
            }

            $tabla .= "
                <tr>
                    <td colspan=\"5\" style=\"text-align: right; border: 1px solid #000; padding: 5px;\">
                        <strong>GRAN TOTAL:</strong>
                    </td>
                    <td style=\"text-align: center; border: 1px solid #000; padding: 5px;\">
                        <strong>$" . number_format($gran_total_tipos, 2) . "</strong>
                    </td>
                </tr>
                </tbody>
            </table>
            </div>";
        }

// Budget comparison table (add this after generating existing tables)
if ($total >= 1 && $presupuesto > 0) {
    $porcentaje_usado = ($gran_total_tipos / $presupuesto) * 100;
    $diferencia = $presupuesto - $gran_total_tipos;

    $tabla .= '
    <div style="margin-top: 30px;">
        <h4 style="text-align: center; margin-bottom: 15px;">Análisis de Presupuesto</h4>
        <table class="table" style="width: 100%; padding-top: 10; font-size: 13px;">
            <thead>
                <tr>
                    <th style="text-align: center; border: 1px solid #000; padding: 5px;">Presupuesto</th>
                    <th style="text-align: center; border: 1px solid #000; padding: 5px;">Total Gastado</th>
                    <th style="text-align: center; border: 1px solid #000; padding: 5px;">Porcentaje Usado</th>
                    <th style="text-align: center; border: 1px solid #000; padding: 5px;">Diferencia</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center; border: 1px solid #000; padding: 5px;">$' . number_format($presupuesto, 2) . '</td>
                    <td style="text-align: center; border: 1px solid #000; padding: 5px;">$' . number_format($gran_total_tipos, 2) . '</td>
                    <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . number_format($porcentaje_usado, 2) . '%</td>
                    <td style="text-align: center; border: 1px solid #000; padding: 5px;">$' . number_format($diferencia, 2) . '</td>
                </tr>
            </tbody>
        </table>
    </div>';
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
    ventanaImpresion.document.write("<html><head><title>Id_'.(isset($datos[0]) ? $datos[0]['id_movimiento'] : '').'</title>");
    
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

    $tabla .= '</div></div></div>';

    return $tabla;
}



/*----------  Controlador listar  ----------*/
public function listarMovControladorEmpleado4($pagina, $registros, $url, $busqueda, $fechaInicio = '', $fechaFin = '', $id_empleado = '')
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
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="'.APP_URL.'movSearch3/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Maquinados por Empleado
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="'.APP_URL.'movSearch4/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Maquinados por herramientas
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contenido principal -->
            <div class="col-12 col-md-9 col-lg-10">
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

    // Consulta modificada para mostrar solo empleados específicos
    $consulta_empleados = "SELECT * FROM empleados 
                          WHERE id_empleado IN (7, 8, 9) 
                          ORDER BY nombre_empleado";
    $datos_empleados = $this->ejecutarConsulta($consulta_empleados);
    $opciones_empleados = "";

    while ($empleados = $datos_empleados->fetch()) {
        $selected = ($empleados['id_empleado'] == $id_empleado) ? 'selected' : '';
        $opciones_empleados .= '<option value="' . $empleados['id_empleado'] . '" ' . $selected . '>'
                             . htmlspecialchars($empleados['nombre_empleado']) . '</option>';
    }

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

    if (!empty($fechaInicio) && !empty($fechaFin)) {
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        // Condiciones modificadas para incluir filtro de categoría y empleados
        $condiciones = "movimientos.fecha_movimiento BETWEEN '$fechaInicio' AND '$fechaFin'
                       AND productos.id_categoria = 3
                       AND empleados.id_empleado IN (7, 8, 9)";
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
            $inicio, $registros";

        $consulta_total = "SELECT COUNT(DISTINCT movimientos.id_movimiento)
        FROM movimientos
        JOIN productos ON movimientos.id_producto = productos.id_producto
        JOIN almacenes AS origen ON movimientos.id_almacen_origen = origen.id_almacen
        JOIN almacenes AS destino ON movimientos.id_almacen_destino = destino.id_almacen
        JOIN empleados ON movimientos.id_empleado = empleados.id_empleado
        WHERE $condiciones";

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

            $tabla .= '
                <tr>
                    <td colspan="3" style="text-align: right; border: 1px solid #000; padding: 5px;"><strong>Total:</strong></td>
                    <td colspan="2" style="border: 1px solid #000; padding: 5px;"></td>
                </tr>';
        } else {
            $tabla .= '<tr><td colspan="7" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
        }

        $tabla .= '
                    </tbody>
                </table>';

        // Consulta modificada de uso de productos para incluir filtros de categoría y empleados
        $consulta_uso_productos = "
           SELECT 
    p.id_producto,
    p.codigo_producto,
    p.nombre_producto,
    COUNT(m.id_movimiento) as total_movimientos,
    SUM(m.cantidad) as cantidad_total_movida,
    (
        SELECT stock 
        FROM stock_almacen 
        WHERE id_producto = p.id_producto 
        AND id_almacen = 1
    ) as stock_actual
FROM 
    movimientos m
    JOIN productos p ON m.id_producto = p.id_producto
    JOIN empleados e ON m.id_empleado = e.id_empleado
WHERE 
    m.fecha_movimiento BETWEEN '$fechaInicio' AND '$fechaFin'
    AND p.id_categoria = 3
    AND e.id_empleado IN (7, 8, 9)
    " . (!empty($id_empleado) ? " AND e.id_empleado = $id_empleado" : "") . "
GROUP BY 
    p.id_producto, p.codigo_producto, p.nombre_producto
ORDER BY 
    total_movimientos DESC, cantidad_total_movida DESC";

        $datos_uso = $this->ejecutarConsulta($consulta_uso_productos);
        $productos_uso = $datos_uso->fetchAll();

        $tabla .= '
        <div class="mt-4">
            <h5 style="text-align: center; font-weight: bold; margin: 20px 0;">Resumen de Uso de Productos</h5>
            <table class="table" style="width: 100%; padding-top: 10px; font-size: 13px;">
                <thead>
                    <tr>
                        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Código Producto</th>
                        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Nombre Producto</th>
                        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Total Movimientos</th>
                        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Cantidad Total Movida</th>
                        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Stock Actual</th>
                    </tr>
                </thead>
                <tbody>';
    
            if (count($productos_uso) > 0) {
                foreach ($productos_uso as $producto) {
                    $tabla .= '
                    <tr>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($producto['codigo_producto']) . '</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($producto['nombre_producto']) . '</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($producto['total_movimientos']) . '</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($producto['cantidad_total_movida']) . '</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . htmlspecialchars($producto['stock_actual']) . '</td>
                    </tr>';
                }
            } else {
                $tabla .= '<tr><td colspan="5" class="text-center">No hay datos de uso de productos para mostrar.</td></tr>';
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
        ventanaImpresion.document.write("<html><head><title>Id_'.$datos[0]['id_movimiento'].'</title>");
        
        // Estilos CSS para la impresión
        ventanaImpresion.document.write("<style>");
        ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
        ventanaImpresion.document.write("table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }");
        ventanaImpresion.document.write("th, td { border: 1px solid #000; padding: 5px; text-align: center; }");
        ventanaImpresion.document.write("h5 { text-align: center; font-weight: bold; margin: 20px 0; }");
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