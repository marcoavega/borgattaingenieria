<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\entradaPTNumserieController;

if (isset($_POST['modulo_entrada_pt'])) {
    $insEntradaPT = new entradaPTNumserieController();

    if ($_POST['modulo_entrada_pt'] == "registrar") {
        echo $insEntradaPT->registrarEntradaPTControlador();
    }
} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
?>
