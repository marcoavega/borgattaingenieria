<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\ordenCompraController;


if (isset($_POST['modulo_orden_compra'])) {
    $insOrdencompra = new ordenCompraController();

    if ($_POST['modulo_orden_compra'] == "registrar") {
        echo $insOrdencompra->registrarOrdenCompraControlador();
    }

} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
