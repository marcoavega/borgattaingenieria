<!-- Contenedor principal -->
<div class="container-fluid mb-4">
    <!-- Título de la página -->
    <h1 class="display-4 text-center">Productos</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center">Lista de productos</h2>
</div>

<!-- Contenedor para la lista de productos -->
<div class="container py-4">
    <div class="mb-4"></div>

    <?php
        // Importa el controlador de productos
        use app\controllers\productController;

        // Crea una instancia del controlador
        $insProduct = new productController();

        // Muestra la lista de productos
        echo $insProduct->listarGeneralControlador($url[1],30,$url[0],"");
    ?>
</div>