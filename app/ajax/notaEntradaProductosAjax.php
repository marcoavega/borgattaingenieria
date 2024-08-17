<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\notaEntradaProductosController;

if (isset($_POST['modulo_nota_entrada_productos'])) {
    $insNotaEntradaProductos = new notaEntradaProductosController();

    if ($_POST['modulo_nota_entrada_productos'] == "registrar") {
        echo $insNotaEntradaProductos->registrarNotaEntradaProductosControlador();
    }
} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
