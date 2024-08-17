<?php

namespace app\controllers;

use app\models\mainModel;

class movController2 extends mainModel
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
        $consulta_movimientos = "SELECT * FROM movimientos ORDER BY id_movimiento desc";
        $datos_movimientos = $this->ejecutarConsulta($consulta_movimientos);
        $opciones_movimientos = "";

        while ($movimientos = $datos_movimientos->fetch()) {
            $opciones_movimientos .= '<option value="' . $movimientos['id_movimiento'] . '">
            '. $movimientos['id_movimiento'] . ''."  ".''. $movimientos['fecha_movimiento'] . '</option>';
        }

        return $opciones_movimientos;
    }

   
 /*----------  Controlador listar  ----------*/
 public function listarMovControlador2($pagina, $registros, $url, $busqueda)
 {
     $pagina = $this->limpiarCadena($pagina);
     $registros = $this->limpiarCadena($registros);
 
     $url = $this->limpiarCadena($url);
     $url = APP_URL . $url . "/";
 
     $busqueda = $this->limpiarCadena($busqueda);
     $tabla = "";
 
     $consulta_datos = "SELECT
     movimientos.id_movimiento,
     productos.*,
     origen.nombre_almacen AS nombre_almacen_origen,
     destino.nombre_almacen AS nombre_almacen_destino,
     empleados.nombre_empleado,
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
     movimientos.id_movimiento = '$busqueda'
     GROUP BY
     movimientos.id_movimiento
     ORDER BY
     movimientos.id_movimiento DESC;";
 
     $datos = $this->ejecutarConsulta($consulta_datos);
     $datos = $datos->fetchAll();
 
     $total = count($datos);
 
     $tabla .= '
     <button class="btn btn-primary" onclick="imprimirArea(\'areaImprimir\')">Imprimir</button>
     <div id="areaImprimir">
     <div class="row row-cols-1 row-cols-md-3 g-4 p-5">';
 
     if ($total >= 1) {
         $tabla .= '
         <div class="table-responsive w-100">
             <table class="table w-100">
                 <tbody>';
 
         foreach ($datos as $rows) {
             $fechaFormateada = date('d/m/Y', strtotime($rows['fecha_movimiento']));
             $tabla .= '
             <div class="invoice">
                 <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding: 5px;">
                 <p style="font-size: 14px; text-align: center;"><strong>Movimientos de Almacenes</strong></p>
                 <div style="display: flex; align-items: center; justify-content: space-between;">
                     <img src="' . APP_URL . 'app/views/fotos/logo_orden.png" alt="logo" style="width:200px; height:auto;">
                     <div>
                         <h5>Movimiento de almacen: ' . $rows['id_movimiento'] . '</h5>
                         <p><strong>Fecha:</strong> ' . date('d/m/Y', strtotime($rows['fecha_movimiento'])) . '</p>
                         <p style="font-size: 13px;"><strong>Formato:</strong>  PR-12-F03</p>
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
                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">codigo</th>
                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Producto</th>
                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Almacén origen</th>
                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Almacén destino</th>
                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Cantidad</th>
                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Empleado</th>
                 <th style="text-align: center; border: 1px solid #000; padding: 5px;">Motivo</th>
             </tr>
         </thead>
         <tbody>
         <tr>
         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['codigo_producto'] . '</td>
         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['nombre_producto'] . '</td>
         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['nombre_almacen_origen'] . '</td>
         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['nombre_almacen_destino'] . '</td>
         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['cantidad'] . '</td>
         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['nombre_empleado'] . '</td>
         <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['nota_movimiento'] . '</td>
         </tr>';
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
             ventanaImpresion.document.write("<html><head><title>Movimiento de almacen: ' . $rows['id_movimiento'] . '-' . date('d/m/Y', strtotime($rows['fecha_movimiento'])) . '</title>");
             ventanaImpresion.document.write("<style>");
             ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; text-align: center; }");
             ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; margin: 0 auto; }");
             ventanaImpresion.document.write("th, td { border: 1px solid black; padding: 8px; text-align: center; }");
             ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
             ventanaImpresion.document.write("</style>");
             ventanaImpresion.document.write("</head><body>");
             ventanaImpresion.document.write(contenido);
             ventanaImpresion.document.write(\'<div class=\"w-100 text-center\" style=\"padding: 20px; border-top: 1px solid #ccc; margin-top: 20px;\">\');
             ventanaImpresion.document.write(\'<div><label>Firma de Recibido:</label><div style=\"width: 235px; height: 60px; border-bottom: 1px solid #000; margin: 0 auto;\"></div></div>\');
             ventanaImpresion.document.write(\'<div><label style=\"margin-top: 20px;\">Fecha de Impresión:</label><span>' . date('d/m/Y') . '</span></div>\');
             ventanaImpresion.document.write("</div>");
             ventanaImpresion.document.write("</body></html>");
             ventanaImpresion.document.close();
             ventanaImpresion.print();
         }
         </script>';
     } else {
         $tabla .= '<div class="col">No hay registros en el sistema</div>';
     }
 
     $tabla .= '</div>';
 
     return $tabla;
 }
 










}