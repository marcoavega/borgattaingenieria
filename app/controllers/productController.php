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
        $stock_deseado = $this->limpiarCadena($_POST['stock_deseado']);
  

        # Verificando campos obligatorios #
        if (
            $codigo_producto == "" || $nombre_producto == "" || $precio == "" || $stock == "" || $categoria == "" || $proveedor == "" ||
            $unidad_medida == "" || $tipo_moneda == "" || $ubicacion == "" || $subcategoria == "" || $stock_deseado == ""
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
            ],
            [
                "campo_nombre" => "stock_deseado",
                "campo_marcador" => ":stockDeseado",
                "campo_valor" => $stock_deseado
            ]
        ];
        

     // Registrar el producto
$productoResult = $this->guardarDatos2("productos", $producto_datos_reg);

if ($productoResult['success']) {
    $id_producto_recien_insertado = $productoResult['lastInsertId'];

    // Obtener todos los almacenes existentes
    $query_almacenes = "SELECT id_almacen FROM almacenes";
    $resultado_almacenes = $this->ejecutarConsulta($query_almacenes);

    $errores = [];

    if ($resultado_almacenes) {
        while ($almacen = $resultado_almacenes->fetch()) {
            $id_almacen = $almacen['id_almacen'];
            $stock_inicial = ($id_almacen == 1) ? $stock : 0; // Stock inicial solo para el primer almacén

            $datos_stock_almacen = [
                ["campo_nombre" => "id_producto", "campo_marcador" => ":IdProducto", "campo_valor" => $id_producto_recien_insertado],
                ["campo_nombre" => "id_almacen", "campo_marcador" => ":IdAlmacen", "campo_valor" => $id_almacen],
                ["campo_nombre" => "stock", "campo_marcador" => ":Stock", "campo_valor" => $stock_inicial]
            ];

            $resultado_stock_almacen = $this->guardarDatos2("stock_almacen", $datos_stock_almacen);

            if (!$resultado_stock_almacen['success']) {
                $errores[] = "No se pudo registrar el stock en el almacén " . $id_almacen . ": " . $resultado_stock_almacen['error'];
            }
        }
    } else {
        $errores[] = "No se pudieron obtener los almacenes existentes";
    }

    if (empty($errores)) {
        $alerta = [
            "tipo" => "limpiar",
            "titulo" => "Producto registrado",
            "texto" => "El producto y el stock se han registrado correctamente en todos los almacenes",
            "icono" => "success"
        ];
    } else {
        $alerta = [
            "tipo" => "simple",
            "titulo" => "Producto registrado con advertencias",
            "texto" => "El producto se registró, pero hubo errores al agregar el stock en algunos almacenes: " . implode(", ", $errores),
            "icono" => "warning"
        ];
    }
} else {
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
    // Manejo de la solicitud AJAX para actualizar el status
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
        $id_producto = $this->limpiarCadena($_POST['id_producto']);
        $status = $this->limpiarCadena($_POST['status']);

        $query = "UPDATE productos SET status = '$status' WHERE id_producto = '$id_producto'";
        
        $resultado = $this->ejecutarConsulta($query);
        
        if ($resultado) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    // Código existente para listar productos
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
        ORDER BY productos.id_producto DESC";

    $consulta_total = "SELECT COUNT(DISTINCT productos.id_producto)
        FROM productos
        JOIN categorias ON productos.id_categoria = categorias.id_categoria
        JOIN proveedores ON productos.id_proveedor = proveedores.id_proveedor
        JOIN unidades_medida ON productos.id_unidad = unidades_medida.id_unidad
        JOIN tipos_moneda ON productos.id_moneda = tipos_moneda.id_moneda
        JOIN sub_categorias ON productos.id_subcategoria = sub_categorias.id_subcategoria
        LEFT JOIN stock_almacen ON productos.id_producto = stock_almacen.id_producto
        LEFT JOIN almacenes ON stock_almacen.id_almacen = almacenes.id_almacen
        WHERE codigo_producto LIKE '%$busqueda%' OR nombre_producto LIKE '%$busqueda%'";

    $datos = $this->ejecutarConsulta($consulta_datos);
    $datos = $datos->fetchAll();

    $total = $this->ejecutarConsulta($consulta_total);
    $total = (int)$total->fetchColumn();

    $tabla .= '
    <div class="container-fluid">
        <div class="row">
            <!-- Menú lateral -->
            <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'productList/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Lista de Productos
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'productNew/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Registrar Nuevo
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="' . APP_URL . 'productInvent/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Inventario
                    </a>
                </li>
            </ul>
            <hr>
            </div>

            <!-- Contenido principal -->
        <div class="col-12 col-md-9 col-lg-10">
            <div class="container-fluid mb-4">
                <h4 class="text-center">Productos</h4>
                <h5 class="lead text-center">Lista de productos</h5>
            </div>
            <!-- Buscador en tiempo real y botón de impresión -->
            <div class="container-fluid p-4">
                <div class="row mb-3">
                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="Buscar..." onkeyup="filtrarBusqueda()">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-flex justify-content-end">
                        <button class="btn btn-success" onclick="imprimirTabla()">Imprimir</button>
                    </div>
                </div>';

    // Vista de lista
    $tabla .= '
    <div id="vistaLista" class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="table-primary text-center">
                    <th><a href="#" class="text-dark" onclick="ordenarTabla(0)">ID</a></th>
                    <th>Imagen</th>
                    <th><a href="#" class="text-dark" onclick="ordenarTabla(2)">Nombre</a></th>
                    <th><a href="#" class="text-dark" onclick="ordenarTabla(3)">Código</a></th>
                    <th>Ubicación</th>
                    <th>Stock General</th>
                    <th>Stock Ensamble</th>
                    <th>Stock Maquinados</th>
                    <th>Stock Deseado</th>
                    <th><a href="#" class="text-dark" onclick="ordenarTabla(9)">Status</a></th>
                </tr>
            </thead>
            <tbody>';

    if ($total >= 1) {
        foreach ($datos as $rows) {
            $tabla .= '
                <tr class="text-center">
                    <td>' . $rows['id_producto'] . '</td>
                    <td><img src="' . APP_URL . 'app/views/img/img/' . $rows['url_imagen'] . '" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;" alt="Imagen del producto" loading="lazy"></td>
                    <td><a href="' . APP_URL . 'productDetails/' . $rows['id_producto'] . '/" class="text-decoration-none">' . $rows['nombre_producto'] . '</a></td>
                    <td>' . $rows['codigo_producto'] . '</td>
                    <td>' . $rows['ubicacion'] . '</td>
                    <td>' . $rows['stock_general'] . '</td>
                    <td>' . $rows['stock_ensamble'] . '</td>
                    <td>' . $rows['stock_maquinados'] . '</td>
                    <td>' . $rows['stock_deseado'] . '</td>
                    <td>
                        <select class="form-select form-select-sm status-select custom-select" data-id="' . $rows['id_producto'] . '">
                            <option value="1" ' . ($rows['status'] == 1 ? 'selected' : '') . '>Activo</option>
                            <option value="0" ' . ($rows['status'] == 0 ? 'selected' : '') . '>Inactivo</option>
                        </select>
                    </td>
                </tr>';
        }
    } else {
        $tabla .= '
            <tr>
                <td colspan="10" class="text-center">No hay registros disponibles</td>
            </tr>';
    }

    $tabla .= '</tbody></table></div>';

    $tabla .= '
    <style>
    .custom-select {
        width: 100px;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }
    </style>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

    let ordenAscendente = true;

    function ordenarTabla(columna) {
        let tabla, filas, switching, i, x, y, shouldSwitch;
        tabla = document.querySelector("#vistaLista table");
        switching = true;

        while (switching) {
            switching = false;
            filas = tabla.rows;

            for (i = 1; i < (filas.length - 1); i++) {
                shouldSwitch = false;
                x = filas[i].getElementsByTagName("TD")[columna];
                y = filas[i + 1].getElementsByTagName("TD")[columna];

                let comparacion;
                if (columna === 9) { // Para la columna Status
                    comparacion = x.querySelector("select").value.localeCompare(y.querySelector("select").value);
                } else if (columna === 0) { // Para la columna ID
                    comparacion = parseInt(x.innerHTML) - parseInt(y.innerHTML);
                } else {
                    comparacion = x.innerHTML.toLowerCase().localeCompare(y.innerHTML.toLowerCase());
                }

                if (ordenAscendente ? comparacion > 0 : comparacion < 0) {
                    shouldSwitch = true;
                    break;
                }
            }

            if (shouldSwitch) {
                filas[i].parentNode.insertBefore(filas[i + 1], filas[i]);
                switching = true;
            }
        }

        ordenAscendente = !ordenAscendente;
    }


    function filtrarBusqueda() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toLowerCase();
        let words = filter.split(" ").filter(Boolean);
        let rowsLista = document.querySelectorAll("#vistaLista tbody tr");

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
        ventana.document.write("<style>table {width: 100%; border-collapse: collapse;} th, td {border: 1px solid black; padding: 8px; text-align: center;} th {background-color: #f2f2f2;}</style>");
        ventana.document.write("</head><body>");
        ventana.document.write(contenido);
        ventana.document.write("</body></html>");
        ventana.document.close();
        ventana.print();
    }

   $(document).ready(function() {
        $(".status-select").change(function() {
            let id_producto = $(this).data("id");
            let new_status = $(this).val();
            
            $.ajax({
                url: window.location.href,
                method: "POST",
                data: {
                    action: "update_status",
                    id_producto: id_producto,
                    status: new_status
                },
                success: function(response) {
                    let data = JSON.parse(response);
                    if(data.status === "success") {
                        alert("Estado actualizado correctamente");
                    } else {
                        alert("Error al actualizar el estado");
                    }
                },
                error: function() {
                    alert("Error en la solicitud");
                }
            });
        });
    });
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
        $precio = $this->limpiarCadena($_POST['precio']);
        $stock = $this->limpiarCadena($_POST['stock']);
        $stock_deseado = $this->limpiarCadena($_POST['stock_deseado']);

        # Verificando campos obligatorios #
        if (
            $codigo_producto == "" || $nombre_producto == "" || $precio == "" || $stock == "" || $ubicacion == "" ||  $stock_deseado == ""
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
                "campo_nombre" => "stock_deseado",
                "campo_marcador" => ":stockDeseado",
                "campo_valor" => $stock_deseado
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



    public function obtenerCategoria($id_categoria)
{
    // Limpieza del ID de categoría (asumiendo que tienes un método limpiarCadena)
    $id_categoria = $this->limpiarCadena($id_categoria);

    // Consulta SQL para obtener el nombre de la categoría por ID
    $consulta_categorias = "SELECT nombre_categoria FROM categorias WHERE id_categoria='$id_categoria' LIMIT 1";
    
    // Ejecutar la consulta
    $datos_categorias = $this->ejecutarConsulta($consulta_categorias);
    
    // Verificar si se encontró la categoría
    if ($datos_categorias->rowCount() > 0) {
        $categoria = $datos_categorias->fetch();
        return $categoria['nombre_categoria']; // Retorna el nombre de la categoría
    } else {
        return "Categoría no encontrada"; // En caso de que no se encuentre la categoría
    }
}
    
public function obtenerNombreSubcategoria($id_subcategoria)
{
    $id_subcategoria = $this->limpiarCadena($id_subcategoria);
    $consulta = "SELECT nombre_subcategoria FROM sub_categorias WHERE id_subcategoria='$id_subcategoria' LIMIT 1";
    $datos = $this->ejecutarConsulta($consulta);
    
    if ($datos->rowCount() > 0) {
        $subcategoria = $datos->fetch();
        return $subcategoria['nombre_subcategoria'];
    } else {
        return "Subcategoría no encontrada";
    }
}

public function obtenerNombreProveedor($id_proveedor)
{
    $id_proveedor = $this->limpiarCadena($id_proveedor);
    $consulta = "SELECT nombre_proveedor FROM proveedores WHERE id_proveedor='$id_proveedor' LIMIT 1";
    $datos = $this->ejecutarConsulta($consulta);
    
    if ($datos->rowCount() > 0) {
        $proveedor = $datos->fetch();
        return $proveedor['nombre_proveedor'];
    } else {
        return "Proveedor no encontrado";
    }
}

public function obtenerNombreUnidad($id_unidad)
{
    $id_unidad = $this->limpiarCadena($id_unidad);
    $consulta = "SELECT nombre_unidad FROM unidades_medida WHERE id_unidad='$id_unidad' LIMIT 1";
    $datos = $this->ejecutarConsulta($consulta);
    
    if ($datos->rowCount() > 0) {
        $unidad = $datos->fetch();
        return $unidad['nombre_unidad'];
    } else {
        return "Unidad no encontrada";
    }
}

public function obtenerNombreMoneda($id_moneda)
{
    $id_moneda = $this->limpiarCadena($id_moneda);
    $consulta = "SELECT nombre_moneda FROM tipos_moneda WHERE id_moneda='$id_moneda' LIMIT 1";
    $datos = $this->ejecutarConsulta($consulta);
    
    if ($datos->rowCount() > 0) {
        $moneda = $datos->fetch();
        return $moneda['nombre_moneda'];
    } else {
        return "Moneda no encontrada";
    }
}


public function obtenerDetallesProducto($id_producto)
{
    $id_producto = $this->limpiarCadena($id_producto);

    $consulta = "SELECT
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
    LEFT JOIN categorias ON productos.id_categoria = categorias.id_categoria
    LEFT JOIN proveedores ON productos.id_proveedor = proveedores.id_proveedor
    LEFT JOIN unidades_medida ON productos.id_unidad = unidades_medida.id_unidad
    LEFT JOIN tipos_moneda ON productos.id_moneda = tipos_moneda.id_moneda
    LEFT JOIN sub_categorias ON productos.id_subcategoria = sub_categorias.id_subcategoria
    LEFT JOIN stock_almacen ON productos.id_producto = stock_almacen.id_producto
    LEFT JOIN almacenes ON stock_almacen.id_almacen = almacenes.id_almacen
    WHERE productos.id_producto = '$id_producto'
    GROUP BY productos.id_producto";

    $datos = $this->ejecutarConsulta($consulta);
    
    if ($datos->rowCount() > 0) {
        return $datos->fetch();
    } else {
        return null;
    }
}


public function obtenerDetallesProductoConAlmacenes($id_producto) {
    $id_producto = $this->limpiarCadena($id_producto);

    // Primero, obtenemos los detalles del producto
    $consulta_producto = "SELECT 
        productos.*,
        categorias.nombre_categoria,
        proveedores.nombre_proveedor,
        unidades_medida.nombre_unidad,
        tipos_moneda.nombre_moneda,
        sub_categorias.nombre_subcategoria
    FROM productos
    LEFT JOIN categorias ON productos.id_categoria = categorias.id_categoria
    LEFT JOIN proveedores ON productos.id_proveedor = proveedores.id_proveedor
    LEFT JOIN unidades_medida ON productos.id_unidad = unidades_medida.id_unidad
    LEFT JOIN tipos_moneda ON productos.id_moneda = tipos_moneda.id_moneda
    LEFT JOIN sub_categorias ON productos.id_subcategoria = sub_categorias.id_subcategoria
    WHERE productos.id_producto = '$id_producto'";

    $datos_producto = $this->ejecutarConsulta($consulta_producto);
    
    if ($datos_producto->rowCount() > 0) {
        $producto = $datos_producto->fetch();

        // Ahora, obtenemos el stock por almacén
        $consulta_stock = "SELECT 
            almacenes.id_almacen,
            almacenes.nombre_almacen,
            COALESCE(stock_almacen.stock, 0) AS stock
        FROM almacenes
        LEFT JOIN stock_almacen ON almacenes.id_almacen = stock_almacen.id_almacen
            AND stock_almacen.id_producto = '$id_producto'";

        $datos_stock = $this->ejecutarConsulta($consulta_stock);
        
        $almacenes = [];
        while ($stock = $datos_stock->fetch()) {
            $almacenes[] = [
                'id_almacen' => $stock['id_almacen'],
                'nombre_almacen' => $stock['nombre_almacen'],
                'stock' => $stock['stock']
            ];
        }

        $producto['almacenes'] = $almacenes;
        return $producto;
    } else {
        return null;
    }
}


public function eliminarProductControlador(){
    $id = $this->limpiarCadena($_POST['id_producto']);

    // Verificar si el producto existe
    $check_producto = $this->ejecutarConsulta("SELECT * FROM productos WHERE id_producto='$id'");
    if($check_producto->rowCount()<=0){
        $alerta = [
            "tipo" => "simple",
            "titulo" => "Ocurrió un error inesperado",
            "texto" => "El producto que intenta eliminar no existe en el sistema",
            "icono" => "error"
        ];
        return json_encode($alerta);
    }

    // Eliminar registros relacionados en stock_almacen
    $eliminar_stock = $this->eliminarRegistro("stock_almacen", "id_producto", $id);

    // Eliminar el producto
    $eliminar_producto = $this->eliminarRegistro("productos", "id_producto", $id);

    if($eliminar_producto->rowCount()==1){
        $alerta = [
            "tipo" => "recargar",
            "titulo" => "Producto eliminado",
            "texto" => "El producto ha sido eliminado del sistema correctamente",
            "icono" => "success"
        ];
    }else{
        $alerta = [
            "tipo" => "simple",
            "titulo" => "Ocurrió un error inesperado",
            "texto" => "No se pudo eliminar el producto, por favor intente nuevamente",
            "icono" => "error"
        ];
    }

    return json_encode($alerta);
}


public function obtenerProductosAResurtir() {
    $consulta = "SELECT 
        p.id_producto, 
        p.nombre_producto,
        p.codigo_producto,
        p.stock_deseado,
        p.id_categoria,
        c.nombre_categoria,
        COALESCE(SUM(sa.stock), 0) as stock_general
    FROM 
        productos p
    LEFT JOIN 
        stock_almacen sa ON p.id_producto = sa.id_producto
    LEFT JOIN
        categorias c ON p.id_categoria = c.id_categoria
    LEFT JOIN
        almacenes a ON sa.id_almacen = a.id_almacen
    WHERE 
        (a.nombre_almacen = 'Almacen General' OR a.nombre_almacen IS NULL)
        AND p.status = 1  -- Añadimos esta condición para obtener solo productos activos
    GROUP BY 
        p.id_producto, p.nombre_producto, p.codigo_producto, p.stock_deseado, p.id_categoria, c.nombre_categoria
    HAVING 
        COALESCE(SUM(sa.stock), 0) < p.stock_deseado
    ORDER BY 
        (p.stock_deseado - COALESCE(SUM(sa.stock), 0)) DESC";

    $datos = $this->ejecutarConsulta($consulta);
    
    return $datos->fetchAll();
}


public function obtenerCategorias()
{
    $consulta = "SELECT id_categoria, nombre_categoria FROM categorias ORDER BY nombre_categoria";
    $datos = $this->ejecutarConsulta($consulta);
    return $datos->fetchAll();
}
    

// En productController.php
public function obtenerProductosConStock() {
    $consulta = "SELECT 
        p.id_producto,
        p.codigo_producto,
        p.nombre_producto,
        p.id_categoria,
        c.nombre_categoria,
        p.precio,
        sa.id_almacen,
        sa.stock
    FROM 
        productos p
    LEFT JOIN 
        categorias c ON p.id_categoria = c.id_categoria
    LEFT JOIN 
        stock_almacen sa ON p.id_producto = sa.id_producto
    WHERE
        p.status = 1  -- Añadimos esta condición para obtener solo productos activos
    ORDER BY 
        p.nombre_producto";

    $datos = $this->ejecutarConsulta($consulta);
    $productos = [];

    while ($row = $datos->fetch()) {
        if (!isset($productos[$row['id_producto']])) {
            $productos[$row['id_producto']] = [
                'id_producto' => $row['id_producto'],
                'codigo_producto' => $row['codigo_producto'],
                'nombre_producto' => $row['nombre_producto'],
                'id_categoria' => $row['id_categoria'],
                'nombre_categoria' => $row['nombre_categoria'],
                'precio' => $row['precio'],
                'stocks' => [],
                'total_stock' => 0
            ];
        }
        if ($row['id_almacen'] !== null) {
            $productos[$row['id_producto']]['stocks'][$row['id_almacen']] = $row['stock'];
            $productos[$row['id_producto']]['total_stock'] += $row['stock'];
        }
    }

    return array_values($productos);
}


}