<?php
        // Importa el controlador de productos
        use app\controllers\numLoteController;
        
        // Crea una instancia del controlador
        $insProduct = new numLoteController();

        // Muestra la lista de productos
        echo $insProduct->listarNumLoteControlador($url[1],9999,$url[0],"");
    ?>

