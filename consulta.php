<?php
/////// CONEXIÓN A LA BASE DE DATOS /////////
$host = 'localhost';
$basededatos = 'borgattaingenieria';
$usuario = 'root';
$contraseña = '';

$conexion = new mysqli($host, $usuario, $contraseña, $basededatos);
if ($conexion->connect_errno) {
    die("Fallo la conexion: (" . $conexion->connect_errno . ") " . $conexion->connect_error);
}

$tabla = "";
$query = "SELECT
    productos.*,
    categorias.nombre_categoria,
    proveedores.nombre_proveedor,
    unidades_medida.nombre_unidad,
    tipos_moneda.nombre_moneda,
    SUM(CASE WHEN almacenes.nombre_almacen = 'Almacen General' THEN stock_almacen.stock ELSE 0 END) AS stock_general,
    SUM(CASE WHEN almacenes.nombre_almacen = 'Almacen de Maquinado' THEN stock_almacen.stock ELSE 0 END) AS stock_maquinados,
    SUM(CASE WHEN almacenes.nombre_almacen = 'Almacen de Ensamble' THEN stock_almacen.stock ELSE 0 END) AS stock_ensamble
FROM productos
JOIN categorias ON productos.id_categoria = categorias.id_categoria
JOIN proveedores ON productos.id_proveedor = proveedores.id_proveedor
JOIN unidades_medida ON productos.id_unidad = unidades_medida.id_unidad
JOIN tipos_moneda ON productos.id_moneda = tipos_moneda.id_moneda
LEFT JOIN stock_almacen ON productos.id_producto = stock_almacen.id_producto
LEFT JOIN almacenes ON stock_almacen.id_almacen = almacenes.id_almacen
GROUP BY productos.id_producto
ORDER BY productos.nombre_producto";


if (isset($_POST['alumnos'])) {
    $q = $conexion->real_escape_string($_POST['alumnos']);
    $query = "SELECT
        productos.*,
        categorias.nombre_categoria,
        proveedores.nombre_proveedor,
        unidades_medida.nombre_unidad,
        tipos_moneda.nombre_moneda,
        SUM(CASE WHEN almacenes.nombre_almacen = 'Almacen General' THEN stock_almacen.stock ELSE 0 END) AS stock_general,
        SUM(CASE WHEN almacenes.nombre_almacen = 'Almacen de Maquinado' THEN stock_almacen.stock ELSE 0 END) AS stock_maquinados,
        SUM(CASE WHEN almacenes.nombre_almacen = 'Almacen de Ensamble' THEN stock_almacen.stock ELSE 0 END) AS stock_ensamble
    FROM productos
    JOIN categorias ON productos.id_categoria = categorias.id_categoria
    JOIN proveedores ON productos.id_proveedor = proveedores.id_proveedor
    JOIN unidades_medida ON productos.id_unidad = unidades_medida.id_unidad
    JOIN tipos_moneda ON productos.id_moneda = tipos_moneda.id_moneda
    LEFT JOIN stock_almacen ON productos.id_producto = stock_almacen.id_producto
    LEFT JOIN almacenes ON stock_almacen.id_almacen = almacenes.id_almacen
    WHERE productos.nombre_producto LIKE '%" . $q . "%' OR productos.id_producto LIKE '%" . $q . "%' OR productos.codigo_producto LIKE '%" . $q . "%' OR categorias.nombre_categoria LIKE '%" . $q . "%'
    GROUP BY productos.id_producto
    ORDER BY productos.nombre_producto";
}



$buscarAlumnos = $conexion->query($query);
if ($buscarAlumnos->num_rows > 0) {
    $tabla = '<table class="table table-dark">';
$tabla .= '<thead>';
$tabla .= '<tr>';
$tabla .= '<th>ID Producto</th>';
$tabla .= '<th>Código Producto</th>';
$tabla .= '<th>Nombre Producto</th>';
$tabla .= '<th>Categoria</th>';
$tabla .= '<th>Almacen General</th>';
$tabla .= '<th>Maquinados</th>';
$tabla .= '<th>Ensamble</th>';
$tabla .= '<th>Imagen</th>';
$tabla .= '</tr>';
$tabla .= '</thead>';
$tabla .= '<tbody>';
    while ($filaAlumnos = $buscarAlumnos->fetch_assoc()) {
		$tabla .= '<tr>';
$tabla .= '<td>' . $filaAlumnos['id_producto'] . '</td>';
$tabla .= '<td>' . $filaAlumnos['codigo_producto'] . '</td>';
$tabla .= '<td>' . $filaAlumnos['nombre_producto'] . '</td>';
$tabla .= '<td>' . $filaAlumnos['nombre_categoria'] . '</td>';
$tabla .= '<td>' . $filaAlumnos['stock_general'] . '</td>';
$tabla .= '<td>' . $filaAlumnos['stock_maquinados'] . '</td>';
$tabla .= '<td>' . $filaAlumnos['stock_ensamble'] . '</td>';
$tabla .= '<td><img src="app/views/img/img/' . $filaAlumnos['url_imagen'] . '" class="card-img-top" alt="..." style="width: 50px; height: 50px;"></td>';
$tabla .= '</tr>';

    }
    $tabla .= '</tbody>';
$tabla .= '</table>';

} else {
    $tabla .= 'No se encontraron resultados.';
}

echo $tabla;
?>
