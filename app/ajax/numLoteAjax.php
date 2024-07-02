<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\numLoteController; // Verifica que el namespace y la clase estén definidos correctamente

if (isset($_POST['modulo_numero_lote'])) {
    $insNumLote = new numLoteController();

    if ($_POST['modulo_numero_lote'] == "registrar") {
        echo $insNumLote->registrarNumLoteControlador();
    }
} else {
    $alerta = [
        "tipo" => "simple",
        "titulo" => "Ocurrió un error inesperado",
        "texto" => "No se recibieron datos para procesar la solicitud",
        "icono" => "error"
    ];
    echo json_encode($alerta);
}
?>
