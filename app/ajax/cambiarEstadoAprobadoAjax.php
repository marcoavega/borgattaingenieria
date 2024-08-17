<?php
require_once "../../config/app.php";
require_once "../../autoload.php";

use app\controllers\numSerieController;

if (isset($_POST['id_numero_serie']) && isset($_POST['aprobado'])) {
    $id_numero_serie = intval($_POST['id_numero_serie']);
    $aprobado = intval($_POST['aprobado']);

    $insSerie = new numSerieController();
    $resultado = $insSerie->cambiarEstadoAprobado($id_numero_serie, $aprobado);

    echo json_encode($resultado);
} else {
    echo json_encode(["status" => "error", "message" => "Datos incompletos."]);
}
