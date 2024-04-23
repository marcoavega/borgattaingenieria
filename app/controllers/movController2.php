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
        $consulta_movimientos = "SELECT * FROM movimientos ORDER BY id_movimiento";
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
 
     $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
     $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
 
     $consulta_datos = "SELECT
     movimientos.id_movimiento,
     productos.nombre_producto,
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
 movimientos.id_movimiento LIKE '%$busqueda%'
 GROUP BY
     movimientos.id_movimiento
 ORDER BY
     movimientos.id_movimiento DESC
 LIMIT
     $inicio, $registros;
 
 
 
     ";
 
 $consulta_total = "SELECT COUNT(DISTINCT movimientos.id_movimiento)
 FROM movimientos
 JOIN productos ON movimientos.id_producto = productos.id_producto
 JOIN almacenes AS origen ON movimientos.id_almacen_origen = origen.id_almacen
 JOIN almacenes AS destino ON movimientos.id_almacen_destino = destino.id_almacen
 JOIN empleados ON movimientos.id_empleado = empleados.id_empleado
 WHERE movimientos.id_movimiento LIKE '%$busqueda%';        
 ";
 
 
 $datos = $this->ejecutarConsulta($consulta_datos);
 $datos = $datos->fetchAll();
 
 $total = $this->ejecutarConsulta($consulta_total);
 $total = (int) $total->fetchColumn();
 
 $numeroPaginas = ceil($total / $registros);
 
 $tabla .= '
 <button class="btn btn-primary" onclick="imprimirArea(\'areaImprimir\')">Imprimir</button>
 <div id="areaImprimir">
 <div class="row row-cols-1 row-cols-md-3 g-4 p-5">';
 
 if ($total >= 1 && $pagina <= $numeroPaginas) {
     $contador = $inicio + 1;
     $pag_inicio = $inicio + 1;
 
     $tabla .= '
<div class="table-responsive w-100">



    <table class="table w-100">
        <thead>
            <tr>
                <th>Artículo</th>
                <th>Almacén origen</th>
                <th>Almacén destino</th>
                <th>Cantidad</th>
                <th>Nombre Empleado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>';

foreach ($datos as $rows) {
    $fechaFormateada = date('d/m/Y', strtotime($rows['fecha_movimiento'])); // Convierte la fecha al formato deseado
    $tabla .= '

    <div style="display: flex; align-items: center;justify-content: space-between;">
            <img src="' . APP_URL . 'app/views/fotos/logo_orden.png" alt="logo" style="width:250px; height:auto; margin-right: 20px;">
            <div>
                <h5>Movimiento de almacen: ' . $rows['id_movimiento'] . '</h5>
                <p><strong>Fecha:</strong> ' . date('d/m/Y', strtotime($rows['fecha_movimiento'])) . '</p>
            </div>
        </div>
        <div style="margin-top: 1px; margin-bottom: 10px;">
            <p style="margin-top: 0; margin-bottom: 0;">RADIOTECNOLOGÍA INDUSTRIAL S.A. DE C.V.</p>
            <p style="margin-top: 0; margin-bottom: 0;">RFC: RIN070219R38</p>
            <p style="margin-top: 0; margin-bottom: 0;">Calle Puebla Sur. Manzana 4. Lote 5 Nave B Int. 2 Col. Jardín Industrial</p>
            <p style="margin-top: 0; margin-bottom: 0;">Ixtapaluca. Edo. de México, C.P. 56535</p>
        </div>

        <tr>
            <td>' . $rows['nombre_producto'] . '</td>
            <td>' . $rows['nombre_almacen_origen'] . '</td>
            <td>' . $rows['nombre_almacen_destino'] . '</td>
            <td>' . $rows['cantidad'] . '</td>
            <td>' . $rows['nombre_empleado'] . '</td>
            <td>' . $fechaFormateada . '</td>  <!-- Usar la fecha formateada aquí -->
        </tr>';
    $contador++;
}

$tabla .= '
    </tbody>
</table>
</div>

<!-- Área de firma al final del documento, justo después de la tabla -->
<div style="width: 100%; padding: 20px; margin-top: 50%;">
    <div class="d-flex justify-content-between">
        <div style="flex: 1;">
            <label>Firma de Recibido:</label>
        </div>
        <div style="flex: 1;">
            <label>Fecha de Recibido:</label>
            <span>' . date("d/m/Y") . '</span>
        </div>
    </div>
</div>

</div>

<script>
function imprimirArea(id) {
   var contenido = document.getElementById(id).innerHTML;
   var ventanaImpresion = window.open("", "_blank");
   ventanaImpresion.document.write("<html><head><title>Imprimir</title>");
   
   // Aquí puedes agregar tus estilos CSS
   ventanaImpresion.document.write("<style>");
   ventanaImpresion.document.write("body,td { font-family: Arial, sans-serif; line-height: 2; text-align: center; }"); // Centramos el texto
   ventanaImpresion.document.write("table { border-collapse: collapse; border: 1px solid black; border-radius: 10px; overflow: hidden; }"); // Agregamos bordes y esquinas redondeadas
   ventanaImpresion.document.write("td, th { border: 1px solid black; }"); // Agregamos bordes a las celdas
   ventanaImpresion.document.write("</style>");
   
   ventanaImpresion.document.write("</head><body>");
   ventanaImpresion.document.write(contenido);
   ventanaImpresion.document.write("</body></html>");
   ventanaImpresion.document.close();
   ventanaImpresion.print();
}
</script>';

 
     $pag_final = $contador - 1;
 } else {
     if ($total >= 1) {
         $tabla .= '
             <div class="col">
                 <a href="' . $url . '1/" class="button is-link is-rounded is-small mt-4 mb-4">
                     Haga clic acá para recargar el listado
                 </a>
             </div>
         ';
     } else {
         $tabla .= '
             <div class="col">
                 No hay registros en el sistemaaaa
             </div>
         ';
     }
 }
 
 $tabla .= '</div>';
 
 
   ### Paginacion ###
 if ($total > 0 && $pagina <= $numeroPaginas) {
     $tabla .= "<p class=\"pagination\">Mostrando productos <strong>  " . $pag_inicio . "   </strong> al <strong>  " . $pag_final . "   </strong> de un total de <strong>  " . $total . "   </strong></p>";
     $tabla .= $this->paginadorTablas($pagina, $numeroPaginas, $url, $pagina);
 }
 
     
     
     return $tabla;
 }





}