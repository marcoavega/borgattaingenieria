<?php //require_once "./app/views/inc/navbar.php"; ?>
            <?php     
            // Importa el controlador de usuarios
            use app\controllers\userController;
            $insUsuario = new userController();

            // Muestra la lista de usuarios
            echo $insUsuario->listarUsuarioControlador($url[1], 54, $url[0], "");
            ?>
        </div>
    </div>
</div>