<?php
namespace app\controllers;
//require_once "./app/views/libreriapdf/dompdf/autoload.inc.php";


use app\models\mainModel;

class numSerieController extends mainModel
{

   public function obtenerOpcionesNumLotes()
    {
        $consulta_lotes = "SELECT * FROM numeros_lote ORDER BY numero_lote";
        $datos_lotes = $this->ejecutarConsulta($consulta_lotes);
        $opciones_lotes = "";

        while ($lotes = $datos_lotes->fetch()) {
            $opciones_lotes .= '<option value="' . $lotes['id_numero_lote'] . '">'
                . $lotes['numero_lote'] . '</option>';
        }

        return $opciones_lotes;
    }


    /*----------  Controlador registrar usuario  ----------*/
  public function registrarNumSerieControlador()
{
    // Generando número de serie automático
$ultimoNumeroSerie = $this->obtenerUltimoNumeroSerie();
$nuevoNumeroSerie = 'PTARC001-5-' . str_pad($ultimoNumeroSerie + 1, 4, '0', STR_PAD_LEFT);

    // Almacenando datos del formulario
    $id_numero_lote = $this->limpiarCadena($_POST['id_lote']);

    // Verificando campos obligatorios
    if (empty($id_numero_lote)) {
        $alerta = [
            "tipo" => "simple",
            "titulo" => "Error",
            "texto" => "Selecciona un lote válido",
            "icono" => "error"
        ];
        return json_encode($alerta);
    }

    // Preparando datos para la inserción
    $datosRegistro = [
        [
            "campo_nombre" => "numero_serie",
            "campo_marcador" => ":NumeroSerie",
            "campo_valor" => $nuevoNumeroSerie
        ],
        [
            "campo_nombre" => "id_numero_lote",  // Asegúrate de que el nombre sea correcto aquí
            "campo_marcador" => ":IdNumeroLote",
            "campo_valor" => $id_numero_lote
        ]
    ];

    // Guardando datos en la base de datos
    $registro = $this->guardarDatos("numeros_serie", $datosRegistro);

    if ($registro->rowCount() === 1) {
        $alerta = [
            "tipo" => "limpiar",
            "titulo" => "Éxito",
            "texto" => "Número de serie registrado correctamente: $nuevoNumeroSerie",
            "icono" => "success"
        ];
    } else {
        $alerta = [
            "tipo" => "simple",
            "titulo" => "Error",
            "texto" => "No se pudo registrar el número de serie",
            "icono" => "error"
        ];
    }

    return json_encode($alerta);
}



  private function obtenerUltimoNumeroSerie()
{
    $consulta_ultimo_numero = "SELECT MAX(CAST(SUBSTRING(numero_serie, 12) AS UNSIGNED)) AS ultimo_numero FROM numeros_serie WHERE numero_serie LIKE 'PTARC001-5-%'";
    $resultado = $this->ejecutarConsulta($consulta_ultimo_numero)->fetch();
    return $resultado ? intval($resultado['ultimo_numero']) : 0;
}


public function listarNumSerieControlador($busqueda)
{
    $busqueda = $this->limpiarCadena($busqueda);
    $tabla = "";

    // Consulta para obtener los números de serie correspondientes a los números de lote
    $consulta_datos = "
        SELECT 
            numeros_lote.numero_lote,
            numeros_serie.numero_serie,
            numeros_serie.fecha_registro,
            numeros_serie.aprobado,
            numeros_serie.id_numero_serie
        FROM 
            numeros_lote 
        LEFT JOIN 
            numeros_serie 
        ON 
            numeros_lote.id_numero_lote = numeros_serie.id_numero_lote 
        WHERE 
            numeros_lote.id_numero_lote = :busqueda;
    ";

    $stmt = $this->conectar()->prepare($consulta_datos);
    $stmt->bindParam(':busqueda', $busqueda, \PDO::PARAM_INT);
    $stmt->execute();
    $datos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    if (empty($datos)) {
        return "No se encontraron resultados.";
    }

    $numero_lote = $datos[0]['numero_lote'];

    $tabla = '
    <button class="btn btn-primary" onclick="imprimirArea(\'areaImprimir\', \'' . $numero_lote . '\')">Imprimir</button>
    <div id="areaImprimir">
    <div class="container-fluid">
    <div style="text-align: center; margin: 20px 0;">
            
        </div>

    <div class="invoice">

    <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding-left: 5px; padding-right: 5px;">
    <p style="font-size: 14px; text-align: center;"><strong>Números de Serie</strong></p>
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <div>
            <p style="font-size: 13px; padding: 0px; margin: 0px;"><strong>Número de Lote:</strong>' . $numero_lote . '</p>
        </div>
    </div>
    </div>
        
        <table class="table" style="width: 100%; padding-top: 2; font-size: 13px;">
            <thead>
                <tr>
                    <th style="text-align: center; border: 1px solid #000; padding: 5px;">Número de Serie</th>
                    <th style="text-align: center; border: 1px solid #000; padding: 5px;">Fecha de Registro</th>
                    <th style="text-align: center; border: 1px solid #000; padding: 5px;">Aprobado</th>
                </tr>
            </thead>
            <tbody>';

    foreach ($datos as $rows) {
        $checked = $rows['aprobado'] ? "checked" : "";
        $tabla .= '
        <tr>
            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['numero_serie'] . '</td>
            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['fecha_registro'] . '</td>
            <td style="text-align: center; border: 1px solid #000; padding: 5px;">
                <input type="checkbox" class="aprobar-checkbox" data-id="' . $rows['id_numero_serie'] . '" ' . $checked . '>
            </td>
        </tr>';
    }

    $tabla .= '
    <style>
    @media print {
        .sello-impresion {
            position: fixed;
            bottom: 50px;
            width: 100%;
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }
    }
    @media screen {
        .sello-impresion {
            display: none;
        }
    }
    </style>
    <div class="sello-impresion">Sello</div>
    ';

    $tabla .= '<script>
    function imprimirArea(id) {
        var contenido = document.getElementById(id).innerHTML;
        var ventanaImpresion = window.open("", "_blank");
        ventanaImpresion.document.write("<html><head><title>' . $numero_lote . '</title>");
        ventanaImpresion.document.write("<style>");
        ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
        ventanaImpresion.document.write("</style>");
        ventanaImpresion.document.write("</head><body>");
        ventanaImpresion.document.write(contenido);
        ventanaImpresion.document.write("</body></html>");
        ventanaImpresion.document.close();
        ventanaImpresion.print();
    }

    document.querySelectorAll(".aprobar-checkbox").forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            var id = this.getAttribute("data-id");
            var aprobado = this.checked ? 1 : 0;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "' . APP_URL . 'app/ajax/cambiarEstadoAprobadoAjax.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    alert(response.message);
                }
            };
            xhr.send("id_numero_serie=" + id + "&aprobado=" + aprobado);
        });
    });
    </script>';

    return $tabla;
}

public function cambiarEstadoAprobado($id_numero_serie, $aprobado)
{
    $consulta = "UPDATE numeros_serie SET aprobado = :aprobado WHERE id_numero_serie = :id_numero_serie";
    $stmt = $this->conectar()->prepare($consulta);
    $stmt->bindParam(':aprobado', $aprobado, \PDO::PARAM_BOOL);
    $stmt->bindParam(':id_numero_serie', $id_numero_serie, \PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return ["status" => "success", "message" => "Estado actualizado correctamente."];
    } else {
        return ["status" => "error", "message" => "No se pudo actualizar el estado."];
    }
}





}