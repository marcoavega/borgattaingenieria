<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\salidaPTNumserieController;

if (isset($_POST['modulo_salida_pt'])) {
    $insSalidaPT = new salidaPTNumserieController();

    if ($_POST['modulo_salida_pt'] == "registrar") {
        echo $insSalidaPT->registrarSalidaPTControlador();
    }
} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
?>
