<?php

namespace app\controllers;

use app\models\mainModel;

class inventoryListController extends mainModel
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



   

    
   /*----------  Controlador listar productos  ----------*/
   public function listarInventoryListControlador($pagina, $registros, $url, $busqueda)
{
    $pagina = $this->limpiarCadena($pagina);
    $registros = $this->limpiarCadena($registros);
    $url = $this->limpiarCadena($url);
    $url = APP_URL . $url . "/";
    $busqueda = $this->limpiarCadena($busqueda);

    $tabla = "";

    $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
    $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

    // Obtener categorías para el menú desplegable
    $consulta_categorias = "SELECT id_categoria, nombre_categoria FROM categorias";
    $categorias = $this->ejecutarConsulta($consulta_categorias)->fetchAll();

    $consulta_datos = "SELECT
            productos.*,
            categorias.nombre_categoria,
            proveedores.nombre_proveedor,
            unidades_medida.nombre_unidad,
            tipos_moneda.nombre_moneda,
            sub_categorias.nombre_subcategoria,
            SUM(CASE WHEN almacenes.nombre_almacen = 'Almacen General' THEN stock_almacen.stock ELSE 0 END) AS stock_general,
            SUM(CASE WHEN almacenes.nombre_almacen = 'Area de Maquinado' THEN stock_almacen.stock ELSE 0 END) AS stock_maquinados,
            SUM(CASE WHEN almacenes.nombre_almacen = 'Area de Ensamble' THEN stock_almacen.stock ELSE 0 END) AS stock_ensamble
        FROM productos
        JOIN categorias ON productos.id_categoria = categorias.id_categoria
        JOIN proveedores ON productos.id_proveedor = proveedores.id_proveedor
        JOIN unidades_medida ON productos.id_unidad = unidades_medida.id_unidad
        JOIN tipos_moneda ON productos.id_moneda = tipos_moneda.id_moneda
        JOIN sub_categorias ON productos.id_subcategoria = sub_categorias.id_subcategoria
        LEFT JOIN stock_almacen ON productos.id_producto = stock_almacen.id_producto
        LEFT JOIN almacenes ON stock_almacen.id_almacen = almacenes.id_almacen
        WHERE 1 = 1
        GROUP BY productos.id_producto
        ORDER BY productos.ubicacion ASC;";

    $consulta_total = "SELECT COUNT(DISTINCT productos.id_producto)
    FROM productos
    JOIN categorias ON productos.id_categoria = categorias.id_categoria
    JOIN proveedores ON productos.id_proveedor = proveedores.id_proveedor
    JOIN unidades_medida ON productos.id_unidad = unidades_medida.id_unidad
    JOIN tipos_moneda ON productos.id_moneda = tipos_moneda.id_moneda
    JOIN sub_categorias ON productos.id_subcategoria = sub_categorias.id_subcategoria
    LEFT JOIN stock_almacen ON productos.id_producto = stock_almacen.id_producto
    LEFT JOIN almacenes ON stock_almacen.id_almacen = almacenes.id_almacen
    WHERE 1 = 1;";

    $datos = $this->ejecutarConsulta($consulta_datos);
    $datos = $datos->fetchAll();

    $total = $this->ejecutarConsulta($consulta_total);
    $total = (int) $total->fetchColumn();

    // Botones para cambiar la vista y el buscador en tiempo real
    $tabla .= '
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between mb-3">
            <div class="input-group" style="max-width: 300px;">
                <select class="form-select" id="categorySelect">
                    <option value="">Todas las Categorías</option>';
                    foreach ($categorias as $categoria) {
                        $tabla .= '<option value="' . $categoria['nombre_categoria'] . '">' . $categoria['nombre_categoria'] . '</option>';
                    }
    $tabla .= '  </select>
            </div>
            <div>
                <button class="btn btn-success" onclick="imprimirTabla()">Imprimir</button>
            </div>
        </div>
    ';

    // Vista de lista
    $tabla .= '<div id="vistaLista" class="table-responsive">
        <table class="table table-bordered table-striped table-hover" id="tablaProductos">
            <thead class="thead-dark">
                <tr>
                    <th>Imagen</th>
                    <th>Id</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Ubicación</th>
                    <th>Precio</th>
                    <th>Moneda</th>
                    <th>Unidad de Medida</th>
                    <th>Stock Almacén General</th>
                    <th>Stock Maquinados</th>
                    <th>Stock Ensamble</th>
                    <th>Categoría</th>
                    <th>Conteo Físico</th>
                </tr>
            </thead>
            <tbody id="productTableBody">';

    if ($total >= 1) {
        foreach ($datos as $rows) {
            $tabla .= '
            <tr class="lista-item" data-categoria="' . htmlspecialchars($rows['nombre_categoria']) . '">
                <td><img src="' . APP_URL . 'app/views/img/img/' . $rows['url_imagen'] . '" class="img-thumbnail" alt="..." style="width: 50px; height: 50px;"></td>
                <td>' . htmlspecialchars($rows['id_producto']) . '</td>
                <td>' . htmlspecialchars($rows['codigo_producto']) . '</td>
                <td>' . htmlspecialchars($rows['nombre_producto']) . '</td>
                <td>' . htmlspecialchars($rows['ubicacion']) . '</td>
                <td>' . htmlspecialchars($rows['precio']) . '</td>
                <td>' . htmlspecialchars($rows['nombre_moneda']) . '</td>
                <td>' . htmlspecialchars($rows['nombre_unidad']) . '</td>
                <td>' . htmlspecialchars($rows['stock_general']) . '</td>
                <td>' . htmlspecialchars($rows['stock_maquinados']) . '</td>
                <td>' . htmlspecialchars($rows['stock_ensamble']) . '</td>
                <td>' . htmlspecialchars($rows['nombre_categoria']) . '</td>
                <td></td>
            </tr>';
        }
    } else {
        $tabla .= '
            <tr>
                <td colspan="13" class="text-center">No hay registros que coincidan con la búsqueda.</td>
            </tr>';
    }

    $tabla .= '
            </tbody>
        </table>
    </div>';

    $tabla .= '</div>';

    // JavaScript para filtrar por categoría y ajustar la impresión
    $tabla .= '<script>
    // Filtro por categoría en tiempo real
    document.getElementById("categorySelect").addEventListener("change", function() {
        var categorySelect = this.value.toUpperCase();
        var listaItems = document.querySelectorAll(".lista-item");

        listaItems.forEach(function(item) {
            var itemCategory = item.getAttribute("data-categoria").toUpperCase();
            if (categorySelect === "" || itemCategory === categorySelect) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });
    });

    // Función para imprimir la tabla en horizontal
    function imprimirTabla() {
        var tabla = document.getElementById("tablaProductos").outerHTML;
        var ventana = window.open("", "_blank");
        ventana.document.write("<html><head><title>Imprimir Tabla</title>");
        ventana.document.write("<style>");
        ventana.document.write("@media print { @page { size: landscape; } }"); // Cambiar orientación a horizontal
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



   





}