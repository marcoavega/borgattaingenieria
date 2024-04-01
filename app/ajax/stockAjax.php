<?php

// **Inclusión de archivos necesarios**

// Carga la configuración de la aplicación
require_once "../../config/app.php";

// Inicia la sesión del usuario
require_once "../views/inc/session_start.php";

// Carga automática de clases
require_once "../../autoload.php";

// **Espacio de nombres y controlador**

// Importa la clase `stockController` para manejar las acciones del stock
use app\controllers\stockController;

// **Lógica principal**

// Si se recibe un POST con el parámetro `modulo_stock`
if (isset($_POST['modulo_stock'])) {

    // Crea una instancia del controlador de stock
    $insStock = new stockController();

    // **Acciones según el valor de `modulo_stock`**

    // Registrar nuevo stock
    if ($_POST['modulo_stock'] == "registrar") {
        echo $insStock->registrarStockControlador();
    }

} else {

    // Si no se recibe el parámetro, destruye la sesión y redirecciona al login
    session_destroy();
    header("Location: ".APP_URL."login/");

}