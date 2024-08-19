<?php

namespace app\controllers;

use app\models\mainModel;

class kitMaquinadosController extends mainModel
{

    
   /*----------  Controlador listar productos  ----------*/
 public function listarKitMaquinadosControlador($pagina, $registros, $url, $busqueda)
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
        COALESCE(sa_general.stock, 0) AS stock_almacen_general,
        COALESCE(sa_ensamble.stock, 0) AS stock_area_ensamble,
        COALESCE(sa_descarte.stock, 0) AS stock_descartes,
        COALESCE(SUM(CASE WHEN cpi.id_cpi_art_af = 1 THEN pca.cantidad END), 0) AS cantidad_cpi,
        COALESCE(SUM(CASE WHEN cpi.id_cpi_art_af = 2 THEN pca.cantidad END), 0) AS cantidad_articulador,
        COALESCE(SUM(CASE WHEN cpi.id_cpi_art_af = 3 THEN pca.cantidad END), 0) AS cantidad_arco_facial,
        COALESCE(SUM(CASE WHEN cpi.id_cpi_art_af = 4 THEN pca.cantidad END), 0) AS cantidad_empaque
    FROM
        productos p
    JOIN categorias c ON p.id_categoria = c.id_categoria
    JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
    JOIN cpi_art_af cpi ON pca.id_cpi_art_af = cpi.id_cpi_art_af
    JOIN sub_categorias s ON p.id_subcategoria = s.id_subcategoria
    LEFT JOIN stock_almacen sa_general ON p.id_producto = sa_general.id_producto AND sa_general.id_almacen = 1
    LEFT JOIN stock_almacen sa_ensamble ON p.id_producto = sa_ensamble.id_producto AND sa_ensamble.id_almacen = 3
    LEFT JOIN stock_almacen sa_descarte ON p.id_producto = sa_descarte.id_producto AND sa_descarte.id_almacen = 8
    WHERE
        (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
        AND s.nombre_subcategoria = 'PIEZAS KIT MAQUINADOS'
    GROUP BY p.id_producto, p.codigo_producto, p.nombre_producto, p.url_imagen, sa_general.stock, sa_ensamble.stock, sa_descarte.stock
    ORDER BY p.codigo_producto ASC
    LIMIT $inicio, $registros;";

    $datos = $this->ejecutarConsulta($consulta_datos);
    $datos = $datos->fetchAll();

    $consulta_total = "SELECT COUNT(DISTINCT p.id_producto)
    FROM productos p
    JOIN categorias c ON p.id_categoria = c.id_categoria
    JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
    JOIN cpi_art_af cpi ON pca.id_cpi_art_af = cpi.id_cpi_art_af
    JOIN sub_categorias s ON p.id_subcategoria = s.id_subcategoria
    LEFT JOIN stock_almacen sa_general ON p.id_producto = sa_general.id_producto AND sa_general.id_almacen = 1
    LEFT JOIN stock_almacen sa_ensamble ON p.id_producto = sa_ensamble.id_producto AND sa_ensamble.id_almacen = 3
    LEFT JOIN stock_almacen sa_descarte ON p.id_producto = sa_descarte.id_producto AND sa_descarte.id_almacen = 8
    WHERE (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
    AND s.nombre_subcategoria = 'PIEZAS KIT MAQUINADOS';";
    $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();

    $numeroPaginas = ceil($total / $registros);

    $tabla = '<div class="container-fluid p-4">
    <input type="number" id="multiplicador" value="1" min="1" oninput="calcularTotales()" class="form-control mb-3" style="width: 200px;">
    <button onclick="imprimirTabla()" class="btn btn-primary mb-3">Imprimir Tabla</button>
    <div style="max-height: 500px; overflow-y: auto; border: 1px solid #ddd;"> <!-- Ajusta la altura según tus necesidades -->
        <table id="tabla-productos" class="table table-bordered table-striped">
            <thead style="position: -webkit-sticky; position: sticky; top: 0; background-color: white; z-index: 1;">
                <tr>
                    <th>Imagen</th>
                    <th>Código Producto</th>
                    <th>Nombre Producto</th>
                    <th>CPI</th>
                    <th>ARTICULADOR</th>
                    <th>ARCO FACIAL</th>
                    <th>EMPAQUE</th>
                    <th>Total</th>
                    <th>Stock Almacén General</th>
                    <th>Stock Área de Ensamble</th>
                    <th>Stock Descartes</th>
                    <th>Stock Restante</th>
                    <th>Disponible para lote 3</th>
                    <th>Necesarias para lote 3</th>
                    <th>Restante de lote 3</th>
                    <th>Disponible para lote 4</th>
                    <th>Necesarias para lote 4</th>
                    <th>Restante de lote 4</th>
                    <th>Disponible para lote 5</th>
                    <th>Necesarias para lote 5</th>
                    <th>Restante de lote 5</th>
                </tr>
            </thead>
    <tbody>';

    if ($total > 0) {
        foreach ($datos as $rows) {
            $total_cantidad = $rows['cantidad_cpi'] + $rows['cantidad_articulador'] + $rows['cantidad_arco_facial'] + $rows['cantidad_empaque'];
            $tabla .= '<tr>
                <td><img src="' . APP_URL . 'app/views/img/img/' . htmlspecialchars($rows['url_imagen']) . '" alt="' . htmlspecialchars($rows['nombre_producto']) . '" style="width: 50px; height: 50px;"></td>
                <td>' . htmlspecialchars($rows['codigo_producto']) . '</td>
                <td>' . htmlspecialchars($rows['nombre_producto']) . '</td>
                <td class="cantidad-cpi">' . htmlspecialchars($rows['cantidad_cpi']) . '</td>
                <td class="cantidad-articulador">' . htmlspecialchars($rows['cantidad_articulador']) . '</td>
                <td class="cantidad-arco-facial">' . htmlspecialchars($rows['cantidad_arco_facial']) . '</td>
                <td class="cantidad-empaque">' . htmlspecialchars($rows['cantidad_empaque']) . '</td>
                <td class="total">' . htmlspecialchars($total_cantidad) . '</td>
                <td class="stock-general">' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
                <td>' . htmlspecialchars($rows['stock_area_ensamble']) . '</td>
                <td>' . htmlspecialchars($rows['stock_descartes']) . '</td>
                <td class="stock-disponible"></td>
                <td class="disponible-lote3">' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
                <td class="necesarias-lote3">' . htmlspecialchars($total_cantidad) . '</td>
                <td class="restante-lote3"></td>
                <td class="disponible-lote4"></td>
                <td class="necesarias-lote4">' . htmlspecialchars($total_cantidad) . '</td>
                <td class="restante-lote4"></td>
                <td class="disponible-lote5"></td>
                <td class="necesarias-lote5">' . htmlspecialchars($total_cantidad) . '</td>
                <td class="restante-lote5"></td>
            </tr>';
        }
    } else {
        $tabla .= '<tr><td colspan="21" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
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
            var arcoFacial = parseFloat(fila.querySelector(".cantidad-arco-facial").textContent) || 0;
            var empaque = parseFloat(fila.querySelector(".cantidad-empaque").textContent) || 0;
            var total = fila.querySelector(".total");
            var stockGeneral = parseFloat(fila.querySelector(".stock-general").textContent);
            var stockDisponible = fila.querySelector(".stock-disponible");
            var disponibleLote3 = fila.querySelector(".disponible-lote3");
            var necesariasLote3 = fila.querySelector(".necesarias-lote3");
            var restanteLote3 = fila.querySelector(".restante-lote3");
            var disponibleLote4 = fila.querySelector(".disponible-lote4");
            var necesariasLote4 = fila.querySelector(".necesarias-lote4");
            var restanteLote4 = fila.querySelector(".restante-lote4");
            var disponibleLote5 = fila.querySelector(".disponible-lote5");
            var necesariasLote5 = fila.querySelector(".necesarias-lote5");
            var restanteLote5 = fila.querySelector(".restante-lote5");
            var totalCantidad = (cpi + articulador + arcoFacial + empaque) * multiplicador;
            total.textContent = totalCantidad.toFixed(2);
            stockDisponible.textContent = (stockGeneral - totalCantidad).toFixed(2);
            disponibleLote3.textContent = stockGeneral.toFixed(2);
            necesariasLote3.textContent = totalCantidad.toFixed(2);
            var restanteLote3Value = stockGeneral - totalCantidad;
            restanteLote3.textContent = restanteLote3Value.toFixed(2);
            disponibleLote4.textContent = restanteLote3Value.toFixed(2);
            necesariasLote4.textContent = totalCantidad.toFixed(2);
            var restanteLote4Value = restanteLote3Value - totalCantidad;
            restanteLote4.textContent = restanteLote4Value.toFixed(2);
            disponibleLote5.textContent = restanteLote4Value.toFixed(2);
            necesariasLote5.textContent = totalCantidad.toFixed(2);
            restanteLote5.textContent = (restanteLote4Value - totalCantidad).toFixed(2);
        });
    }



    function imprimirTabla() {
        var contenidoTabla = document.getElementById("tabla-productos").innerHTML;
        var ventanaImpresion = window.open("", "_blank");
        ventanaImpresion.document.write("<html><head><title>Lista Kit Piezas Maquinados</title>");
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


   

   



   
   
   
   


}