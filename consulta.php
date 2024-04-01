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
$query = "SELECT * FROM productos ORDER BY nombre_producto";

if (isset($_POST['alumnos'])) {
    $q = $conexion->real_escape_string($_POST['alumnos']);
    $query = "SELECT * FROM productos WHERE nombre_producto LIKE '%" . $q . "%' OR id_producto LIKE '%" . $q . "%' OR codigo_producto LIKE '%" . $q . "%'";
}


$buscarAlumnos = $conexion->query($query);
if ($buscarAlumnos->num_rows > 0) {
    $tabla = '<table class="table table-dark">';
$tabla .= '<thead>';
$tabla .= '<tr>';
$tabla .= '<th>ID Producto</th>';
$tabla .= '<th>Código Producto</th>';
$tabla .= '<th>Nombre Producto</th>';
$tabla .= '<th>Stock</th>';
$tabla .= '</tr>';
$tabla .= '</thead>';
$tabla .= '<tbody>';
    while ($filaAlumnos = $buscarAlumnos->fetch_assoc()) {
		$tabla .= '<tr>';
    $tabla .= '<td>' . $filaAlumnos['id_producto'] . '</td>';
    $tabla .= '<td>' . $filaAlumnos['codigo_producto'] . '</td>';
    $tabla .= '<td>' . $filaAlumnos['nombre_producto'] . '</td>';
    $tabla .= '<td>' . $filaAlumnos['stock'] . '</td>';
    $tabla .= '</tr>';
    }
    $tabla .= '</tbody>';
$tabla .= '</table>';

} else {
    $tabla .= 'No se encontraron resultados.';
}

echo $tabla;
?>
