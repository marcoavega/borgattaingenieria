<?php

namespace app\controllers;

use app\models\mainModel;

class kitPiezasExternasController extends mainModel
{

    
   /*----------  Controlador listar productos  ----------*/
  public function listarKitPiezasExternasControlador($busqueda)
{
    $busqueda = $this->limpiarCadena($busqueda);

    // Consulta SQL simplificada
    $consulta_datos = "
        SELECT
            p.codigo_producto,
            p.nombre_producto,
            p.url_imagen,
            sa.stock AS stock_almacen_general,
            COALESCE(SUM(CASE WHEN cpi.id_cpi_art_af = 1 THEN pca.cantidad END), 0) AS cantidad_cpi,
            COALESCE(SUM(CASE WHEN cpi.id_cpi_art_af = 2 THEN pca.cantidad END), 0) AS cantidad_articulador,
            COALESCE(SUM(CASE WHEN cpi.id_cpi_art_af = 3 THEN pca.cantidad END), 0) AS cantidad_arco_facial,
            COALESCE(SUM(CASE WHEN cpi.id_cpi_art_af = 4 THEN pca.cantidad END), 0) AS cantidad_empaque
        FROM
            productos p
        JOIN sub_categorias s ON p.id_subcategoria = s.id_subcategoria
        LEFT JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
        LEFT JOIN cpi_art_af cpi ON pca.id_cpi_art_af = cpi.id_cpi_art_af
        LEFT JOIN stock_almacen sa ON p.id_producto = sa.id_producto AND sa.id_almacen = 1
        WHERE
            (p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%')
            AND s.nombre_subcategoria = 'PIEZAS COMPRA EXTERNA PARA KIT'
        GROUP BY
            p.id_producto, p.codigo_producto, p.nombre_producto, p.url_imagen, sa.stock
        ORDER BY
            p.codigo_producto ASC;
    ";

    // Ejecutar la consulta
    $datos = $this->ejecutarConsulta($consulta_datos);
    $datos = $datos->fetchAll();

    // Verificar resultados
    if (empty($datos)) {
        echo "No se encontraron productos que coincidan con la búsqueda.";
    } else {
        echo "Se encontraron productos.";
    }

    // Construir la tabla
    $tabla = '<div class="container-fluid p-4">
        <input type="number" id="multiplicador" value="1" min="1" oninput="calcularTotales()" class="form-control mb-3" style="width: 200px;">
        <button onclick="imprimirTabla()" class="btn btn-primary mb-3">Imprimir Tabla</button>
        <table id="tabla-productos" class="table table-bordered table-striped">
        <thead>
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
                <th>Stock Restante</th>
            </tr>
        </thead>
        <tbody>';

    // Rellenar la tabla con los datos obtenidos
    if (!empty($datos)) {
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
                <td>' . htmlspecialchars($rows['stock_almacen_general']) . '</td>
                <td class="stock-disponible"></td>
            </tr>';
        }
    } else {
        $tabla .= '<tr><td colspan="10" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
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
                var stock = parseFloat(fila.querySelector("td:nth-child(9)").textContent);
                var stockDisponible = fila.querySelector(".stock-disponible");
                var totalCantidad = (cpi + articulador + arcoFacial + empaque) * multiplicador;
                total.textContent = totalCantidad.toFixed(2);
                stockDisponible.textContent = (stock - totalCantidad).toFixed(2);
            });
        }

        function imprimirTabla() {
            var contenidoTabla = document.getElementById("tabla-productos").innerHTML;
            var ventanaImpresion = window.open("", "_blank");
            ventanaImpresion.document.write("<html><head><title>Lista Kit Piezas Externas</title>");
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

    return $tabla;
}





   

   



   
   
   
   


}