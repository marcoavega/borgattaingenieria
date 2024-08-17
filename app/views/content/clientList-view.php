<!-- Contenedor principal -->
<div class="container-fluid mb-4">
    <!-- Título de la página -->
    <h1 class="display-4 text-center">Clientes</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center">Lista de Clientes</h2>
</div>

<!-- Contenedor para la lista de usuarios -->
<div class="container py-4">
    <div class="mb-4"></div>

    <?php
        // Importa el controlador de usuarios
        use app\controllers\clientController;
       
    // Incluye el botón de regreso
    include "./app/views/inc/btn_back2.php";
    
        $insCliente = new clientController();

        // Muestra la lista de usuarios
        echo $insCliente->listarClientesControlador($url[1],99999,$url[0],"");
    ?>
</div>