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
            echo "Estado de pago actualizado correctamente.";
        } else {
            echo "Error al actualizar el estado de pago.";
        }
        exit;
    }

    // Formulario de búsqueda y filtro
    $tabla = '
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

    // Continuación del formulario en la cadena $tabla
    $tabla .= '
            <div class="col-md-4">
                <select class="form-control" name="id_numero_lote" required>
                    <option value="">Seleccione Número de Lote</option>
                    ' . $opciones_lotes . '
                </select>
            </div>
            <div class="col-md-4">
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

        $tabla .= '
<button class="btn btn-primary mb-3" onclick="imprimirArea(\'areaImprimir\')">Imprimir</button>
<div id="areaImprimir">
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

    return $tabla;
}







}