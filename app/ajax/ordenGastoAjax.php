<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\ordenGastoController;


if (isset($_POST['modulo_orden_gasto'])) {
    $insOrdencompra = new ordenGastoController();

    if ($_POST['modulo_orden_gasto'] == "registrar") {
        echo $insOrdencompra->registrarOrdenGastoControlador();
    }

} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
