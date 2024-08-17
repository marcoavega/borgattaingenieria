<!-- Contenedor principal -->
<div class="container-fluid mb-4">
    <!-- Título de la página -->
    <h1 class="display-4 text-center">Usuarios</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center">Lista de usuarios</h2>
</div>

<!-- Contenedor para la lista de usuarios -->
<div class="container py-4">
    <div class="mb-4"></div>
    <?php
            // Incluye el botón de regreso
            include "./app/views/inc/btn_back2.php";
           
        // Importa el controlador de usuarios
        use app\controllers\userController;
        $insUsuario = new userController();

        // Muestra la lista de usuarios
        echo $insUsuario->listarUsuarioControlador($url[1],15,$url[0],"");
    ?>
</div>