<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\facturaController;


if (isset($_POST['modulo_factura'])) {
    $insfactura = new facturaController();

    if ($_POST['modulo_factura'] == "registrar") {
        echo $insfactura->registrarfacturaControlador();
    }

} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
