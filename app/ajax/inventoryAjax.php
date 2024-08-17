<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\inventoryController;

if (isset($_POST['modulo_Inventory'])) {
    $insInventory = new inventoryController();

    if ($_POST['modulo_Inventory'] == "registrar") {
        echo $insInventory->descontarInventarioControlador();
    }

} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
