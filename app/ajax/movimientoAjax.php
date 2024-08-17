<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\movController;

if (isset($_POST['modulo_movimiento'])) {
    $insMovimiento = new movController();

    if ($_POST['modulo_movimiento'] == "registrar") {
        echo $insMovimiento->registrarMovimientoControlador();
    }

} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
