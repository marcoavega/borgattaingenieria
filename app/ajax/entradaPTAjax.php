<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\entradaPTController;

if (isset($_POST['modulo_entrada_producto'])) {
    $insNotaEntrada = new entradaPTController();

    if ($_POST['modulo_entrada_producto'] == "registrar") {
        echo $insNotaEntrada->registrarEntradaControlador();
    }

} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
