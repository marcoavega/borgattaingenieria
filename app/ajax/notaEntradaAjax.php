<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\notaEntradaController;


if (isset($_POST['modulo_nota_entrada'])) {
    $insNotaEntrada = new notaEntradaController();

    if ($_POST['modulo_nota_entrada'] == "registrar") {
        echo $insNotaEntrada->registrarNotaEntradaControlador();
    }

} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
