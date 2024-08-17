<?php

namespace app\controllers;

use app\models\mainModel;

class herramientasMaquinadoController extends mainModel
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
   public function listarherramientasMaquinadoControlador($pagina, $registros, $url, $busqueda)
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
               productos.*,
               categorias.nombre_categoria,
               proveedores.nombre_proveedor,
               unidades_medida.nombre_unidad,
               tipos_moneda.nombre_moneda,
               SUM(CASE WHEN almacenes.nombre_almacen = 'Almacen General' THEN stock_almacen.stock ELSE 0 END) AS stock_general,
               SUM(CASE WHEN almacenes.nombre_almacen = 'Area de Maquinado' THEN stock_almacen.stock ELSE 0 END) AS stock_maquinados,
               SUM(CASE WHEN almacenes.nombre_almacen = 'Area de Ensamble' THEN stock_almacen.stock ELSE 0 END) AS stock_ensamble
           FROM productos
           JOIN categorias ON productos.id_categoria = categorias.id_categoria
           JOIN proveedores ON productos.id_proveedor = proveedores.id_proveedor
           JOIN unidades_medida ON productos.id_unidad = unidades_medida.id_unidad
           JOIN tipos_moneda ON productos.id_moneda = tipos_moneda.id_moneda
           LEFT JOIN stock_almacen ON productos.id_producto = stock_almacen.id_producto
           LEFT JOIN almacenes ON stock_almacen.id_almacen = almacenes.id_almacen
           WHERE categorias.id_categoria = 3
           GROUP BY productos.id_producto
           ORDER BY productos.id_producto DESC;";
   
       $consulta_total = "SELECT COUNT(DISTINCT productos.id_producto)
       FROM productos
       JOIN categorias ON productos.id_categoria = categorias.id_categoria
       JOIN proveedores ON productos.id_proveedor = proveedores.id_proveedor
       JOIN unidades_medida ON productos.id_unidad = unidades_medida.id_unidad
       JOIN tipos_moneda ON productos.id_moneda = tipos_moneda.id_moneda
       LEFT JOIN stock_almacen ON productos.id_producto = stock_almacen.id_producto
       LEFT JOIN almacenes ON stock_almacen.id_almacen = almacenes.id_almacen
       WHERE categorias.id_categoria = 3;";
   
       $datos = $this->ejecutarConsulta($consulta_datos);
       $datos = $datos->fetchAll();
   
       $total = $this->ejecutarConsulta($consulta_total);
       $total = (int) $total->fetchColumn();
   
       // Botones para cambiar la vista y el buscador en tiempo real
       $tabla .= '
       <div class="container-fluid p-4">
           <div class="d-flex justify-content-between mb-3">
               <div class="input-group" style="max-width: 300px;">
                   <input type="text" class="form-control" id="searchInput" placeholder="Buscar...">
               </div>
               <div>
                   <button class="btn btn-primary me-2" onclick="cambiarVista(\'tarjeta\')">Vista de Tarjeta</button>
                   <button class="btn btn-secondary me-2" onclick="cambiarVista(\'lista\')">Vista de Lista</button>
                   <button class="btn btn-success" onclick="imprimirTabla()">Imprimir</button>
               </div>
           </div>
       ';
   
       // Vista de tarjeta
       $tabla .= '<div id="vistaTarjeta" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4 p-5">';
   
       if ($total >= 1) {
           foreach ($datos as $rows) {
               $tabla .= '
               <div class="col tarjeta-item">
                   <div class="card h-100">
                       <div class="card-img-top-container">
                           <img src="' . APP_URL . 'app/views/img/img/' . $rows['url_imagen'] . '" class="card-img-top img-fluid" alt="...">
                       </div>
                       <div class="card-body">
                           <h5 class="card-title">' . $rows['nombre_producto'] . '</h5>
                           <p class="card-text">Id: ' . $rows['id_producto'] . '</p>
                           <p class="card-text">Código: ' . $rows['codigo_producto'] . '</p>
                           <p class="card-text">Precio: ' . $rows['precio'] . '</p>
                           <p class="card-text">Moneda: ' . $rows['nombre_moneda'] . '</p>
                           <p class="card-text">Unidad de Medida: ' . $rows['nombre_unidad'] . '</p>
                           <p class="card-text">Stock Almacén General: ' . $rows['stock_general'] . '<br> Almacén Maquinados: ' . $rows['stock_maquinados'] . '<br> Almacén Ensamble: ' . $rows['stock_ensamble'] . '</p>
                           <p class="card-text">Categoría: ' . $rows['nombre_categoria'] . '</p>
                           <p class="card-text">Proveedor: ' . $rows['nombre_proveedor'] . '</p>
                       </div>
                       ' . ($_SESSION['permiso'] == 1 ? '
                       <div class="card-footer d-flex flex-column align-items-center">
                           <a href="' . APP_URL . 'productPhoto/' . $rows['id_producto'] . '/" class="btn btn-warning w-100 mb-2 rounded">Foto</a>
                           <a href="' . APP_URL . 'productUpdate/' . $rows['id_producto'] . '/" class="btn btn-success w-100 mb-2 rounded">Actualizar</a>
                           <a href="' . APP_URL . 'productEntrance/' . $rows['id_producto'] . '/" class="btn btn-light w-100 mb-2 rounded">Entrada</a>
                           <a href="' . APP_URL . 'movUpdate/' . $rows['id_producto'] . '/" class="btn btn-info w-100 mb-2 rounded">Movimiento Entre Almacenes</a>
                           <a href="' . APP_URL . 'descInventory/' . $rows['id_producto'] . '/" class="btn btn-danger w-100 rounded">Descontar inventario</a>
                       </div>' : '') . '
                   </div>
               </div>';
           }
       } else {
           $tabla .= '
               <div class="col">
                   No hay registros en el sistema
               </div>';
       }
   
       $tabla .= '</div>';
   
       // Vista de lista
       $tabla .= '<div id="vistaLista" class="table-responsive" style="display: none;">
           <table class="table table-bordered table-striped table-hover" id="tablaProductos">
               <thead class="thead-dark">
                   <tr>
                       <th>Imagen</th>
                       <th>Id</th>
                       <th>Código</th>
                       <th>Nombre</th>
                       <th>Precio</th>
                       <th>Moneda</th>
                       <th>Unidad de Medida</th>
                       <th>Stock Almacén General</th>
                       <th>Stock Maquinados</th>
                       <th>Stock Ensamble</th>
                       <th>Categoría</th>
                       <th>Proveedor</th>
                   </tr>
               </thead>
               <tbody id="productTableBody">';
   
       if ($total >= 1) {
           foreach ($datos as $rows) {
               $tabla .= '
               <tr class="lista-item">
                   <td><img src="' . APP_URL . 'app/views/img/img/' . $rows['url_imagen'] . '" class="img-thumbnail" alt="..." style="width: 50px; height: 50px;"></td>
                   <td>' . htmlspecialchars($rows['id_producto']) . '</td>
                   <td>' . htmlspecialchars($rows['codigo_producto']) . '</td>
                   <td>' . htmlspecialchars($rows['nombre_producto']) . '</td>
                   <td>' . htmlspecialchars($rows['precio']) . '</td>
                   <td>' . htmlspecialchars($rows['nombre_moneda']) . '</td>
                   <td>' . htmlspecialchars($rows['nombre_unidad']) . '</td>
                   <td>' . htmlspecialchars($rows['stock_general']) . '</td>
                   <td>' . htmlspecialchars($rows['stock_maquinados']) . '</td>
                   <td>' . htmlspecialchars($rows['stock_ensamble']) . '</td>
                   <td>' . htmlspecialchars($rows['nombre_categoria']) . '</td>
                   <td>' . htmlspecialchars($rows['nombre_proveedor']) . '</td>
               </tr>';
           }
       } else {
           $tabla .= '
               <tr>
                   <td colspan="12" class="text-center">No hay registros que coincidan con la búsqueda.</td>
               </tr>';
       }
   
       $tabla .= '
               </tbody>
           </table>
       </div>';
   
       $tabla .= '</div>';
   
       // JavaScript para cambiar la vista y buscar en tiempo real
       $tabla .= '<script>
       function cambiarVista(vista) {
           if (vista === "tarjeta") {
               document.getElementById("vistaTarjeta").style.display = "flex";
               document.getElementById("vistaLista").style.display = "none";
           } else {
               document.getElementById("vistaTarjeta").style.display = "none";
               document.getElementById("vistaLista").style.display = "block";
           }
       }
   
       // Mostrar por defecto la vista de tarjeta
       cambiarVista("tarjeta");
   
       // Buscador en tiempo real
       document.getElementById("searchInput").addEventListener("input", function() {
           var filter = this.value.toUpperCase();
           var words = filter.split(" ");
           var tarjetaItems = document.querySelectorAll(".tarjeta-item");
           var listaItems = document.querySelectorAll(".lista-item");
   
           tarjetaItems.forEach(function(item) {
               var textContent = item.textContent || item.innerText;
               var match = words.every(function(word) {
                   return textContent.toUpperCase().indexOf(word) > -1;
               });
               if (match) {
                   item.style.display = "";
               } else {
                   item.style.display = "none";
               }
           });
   
           listaItems.forEach(function(item) {
               var textContent = item.textContent || item.innerText;
               var match = words.every(function(word) {
                   return textContent.toUpperCase().indexOf(word) > -1;
               });
               if (match) {
                   item.style.display = "";
               } else {
                   item.style.display = "none";
               }
           });
       });
   
       // Función para imprimir la tabla
       function imprimirTabla() {
           var tabla = document.getElementById("tablaProductos").outerHTML;
           var ventana = window.open("", "_blank");
           ventana.document.write("<html><head><title>Imprimir Tabla</title>");
           ventana.document.write("<style>");
           ventana.document.write("body { font-family: Arial, sans-serif; }");
           ventana.document.write("table { width: 100%; border-collapse: collapse; }");
           ventana.document.write("th, td { border: 1px solid #000; padding: 8px; text-align: left; }");
           ventana.document.write("th { background-color: #f2f2f2; }");
           ventana.document.write("</style>");
           ventana.document.write("</head><body>");
           ventana.document.write(tabla);
           ventana.document.write("</body></html>");
           ventana.document.close();
           ventana.print();
       }
       </script>';
   
       return $tabla;
   }
   


    /*----------  Controlador eliminar producto  ----------*/
    public function eliminarProductControlador()
    {

        $id = $this->limpiarCadena($_POST['id_producto']);

        if ($id == 1) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No podemos eliminar el producto del sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Verificando producto #
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

        $eliminarUsuario = $this->eliminarRegistro("productos", "id_producto", $id);

        if ($eliminarUsuario->rowCount() == 1) {

            if (is_file("../views/img/img/" . $datos['url_imagen'])) {
                chmod("../views/img/img/" . $datos['url_imagen'], 0777);
                unlink("../views/img/img/" . $datos['url_imagen']);
            }

            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Producto eliminado",
                "texto" => "El usuario " . $datos['nombre_producto'] . " ha sido eliminado del sistema correctamente",
                "icono" => "success"
            ];

        } else {

            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos podido eliminar el usuario " . $datos['nombre_producto'] . " del sistema, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
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
        $id_categoria = $this->limpiarCadena($_POST['id_categoria']);
        $precio = $this->limpiarCadena($_POST['precio']);
        $stock = $this->limpiarCadena($_POST['stock']);
       

        # Verificando campos obligatorios #
        if (
            $codigo_producto == "" || $nombre_producto == "" || $precio == "" || $stock == "" || $id_categoria == ""
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
        $datosAlmacen = $this->ejecutarConsulta("SELECT stock FROM stock_almacen WHERE id_producto='$id' AND id_almacen = 1");
        if ($datosAlmacen->rowCount() > 0) {
            $filaAlmacen = $datosAlmacen->fetch();
            $stockAlmacenActual = $filaAlmacen['stock'];
            $stockAlmacenFinal = $stockAlmacenActual + $nuevoStock;
            $actualizarAlmacen = $this->ejecutarConsulta("UPDATE stock_almacen SET stock = '$stockAlmacenFinal' WHERE id_producto='$id' AND id_almacen = 1");
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