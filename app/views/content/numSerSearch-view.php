<!-- Contenedor principal -->
<div class="container-fluid mb-4">
    <!-- Título de la página -->
    <h1 class="display-4 text-center">Consulta de Numeros de Serie</h1>
</div>

<!-- Contenedor para la lista de productos -->
<div class="container py-4">
    <div class="mb-4"></div>
    
    <?php
        // Importa el controlador de productos
        use app\controllers\numSerController;
    
        // Incluye el botón de regreso
        include "./app/views/inc/btn_back2.php";
        
        // Crea una instancia del controlador
        $insMov = new numSerController();

        // Muestra la lista de productos
        echo $insMov->listarNumSerControlador($url[1],1000,$url[0],"");
    ?>
</div>