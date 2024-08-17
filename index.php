<?php

// Incluyendo configuraciones y autoloader
require_once "./config/app.php";
require_once "./autoload.php";

/*---------- Iniciando sesión ----------*/
require_once "./app/views/inc/session_start.php";

// Obteniendo la vista desde la URL
if (isset($_GET['views'])) {
    $url = explode("/", $_GET['views']);
} else {
    $url = ["login"];
}

?>

<!DOCTYPE html>
<html lang="es-MX" data-bs-theme="auto">

<head>
    <?php require_once "./app/views/inc/head.php"; ?>
</head>
<body>
    <style> body {
     font-family: "Bakbak One", sans-serif;
  font-weight: 400;
  font-style: normal;
}

.card-img-top-container {
    width: 100%; /* Ajusta el ancho al 100% del contenedor */
    padding-top: 56.25%; /* Relación de aspecto de 16:9 */
    position: relative;
}

.card-img-top {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover; /* Esto asegura que la imagen cubra el área sin deformarse */
}</style>
    <?php

    // Incluyendo SVG y controladores
    require_once "./app/views/inc/svg.php";
    use app\controllers\viewsController;
    use app\controllers\loginController;

    $insLogin = new loginController();
    $viewsController = new viewsController();

    // Obteniendo la vista
    $vista = $viewsController->obtenerVistasControlador($url[0]);

    if ($vista == "login" || $vista == "404") {
        // Mostrando vista de login o error 404
        require_once "./app/views/content/" . $vista . "-view.php";
    } else {
        // Cerrar sesión si no hay usuario autenticado
        if ((!isset($_SESSION['id']) || $_SESSION['id'] == "") || (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")) {
            $insLogin->cerrarSesionControlador();
            exit();
        }

        // Mostrando la barra de navegación y la vista principal
        
        require_once "./app/views/inc/navbar.php";
        require_once $vista;
    }

    // Incluyendo scripts al final del body
    require_once "./app/views/inc/script.php";
    ?>
</body>

</html>
