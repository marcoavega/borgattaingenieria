<?php

namespace app\controllers;

use app\models\mainModel;

class piezasController extends mainModel
{


    /*----------  Controlador listar productos  ----------*/
    public function listarPiezasMaquinadosCpiControlador($pagina, $registros, $url, $busqueda)
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
       IF(cpi.nombre = 'CPI', pca.cantidad, 0) AS cantidad_cpi,
       sa.stock AS stock_almacen_general,
       IF(cpi.nombre = 'CPI', pca.cantidad, 0) * 1 AS total_cantidad
   FROM
       productos p
   JOIN categorias c ON p.id_categoria = c.id_categoria
   JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
   JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
   JOIN cpi_art_af cpi ON pca.id_cpi_art_af = cpi.id_cpi_art_af AND cpi.id_cpi_art_af = 1
   JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
   WHERE
       (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
       AND cpi.nombre = 'CPI' AND sc.id_subcategoria = 3
   GROUP BY p.id_producto
   ORDER BY p.codigo_producto ASC
   LIMIT $inicio, $registros;";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $consulta_total = "SELECT COUNT(DISTINCT p.id_producto)
   FROM productos p
   JOIN categorias c ON p.id_categoria = c.id_categoria
   JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
   JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
   JOIN cpi_art_af cpi ON pca.id_cpi_art_af = cpi.id_cpi_art_af
   JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
   WHERE (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
   AND cpi.nombre = 'CPI' AND sc.id_subcategoria = 3;";

        $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();

        $numeroPaginas = ceil($total / $registros);

        $tabla = '<div class="container-fluid p-4">
       <input type="number" id="multiplicador" value="1" min="1" oninput="calcularTotales()" class="form-control mb-3" style="width: 200px;">
       <button onclick="imprimirTabla()" class="btn btn-primary mb-3">Imprimir Tabla</button>
       <table id="tabla-productos" class="table table-bordered table-striped">
       <thead>
           <tr>
               <th>Imagen</th>
               <th>Código Producto</th>
               <th>Nombre Producto</th>
               <th>Cantidad</th>
               <th>Total</th>
               <th>Stock Almacén General</th>
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
                   <td class="total">' . htmlspecialchars($rows['total_cantidad']) . '</td>
                   <td>' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
                   <td class="stock-disponible"></td>
               </tr>';
            }
        } else {
            $tabla .= '<tr><td colspan="6" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
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
               var total = fila.querySelector(".total");
               var stock = parseFloat(fila.querySelector("td:nth-child(6)").textContent);
               var stockDisponible = fila.querySelector(".stock-disponible");
               var totalCantidad = cpi * multiplicador;
               total.textContent = totalCantidad.toFixed(2);
               stockDisponible.textContent = (stock - totalCantidad).toFixed(2);
           });
       }

   
       function imprimirTabla() {
        var contenidoTabla = document.getElementById("tabla-productos").innerHTML;
        var ventanaImpresion = window.open("", "_blank");
        ventanaImpresion.document.write("<html><head><title>PIEZAS MAQUINADO CPI</title>");
        ventanaImpresion.document.write("<style>");
        ventanaImpresion.document.write("@media print {");
        ventanaImpresion.document.write("    table { page-break-inside: avoid; }");
        ventanaImpresion.document.write("}");
        ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
        ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; }");
        ventanaImpresion.document.write("th, td { border: 1px solid #000; padding: 8px; text-align: center; }");
        ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
        ventanaImpresion.document.write("</style>");
        ventanaImpresion.document.write("</head><body>");
        ventanaImpresion.document.write("<table>");
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
                $tabla .= "<li class='page-item " . ($i == $pagina ? "active" : "") . "'><a class='page-link' href='" . $url . $i . "'>$i</a></li>";
            }
            if ($pagina < $numeroPaginas) {
                $tabla .= "<li class='page-item'><a class='page-link' href='" . $url . ($pagina + 1) . "'>Siguiente</a></li>";
            }
            $tabla .= "</ul></nav>";
        }

        return $tabla;
    }

    /*----------  Controlador listar productos  ----------*/
    public function listarTormilleriaMaquinadosCpiControlador($pagina, $registros, $url, $busqueda)
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
       IF(cpi.nombre = 'CPI', pca.cantidad, 0) AS cantidad_cpi,
       sa.stock AS stock_almacen_general,
       IF(cpi.nombre = 'CPI', pca.cantidad, 0) * 1 AS total_cantidad
   FROM
       productos p
   JOIN categorias c ON p.id_categoria = c.id_categoria
   JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
   JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
   JOIN cpi_art_af cpi ON pca.id_cpi_art_af = cpi.id_cpi_art_af AND cpi.id_cpi_art_af = 1
   JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
   WHERE
       (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
       AND cpi.nombre = 'CPI' AND sc.id_subcategoria = 2
   GROUP BY p.id_producto
   ORDER BY p.codigo_producto ASC
   LIMIT $inicio, $registros;";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $consulta_total = "SELECT COUNT(DISTINCT p.id_producto)
   FROM productos p
   JOIN categorias c ON p.id_categoria = c.id_categoria
   JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
   JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
   JOIN cpi_art_af cpi ON pca.id_cpi_art_af = cpi.id_cpi_art_af
   JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
   WHERE (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
   AND cpi.nombre = 'CPI' AND sc.id_subcategoria = 2;";

        $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();

        $numeroPaginas = ceil($total / $registros);

        $tabla = '<div class="container-fluid p-4">
       <input type="number" id="multiplicador" value="1" min="1" oninput="calcularTotales()" class="form-control mb-3" style="width: 200px;">
       <button onclick="imprimirTabla()" class="btn btn-primary mb-3">Imprimir Tabla</button>
       <table id="tabla-productos" class="table table-bordered table-striped">
       <thead>
           <tr>
           <th>Imagen</th>
               <th>Código Producto</th>
               <th>Nombre Producto</th>
               <th>Cantidad</th>
               <th>Total</th>
               <th>Stock Almacén General</th>
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
                   <td class="total">' . htmlspecialchars($rows['total_cantidad']) . '</td>
                   <td>' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
                   <td class="stock-disponible"></td>
               </tr>';
            }
        } else {
            $tabla .= '<tr><td colspan="6" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
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
               var total = fila.querySelector(".total");
               var stock = parseFloat(fila.querySelector("td:nth-child(6)").textContent);
               var stockDisponible = fila.querySelector(".stock-disponible");
               var totalCantidad = cpi * multiplicador;
               total.textContent = totalCantidad.toFixed(2);
               stockDisponible.textContent = (stock - totalCantidad).toFixed(2);
           });
       }
   
       function imprimirTabla() {
        var contenidoTabla = document.getElementById("tabla-productos").innerHTML;
        var ventanaImpresion = window.open("", "_blank");
        ventanaImpresion.document.write("<html><head><title>TORNILLERIA MAQUINADOS CPI</title>");
        ventanaImpresion.document.write("<style>");
        ventanaImpresion.document.write("@media print {");
        ventanaImpresion.document.write("    table { page-break-inside: avoid; }");
        ventanaImpresion.document.write("}");
        ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
        ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; }");
        ventanaImpresion.document.write("th, td { border: 1px solid #000; padding: 8px; text-align: center; }");
        ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
        ventanaImpresion.document.write("</style>");
        ventanaImpresion.document.write("</head><body>");
        ventanaImpresion.document.write("<table>");
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
                $tabla .= "<li class='page-item " . ($i == $pagina ? "active" : "") . "'><a class='page-link' href='" . $url . $i . "'>$i</a></li>";
            }
            if ($pagina < $numeroPaginas) {
                $tabla .= "<li class='page-item'><a class='page-link' href='" . $url . ($pagina + 1) . "'>Siguiente</a></li>";
            }
            $tabla .= "</ul></nav>";
        }

        return $tabla;
    }

   public function listarTornilleriaExternaCpiControlador($pagina, $registros, $url, $busqueda)
{
    $pagina = intval($this->limpiarCadena($pagina));
    $registros = intval($this->limpiarCadena($registros));
    $url = $this->limpiarCadena($url);
    $url = APP_URL . $url . "/";
    $busqueda = $this->limpiarCadena($busqueda);

    $inicio = ($pagina > 0) ? (($pagina - 1) * $registros) : 0;

    // Consulta SQL con el precio y tipo de moneda añadidos
    $consulta_datos = "SELECT
       p.codigo_producto,
       p.nombre_producto,
       p.url_imagen,
       p.precio,  -- Columna para el precio del producto
       tm.nombre_moneda,  -- Columna añadida para mostrar el tipo de moneda
       IF(cpi.nombre = 'CPI', pca.cantidad, 0) AS cantidad_cpi,
       sa.stock AS stock_almacen_general,
       IF(cpi.nombre = 'CPI', pca.cantidad, 0) * 1 AS total_cantidad
   FROM
       productos p
   JOIN categorias c ON p.id_categoria = c.id_categoria
   JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
   JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
   JOIN cpi_art_af cpi ON pca.id_cpi_art_af = cpi.id_cpi_art_af AND cpi.id_cpi_art_af = 1
   JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
   JOIN tipos_moneda tm ON p.id_moneda = tm.id_moneda  -- JOIN para obtener el tipo de moneda
   WHERE
       (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
       AND cpi.nombre = 'CPI' AND sc.id_subcategoria = 1
   GROUP BY p.id_producto
   ORDER BY p.codigo_producto ASC
   LIMIT $inicio, $registros;";

    $datos = $this->ejecutarConsulta($consulta_datos);
    $datos = $datos->fetchAll();

    $consulta_total = "SELECT COUNT(DISTINCT p.id_producto)
   FROM productos p
   JOIN categorias c ON p.id_categoria = c.id_categoria
   JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
   JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
   JOIN cpi_art_af cpi ON pca.id_cpi_art_af = cpi.id_cpi_art_af
   JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
   WHERE (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
   AND cpi.nombre = 'CPI' AND sc.id_subcategoria = 1;";

    $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();

    $numeroPaginas = ceil($total / $registros);

    // Inicio de la tabla HTML
    $tabla = '<div class="container-fluid p-4">
       <input type="number" id="multiplicador" value="1" min="1" oninput="calcularTotales()" class="form-control mb-3" style="width: 200px;">
       <button onclick="imprimirTabla()" class="btn btn-primary mb-3">Imprimir Tabla</button>
       <table id="tabla-productos" class="table table-bordered table-striped">
       <thead>
           <tr>
               <th>Imagen</th>
               <th>Código Producto</th>
               <th>Nombre Producto</th>
               <th>Precio</th>
               <th>Moneda</th>  <!-- Nueva columna de moneda -->
               <th>Cantidad</th>
               <th>Total</th>
               <th>Stock Almacén General</th>
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
               <td>' . htmlspecialchars($rows['precio']) . '</td>  <!-- Mostrar precio -->
               <td>' . htmlspecialchars($rows['nombre_moneda']) . '</td>  <!-- Mostrar tipo de moneda -->
               <td class="cantidad-cpi">' . htmlspecialchars($rows['cantidad_cpi']) . '</td>
               <td class="total">' . htmlspecialchars($rows['total_cantidad']) . '</td>
               <td>' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
               <td class="stock-disponible"></td>
           </tr>';
        }
    } else {
        $tabla .= '<tr><td colspan="9" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
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
               var total = fila.querySelector(".total");
               var stock = parseFloat(fila.querySelector("td:nth-child(8)").textContent);
               var stockDisponible = fila.querySelector(".stock-disponible");
               var totalCantidad = cpi * multiplicador;
               total.textContent = totalCantidad.toFixed(2);
               stockDisponible.textContent = (stock - totalCantidad).toFixed(2);
           });
       }
   
       function imprimirTabla() {
        var contenidoTabla = document.getElementById("tabla-productos").innerHTML;
        var ventanaImpresion = window.open("", "_blank");
        ventanaImpresion.document.write("<html><head><title>TORNILLERIA COMPRA EXTERNA CPI</title>");
        ventanaImpresion.document.write("<style>");
        ventanaImpresion.document.write("@media print { table { page-break-inside: avoid; } }");
        ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
        ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; }");
        ventanaImpresion.document.write("th, td { border: 1px solid #000; padding: 8px; text-align: center; }");
        ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
        ventanaImpresion.document.write("</style>");
        ventanaImpresion.document.write("</head><body>");
        ventanaImpresion.document.write("<table>");
        ventanaImpresion.document.write("<tbody>");
        ventanaImpresion.document.write(contenidoTabla);
        ventanaImpresion.document.write("</tbody>");
        ventanaImpresion.document.write("</table>");
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
            $tabla .= "<li class='page-item " . ($i == $pagina ? "active" : "") . "'><a class='page-link' href='" . $url . $i . "'>$i</a></li>";
        }
        if ($pagina < $numeroPaginas) {
            $tabla .= "<li class='page-item'><a class='page-link' href='" . $url . ($pagina + 1) . "'>Siguiente</a></li>";
        }
        $tabla .= "</ul></nav>";
    }

    return $tabla;
}


    /*----------  Controlador listar productos  ----------*/
    public function listarPiezasCompraExternaCPIControlador($pagina, $registros, $url, $busqueda)
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
    IF(cpi.nombre = 'CPI', pca.cantidad, 0) AS cantidad_cpi,
    sa.stock AS stock_almacen_general,
    IF(cpi.nombre = 'CPI', pca.cantidad, 0) * 1 AS total_cantidad,
    p.precio,
    tm.nombre_moneda
FROM
    productos p
JOIN categorias c ON p.id_categoria = c.id_categoria
JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
JOIN cpi_art_af cpi ON pca.id_cpi_art_af = cpi.id_cpi_art_af AND cpi.id_cpi_art_af = 1
JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
JOIN tipos_moneda tm ON p.id_moneda = tm.id_moneda
WHERE
    (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
    AND cpi.nombre = 'CPI' AND sc.id_subcategoria = 4
GROUP BY p.id_producto
ORDER BY p.codigo_producto ASC
LIMIT $inicio, $registros;";


        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $consulta_total = "SELECT COUNT(DISTINCT p.id_producto)
   FROM productos p
   JOIN categorias c ON p.id_categoria = c.id_categoria
   JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
   JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
   JOIN cpi_art_af cpi ON pca.id_cpi_art_af = cpi.id_cpi_art_af
   JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
   WHERE (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
   AND cpi.nombre = 'CPI' AND sc.id_subcategoria = 4;";

        $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();

        $numeroPaginas = ceil($total / $registros);

        $tabla = '<div class="container-fluid p-4">
       <input type="number" id="multiplicador" value="1" min="1" oninput="calcularTotales()" class="form-control mb-3" style="width: 200px;">
       <button onclick="imprimirTabla()" class="btn btn-primary mb-3">Imprimir Tabla</button>
       <table id="tabla-productos" class="table table-bordered table-striped">
      <thead>
    <tr>
        <th>Imagen</th>
        <th>Código Producto</th>
        <th>Nombre Producto</th>
        <th>Cantidad</th>
        <th>Total</th>
        <th>Precio</th>
        <th>Moneda</th>
        <th>Stock Almacén General</th>
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
    <td class="total">' . htmlspecialchars($rows['total_cantidad']) . '</td>
    <td>' . htmlspecialchars($rows['precio']) . '</td>
    <td>' . htmlspecialchars($rows['nombre_moneda']) . '</td>
    <td>' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
    <td class="stock-disponible"></td>
</tr>';
            }
        } else {
            $tabla .= '<tr><td colspan="6" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
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
               var total = fila.querySelector(".total");
               var stock = parseFloat(fila.querySelector("td:nth-child(6)").textContent);
               var stockDisponible = fila.querySelector(".stock-disponible");
               var totalCantidad = cpi * multiplicador;
               total.textContent = totalCantidad.toFixed(2);
               stockDisponible.textContent = (stock - totalCantidad).toFixed(2);
           });
       }
   
       function imprimirTabla() {
        var contenidoTabla = document.getElementById("tabla-productos").innerHTML;
        var ventanaImpresion = window.open("", "_blank");
        ventanaImpresion.document.write("<html><head><title>PIEZAS COMPRA EXTERNA CPI</title>");
        ventanaImpresion.document.write("<style>");
        ventanaImpresion.document.write("@media print {");
        ventanaImpresion.document.write("    table { page-break-inside: avoid; }");
        ventanaImpresion.document.write("}");
        ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
        ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; }");
        ventanaImpresion.document.write("th, td { border: 1px solid #000; padding: 8px; text-align: center; }");
        ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
        ventanaImpresion.document.write("</style>");
        ventanaImpresion.document.write("</head><body>");
        ventanaImpresion.document.write("<table>");
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
                $tabla .= "<li class='page-item " . ($i == $pagina ? "active" : "") . "'><a class='page-link' href='" . $url . $i . "'>$i</a></li>";
            }
            if ($pagina < $numeroPaginas) {
                $tabla .= "<li class='page-item'><a class='page-link' href='" . $url . ($pagina + 1) . "'>Siguiente</a></li>";
            }
            $tabla .= "</ul></nav>";
        }

        return $tabla;
    }

    /*----------  Controlador listar productos  ----------*/
    public function listarPiezasMaquinadosArtControlador($pagina, $registros, $url, $busqueda)
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
    IF(articulador.nombre = 'ARTICULADOR', pca.cantidad, 0) AS cantidad_articulador,
    sa.stock AS stock_almacen_general,
    IF(articulador.nombre = 'ARTICULADOR', pca.cantidad, 0) * 1 AS total_cantidad
FROM
    productos p
JOIN categorias c ON p.id_categoria = c.id_categoria
JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
JOIN cpi_art_af articulador ON pca.id_cpi_art_af = articulador.id_cpi_art_af AND articulador.id_cpi_art_af = 2
JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
WHERE
    (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
    AND articulador.nombre = 'ARTICULADOR' AND sc.id_subcategoria = 3
GROUP BY p.id_producto
ORDER BY p.codigo_producto ASC
LIMIT $inicio, $registros;";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $consulta_total = "SELECT COUNT(DISTINCT p.id_producto)
FROM productos p
JOIN categorias c ON p.id_categoria = c.id_categoria
JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
JOIN cpi_art_af articulador ON pca.id_cpi_art_af = articulador.id_cpi_art_af
JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
WHERE (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
AND articulador.nombre = 'ARTICULADOR' AND sc.id_subcategoria = 3;";

        $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();

        $numeroPaginas = ceil($total / $registros);

        $tabla = '<div class="container-fluid p-4">
       <input type="number" id="multiplicador" value="1" min="1" oninput="calcularTotales()" class="form-control mb-3" style="width: 200px;">
       <button onclick="imprimirTabla()" class="btn btn-primary mb-3">Imprimir Tabla</button>
       <table id="tabla-productos" class="table table-bordered table-striped">
       <thead>
           <tr>
           <th>Imagen</th>
           <th>Código Producto</th>
               <th>Nombre Producto</th>
               <th>Cantidad</th>
               <th>Total</th>
               <th>Stock Almacén General</th>
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
                   <td class="cantidad-cpi">' . htmlspecialchars($rows['cantidad_articulador']) . '</td>
                   <td class="total">' . htmlspecialchars($rows['total_cantidad']) . '</td>
                   <td>' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
                   <td class="stock-disponible"></td>
               </tr>';
            }
        } else {
            $tabla .= '<tr><td colspan="6" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
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
               var total = fila.querySelector(".total");
               var stock = parseFloat(fila.querySelector("td:nth-child(6)").textContent);
               var stockDisponible = fila.querySelector(".stock-disponible");
               var totalCantidad = cpi * multiplicador;
               total.textContent = totalCantidad.toFixed(2);
               stockDisponible.textContent = (stock - totalCantidad).toFixed(2);
           });
       }
   
       function imprimirTabla() {
        var contenidoTabla = document.getElementById("tabla-productos").innerHTML;
        var ventanaImpresion = window.open("", "_blank");
        ventanaImpresion.document.write("<html><head><title>PIEZAS MAQUINADOS ARTICULADOR</title>");
        ventanaImpresion.document.write("<style>");
        ventanaImpresion.document.write("@media print {");
        ventanaImpresion.document.write("    table { page-break-inside: avoid; }");
        ventanaImpresion.document.write("}");
        ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
        ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; }");
        ventanaImpresion.document.write("th, td { border: 1px solid #000; padding: 8px; text-align: center; }");
        ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
        ventanaImpresion.document.write("</style>");
        ventanaImpresion.document.write("</head><body>");
        ventanaImpresion.document.write("<table>");
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
                $tabla .= "<li class='page-item " . ($i == $pagina ? "active" : "") . "'><a class='page-link' href='" . $url . $i . "'>$i</a></li>";
            }
            if ($pagina < $numeroPaginas) {
                $tabla .= "<li class='page-item'><a class='page-link' href='" . $url . ($pagina + 1) . "'>Siguiente</a></li>";
            }
            $tabla .= "</ul></nav>";
        }

        return $tabla;
    }

    /*----------  Controlador listar productos  ----------*/
    public function listarTornilleriaMaquinadosArtControlador($pagina, $registros, $url, $busqueda)
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
  IF(articulador.nombre = 'ARTICULADOR', pca.cantidad, 0) AS cantidad_articulador,
  sa.stock AS stock_almacen_general,
  IF(articulador.nombre = 'ARTICULADOR', pca.cantidad, 0) * 1 AS total_cantidad
FROM
  productos p
JOIN categorias c ON p.id_categoria = c.id_categoria
JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
JOIN cpi_art_af articulador ON pca.id_cpi_art_af = articulador.id_cpi_art_af AND articulador.id_cpi_art_af = 2
JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
WHERE
  (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
  AND articulador.nombre = 'ARTICULADOR' AND sc.id_subcategoria = 2
GROUP BY p.id_producto
ORDER BY p.codigo_producto ASC
LIMIT $inicio, $registros;";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $consulta_total = "SELECT COUNT(DISTINCT p.id_producto)
FROM productos p
JOIN categorias c ON p.id_categoria = c.id_categoria
JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
JOIN cpi_art_af articulador ON pca.id_cpi_art_af = articulador.id_cpi_art_af
JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
WHERE (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
AND articulador.nombre = 'ARTICULADOR' AND sc.id_subcategoria = 2;";

        $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();

        $numeroPaginas = ceil($total / $registros);

        $tabla = '<div class="container-fluid p-4">
     <input type="number" id="multiplicador" value="1" min="1" oninput="calcularTotales()" class="form-control mb-3" style="width: 200px;">
     <button onclick="imprimirTabla()" class="btn btn-primary mb-3">Imprimir Tabla</button>
     <table id="tabla-productos" class="table table-bordered table-striped">
     <thead>
         <tr>
         <th>Imagen</th>
             <th>Código Producto</th>
             <th>Nombre Producto</th>
             <th>Cantidad</th>
             <th>Total</th>
             <th>Stock Almacén General</th>
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
                 <td class="cantidad-cpi">' . htmlspecialchars($rows['cantidad_articulador']) . '</td>
                 <td class="total">' . htmlspecialchars($rows['total_cantidad']) . '</td>
                 <td>' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
                 <td class="stock-disponible"></td>
             </tr>';
            }
        } else {
            $tabla .= '<tr><td colspan="6" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
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
             var total = fila.querySelector(".total");
             var stock = parseFloat(fila.querySelector("td:nth-child(6)").textContent);
             var stockDisponible = fila.querySelector(".stock-disponible");
             var totalCantidad = cpi * multiplicador;
             total.textContent = totalCantidad.toFixed(2);
             stockDisponible.textContent = (stock - totalCantidad).toFixed(2);
         });
     }
 
     function imprimirTabla() {
      var contenidoTabla = document.getElementById("tabla-productos").innerHTML;
      var ventanaImpresion = window.open("", "_blank");
      ventanaImpresion.document.write("<html><head><title>TORNILLERIA MAQUINADOS ARTICULADOR</title>");
      ventanaImpresion.document.write("<style>");
      ventanaImpresion.document.write("@media print {");
      ventanaImpresion.document.write("    table { page-break-inside: avoid; }");
      ventanaImpresion.document.write("}");
      ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
      ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; }");
      ventanaImpresion.document.write("th, td { border: 1px solid #000; padding: 8px; text-align: center; }");
      ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
      ventanaImpresion.document.write("</style>");
      ventanaImpresion.document.write("</head><body>");
      ventanaImpresion.document.write("<table>");
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
                $tabla .= "<li class='page-item " . ($i == $pagina ? "active" : "") . "'><a class='page-link' href='" . $url . $i . "'>$i</a></li>";
            }
            if ($pagina < $numeroPaginas) {
                $tabla .= "<li class='page-item'><a class='page-link' href='" . $url . ($pagina + 1) . "'>Siguiente</a></li>";
            }
            $tabla .= "</ul></nav>";
        }

        return $tabla;
    }


    public function listarTornilleriaExternaArticuladorControlador($pagina, $registros, $url, $busqueda)
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
        IF(articulador.nombre = 'ARTICULADOR', pca.cantidad, 0) AS cantidad_articulador,
        sa.stock AS stock_almacen_general,
        IF(articulador.nombre = 'ARTICULADOR', pca.cantidad, 0) * 1 AS total_cantidad,
        p.precio,
        tm.nombre_moneda
    FROM
        productos p
    JOIN categorias c ON p.id_categoria = c.id_categoria
    JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
    JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
    JOIN cpi_art_af articulador ON pca.id_cpi_art_af = articulador.id_cpi_art_af AND articulador.id_cpi_art_af = 2
    JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
    JOIN tipos_moneda tm ON p.id_moneda = tm.id_moneda
    WHERE
        (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
        AND articulador.nombre = 'ARTICULADOR' AND sc.id_subcategoria = 1
    GROUP BY p.id_producto
    ORDER BY p.codigo_producto ASC
    LIMIT $inicio, $registros;";
    
        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();
    
        $consulta_total = "SELECT COUNT(DISTINCT p.id_producto)
    FROM productos p
    JOIN categorias c ON p.id_categoria = c.id_categoria
    JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
    JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
    JOIN cpi_art_af articulador ON pca.id_cpi_art_af = articulador.id_cpi_art_af
    JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
    WHERE (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
    AND articulador.nombre = 'ARTICULADOR' AND sc.id_subcategoria = 1;";
    
        $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();
    
        $numeroPaginas = ceil($total / $registros);
    
        $tabla = '<div class="container-fluid p-4">
        <input type="number" id="multiplicador" value="1" min="1" oninput="calcularTotales()" class="form-control mb-3" style="width: 200px;">
        <button onclick="imprimirTabla()" class="btn btn-primary mb-3">Imprimir Tabla</button>
        <table id="tabla-productos" class="table table-bordered table-striped">
        <thead>
            <tr>
            <th>Imagen</th>
                <th>Código Producto</th>
                <th>Nombre Producto</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Precio</th>
                <th>Moneda</th>
                <th>Stock Almacén General</th>
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
                    <td class="cantidad-cpi">' . htmlspecialchars($rows['cantidad_articulador']) . '</td>
                    <td class="total">' . htmlspecialchars($rows['total_cantidad']) . '</td>
                    <td>' . htmlspecialchars($rows['precio']) . '</td>
                    <td>' . htmlspecialchars($rows['nombre_moneda']) . '</td>
                    <td>' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
                    <td class="stock-disponible"></td>
                </tr>';
            }
        } else {
            $tabla .= '<tr><td colspan="9" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
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
                var total = fila.querySelector(".total");
                var stock = parseFloat(fila.querySelector("td:nth-child(8)").textContent);
                var stockDisponible = fila.querySelector(".stock-disponible");
                var totalCantidad = cpi * multiplicador;
                total.textContent = totalCantidad.toFixed(2);
                stockDisponible.textContent = (stock - totalCantidad).toFixed(2);
            });
        }
    
        function imprimirTabla() {
            var contenidoTabla = document.getElementById("tabla-productos").innerHTML;
            var ventanaImpresion = window.open("", "_blank");
            ventanaImpresion.document.write("<html><head><title>TORNILLERIA COMPRA EXTERNA ARTICULADOR</title>");
            ventanaImpresion.document.write("<style>");
            ventanaImpresion.document.write("@media print {");
            ventanaImpresion.document.write("    table { page-break-inside: avoid; }");
            ventanaImpresion.document.write("}");
            ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
            ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; }");
            ventanaImpresion.document.write("th, td { border: 1px solid #000; padding: 8px; text-align: center; }");
            ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
            ventanaImpresion.document.write("</style>");
            ventanaImpresion.document.write("</head><body>");
            ventanaImpresion.document.write("<table>");
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
                $tabla .= "<li class='page-item " . ($i == $pagina ? "active" : "") . "'><a class='page-link' href='" . $url . $i . "'>$i</a></li>";
            }
            if ($pagina < $numeroPaginas) {
                $tabla .= "<li class='page-item'><a class='page-link' href='" . $url . ($pagina + 1) . "'>Siguiente</a></li>";
            }
            $tabla .= "</ul></nav>";
        }
    
        return $tabla;
    }


    /*----------  Controlador listar productos  ----------*/
    public function listarPiezasCompraExternaArticuladorControlador($pagina, $registros, $url, $busqueda)
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
  IF(articulador.nombre = 'ARTICULADOR', pca.cantidad, 0) AS cantidad_articulador,
  sa.stock AS stock_almacen_general,
  IF(articulador.nombre = 'ARTICULADOR', pca.cantidad, 0) * 1 AS total_cantidad,
  p.precio,  /* Precio agregado */
  tm.nombre_moneda  /* Moneda agregada */
FROM
  productos p
JOIN categorias c ON p.id_categoria = c.id_categoria
JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
JOIN cpi_art_af articulador ON pca.id_cpi_art_af = articulador.id_cpi_art_af AND articulador.id_cpi_art_af = 2
JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
JOIN tipos_moneda tm ON p.id_moneda = tm.id_moneda  /* Join para obtener la moneda */
WHERE
  (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
  AND articulador.nombre = 'ARTICULADOR' AND sc.id_subcategoria = 4
GROUP BY p.id_producto
ORDER BY p.codigo_producto ASC
LIMIT $inicio, $registros;";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $consulta_total = "SELECT COUNT(DISTINCT p.id_producto)
FROM productos p
JOIN categorias c ON p.id_categoria = c.id_categoria
JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
JOIN cpi_art_af articulador ON pca.id_cpi_art_af = articulador.id_cpi_art_af
JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
WHERE (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
AND articulador.nombre = 'ARTICULADOR' AND sc.id_subcategoria = 4;";

        $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();

        $numeroPaginas = ceil($total / $registros);

        $tabla = '<div class="container-fluid p-4">
        <input type="number" id="multiplicador" value="1" min="1" oninput="calcularTotales()" class="form-control mb-3" style="width: 200px;">
        <button onclick="imprimirTabla()" class="btn btn-primary mb-3">Imprimir Tabla</button>
        <table id="tabla-productos" class="table table-bordered table-striped">
        <thead>
            <tr>
            <th>Imagen</th>
                <th>Código Producto</th>
                <th>Nombre Producto</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Precio</th>  <!-- Columna de precio agregada -->
                <th>Moneda</th>  <!-- Columna de moneda agregada -->
                <th>Stock Almacén General</th>
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
                <td class="cantidad-cpi">' . htmlspecialchars($rows['cantidad_articulador']) . '</td>
                <td class="total">' . htmlspecialchars($rows['total_cantidad']) . '</td>
                <td>' . htmlspecialchars($rows['precio']) . '</td>  <!-- Precio agregado -->
                <td>' . htmlspecialchars($rows['nombre_moneda']) . '</td>  <!-- Moneda agregada -->
                <td>' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
                <td class="stock-disponible"></td>
            </tr>';
           }
       } else {
           $tabla .= '<tr><td colspan="9" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
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
                var total = fila.querySelector(".total");
                var stock = parseFloat(fila.querySelector("td:nth-child(8)").textContent); // Cambiado a la columna correcta
                var stockDisponible = fila.querySelector(".stock-disponible");
                var totalCantidad = cpi * multiplicador;
                total.textContent = totalCantidad.toFixed(2);
                stockDisponible.textContent = (stock - totalCantidad).toFixed(2);
            });
        }
 
     function imprimirTabla() {
      var contenidoTabla = document.getElementById("tabla-productos").innerHTML;
      var ventanaImpresion = window.open("", "_blank");
      ventanaImpresion.document.write("<html><head><title>PIEZAS COMPRA EXTERNA ARTICULADOR</title>");
      ventanaImpresion.document.write("<style>");
      ventanaImpresion.document.write("@media print {");
      ventanaImpresion.document.write("    table { page-break-inside: avoid; }");
      ventanaImpresion.document.write("}");
      ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
      ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; }");
      ventanaImpresion.document.write("th, td { border: 1px solid #000; padding: 8px; text-align: center; }");
      ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
      ventanaImpresion.document.write("</style>");
      ventanaImpresion.document.write("</head><body>");
      ventanaImpresion.document.write("<table>");
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
                $tabla .= "<li class='page-item " . ($i == $pagina ? "active" : "") . "'><a class='page-link' href='" . $url . $i . "'>$i</a></li>";
            }
            if ($pagina < $numeroPaginas) {
                $tabla .= "<li class='page-item'><a class='page-link' href='" . $url . ($pagina + 1) . "'>Siguiente</a></li>";
            }
            $tabla .= "</ul></nav>";
        }

        return $tabla;
    }



    /*----------  Controlador listar productos  ----------*/
    public function listarPiezasMaquinadosArcoControlador($pagina, $registros, $url, $busqueda)
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
    IF(arco.nombre = 'ARCO', pca.cantidad, 0) AS cantidad_arco,
    sa.stock AS stock_almacen_general,
    IF(arco.nombre = 'ARCO', pca.cantidad, 0) * 1 AS total_cantidad
FROM
    productos p
JOIN categorias c ON p.id_categoria = c.id_categoria
JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
JOIN cpi_art_af arco ON pca.id_cpi_art_af = arco.id_cpi_art_af AND arco.id_cpi_art_af = 3
JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
WHERE
    (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
    AND arco.nombre = 'ARCO' AND sc.id_subcategoria = 3
GROUP BY p.id_producto
ORDER BY p.codigo_producto ASC
LIMIT $inicio, $registros;";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $consulta_total = "SELECT COUNT(DISTINCT p.id_producto)
FROM productos p
JOIN categorias c ON p.id_categoria = c.id_categoria
JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
JOIN cpi_art_af arco ON pca.id_cpi_art_af = arco.id_cpi_art_af
JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
WHERE (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
AND arco.nombre = 'ARCO' AND sc.id_subcategoria = 3;";

        $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();

        $numeroPaginas = ceil($total / $registros);

        $tabla = '<div class="container-fluid p-4">
       <input type="number" id="multiplicador" value="1" min="1" oninput="calcularTotales()" class="form-control mb-3" style="width: 200px;">
       <button onclick="imprimirTabla()" class="btn btn-primary mb-3">Imprimir Tabla</button>
       <table id="tabla-productos" class="table table-bordered table-striped">
       <thead>
           <tr>
           <th>Imagen</th>
               <th>Código Producto</th>
               <th>Nombre Producto</th>
               <th>Cantidad</th>
               <th>Total</th>
               <th>Stock Almacén General</th>
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
                   <td class="cantidad-cpi">' . htmlspecialchars($rows['cantidad_arco']) . '</td>
                   <td class="total">' . htmlspecialchars($rows['total_cantidad']) . '</td>
                   <td>' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
                   <td class="stock-disponible"></td>
               </tr>';
            }
        } else {
            $tabla .= '<tr><td colspan="6" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
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
               var total = fila.querySelector(".total");
               var stock = parseFloat(fila.querySelector("td:nth-child(6)").textContent);
               var stockDisponible = fila.querySelector(".stock-disponible");
               var totalCantidad = cpi * multiplicador;
               total.textContent = totalCantidad.toFixed(2);
               stockDisponible.textContent = (stock - totalCantidad).toFixed(2);
           });
       }
   
       function imprimirTabla() {
        var contenidoTabla = document.getElementById("tabla-productos").innerHTML;
        var ventanaImpresion = window.open("", "_blank");
        ventanaImpresion.document.write("<html><head><title>PIEZAS MAQUINADOS ARCO FACIAL</title>");
        ventanaImpresion.document.write("<style>");
        ventanaImpresion.document.write("@media print {");
        ventanaImpresion.document.write("    table { page-break-inside: avoid; }");
        ventanaImpresion.document.write("}");
        ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
        ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; }");
        ventanaImpresion.document.write("th, td { border: 1px solid #000; padding: 8px; text-align: center; }");
        ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
        ventanaImpresion.document.write("</style>");
        ventanaImpresion.document.write("</head><body>");
        ventanaImpresion.document.write("<table>");
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
                $tabla .= "<li class='page-item " . ($i == $pagina ? "active" : "") . "'><a class='page-link' href='" . $url . $i . "'>$i</a></li>";
            }
            if ($pagina < $numeroPaginas) {
                $tabla .= "<li class='page-item'><a class='page-link' href='" . $url . ($pagina + 1) . "'>Siguiente</a></li>";
            }
            $tabla .= "</ul></nav>";
        }

        return $tabla;
    }



    /*----------  Controlador listar productos  ----------*/
    public function listarTornilleriaMaquinadosArcoControlador($pagina, $registros, $url, $busqueda)
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
  IF(arco.nombre = 'ARCO', pca.cantidad, 0) AS cantidad_arco,
  sa.stock AS stock_almacen_general,
  IF(arco.nombre = 'ARCO', pca.cantidad, 0) * 1 AS total_cantidad
FROM
  productos p
JOIN categorias c ON p.id_categoria = c.id_categoria
JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
JOIN cpi_art_af arco ON pca.id_cpi_art_af = arco.id_cpi_art_af AND arco.id_cpi_art_af = 3
JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
WHERE
  (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
  AND arco.nombre = 'ARCO' AND sc.id_subcategoria = 2
GROUP BY p.id_producto
ORDER BY p.codigo_producto ASC
LIMIT $inicio, $registros;";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $consulta_total = "SELECT COUNT(DISTINCT p.id_producto)
FROM productos p
JOIN categorias c ON p.id_categoria = c.id_categoria
JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
JOIN cpi_art_af arco ON pca.id_cpi_art_af = arco.id_cpi_art_af
JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
WHERE (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
AND arco.nombre = 'ARTICULADOR' AND sc.id_subcategoria = 2;";

        $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();

        $numeroPaginas = ceil($total / $registros);

        $tabla = '<div class="container-fluid p-4">
     <input type="number" id="multiplicador" value="1" min="1" oninput="calcularTotales()" class="form-control mb-3" style="width: 200px;">
     <button onclick="imprimirTabla()" class="btn btn-primary mb-3">Imprimir Tabla</button>
     <table id="tabla-productos" class="table table-bordered table-striped">
     <thead>
         <tr>
         <th>Imagen</th>
             <th>Código Producto</th>
             <th>Nombre Producto</th>
             <th>Cantidad</th>
             <th>Total</th>
             <th>Stock Almacén General</th>
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
                 <td class="cantidad-cpi">' . htmlspecialchars($rows['cantidad_arco']) . '</td>
                 <td class="total">' . htmlspecialchars($rows['total_cantidad']) . '</td>
                 <td>' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
                 <td class="stock-disponible"></td>
             </tr>';
            }
        } else {
            $tabla .= '<tr><td colspan="6" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
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
             var total = fila.querySelector(".total");
             var stock = parseFloat(fila.querySelector("td:nth-child(6)").textContent);
             var stockDisponible = fila.querySelector(".stock-disponible");
             var totalCantidad = cpi * multiplicador;
             total.textContent = totalCantidad.toFixed(2);
             stockDisponible.textContent = (stock - totalCantidad).toFixed(2);
         });
     }
 
     function imprimirTabla() {
      var contenidoTabla = document.getElementById("tabla-productos").innerHTML;
      var ventanaImpresion = window.open("", "_blank");
      ventanaImpresion.document.write("<html><head><title>TORNILLERIA MAQUINADOS ARCO</title>");
      ventanaImpresion.document.write("<style>");
      ventanaImpresion.document.write("@media print {");
      ventanaImpresion.document.write("    table { page-break-inside: avoid; }");
      ventanaImpresion.document.write("}");
      ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
      ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; }");
      ventanaImpresion.document.write("th, td { border: 1px solid #000; padding: 8px; text-align: center; }");
      ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
      ventanaImpresion.document.write("</style>");
      ventanaImpresion.document.write("</head><body>");
      ventanaImpresion.document.write("<table>");
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
                $tabla .= "<li class='page-item " . ($i == $pagina ? "active" : "") . "'><a class='page-link' href='" . $url . $i . "'>$i</a></li>";
            }
            if ($pagina < $numeroPaginas) {
                $tabla .= "<li class='page-item'><a class='page-link' href='" . $url . ($pagina + 1) . "'>Siguiente</a></li>";
            }
            $tabla .= "</ul></nav>";
        }

        return $tabla;
    }



    /*----------  Controlador listar productos  ----------*/
    public function listarTornilleriaExternaArcoControlador($pagina, $registros, $url, $busqueda)
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
          IF(arco.nombre = 'ARCO', pca.cantidad, 0) AS cantidad_arco,
          sa.stock AS stock_almacen_general,
          IF(arco.nombre = 'ARCO', pca.cantidad, 0) * 1 AS total_cantidad,
          p.precio,  -- Agregamos el campo de precio
          tm.nombre_moneda -- Agregamos el campo de moneda
        FROM
          productos p
        JOIN categorias c ON p.id_categoria = c.id_categoria
        JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
        JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
        JOIN cpi_art_af arco ON pca.id_cpi_art_af = arco.id_cpi_art_af AND arco.id_cpi_art_af = 3
        JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
        JOIN tipos_moneda tm ON p.id_moneda = tm.id_moneda -- Relación con la tabla de moneda
        WHERE
          (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
          AND arco.nombre = 'ARCO' AND sc.id_subcategoria = 1
        GROUP BY p.id_producto
        ORDER BY p.codigo_producto ASC
        LIMIT $inicio, $registros;";
    
        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();
    
        $consulta_total = "SELECT COUNT(DISTINCT p.id_producto)
        FROM productos p
        JOIN categorias c ON p.id_categoria = c.id_categoria
        JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
        JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
        JOIN cpi_art_af arco ON pca.id_cpi_art_af = arco.id_cpi_art_af
        JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
        WHERE (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
        AND arco.nombre = 'ARCO' AND sc.id_subcategoria = 1;";
    
        $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();
    
        $numeroPaginas = ceil($total / $registros);
    
        $tabla = '<div class="container-fluid p-4">
         <input type="number" id="multiplicador" value="1" min="1" oninput="calcularTotales()" class="form-control mb-3" style="width: 200px;">
         <button onclick="imprimirTabla()" class="btn btn-primary mb-3">Imprimir Tabla</button>
         <table id="tabla-productos" class="table table-bordered table-striped">
         <thead>
             <tr>
             <th>Imagen</th>
                 <th>Código Producto</th>
                 <th>Nombre Producto</th>
                 <th>Cantidad</th>
                 <th>Total</th>
                 <th>Stock Almacén General</th>
                 <th>Stock Restante</th>
                 <th>Precio</th> <!-- Nueva columna -->
                 <th>Moneda</th> <!-- Nueva columna -->
             </tr>
         </thead>
         <tbody>';
    
        if ($total > 0) {
            foreach ($datos as $rows) {
                $tabla .= '<tr>
                <td><img src="' . APP_URL . 'app/views/img/img/' . htmlspecialchars($rows['url_imagen']) . '" alt="' . htmlspecialchars($rows['nombre_producto']) . '" style="width: 50px; height: 50px;"></td>
                 <td>' . htmlspecialchars($rows['codigo_producto']) . '</td>
                 <td>' . htmlspecialchars($rows['nombre_producto']) . '</td>
                 <td class="cantidad-cpi">' . htmlspecialchars($rows['cantidad_arco']) . '</td>
                 <td class="total">' . htmlspecialchars($rows['total_cantidad']) . '</td>
                 <td>' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
                 <td class="stock-disponible"></td>
                 <td>' . htmlspecialchars($rows['precio']) . '</td> <!-- Mostrar precio -->
                 <td>' . htmlspecialchars($rows['nombre_moneda']) . '</td> <!-- Mostrar moneda -->
             </tr>';
            }
        } else {
            $tabla .= '<tr><td colspan="9" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
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
             var total = fila.querySelector(".total");
             var stock = parseFloat(fila.querySelector("td:nth-child(6)").textContent);
             var stockDisponible = fila.querySelector(".stock-disponible");
             var totalCantidad = cpi * multiplicador;
             total.textContent = totalCantidad.toFixed(2);
             stockDisponible.textContent = (stock - totalCantidad).toFixed(2);
         });
     }
 
     function imprimirTabla() {
      var contenidoTabla = document.getElementById("tabla-productos").innerHTML;
      var ventanaImpresion = window.open("", "_blank");
      ventanaImpresion.document.write("<html><head><title>TORNILLERIA COMPRA EXTERNA ARCO</title>");
      ventanaImpresion.document.write("<style>");
      ventanaImpresion.document.write("@media print {");
      ventanaImpresion.document.write("    table { page-break-inside: avoid; }");
      ventanaImpresion.document.write("}");
      ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
      ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; }");
      ventanaImpresion.document.write("th, td { border: 1px solid #000; padding: 8px; text-align: center; }");
      ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
      ventanaImpresion.document.write("</style>");
      ventanaImpresion.document.write("</head><body>");
      ventanaImpresion.document.write("<table>");
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
                $tabla .= "<li class='page-item " . ($i == $pagina ? "active" : "") . "'><a class='page-link' href='" . $url . $i . "'>$i</a></li>";
            }
            if ($pagina < $numeroPaginas) {
                $tabla .= "<li class='page-item'><a class='page-link' href='" . $url . ($pagina + 1) . "'>Siguiente</a></li>";
            }
            $tabla .= "</ul></nav>";
        }

        return $tabla;
    }


    public function listarPiezasCompraExternaArcoControlador($pagina, $registros, $url, $busqueda)
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
            IF(arco.nombre = 'ARCO', pca.cantidad, 0) AS cantidad_arco,
            sa.stock AS stock_almacen_general,
            IF(arco.nombre = 'ARCO', pca.cantidad, 0) * 1 AS total_cantidad,
            p.precio,
            tm.nombre_moneda
        FROM
            productos p
        JOIN categorias c ON p.id_categoria = c.id_categoria
        JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
        JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
        JOIN cpi_art_af arco ON pca.id_cpi_art_af = arco.id_cpi_art_af AND arco.id_cpi_art_af = 3
        JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
        JOIN tipos_moneda tm ON p.id_moneda = tm.id_moneda
        WHERE
            (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
            AND arco.nombre = 'ARCO' AND sc.id_subcategoria = 4
        GROUP BY p.id_producto
        ORDER BY p.codigo_producto ASC
        LIMIT $inicio, $registros;";
    
        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();
    
        $consulta_total = "SELECT COUNT(DISTINCT p.id_producto)
        FROM productos p
        JOIN categorias c ON p.id_categoria = c.id_categoria
        JOIN sub_categorias sc ON p.id_subcategoria = sc.id_subcategoria
        JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
        JOIN cpi_art_af arco ON pca.id_cpi_art_af = arco.id_cpi_art_af
        JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
        WHERE (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
        AND arco.nombre = 'ARCO' AND sc.id_subcategoria = 4;";
    
        $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();
    
        $numeroPaginas = ceil($total / $registros);
    
        $tabla = '<div class="container-fluid p-4">
         <input type="number" id="multiplicador" value="1" min="1" oninput="calcularTotales()" class="form-control mb-3" style="width: 200px;">
         <button onclick="imprimirTabla()" class="btn btn-primary mb-3">Imprimir Tabla</button>
         <table id="tabla-productos" class="table table-bordered table-striped">
         <thead>
             <tr>
             <th>Imagen</th>
                 <th>Código Producto</th>
                 <th>Nombre Producto</th>
                 <th>Cantidad</th>
                 <th>Total</th>
                 <th>Stock Almacén General</th>
                 <th>Stock Restante</th>
                 <th>Precio</th>
                 <th>Moneda</th>
             </tr>
         </thead>
         <tbody>';
    
        if ($total > 0) {
            foreach ($datos as $rows) {
                $tabla .= '<tr>
                    <td><img src="' . APP_URL . 'app/views/img/img/' . htmlspecialchars($rows['url_imagen']) . '" alt="' . htmlspecialchars($rows['nombre_producto']) . '" style="width: 50px; height: 50px;"></td>
                    <td>' . htmlspecialchars($rows['codigo_producto']) . '</td>
                    <td>' . htmlspecialchars($rows['nombre_producto']) . '</td>
                    <td class="cantidad-cpi">' . htmlspecialchars($rows['cantidad_arco']) . '</td>
                    <td class="total">' . htmlspecialchars($rows['total_cantidad']) . '</td>
                    <td>' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
                    <td class="stock-disponible"></td>
                    <td>' . htmlspecialchars($rows['precio']) . '</td>
                    <td>' . htmlspecialchars($rows['nombre_moneda']) . '</td>
                </tr>';
            }
        } else {
            $tabla .= '<tr><td colspan="9" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
        }
    
        $tabla .= '</tbody></table>';
        $tabla .= '</div>';
    
        // JavaScript para calcular totales dinámicamente (sin cambios)
        $tabla .= '<script>
        function calcularTotales() {
            var multiplicador = document.getElementById("multiplicador").value;
            var filas = document.querySelectorAll("tbody tr");
            filas.forEach(function(fila) {
                var cpi = parseFloat(fila.querySelector(".cantidad-cpi").textContent) || 0;
                var total = fila.querySelector(".total");
                var stock = parseFloat(fila.querySelector("td:nth-child(6)").textContent);
                var stockDisponible = fila.querySelector(".stock-disponible");
                var totalCantidad = cpi * multiplicador;
                total.textContent = totalCantidad.toFixed(2);
                stockDisponible.textContent = (stock - totalCantidad).toFixed(2);
            });
        }
    
        function imprimirTabla() {
         var contenidoTabla = document.getElementById("tabla-productos").innerHTML;
         var ventanaImpresion = window.open("", "_blank");
         ventanaImpresion.document.write("<html><head><title>PIEZAS COMPRA EXTERNA ARCO</title>");
         ventanaImpresion.document.write("<style>");
         ventanaImpresion.document.write("@media print {");
         ventanaImpresion.document.write("    table { page-break-inside: avoid; }");
         ventanaImpresion.document.write("}");
         ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
         ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; }");
         ventanaImpresion.document.write("th, td { border: 1px solid #000; padding: 8px; text-align: center; }");
         ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
         ventanaImpresion.document.write("</style>");
         ventanaImpresion.document.write("</head><body>");
         ventanaImpresion.document.write("<table>");
         ventanaImpresion.document.write("<tbody>");
         ventanaImpresion.document.write(contenidoTabla);
         ventanaImpresion.document.write("</tbody>");
         ventanaImpresion.document.write("</table>");
         ventanaImpresion.document.write("</body></html>");
         ventanaImpresion.document.close();
         ventanaImpresion.print();
     }
        </script>';
    
        // Paginación (sin cambios)
        if ($total > 0 && $numeroPaginas > 1) {
            $tabla .= "<nav><ul class='pagination'>";
            if ($pagina > 1) {
                $tabla .= "<li class='page-item'><a class='page-link' href='" . $url . ($pagina - 1) . "'>Anterior</a></li>";
            }
            for ($i = 1; $i <= $numeroPaginas; $i++) {
                $tabla .= "<li class='page-item " . ($i == $pagina ? "active" : "") . "'><a class='page-link' href='" . $url . $i . "'>$i</a></li>";
            }
            if ($pagina < $numeroPaginas) {
                $tabla .= "<li class='page-item'><a class='page-link' href='" . $url . ($pagina + 1) . "'>Siguiente</a></li>";
            }
            $tabla .= "</ul></nav>";
        }
    
        return $tabla;
    }


}