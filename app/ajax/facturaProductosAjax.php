<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\facturaProductosController;


if (isset($_POST['modulo_factura_productos'])) {
    $insFacturaProductos = new facturaProductosController();

    if ($_POST['modulo_factura_productos'] == "registrar") {
        echo $insFacturaProductos->registrarFacturaProductosControlador();
    }

} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
