<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\salidaPTController;

if (isset($_POST['modulo_salida_producto'])) {
    $insNotaEntrada = new salidaPTController();

    if ($_POST['modulo_salida_producto'] == "registrar") {
        echo $insNotaEntrada->registrarSalidaControlador();
    }

} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
