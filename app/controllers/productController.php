<?php

namespace app\controllers;

use app\models\mainModel;

class productController extends mainModel
{

    public function obtenerOpcionesCategorias()
    {
        $consulta_categorias = "SELECT * FROM categorias ORDER BY nombre_categoria";
        $datos_categorias = $this->ejecutarConsulta($consulta_categorias);
        $opciones_categorias = "";

        while ($categoria = $datos_categorias->fetch()) {
            $opciones_categorias .= '<option value="' . $categoria['id_categoria'] . '">'
                . $categoria['nombre_categoria'] . '</option>';
        }

        return $opciones_categorias;
    }

    public function obtenerOpcionesSubCategorias()
    {
        $consulta_subcategorias = "SELECT * FROM sub_categorias ORDER BY nombre_subcategoria";
        $datos_subcategorias = $this->ejecutarConsulta($consulta_subcategorias);
        $opciones_subcategorias = "";

        while ($subcategoria = $datos_subcategorias->fetch()) {
            $opciones_subcategorias .= '<option value="' . $subcategoria['id_subcategoria'] . '">'
                . $subcategoria['nombre_subcategoria'] . '</option>';
        }

        return $opciones_subcategorias;
    }
    
    public function obtenerOpcionesProveedores()
    {
        $consulta_proveedores = "SELECT * FROM proveedores ORDER BY nombre_proveedor";
        $datos_proveedores = $this->ejecutarConsulta($consulta_proveedores);
        $opciones_proveedores = "";

        while ($proveedor = $datos_proveedores->fetch()) {
            $opciones_proveedores .= '<option value="' . $proveedor['id_proveedor'] . '">'
                . $proveedor['nombre_proveedor'] . '</option>';
        }

        return $opciones_proveedores;
    }
    
    public function obtenerOpcionesUnidadesMedida()
    {
        $consulta_unidades = "SELECT * FROM unidades_medida ORDER BY nombre_unidad";
        $datos_unidades = $this->ejecutarConsulta($consulta_unidades);
        $opciones_unidades = "";

        while ($unidad = $datos_unidades->fetch()) {
            $opciones_unidades .= '<option value="' . $unidad['id_unidad'] . '">'
                . $unidad['nombre_unidad'] . '</option>';
        }

        return $opciones_unidades;
    }
    
    public function obtenerOpcionesTiposMoneda()
    {
        $consulta_tipos_moneda = "SELECT * FROM tipos_moneda ORDER BY nombre_moneda";
        $datos_tipos_moneda = $this->ejecutarConsulta($consulta_tipos_moneda);
        $opciones_tipos_moneda = "";

        while ($tipo_moneda = $datos_tipos_moneda->fetch()) {
            $opciones_tipos_moneda .= '<option value="' . $tipo_moneda['id_moneda'] . '">'
                . $tipo_moneda['nombre_moneda'] . '</option>';
        }

        return $opciones_tipos_moneda;
    }
    public function obtenerOpcionesAlmacenes()
    {
        $consulta_almacenes = "SELECT * FROM stock_almacenes ORDER BY id_producto";
        $datos_almacenes = $this->ejecutarConsulta($consulta_almacenes);
        $opciones_almacenes = "";

        while ($almacenes = $datos_almacenes->fetch()) {
            $opciones_almacenes .= '<option value="' . $almacenes['id_producto'] . '">'
                . $almacenes['id_almacen'] . '</option>';
        }

        return $opciones_almacenes;
    }

    public function obtenerAlmacenes()
    {
        $consulta_almacenes = "SELECT * FROM almacenes ORDER BY id_almacen";
        $datos_almacenes = $this->ejecutarConsulta($consulta_almacenes);
        $opciones_almacenes = "";

        while ($almacenes = $datos_almacenes->fetch()) {
            $opciones_almacenes .= '<option value="' . $almacenes['id_almacen'] . '">'
                . $almacenes['nombre_almacen'] . '</option>';
        }

        return $opciones_almacenes;
    }

    public function obtenerOpcionesUsuario()
    {
        $consulta_usuario = "SELECT * FROM usuario";
        $datos_usuario = $this->ejecutarConsulta($consulta_usuario);
        $opciones_usuario = "";

        while ($usuario = $datos_usuario->fetch()) {
            $opciones_usuario .= '<option value="' . $usuario['permiso'] . '">'
                . $usuario['permiso'] . '</option>';
        }

        return $opciones_usuario;
    }



    /*----------  Controlador registrar ----------*/
    public function registrarProductControlador()
    {

        # Almacenando datos#

        $codigo_producto = $this->limpiarCadena($_POST['codigo_producto']);
        $nombre_producto = $_POST['nombre_producto'];
        $ubicacion = $_POST['ubicacion'];
        $precio = $this->limpiarCadena($_POST['precio']);
        $stock = $this->limpiarCadena($_POST['stock']);
        $categoria = $this->limpiarCadena($_POST['categoria']);
        $proveedor = $this->limpiarCadena($_POST['proveedor']);
        $unidad_medida = $this->limpiarCadena($_POST['unidad_medida']);
        $tipo_moneda = $this->limpiarCadena($_POST['tipo_moneda']);
        $subcategoria = $this->limpiarCadena($_POST['subcategoria']);
  

        # Verificando campos obligatorios #
        if (
            $codigo_producto == "" || $nombre_producto == "" || $precio == "" || $stock == "" || $categoria == "" || $proveedor == "" ||
            $unidad_medida == "" || $tipo_moneda == "" || $ubicacion == "" || $subcategoria == ""
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
                "campo_nombre" => "ubicacion",
                "campo_marcador" => ":Ubicacion",
                "campo_valor" => $ubicacion
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
            [
                "campo_nombre" => "id_subcategoria",
                "campo_marcador" => ":IdSubCategoria",
                "campo_valor" => $subcategoria
            ]
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

    // Inserción de stock para los almacenes
    $almacenesAdicionales = [2,3,4,5,6,7,8,9];
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

    
  public function listarProductControlador($pagina, $registros, $url, $busqueda)
{
    $pagina = $this->limpiarCadena($pagina);
    $registros = $this->limpiarCadena($registros);
    $url = $this->limpiarCadena($url);
    $url = APP_URL . $url . "/";
    $busqueda = $this->limpiarCadena($busqueda);

    $tabla = "";

    $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
    $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

    $consulta_datos = "SELECT
        productos.*,
        categorias.nombre_categoria,
        proveedores.nombre_proveedor,
        unidades_medida.nombre_unidad,
        tipos_moneda.nombre_moneda,
        sub_categorias.nombre_subcategoria,
        SUM(CASE WHEN almacenes.nombre_almacen = 'Almacen General' THEN stock_almacen.stock ELSE 0 END) AS stock_general,
        SUM(CASE WHEN almacenes.nombre_almacen = 'Area de Maquinado' THEN stock_almacen.stock ELSE 0 END) AS stock_maquinados,
        SUM(CASE WHEN almacenes.nombre_almacen = 'Area de Ensamble' THEN stock_almacen.stock ELSE 0 END) AS stock_ensamble,
        SUM(CASE WHEN almacenes.nombre_almacen = 'Almacen Dental Trade' THEN stock_almacen.stock ELSE 0 END) AS stock_dental,
        SUM(CASE WHEN almacenes.nombre_almacen = 'Producto Terminado' THEN stock_almacen.stock ELSE 0 END) AS stock_terminado,
        SUM(CASE WHEN almacenes.nombre_almacen = 'Almacen Radiotecnologia Producto Terminado' THEN stock_almacen.stock ELSE 0 END) AS stock_rtproducto,
        SUM(CASE WHEN almacenes.nombre_almacen = 'Area de Ventas' THEN stock_almacen.stock ELSE 0 END) AS stock_ventas,
        SUM(CASE WHEN almacenes.nombre_almacen = 'Descarte de Producto Terminado' THEN stock_almacen.stock ELSE 0 END) AS stock_descarte_terminado,
        SUM(CASE WHEN almacenes.nombre_almacen = 'Descarte de Desgaste' THEN stock_almacen.stock ELSE 0 END) AS stock_descarte_desgaste
        FROM productos
        JOIN categorias ON productos.id_categoria = categorias.id_categoria
        JOIN proveedores ON productos.id_proveedor = proveedores.id_proveedor
        JOIN unidades_medida ON productos.id_unidad = unidades_medida.id_unidad
        JOIN tipos_moneda ON productos.id_moneda = tipos_moneda.id_moneda
        JOIN sub_categorias ON productos.id_subcategoria = sub_categorias.id_subcategoria
        LEFT JOIN stock_almacen ON productos.id_producto = stock_almacen.id_producto
        LEFT JOIN almacenes ON stock_almacen.id_almacen = almacenes.id_almacen
        WHERE codigo_producto LIKE '%$busqueda%' OR nombre_producto LIKE '%$busqueda%'
        GROUP BY productos.id_producto
        ORDER BY productos.id_producto DESC;";

    $consulta_total = "SELECT COUNT(DISTINCT productos.id_producto)
        FROM productos
        JOIN categorias ON productos.id_categoria = categorias.id_categoria
        JOIN proveedores ON productos.id_proveedor = proveedores.id_proveedor
        JOIN unidades_medida ON productos.id_unidad = unidades_medida.id_unidad
        JOIN tipos_moneda ON productos.id_moneda = tipos_moneda.id_moneda
        JOIN sub_categorias ON productos.id_subcategoria = sub_categorias.id_subcategoria
        LEFT JOIN stock_almacen ON productos.id_producto = stock_almacen.id_producto
        LEFT JOIN almacenes ON stock_almacen.id_almacen = almacenes.id_almacen
        WHERE codigo_producto LIKE '%$busqueda%' OR nombre_producto LIKE '%$busqueda%';";

    $datos = $this->ejecutarConsulta($consulta_datos);
    $datos = $datos->fetchAll();

    $total = $this->ejecutarConsulta($consulta_total);
    $total = (int)$total->fetchColumn();

   // Botones para cambiar la vista y el buscador en tiempo real
$tabla .= '
<div class="container-fluid p-4">
    <div class="row mb-3">
        <div class="col-12 col-md-6 mb-2 mb-md-0">
            <div class="input-group">
                <input type="text" class="form-control" id="searchInput" placeholder="Buscar..." onkeyup="filtrarBusqueda()">
            </div>
        </div>
        <div class="col-12 col-md-6 d-flex flex-column flex-md-row align-items-stretch">
            <button class="btn btn-primary mb-2 mb-md-0 me-md-2 w-100 w-md-auto" onclick="cambiarVista(\'tarjeta\')">Vista de Tarjeta</button>
            <button class="btn btn-secondary mb-2 mb-md-0 me-md-2 w-100 w-md-auto" onclick="cambiarVista(\'lista\')">Vista de Lista</button>
            <button class="btn btn-success w-100 w-md-auto" onclick="imprimirTabla()">Imprimir</button>
        </div>
    </div>
';


    // Vista de tarjeta
    $tabla .= '<div id="vistaTarjeta" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">';

    if ($total >= 1) {
        foreach ($datos as $rows) {
            $tabla .= '
            <div class="col tarjeta-item">
                <div class="card h-100">
                    <div class="card-img-top-container">
                        <img src="' . APP_URL . 'app/views/img/img/' . $rows['url_imagen'] . '" class="card-img-top img-fluid" alt="..."  loading="lazy">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">' . $rows['nombre_producto'] . '</h5>
                        <p class="card-text">Id: ' . $rows['id_producto'] . '</p>
                        <p class="card-text">Código: ' . $rows['codigo_producto'] . '</p>
                        <p class="card-text">Ubicación: ' . $rows['ubicacion'] . '</p>
                        <p class="card-text">Precio: ' . $rows['precio'] . '</p>
                        <p class="card-text">Moneda: ' . $rows['nombre_moneda'] . '</p>
                        <p class="card-text">Unidad de Medida: ' . $rows['nombre_unidad'] . '</p>
                        <p class="card-text">Categoría: ' . $rows['nombre_categoria'] . '</p>
                        <p class="card-text">Sub-Categoría: ' . $rows['nombre_subcategoria'] . '</p>
                        <p class="card-text">Proveedor: ' . $rows['nombre_proveedor'] . '</p>
                        <p class="card-text">Stock en almacenes:</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">General: ' . $rows['stock_general'] . '</li>
                            <li class="list-group-item">Maquinados: ' . $rows['stock_maquinados'] . '</li>
                            <li class="list-group-item">Ensamble: ' . $rows['stock_ensamble'] . '</li>
                            <li class="list-group-item">Dental Trade: ' . $rows['stock_dental'] . '</li>
                            <li class="list-group-item">Terminado: ' . $rows['stock_terminado'] . '</li>
                            <li class="list-group-item">RT Producto Terminado: ' . $rows['stock_rtproducto'] . '</li>
                            <li class="list-group-item">Ventas: ' . $rows['stock_ventas'] . '</li>
                            <li class="list-group-item">Descarte Terminado: ' . $rows['stock_descarte_terminado'] . '</li>
                            <li class="list-group-item">Descarte Desgaste: ' . $rows['stock_descarte_desgaste'] . '</li>
                        </ul>
                    </div>';

            if ($_SESSION['permiso'] == 1) {
                $tabla .= '
                    <div class="card-footer d-flex flex-column align-items-center">
                        <a href="' . APP_URL . 'productPhoto/' . $rows['id_producto'] . '/" class="btn btn-warning w-100 mb-2 rounded">Foto</a>
                        <a href="' . APP_URL . 'productUpdate/' . $rows['id_producto'] . '/" class="btn btn-success w-100 mb-2 rounded">Actualizar</a>
                        <a href="' . APP_URL . 'productEntrance/' . $rows['id_producto'] . '/" class="btn btn-light w-100 mb-2 rounded">Entrada</a>
                        <a href="' . APP_URL . 'movUpdate/' . $rows['id_producto'] . '/" class="btn btn-info w-100 mb-2 rounded">Movimiento Entre Almacenes</a>
                        <a href="' . APP_URL . 'descInventory/' . $rows['id_producto'] . '/" class="btn btn-danger w-100 mb-2 rounded">Descontar</a>
                    </div>';
            }

            $tabla .= '</div></div>';
        }
    } else {
        $tabla .= '
            <div class="alert alert-warning text-center" role="alert">
                No hay registros disponibles
            </div>';
    }

    $tabla .= '</div>';  // Cierra vista de tarjeta

    // Vista de lista
    $tabla .= '
    <div id="vistaLista" class="table-responsive d-none">
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="table-primary text-center">
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Precio</th>
                    <th>Moneda</th>
                    <th>Ubicación</th>
                    <th>Stock General</th>
                    <th>Stock Ensamble</th>
                </tr>
            </thead>
            <tbody>';

    if ($total >= 1) {
        foreach ($datos as $rows) {
            $tabla .= '
                <tr class="text-center">
                    <td>' . $rows['id_producto'] . '</td>
                    <td><img src="' . APP_URL . 'app/views/img/img/' . $rows['url_imagen'] . '" class="img-thumbnail" style="width: 100px; height: auto;" alt="Imagen del producto" loading="lazy"></td>
                    <td>' . $rows['nombre_producto'] . '</td>
                    <td>' . $rows['codigo_producto'] . '</td>
                    <td>' . $rows['precio'] . '</td>
                    <td>' . $rows['nombre_moneda'] . '</td>
                    <td>' . $rows['ubicacion'] . '</td>
                    <td>' . $rows['stock_general'] . '</td>
                    <td>' . $rows['stock_ensamble'] . '</td>
                </tr>';
        }
    } else {
        $tabla .= '
            <tr>
                <td colspan="14" class="text-center">No hay registros disponibles</td>
            </tr>';
    }

    $tabla .= '</tbody></table></div></div>';  // Cierra vista de lista y el contenedor principal

    // JavaScript para interactividad
    $tabla .= '
    <script>
    function cambiarVista(vista) {
        if (vista === "tarjeta") {
            document.getElementById("vistaTarjeta").classList.remove("d-none");
            document.getElementById("vistaLista").classList.add("d-none");
        } else {
            document.getElementById("vistaLista").classList.remove("d-none");
            document.getElementById("vistaTarjeta").classList.add("d-none");
        }
    }

    function filtrarBusqueda() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toLowerCase();
        let words = filter.split(" ").filter(Boolean);
        let itemsTarjeta = document.querySelectorAll("#vistaTarjeta .tarjeta-item");
        let rowsLista = document.querySelectorAll("#vistaLista tbody tr");

        itemsTarjeta.forEach(function (item) {
            let text = item.innerText.toLowerCase();
            let matches = words.every(word => text.includes(word));
            item.style.display = matches ? "" : "none";
        });

        rowsLista.forEach(function (row) {
            let text = row.innerText.toLowerCase();
            let matches = words.every(word => text.includes(word));
            row.style.display = matches ? "" : "none";
        });
    }

    function imprimirTabla() {
        let contenido = document.getElementById("vistaLista").innerHTML;
        let ventana = window.open("", "_blank");
        ventana.document.write("<html><head><title>Imprimir Tabla</title>");
        ventana.document.write("</head><body >");
        ventana.document.write("<style>table {width: 100%; border-collapse: collapse;} th, td {border: 1px solid black; padding: 8px; text-align: center;} th {background-color: #f2f2f2;}</style>");
        ventana.document.write(contenido);
        ventana.document.write("</body></html>");
        ventana.document.close();
        ventana.print();
    }
    </script>';

    return $tabla;
}





    /*----------  Controlador actualizar usuario  ----------*/
    public function actualizarProductControlador()
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
        $codigo_producto = $this->limpiarCadena($_POST['codigo_producto']);
        $nombre_producto = $this->limpiarCadena($_POST['nombre_producto']);
        $ubicacion = $_POST['ubicacion'];
        $id_categoria = $this->limpiarCadena($_POST['id_categoria']);
        $precio = $this->limpiarCadena($_POST['precio']);
        $stock = $this->limpiarCadena($_POST['stock']);
        $subcategoria = $this->limpiarCadena($_POST['subcategoria']);
       

        # Verificando campos obligatorios #
        if (
            $codigo_producto == "" || $nombre_producto == "" || $precio == "" || $stock == "" || $id_categoria == "" || $ubicacion == "" || $subcategoria == ""
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
                "campo_nombre" => "ubicacion",
                "campo_marcador" => ":Ubicacion",
                "campo_valor" => $ubicacion
            ],
            [
                "campo_nombre" => "id_categoria",
                "campo_marcador" => ":IdCategoria",
                "campo_valor" => $id_categoria
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
                "campo_nombre" => "id_subcategoria",
                "campo_marcador" => ":IdSubCategoria",
                "campo_valor" => $subcategoria
            ]
        ];


        $condicion = [
            "condicion_campo" => "id_producto",
            "condicion_marcador" => ":ID",
            "condicion_valor" => $id
        ];

        if ($this->actualizarDatos("productos", $producto_datos_reg, $condicion)) {

            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Producto actualizado",
                "texto" => "Los datos del producto " . $datos['nombre_producto'] . " se actualizaron correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos podido actualizar los datos del producto " . $datos['nombre_producto'] . ", por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }



    public function agregarCantidadProductControlador()
    {
        $id = $this->limpiarCadena($_POST['id_producto']);
        $nuevoStock = $this->limpiarCadena($_POST['stock']);  // La cantidad adicional de stock a agregar
        $almacen = $this->limpiarCadena($_POST['almacen']);
    
        // Verificando producto
        $datos = $this->ejecutarConsulta("SELECT * FROM productos WHERE id_producto='$id'");
        if ($datos->rowCount() <= 0) {
            return json_encode([
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado el producto en el sistema",
                "icono" => "error"
            ]);
        } else {
            $datos = $datos->fetch();
            $stockActual = $datos['stock'];  // Stock actual del producto
        }
    
        // Actualizar el stock en la tabla de productos
        $stockFinal = $stockActual + $nuevoStock;
        $actualizarProducto = $this->ejecutarConsulta("UPDATE productos SET stock = '$stockFinal' WHERE id_producto='$id'");
    
        // Actualizar el stock en la tabla stock_almacenes para el almacén general (id_almacen = 1)
        $datosAlmacen = $this->ejecutarConsulta("SELECT stock FROM stock_almacen WHERE id_producto='$id' AND id_almacen = $almacen");
        if ($datosAlmacen->rowCount() > 0) {
            $filaAlmacen = $datosAlmacen->fetch();
            $stockAlmacenActual = $filaAlmacen['stock'];
            $stockAlmacenFinal = $stockAlmacenActual + $nuevoStock;
            $actualizarAlmacen = $this->ejecutarConsulta("UPDATE stock_almacen SET stock = '$stockAlmacenFinal' WHERE id_producto='$id' AND id_almacen = $almacen");
        }
    
        if ($actualizarProducto && $actualizarAlmacen) {
            return json_encode([
                "tipo" => "recargar",
                "titulo" => "Producto actualizado",
                "texto" => "Los datos del producto se actualizaron correctamente",
                "icono" => "success"
            ]);
        } else {
            return json_encode([
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos podido actualizar los datos del producto, por favor intente nuevamente",
                "icono" => "error"
            ]);
        }

    }
    




    /*----------  Controlador eliminar foto usuario  ----------*/
    public function eliminarFotoProductControlador()
    {

        $id = $this->limpiarCadena($_POST['id_producto']);

        # Verificando usuario #
        $datos = $this->ejecutarConsulta("SELECT * FROM productos WHERE id_producto='$id'");
        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado el producto en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $datos = $datos->fetch();
        }

        # Directorio de imagenes #
        $img_dir = "../views/img/img/";

        chmod($img_dir, 0777);

        if (is_file($img_dir . $datos['url_imagen'])) {

            chmod($img_dir . $datos['url_imagen'], 0777);

            if (!unlink($img_dir . $datos['url_imagen'])) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "Error al intentar eliminar la foto del producto, por favor intente nuevamente",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado la foto del producto en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        $producto_datos_up = [
            [
                "campo_nombre" => "url_imagen",
                "campo_marcador" => ":Foto",
                "campo_valor" => ""
            ]
        ];

        $condicion = [
            "condicion_campo" => "id_producto",
            "condicion_marcador" => ":ID",
            "condicion_valor" => $id
        ];

        if ($this->actualizarDatos("productos", $producto_datos_up, $condicion)) {

            if ($id == $_SESSION['id']) {
                $_SESSION['foto'] = "";
            }

            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Foto eliminada",
                "texto" => "La foto del producto " . $datos['nombre_producto'] . " se elimino correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Foto eliminada",
                "texto" => "No hemos podido actualizar algunos datos del producto " . $datos['nombre_producto'] . ", sin embargo la foto ha sido eliminada correctamente",
                "icono" => "warning"
            ];
        }

        return json_encode($alerta);
    }




    /*----------  Controlador actualizar foto usuario  ----------*/
    public function actualizarFotoProductControlador()
    {

        $id = $this->limpiarCadena($_POST['id_producto']);

        # Verificando usuario #
        $datos = $this->ejecutarConsulta("SELECT * FROM productos WHERE id_producto='$id'");
        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado el producto en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $datos = $datos->fetch();
        }

        # Directorio de imagenes #
        $img_dir = "../views/img/img/";

        # Comprobar si se selecciono una imagen #
        if ($_FILES['url_imagen']['name'] == "" && $_FILES['url_imagen']['size'] <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No ha seleccionado una foto para el producto",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

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

        # Verificando formato de imagenes #
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

        # Verificando peso de imagen #
        if (($_FILES['url_imagen']['size'] / 1024) > 5120) {
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
        if ($datos['url_imagen'] != "") {
            $foto = explode(".", $datos['url_imagen']);
            $foto = $foto[0];
        } else {
            $nombre_producto_limpio = preg_replace("/[^a-zA-Z0-9]+/", "_", $datos['nombre_producto']); // Limpia el nombre del producto
            $foto = $nombre_producto_limpio . "_" . rand(0, 100);
        }


        # Extension de la imagen #
        switch (mime_content_type($_FILES['url_imagen']['tmp_name'])) {
            case 'image/jpeg':
                $foto = $foto . ".jpg";
                break;
            case 'image/png':
                $foto = $foto . ".png";
                break;
        }

        chmod($img_dir, 0777);

        # Moviendo imagen al directorio #
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

        # Eliminando imagen anterior #
        if (is_file($img_dir . $datos['url_imagen']) && $datos['url_imagen'] != $foto) {
            chmod($img_dir . $datos['url_imagen'], 0777);
            unlink($img_dir . $datos['url_imagen']);
        }

        $productos_datos_up = [
            [
                "campo_nombre" => "url_imagen",
                "campo_marcador" => ":Foto",
                "campo_valor" => $foto
            ]
        ];

        $condicion = [
            "condicion_campo" => "id_producto",
            "condicion_marcador" => ":ID",
            "condicion_valor" => $id
        ];

        if ($this->actualizarDatos("productos", $productos_datos_up, $condicion)) {

            if ($id == $_SESSION['id']) {
                $_SESSION['foto'] = $foto;
            }

            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Foto actualizada",
                "texto" => "La foto del producto " . $datos['nombre_producto'] . " se actualizo correctamente",
                "icono" => "success"
            ];
        } else {

            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Foto actualizada",
                "texto" => "No hemos podido actualizar algunos datos del producto " . $datos['nombre_producto'] . ", sin embargo la foto ha sido actualizada",
                "icono" => "warning"
            ];
        }

        return json_encode($alerta);
    }




}