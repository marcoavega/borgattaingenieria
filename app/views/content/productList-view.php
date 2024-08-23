<?php //require_once "./app/views/inc/navbar.php"; ?>
<!-- Contenedor principal -->
<!-- Contenedor para la lista de productos -->
    <?php
        // Importa el controlador de productos
        use app\controllers\productController;
        // Crea una instancia del controlador
        $insProduct = new productController();
        // Muestra la lista de productos
        echo $insProduct->listarProductControlador($url[1],54,$url[0],"");
    ?>
