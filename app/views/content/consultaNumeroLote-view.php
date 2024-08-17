<?php //require_once "./app/views/inc/navbar.php"; ?>
<!-- Contenedor principal -->
<div class="container-fluid mb-4">
    <!-- Título de la página -->
    <h1 class="display-4 text-center">Números de serie</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center">Lista de Números de Serie</h2>
</div>

<!-- Contenedor para la lista de productos -->
<div class="container py-4">
    <div class="mb-4"></div>
    <?php
        // Importa el controlador de productos
        use app\controllers\numLoteController;
        
        // Incluye el botón de regreso
        include "./app/views/inc/btn_back2.php";
        
        // Crea una instancia del controlador
        $insProduct = new numLoteController();

        // Muestra la lista de productos
        echo $insProduct->listarNumLoteControlador($url[1],54,$url[0],"");
    ?>
</div>
