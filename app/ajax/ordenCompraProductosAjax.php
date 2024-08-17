<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\ordenCompraProductosController;


if (isset($_POST['modulo_orden_compra_productos'])) {
    $insOrdencompraProductos = new ordenCompraProductosController();

    if ($_POST['modulo_orden_compra_productos'] == "registrar") {
        echo $insOrdencompraProductos->registrarOrdenCompraProductosControlador();
    }

} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
