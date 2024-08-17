<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\ordenGastoProductosController;


if (isset($_POST['modulo_orden_gasto_productos'])) {
    $insOrdenGastoProductos = new ordenGastoProductosController();

    if ($_POST['modulo_orden_gasto_productos'] == "registrar") {
        echo $insOrdenGastoProductos->registrarOrdenGastoProductosControlador();
    }

} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
