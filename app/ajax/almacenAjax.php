<?php

// Asegúrate de que estas rutas sean correctas
require_once __DIR__ . "/../../config/app.php";
require_once __DIR__ . "/../views/inc/session_start.php";
require_once __DIR__ . "/../../autoload.php";

use app\controllers\almacenController;

// Verifica que la sesión esté iniciada y que el usuario esté autenticado
if (!isset($_SESSION['id']) || !isset($_SESSION['usuario'])) {
    $response = [
        "status" => "error",
        "message" => "Sesión no iniciada o usuario no autenticado"
    ];
    echo json_encode($response);
    exit;
}

if(isset($_POST['modulo_almacen'])){
    $insAlmacen = new almacenController();

    switch($_POST['modulo_almacen']) {
        case "registrar":
            echo $insAlmacen->registrarAlmacenControlador();
            break;
        case "eliminar":
            echo $insAlmacen->eliminarAlmacenControlador();
            break;
        case "actualizar":
            echo $insAlmacen->actualizarAlmacenControlador();
            break;
        default:
            $response = [
                "status" => "error",
                "message" => "Acción no reconocida"
            ];
            echo json_encode($response);
    }
} else {
    $response = [
        "status" => "error",
        "message" => "No se especificó ninguna acción"
    ];
    echo json_encode($response);
}