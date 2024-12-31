<?php
        // Importa el controlador de productos
        use app\controllers\movController;
        // Crea una instancia del controlador
        $insMov = new movController();
        // Muestra la lista de productos
        echo $insMov->listarMovControladorEmpleado3($url[1],10000,$url[0],"");
    ?>
</div>