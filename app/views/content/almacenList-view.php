<?php //require_once "./app/views/inc/navbar.php"; ?>
            <?php     
            // Importa el controlador de usuarios
            use app\controllers\almacenController;
            $insUsuario = new almacenController();

            // Muestra la lista de usuarios
            echo $insUsuario->listarAlmacenesControlador($url[1], 54, $url[0], "");
            ?>
        </div>
    </div>
</div>