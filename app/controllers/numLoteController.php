<?php
namespace app\controllers;

use app\models\mainModel;

class numLoteController extends mainModel
{
    
    public function registrarNumLoteControlador()
    {
        $fechaInicio = $this->limpiarCadena($_POST['fecha_inicio']);
        $fechaFin = $this->limpiarCadena($_POST['fecha_fin']);

        if ($fechaInicio == "" || $fechaFin == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        // Obtener el último número de lote registrado
        $ultimoNumeroLote = $this->obtenerUltimoNumeroLote();

        // Generar el nuevo número de lote
        $numeroLote = $this->generarNumeroLote($fechaInicio, $fechaFin, $ultimoNumeroLote);

        if (!$numeroLote) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "Error al generar el número de lote",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        $datos_reg = [
            [
                "campo_nombre" => "numero_lote",
                "campo_marcador" => ":NumeroLote",
                "campo_valor" => $numeroLote
            ]
        ];

        $registrar_lote = $this->guardarDatos("numeros_lote", $datos_reg);

        if ($registrar_lote->rowCount() > 0) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Número de Lote generado",
                "texto" => "El número de lote $numeroLote se generó y almacenó con éxito",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo almacenar el número de lote, contacte con su administrador",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    private function obtenerUltimoNumeroLote()
    {
        $consulta = "
            SELECT 
                numero_lote
            FROM 
                numeros_lote
            ORDER BY 
                id_numero_lote DESC
            LIMIT 1
        ";

        $stmt = $this->conectar()->prepare($consulta);
        $stmt->execute();
        $dato = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($dato) {
            // Extraer la parte numérica final del número de lote
            $ultimoNumero = substr($dato['numero_lote'], -3);
            return (int)$ultimoNumero;
        }

        return 0; // Si no hay ningún registro, comenzamos desde 0
    }

    private function generarNumeroLote($fechaInicio, $fechaFin, $ultimoNumeroLote)
    {
        $inicio = strtotime($fechaInicio);
        $fin = strtotime($fechaFin);

        if ($inicio > $fin) {
            return false;
        }

        $diaInicio = date('d', $inicio);
        $mesInicio = $this->convertirMesARomano(date('m', $inicio));
        $anioInicio = date('y', $inicio);

        $diaFin = date('d', $fin);
        $mesFin = $this->convertirMesARomano(date('m', $fin));
        $anioFin = date('y', $fin);

        // Incrementar el número de lote
        $nuevoNumeroLote = str_pad($ultimoNumeroLote + 1, 4, '0', STR_PAD_LEFT);

        $numeroLote = sprintf('%02d%s%s-%02d%s%s-%s', $diaInicio, $mesInicio, $anioInicio, $diaFin, $mesFin, $anioFin, $nuevoNumeroLote);
        return $numeroLote;
    }

    private function convertirMesARomano($mes)
    {
        $mesesRomanos = [
            '01' => 'I', '02' => 'II', '03' => 'III', '04' => 'IV',
            '05' => 'V', '06' => 'VI', '07' => 'VII', '08' => 'VIII',
            '09' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII'
        ];

        return $mesesRomanos[$mes];
    }




    /*----------  Controlador listar productos  ----------*/
  
    public function listarNumLoteControlador($pagina, $registros, $url, $busqueda)
{
    $pagina = $this->limpiarCadena($pagina);
    $registros = $this->limpiarCadena($registros);
    $url = $this->limpiarCadena($url);
    $url = APP_URL . $url . "/";
    $busqueda = $this->limpiarCadena($busqueda);
    $tabla = "";

    // Consulta para obtener todos los números de lote
    $consulta_datos = "
        SELECT 
            id_numero_lote,
            numero_lote,
            fecha_registro
        FROM 
            numeros_lote
    ";

    $stmt = $this->conectar()->prepare($consulta_datos);
    $stmt->execute();
    $datos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    if (empty($datos)) {
        return "No se encontraron resultados.";
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
                    <h4>Listado de Números de Lote</h4>
                </div>
                <table class="table table-bordered" style="width: 100%; font-size: 13px;">
                    <thead>
                        <tr>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">ID</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Número de Lote</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Fecha de Registro</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>';

    foreach ($datos as $rows) {
        $tabla .= '
        <tr>
            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['id_numero_lote'] . '</td>
            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['numero_lote'] . '</td>
            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . date('d/m/Y', strtotime($rows['fecha_registro'])) . '</td>
            <td style="text-align: center; border: 1px solid #000; padding: 5px;">
                <button class="btn btn-primary" onclick="imprimirArea(\'areaImprimir-' . $rows['id_numero_lote'] . '\', \'' . $rows['numero_lote'] . '\')">Imprimir</button>
            </td>
        </tr>';
    }

    $tabla .= '
                    </tbody>
                </table>
            </div>
        </div>
    </div>';

    foreach ($datos as $rows) {
        $tabla .= '
        <div id="areaImprimir-' . $rows['id_numero_lote'] . '" style="display: none;">
            <div class="container-fluid">
                <div style="text-align: center; margin: 20px 0;">
                    <h2>Registro de Número de Lote</h2>
                </div>
                <div class="invoice">
                    <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding-left: 5px; padding-right: 5px;">
                        <p style="font-size: 14px; text-align: center;"><strong>Número de Lote</strong></p>
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <img src="' . APP_URL . 'app/views/fotos/logo_orden.png" alt="logo" style="width:200px; height:auto;">
                            <div>
                                <p style="font-size: 13px; padding: 0px; margin: 0px;"><strong>Número de Lote:</strong> ' . $rows['numero_lote'] . '</p>
                                <p style="font-size: 13px; padding: 0px; margin: 0px;"><strong>Fecha de Registro:</strong> ' . date('d/m/Y', strtotime($rows['fecha_registro'])) . '</p>
                            </div>
                        </div>
                        <p style="margin-top: 0; margin-bottom: 0;">RADIOTECNOLOGÍA INDUSTRIAL S.A. DE C.V.</p>
                        <p style="margin-top: 0; margin-bottom: 0;">RFC: RIN070219R38</p>
                        <p style="margin-top: 0; margin-bottom: 0;">Calle Puebla Sur. Manzana 4. Lote 5 Nave B Int. 2 Col. Jardín Industrial</p>
                        <p style="margin-top: 0; margin-bottom: 0;">Ixtapaluca. Edo. de México, C.P. 56535</p>
                    </div>
                </div>
            </div>
        </div>';
    }

    $tabla .= '<script>
    function imprimirArea(id, title) {
        var contenido = document.getElementById(id).innerHTML;
        var ventanaImpresion = window.open("", "_blank");
        ventanaImpresion.document.write("<html><head><title>" + title + "</title>");
        ventanaImpresion.document.write("<style>body { font-family: Arial, sans-serif; line-height: 1; }</style>");
        ventanaImpresion.document.write("</head><body>");
        ventanaImpresion.document.write(contenido);
        ventanaImpresion.document.write("</body></html>");
        ventanaImpresion.document.close();
        ventanaImpresion.print();
    }
    </script>';

    return $tabla;
}


}


    
    
    

    

  
