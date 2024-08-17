<?php //require_once "./app/views/inc/navbar.php"; ?>
<!-- Contenedor principal -->
<div class="container-fluid mb-4">
    <!-- Título de la página -->
    <h1 class="display-4 text-center">ARTíCUlADOR</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center">Lista componentes de Articulador</h2>
</div>

<!-- Contenedor para la lista -->
<div class="container py-4">
    <div class="mb-4"></div>
    <?php
        // Importa el controlador
        use app\controllers\artController;
        
        // Incluye el botón de regreso
        include "./app/views/inc/btn_back2.php";
        
        // Crea una instancia del controlador
        $insKit = new artController();

        // Muestra la lista
        echo $insKit->listarArtControlador($url[1],200,$url[0],"");
    ?>
</div>