<?php

namespace app\controllers;

use app\models\mainModel;

class numSerController extends mainModel
{

  

/*----------  Controlador listar  ----------*/
public function listarNumSerControlador($pagina, $registros, $url, $busqueda, $fechaInicio = '', $fechaFin = '', $id_numero_lote = '')
{
    $pagina = $this->limpiarCadena($pagina);
    $registros = $this->limpiarCadena($registros);
    $url = $this->limpiarCadena($url);
    $url = APP_URL . $url . "/";
    $busqueda = $this->limpiarCadena($busqueda);

    $fechaInicio = isset($_POST['fechaInicio']) ? $this->limpiarCadena($_POST['fechaInicio']) : '';
    $fechaFin = isset($_POST['fechaFin']) ? $this->limpiarCadena($_POST['fechaFin']) : '';
    $id_numero_lote = isset($_POST['id_numero_lote']) ? $this->limpiarCadena($_POST['id_numero_lote']) : '';

    // Verificar si es una solicitud AJAX para actualizar el estado de aprobado
    if (isset($_POST['actualizarAprobado']) && isset($_POST['id']) && isset($_POST['aprobado'])) {
        $id = $_POST['id'];
        $aprobado = $_POST['aprobado'];

        $actualizacion = "UPDATE numeros_serie SET aprobado = $aprobado WHERE id_numero_serie = $id";
        $resultadoActualizacion = $this->ejecutarConsulta($actualizacion);

        if ($resultadoActualizacion) {
            echo json_encode(['status' => 'success', 'message' => 'Estado de pago actualizado correctamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el estado de pago.']);
        }
        exit;
    }

    $tabla = '
    <div class="container-fluid">
        <div class="row">
            <!-- Menú lateral -->
            <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'regNumeroLote/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Registrar Nº Lote
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'consultaNumeroLote/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Consultar Nº Lote
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'regNumeroSerie/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Registrar Nº Serie
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'consultaNumeroSerie/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Consultar Nº Serie
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'salidasProductoTerminado/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Registrar Salidas
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'salidaPTNew/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Registro Salidas Nº Serie
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'salidaPTSearch/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Consultar Vale Salida
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'numSerSearch/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Consultar Registros
                        </a>
                    </li>
                </ul>
                <hr>
            </div>

            <!-- Contenido principal -->
            <div class="col-md-9 col-lg-10 py-4">
                <div style="text-align: center; margin: 20px 0;">
                    <h4>Listado de Números de Serie</h4>
                </div>
                
                <!-- Formulario de búsqueda y filtro -->
                <form method="POST" action="' . $url . '">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="fechaInicio" placeholder="Fecha Inicio" value="' . htmlspecialchars($fechaInicio) . '">
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="fechaFin" placeholder="Fecha Fin" value="' . htmlspecialchars($fechaFin) . '">
                        </div>';

    // Consulta para obtener la lista de lotes
    $consulta_lotes = "SELECT * FROM numeros_lote ORDER BY id_numero_lote";
    $datos_lotes = $this->ejecutarConsulta($consulta_lotes);
    $opciones_lotes = "";

    while ($lote = $datos_lotes->fetch()) {
        $selected = ($lote['id_numero_lote'] == $id_numero_lote) ? 'selected' : '';
        $opciones_lotes .= '<option value="' . $lote['id_numero_lote'] . '" ' . $selected . '>'
                         . htmlspecialchars($lote['numero_lote']) . '</option>';
    }

   // Continuación del formulario
   $tabla .= '
   <div class="col-md-4">
       <select class="form-control" name="id_numero_lote" required>
           <option value="">Seleccione Número de Lote</option>
           ' . $opciones_lotes . '
       </select>
   </div>
   <div class="col-md-4 mt-3">
       <button type="submit" class="btn btn-primary">Filtrar</button>
   </div>
</div>
</form>';

if (!empty($fechaInicio) && !empty($fechaFin)) {
$pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

// Condiciones para la consulta SQL
$condiciones = "numeros_serie.fecha_registro BETWEEN '$fechaInicio' AND '$fechaFin'";
if (!empty($id_numero_lote)) {
$condiciones .= " AND numeros_serie.id_numero_lote = $id_numero_lote";
}

$consulta_datos = "SELECT
numeros_serie.id_numero_serie,
numeros_serie.numero_serie,
numeros_lote.numero_lote,
numeros_serie.fecha_registro,
numeros_serie.aprobado
FROM
numeros_serie
JOIN
numeros_lote ON numeros_serie.id_numero_lote = numeros_lote.id_numero_lote
WHERE
$condiciones
ORDER BY
numeros_serie.id_numero_serie ASC
LIMIT
$inicio, $registros;";

$consulta_total = "SELECT COUNT(*)
FROM numeros_serie
WHERE
$condiciones;";

$datos = $this->ejecutarConsulta($consulta_datos);
$datos = $datos->fetchAll();

$total = $this->ejecutarConsulta($consulta_total);
$total = (int) $total->fetchColumn();


// Obtener el número de lote seleccionado
$numero_lote = "";
if (!empty($id_numero_lote)) {
    $consulta_lote = "SELECT numero_lote FROM numeros_lote WHERE id_numero_lote = :id_numero_lote";
    $stmt_lote = $this->conectar()->prepare($consulta_lote);
    $stmt_lote->bindParam(':id_numero_lote', $id_numero_lote, \PDO::PARAM_INT);
    $stmt_lote->execute();
    $resultado_lote = $stmt_lote->fetch(\PDO::FETCH_ASSOC);
    if ($resultado_lote) {
        $numero_lote = $resultado_lote['numero_lote'];
    }
}


$tabla .= '
<button class="btn btn-primary mb-3" onclick="imprimirArea(\'areaImprimir\')">Imprimir</button>
<div id="areaImprimir">
<div class="invoice">
   <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding-left: 5px; padding-right: 5px;">
       <p style="font-size: 14px; text-align: center;"><strong>Números de Serie</strong></p>
       <div style="display: flex; align-items: center; justify-content: space-between;">
           <img src="' . APP_URL . 'app/views/fotos/logo_orden.png" alt="logo" style="width:200px; height:auto;">
           <div>
               <p style="font-size: 13px; padding: 0px; margin: 0px;"><strong>Fecha:</strong> ' . date('d/m/Y') . '</p>
               <p style="font-size: 13px; padding: 0px; margin: 0px;"><strong>Número de Lote:</strong> ' . htmlspecialchars($numero_lote) . '</p>
           </div>
       </div>
       <p style="margin-top: 0; margin-bottom: 0;">RADIOTECNOLOGÍA INDUSTRIAL S.A. DE C.V.</p>
       <p style="margin-top: 0; margin-bottom: 0;">RFC: RIN070219R38</p>
       <p style="margin-top: 0; margin-bottom: 0;">Calle Puebla Sur. Manzana 4. Lote 5 Nave B Int. 2 Col. Jardín Industrial</p>
       <p style="margin-top: 0; margin-bottom: 0;">Ixtapaluca. Edo. de México, C.P. 56535</p>
   </div>
</div>
<div class="text-center">
   <h2>Reporte de Números de Serie</h2>
   <p>Desde ' . htmlspecialchars($fechaInicio) . ' hasta ' . htmlspecialchars($fechaFin) . '</p>
</div>
<div class="table-responsive">
   <table class="table table-striped table-bordered">
       <thead class="table-dark">
           <tr>
               <th>Número de Serie</th>
               <th>Número de Lote</th>
               <th>Fecha de Registro</th>
               <th>Facturado</th>
           </tr>
       </thead>
       <tbody>';

if ($total >= 1) {
foreach ($datos as $rows) {
$fechaFormateada = date('d/m/Y', strtotime($rows['fecha_registro']));
$checked = $rows['aprobado'] ? 'checked' : '';
$tabla .= '
           <tr>
               <td>' . htmlspecialchars($rows['numero_serie']) . '</td>
               <td>' . htmlspecialchars($rows['numero_lote']) . '</td>
               <td>' . htmlspecialchars($fechaFormateada) . '</td>
               <td>
                   <input type="checkbox" onchange="actualizarAprobado(' . $rows['id_numero_serie'] . ', this.checked)" ' . $checked . '>
               </td>
           </tr>';
}
} else {
$tabla .= '<tr><td colspan="4" class="text-center">No hay registros que coincidan con la búsqueda.</td></tr>';
}

$tabla .= '
       </tbody>
   </table>
</div>
</div>';

$tabla .= '
<script>
function imprimirArea(id) {
var contenido = document.getElementById(id).innerHTML;
var ventanaImpresion = window.open("", "_blank");
ventanaImpresion.document.write("<html><head><title>Imprimir</title>");
ventanaImpresion.document.write("<style>");
ventanaImpresion.document.write("body,td { font-family: Arial, sans-serif; line-height: 1.6; text-align: center; }");
ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; }");
ventanaImpresion.document.write("th, td { border: 1px solid black; padding: 8px; }");
ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
ventanaImpresion.document.write("</style>");
ventanaImpresion.document.write("</head><body>");
ventanaImpresion.document.write(contenido);
ventanaImpresion.document.write("</body></html>");
ventanaImpresion.document.close();
ventanaImpresion.print();
}

function actualizarAprobado(id, aprobado) {
var xhr = new XMLHttpRequest();
xhr.open("POST", "' . $url . '", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.onreadystatechange = function() {
   if (xhr.readyState === 4) {
       if (xhr.status === 200) {
           var response = JSON.parse(xhr.responseText);
           if (response.status === "success") {
               console.log("Actualización exitosa");
           } else {
               console.log("Error en la actualización: " + response.message);
           }
       } else {
           console.log("Error en la solicitud AJAX: " + xhr.status);
       }
   }
};
xhr.send("actualizarAprobado=1&id=" + id + "&aprobado=" + (aprobado ? 1 : 0));
}
</script>';
}

$tabla .= '
</div>
</div>
</div>';

return $tabla;
}







}