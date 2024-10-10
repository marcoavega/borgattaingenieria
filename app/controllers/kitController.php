<?php

namespace app\controllers;

use app\models\mainModel;

class kitController extends mainModel
{

    
   /*----------  Controlador listar productos  ----------*/
   public function listarKitControlador($pagina, $registros, $url, $busqueda)
   {
       $pagina = intval($this->limpiarCadena($pagina));
       $registros = intval($this->limpiarCadena($registros));
       $url = $this->limpiarCadena($url);
       $url = APP_URL . $url . "/";
       $busqueda = $this->limpiarCadena($busqueda);
   
       $inicio = ($pagina > 0) ? (($pagina - 1) * $registros) : 0;
   
       $consulta_datos = "SELECT
           p.codigo_producto,
           p.nombre_producto,
           p.url_imagen,
           SUM(CASE WHEN cpi.nombre = 'CPI' THEN pca.cantidad ELSE 0 END) AS cantidad_cpi,
           SUM(CASE WHEN cpi.nombre = 'Articulador' THEN pca.cantidad ELSE 0 END) AS cantidad_articulador,
           SUM(CASE WHEN cpi.nombre = 'ARCO' THEN pca.cantidad ELSE 0 END) AS cantidad_arco_facial,
           SUM(CASE WHEN cpi.nombre = 'Empaque' THEN pca.cantidad ELSE 0 END) AS cantidad_empaque,
           (SELECT COALESCE(SUM(stock), 0) FROM stock_almacen WHERE id_producto = p.id_producto AND id_almacen = 1) AS stock_almacen_general,
           (SELECT COALESCE(SUM(stock), 0) FROM stock_almacen WHERE id_producto = p.id_producto AND id_almacen = 3) AS stock_area_ensamble,
           (SELECT COALESCE(SUM(stock), 0) FROM stock_almacen WHERE id_producto = p.id_producto AND id_almacen = 31) AS stock_almacen_sin_pintar,
           (SELECT COALESCE(SUM(stock), 0) FROM stock_almacen WHERE id_producto = p.id_producto AND id_almacen = 32) AS stock_area_pintura,
           (SELECT COALESCE(SUM(stock), 0) FROM stock_almacen WHERE id_producto = p.id_producto AND id_almacen = 34) AS stock_almacen_pintadas,
           (SELECT COALESCE(SUM(stock), 0) FROM stock_almacen WHERE id_producto = p.id_producto AND id_almacen IN (1, 3, 31, 32, 34)) AS stock_total,
           (SUM(CASE WHEN cpi.nombre = 'CPI' THEN pca.cantidad ELSE 0 END) +
            SUM(CASE WHEN cpi.nombre = 'Articulador' THEN pca.cantidad ELSE 0 END) +
            SUM(CASE WHEN cpi.nombre = 'ARCO' THEN pca.cantidad ELSE 0 END) +
            SUM(CASE WHEN cpi.nombre = 'Empaque' THEN pca.cantidad ELSE 0 END)) AS total_cantidad
       FROM
           productos p
       JOIN categorias c ON p.id_categoria = c.id_categoria
       JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
       JOIN cpi_art_af cpi ON pca.id_cpi_art_af = cpi.id_cpi_art_af
       GROUP BY p.codigo_producto, p.nombre_producto
       ORDER BY p.codigo_producto ASC
       LIMIT $inicio, $registros;";
   
       $datos = $this->ejecutarConsulta($consulta_datos);
       $datos = $datos->fetchAll();
   
       $consulta_total = "SELECT COUNT(DISTINCT p.id_producto)
       FROM productos p
       JOIN categorias c ON p.id_categoria = c.id_categoria
       JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
       JOIN cpi_art_af cpi ON pca.id_cpi_art_af = cpi.id_cpi_art_af
       WHERE p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%';";
       $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();
   
       $numeroPaginas = ceil($total / $registros);
   
       $tabla = '<div class="container-fluid p-4">
       <h5>Ingrese la cantidad de kit a fabricar</h5>
       <input type="number" id="multiplicador" value="1" min="1" oninput="calcularTotales()" class="form-control mb-3" style="width: 200px;">
       <button onclick="imprimirTabla()" class="btn btn-primary mb-3">Imprimir Tabla</button>
       <table id="tabla-productos" class="table table-bordered table-striped table-hover">
       <thead class="thead-dark">
           <tr>
               <th>Imagen</th>
               <th>Código Producto</th>
               <th>Nombre Producto</th>
               <th>CPI</th>
               <th>Articulador</th>
               <th>Arco Facial</th>
               <th>Empaque</th>
               <th>Total</th>
               <th>Almacén General</th>
               <th>Área de Ensamble</th>
               <th>Almacén Sin Pintar</th>
               <th>Área de Pintura</th>
               <th>Almacén Pintadas</th>
               <th>Stock Total</th>
               <th>Stock Restante</th>
           </tr>
       </thead>
       <tbody>';
   
       if ($total > 0) {
           foreach ($datos as $rows) {
               $tabla .= '<tr>
                   <td><img src="' . APP_URL . 'app/views/img/img/' . htmlspecialchars($rows['url_imagen']) . '" alt="' . htmlspecialchars($rows['nombre_producto']) . '" style="width: 50px; height: 50px;"></td>
                   <td>' . htmlspecialchars($rows['codigo_producto']) . '</td>
                   <td>' . htmlspecialchars($rows['nombre_producto']) . '</td>
                   <td class="cantidad-cpi">' . htmlspecialchars($rows['cantidad_cpi']) . '</td>
                   <td class="cantidad-articulador">' . htmlspecialchars($rows['cantidad_articulador']) . '</td>
                   <td class="cantidad-arco">' . htmlspecialchars($rows['cantidad_arco_facial']) . '</td>
                   <td class="cantidad-empaque">' . htmlspecialchars($rows['cantidad_empaque']) . '</td>
                   <td class="total">' . htmlspecialchars($rows['total_cantidad']) . '</td>
                   <td class="stock-almacen-general">' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
                   <td class="stock-area-ensamble">' . htmlspecialchars($rows['stock_area_ensamble']) . '</td>
                   <td class="stock-almacen-sin-pintar">' . htmlspecialchars($rows['stock_almacen_sin_pintar']) . '</td>
                   <td class="stock-area-pintura">' . htmlspecialchars($rows['stock_area_pintura']) . '</td>
                   <td class="stock-almacen-pintadas">' . htmlspecialchars($rows['stock_almacen_pintadas']) . '</td>
                   <td class="stock-total">' . htmlspecialchars($rows['stock_total']) . '</td>
                   <td class="stock-disponible"></td>
               </tr>';
           }
       } else {
           $tabla .= '<tr><td colspan="15" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
       }
   
       $tabla .= '</tbody></table>';
       $tabla .= '</div>';
   
       // JavaScript para calcular totales dinámicamente
       $tabla .= '<script>
       function calcularTotales() {
           var multiplicador = document.getElementById("multiplicador").value;
           var filas = document.querySelectorAll("tbody tr");
           filas.forEach(function(fila) {
               var cpi = parseFloat(fila.querySelector(".cantidad-cpi").textContent) || 0;
               var articulador = parseFloat(fila.querySelector(".cantidad-articulador").textContent) || 0;
               var arco = parseFloat(fila.querySelector(".cantidad-arco").textContent) || 0;
               var empaque = parseFloat(fila.querySelector(".cantidad-empaque").textContent) || 0;
               var stockTotal = parseFloat(fila.querySelector(".stock-total").textContent);
               var total = fila.querySelector(".total");
               var stockDisponible = fila.querySelector(".stock-disponible");
               var totalCantidad = (cpi + articulador + arco + empaque) * multiplicador;
               total.textContent = totalCantidad.toFixed(2);
               stockDisponible.textContent = (stockTotal - totalCantidad).toFixed(2);
           });
       }
   
       function imprimirTabla() {
           var contenidoTabla = document.getElementById("tabla-productos").innerHTML;
           var ventanaImpresion = window.open("", "_blank");
           ventanaImpresion.document.write("<html><head><title>Lista KIT</title>");
           ventanaImpresion.document.write("<style>");
           ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
           ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; }");
           ventanaImpresion.document.write("th, td { border: 1px solid #000; padding: 8px; text-align: center; }");
           ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
           ventanaImpresion.document.write("@media print { table { page-break-inside: avoid; } }");
           ventanaImpresion.document.write("</style>");
           ventanaImpresion.document.write("</head><body>");
           ventanaImpresion.document.write("<table>");
           ventanaImpresion.document.write("<thead class=\'thead-dark\'><tr><th>Imagen</th><th>Código Producto</th><th>Nombre Producto</th><th>CPI</th><th>Articulador</th><th>Arco Facial</th><th>Empaque</th><th>Total</th><th>Almacén General</th><th>Área de Ensamble</th><th>Almacén Sin Pintar</th><th>Área de Pintura</th><th>Almacén Pintadas</th><th>Stock Total</th><th>Stock Restante</th></tr></thead>");
           ventanaImpresion.document.write("<tbody>");
           ventanaImpresion.document.write(contenidoTabla);
           ventanaImpresion.document.write("</tbody>");
           ventanaImpresion.document.write("</table>");
           ventanaImpresion.document.write("</body></html>");
           ventanaImpresion.document.close();
           ventanaImpresion.print();
       }
       </script>';
   
       // Paginación
       if ($total > 0 && $numeroPaginas > 1) {
           $tabla .= "<nav><ul class='pagination'>";
           if ($pagina > 1) {
               $tabla .= "<li class='page-item'><a class='page-link' href='" . $url . ($pagina - 1) . "'>Anterior</a></li>";
           }
           for ($i = 1; $i <= $numeroPaginas; $i++) {
               $tabla .= "<li class='page-item " . ($i == $pagina ? 'active' : '') . "'><a class='page-link' href='" . $url . $i . "'>$i</a></li>";
           }
           if ($pagina < $numeroPaginas) {
               $tabla .= "<li class='page-item'><a class='page-link' href='" . $url . ($pagina + 1) . "'>Siguiente</a></li>";
           }
           $tabla .= "</ul></nav>";
       }
   
       return $tabla;
   }
   
   
   
   
   
   
   
   




}