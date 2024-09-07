<!-- Contenedor principal -->
    <?php
        // Importa el controlador de productos
        use app\controllers\numSerController;
        
        // Crea una instancia del controlador
        $insMov = new numSerController();

        // Muestra la lista de productos
        echo $insMov->listarNumSerControlador($url[1],1000,$url[0],"");
    ?>