<?php

namespace app\controllers;

use app\models\mainModel;

class kitController extends mainModel
{


    /*----------  Controlador registrar ----------*/
    public function registrarProductControlador()
    {

        # Almacenando datos#

        $codigo_producto = $this->limpiarCadena($_POST['codigo_producto']);
        $nombre_producto = $_POST['nombre_producto'];
        $precio = $this->limpiarCadena($_POST['precio']);
        $stock = $this->limpiarCadena($_POST['stock']);
        $categoria = $this->limpiarCadena($_POST['categoria']);
        $proveedor = $this->limpiarCadena($_POST['proveedor']);
        $unidad_medida = $this->limpiarCadena($_POST['unidad_medida']);
        $tipo_moneda = $this->limpiarCadena($_POST['tipo_moneda']);
  

        # Verificando campos obligatorios #
        if (
            $codigo_producto == "" || $nombre_producto == "" || $precio == "" || $stock == "" || $categoria == "" || $proveedor == "" ||
            $unidad_medida == "" || $tipo_moneda == ""
        ) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Directorio de imágenes #
        $img_dir = "../views/img/img/";

        # Comprobar si se seleccionó una imagen #
        if ($_FILES['url_imagen']['name'] != "" && $_FILES['url_imagen']['size'] > 0) {

            # Creando directorio #
            if (!file_exists($img_dir)) {
                if (!mkdir($img_dir, 0777)) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "Error al crear el directorio",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }

            # Verificando formato de imágenes #
            if (mime_content_type($_FILES['url_imagen']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['url_imagen']['tmp_name']) != "image/png") {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "La imagen que ha seleccionado es de un formato no permitido",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }

            # Verificando peso de la imagen #
            if (($_FILES['url_imagen']['size'] / 1024) > 10120) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "La imagen que ha seleccionado supera el peso permitido",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }

            # Nombre de la foto #
            $nombre_producto_limpio = preg_replace("/[^a-zA-Z0-9]+/", "_", $nombre_producto); // Limpia el nombre del producto
            $foto = $nombre_producto_limpio . "_" . rand(0, 100);

            # Extensión de la imagen #
            switch (mime_content_type($_FILES['url_imagen']['tmp_name'])) {
                case 'image/jpeg':
                    $foto = $foto . ".jpg";
                    break;
                case 'image/png':
                    $foto = $foto . ".png";
                    break;
            }

            chmod($img_dir, 0777);

            # Moviendo la imagen al directorio #
            if (!move_uploaded_file($_FILES['url_imagen']['tmp_name'], $img_dir . $foto)) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "No podemos subir la imagen al sistema en este momento",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        } else {
            $foto = "";
        }

        $producto_datos_reg = [

            [
                "campo_nombre" => "codigo_producto",
                "campo_marcador" => ":CodigoProducto",
                "campo_valor" => $codigo_producto
            ],
            [
                "campo_nombre" => "nombre_producto",
                "campo_marcador" => ":NombreProducto",
                "campo_valor" => $nombre_producto
            ],
            [
                "campo_nombre" => "precio",
                "campo_marcador" => ":Precio",
                "campo_valor" => $precio
            ],
            [
                "campo_nombre" => "stock",
                "campo_marcador" => ":Stock",
                "campo_valor" => $stock
            ],
            [
                "campo_nombre" => "id_categoria",
                "campo_marcador" => ":IdCategoria",
                "campo_valor" => $categoria
            ],
            [
                "campo_nombre" => "id_proveedor",
                "campo_marcador" => ":IdProveedor",
                "campo_valor" => $proveedor
            ],
            [
                "campo_nombre" => "id_unidad",
                "campo_marcador" => ":IdUnidad",
                "campo_valor" => $unidad_medida
            ],
            [
                "campo_nombre" => "id_moneda",
                "campo_marcador" => ":IdMoneda",
                "campo_valor" => $tipo_moneda
            ],
            [
                "campo_nombre" => "url_imagen",
                "campo_marcador" => ":UrlImagen",
                "campo_valor" => $foto
            ],
        ];
        

     // Registrar el producto
$productoResult = $this->guardarDatos2("productos", $producto_datos_reg);

if ($productoResult['success']) {
    // Obtén el ID del producto recién insertado
    $id_producto_recien_insertado = $productoResult['lastInsertId'];

    // Datos para el primer almacén
    $datos_stock_almacen = [
        ["campo_nombre" => "id_producto", "campo_marcador" => ":IdProducto", "campo_valor" => $id_producto_recien_insertado],
        ["campo_nombre" => "id_almacen", "campo_marcador" => ":IdAlmacen", "campo_valor" => 1], // Asumiendo que el id_almacen es 1 para este ejemplo
        ["campo_nombre" => "stock", "campo_marcador" => ":Stock", "campo_valor" => $stock]
    ];

    // Inserta los datos en la tabla stock_almacen para el primer almacén
    $resultado_stock_almacen = $this->guardarDatos2("stock_almacen", $datos_stock_almacen);

    if (!$resultado_stock_almacen['success']) {
        // Si falla, manejar el error y terminar
        $alerta = [
            "tipo" => "simple",
            "titulo" => "Error al registrar stock",
            "texto" => "No se pudo registrar el stock en el almacén 1: " . $resultado_stock_almacen['error'],
            "icono" => "error"
        ];
        return json_encode($alerta);
    }

    // Inserción de stock de 0 para los almacenes 2 y 3
    $almacenesAdicionales = [2, 3];
    foreach ($almacenesAdicionales as $id_almacen) {
        $datos_stock_almacen_adicional = [
            ["campo_nombre" => "id_producto", "campo_marcador" => ":IdProducto", "campo_valor" => $id_producto_recien_insertado],
            ["campo_nombre" => "id_almacen", "campo_marcador" => ":IdAlmacen", "campo_valor" => $id_almacen],
            ["campo_nombre" => "stock", "campo_marcador" => ":Stock", "campo_valor" => 0] // Stock inicial será 0
        ];

        $resultado_stock_almacen_adicional = $this->guardarDatos2("stock_almacen", $datos_stock_almacen_adicional);

        if (!$resultado_stock_almacen_adicional['success']) {
            // Si falla, manejar el error y terminar
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error al registrar stock",
                "texto" => "No se pudo registrar el stock en el almacén " . $id_almacen . ": " . $resultado_stock_almacen_adicional['error'],
                "icono" => "error"
            ];
            return json_encode($alerta);
        }
    }

    // Si todos los registros fueron exitosos
    $alerta = [
        "tipo" => "limpiar",
        "titulo" => "Producto registrado",
        "texto" => "El producto y el stock se han registrado correctamente en todos los almacenes",
        "icono" => "success"
    ];
} else {
    // Si falla el registro del producto, manejar el error
    $alerta = [
        "tipo" => "simple",
        "titulo" => "Error al registrar producto",
        "texto" => "No se pudo registrar el producto: " . $productoResult['error'],
        "icono" => "error"
    ];
}

return json_encode($alerta);
    }

    
   /*----------  Controlador listar productos  ----------*/
   public function listarProductControlador($pagina, $registros, $url, $busqueda)
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
        MAX(IF(cpi.nombre = 'CPI', pca.cantidad, 0)) AS cantidad_cpi,
        MAX(IF(cpi.nombre = 'Articulador', pca.cantidad, 0)) AS cantidad_articulador,
        MAX(IF(cpi.nombre = 'Arco Facial', pca.cantidad, 0)) AS cantidad_arco_facial,
        MAX(IF(cpi.nombre = 'Empaque', pca.cantidad, 0)) AS cantidad_empaque
    FROM
        productos p
    JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
    JOIN cpi_art_af cpi ON pca.id_cpi_art_af = cpi.id_cpi_art_af
    WHERE
        p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%'
    GROUP BY
        p.id_producto
    ORDER BY
        p.codigo_producto ASC
    LIMIT $inicio, $registros;";

    $datos = $this->ejecutarConsulta($consulta_datos);
    $datos = $datos->fetchAll();

    $consulta_total = "SELECT COUNT(DISTINCT p.id_producto)
    FROM productos p
    JOIN productos_cpi_art_af pca ON p.id_producto = pca.id_producto
    JOIN cpi_art_af cpi ON pca.id_cpi_art_af = cpi.id_cpi_art_af
    WHERE p.codigo_producto LIKE '%$busqueda%' OR p.nombre_producto LIKE '%$busqueda%';";
    $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();

    $numeroPaginas = ceil($total / $registros);

    $tabla = '<div class="container-fluid p-4">';
    $tabla .= '<table class="table table-bordered table-striped">';
    $tabla .= '<thead>
        <tr>
            <th>Código Producto</th>
            <th>Nombre Producto</th>
            <th>CPI</th>
            <th>Articulador</th>
            <th>Arco Facial</th>
            <th>Empaque</th>
        </tr>
    </thead>
    <tbody>';

    if ($total > 0) {
        foreach ($datos as $rows) {
            $tabla .= '<tr>
                <td>' . htmlspecialchars($rows['codigo_producto']) . '</td>
                <td>' . htmlspecialchars($rows['nombre_producto']) . '</td>
                <td>' . htmlspecialchars($rows['cantidad_cpi']) . '</td>
                <td>' . htmlspecialchars($rows['cantidad_articulador']) . '</td>
                <td>' . htmlspecialchars($rows['cantidad_arco_facial']) . '</td>
                <td>' . htmlspecialchars($rows['cantidad_empaque']) . '</td>
            </tr>';
        }
    } else {
        $tabla .= '<tr><td colspan="6" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
    }

    $tabla .= '</tbody></table>';
    $tabla .= '</div>';

    // Paginación

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