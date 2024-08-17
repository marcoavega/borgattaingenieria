<!-- Contenedor principal -->
<div class="container-fluid mb-4">
    <?php 
        // Obtiene el ID del usuario a actualizar
        $id=$insLogin->limpiarCadena($url[1]);

        // Comprueba si el ID del usuario a actualizar es el mismo que el ID del usuario logueado
        if($id==$_SESSION['id']){ 
    ?>
    <!-- Si el usuario está actualizando su propia cuenta, muestra estos títulos -->
    <h1 class="display-4">Mi cuenta</h1>
    <h2 class="lead">Actualizar cuenta</h2>
    <?php }else{ ?>
    <!-- Si el usuario está actualizando la cuenta de otro usuario, muestra estos títulos -->
    <h1 class="display-4">Usuarios</h1>
    <h2 class="lead">Actualizar usuario</h2>
    <?php } ?>
</div>

<!-- Contenedor para el formulario de actualización -->
<div class="container py-4">
    <?php
        // Incluye el botón de regreso
        include "./app/views/inc/btn_back2.php";

        // Obtiene los datos del usuario a actualizar
        $datos=$insLogin->seleccionarDatos("Unico","usuario","usuario_id",$id);

        // Comprueba si se obtuvieron los datos del usuario
        if($datos->rowCount()==1){
            $datos=$datos->fetch();
    ?>

    <!-- Muestra el nombre de usuario -->
    <h2 class="h3 text-center mb-4"><?php echo $datos['usuario_usuario']; ?></h2>

    <!-- Muestra las fechas de creación y actualización del usuario -->
    <p class="text-center pb-4"><?php echo "<strong>Usuario creado:</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['usuario_creado']))." &nbsp; <strong>Usuario actualizado:</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['usuario_actualizado'])); ?></p>

    <!-- Formulario para actualizar los datos del usuario -->
    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off" >
        <!-- Campo oculto para el módulo de usuario -->
        <input type="hidden" name="modulo_usuario" value="actualizar">
        <!-- Campo oculto para el ID del usuario -->
        <input type="hidden" name="usuario_id" value="<?php echo $datos['usuario_id']; ?>">

        <!-- Campo para el nombre de usuario -->
        <div class="mb-3">
            <label for="usuario_usuario" class="form-label">Nuevo nombre de Usuario</label>
            <input type="text" class="form-control" id="usuario_usuario" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" value="<?php echo $datos['usuario_usuario']; ?>" required>
        </div>

        <!-- Mensaje sobre la actualización de la clave -->
        <p class="text-center">
            SI desea actualizar la clave de este usuario por favor llene los 2 campos. Si NO desea actualizar la clave deje los campos vacíos.
        </p>

        <!-- Campos para la nueva clave -->
        <div class="row g-3">
            <div class="col">
                <label for="usuario_clave_1" class="form-label">Nueva clave</label>
                <input type="password" class="form-control" id="usuario_clave_1" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
            </div>
            <div class="col">
                <label for="usuario_clave_2" class="form-label">Repetir nueva clave</label>
                <input type="password" class="form-control" id="usuario_clave_2" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
            </div>
        </div>

        <!-- Mensaje sobre la necesidad de ingresar el usuario y la clave del administrador -->
        <p class="text-center mt-4">
            Para poder actualizar los datos de este usuario por favor ingrese su USUARIO y CLAVE con la que ha iniciado sesión
        </p>

        <!-- Campos para el usuario y la clave del administrador -->
        <div class="row g-3">
            <div class="col">
                <label for="administrador_usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="administrador_usuario" name="administrador_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
            </div>
            <div class="col">
                <label for="administrador_clave" class="form-label">Clave</label>
                <input type="password" class="form-control" id="administrador_clave" name="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
            </div>
        </div>

        <!-- Botón para enviar el formulario -->
        <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-success">Actualizar</button>
        </div>
    </form>

    <?php
        }else{
            // Si no se obtuvieron los datos del usuario, muestra un mensaje de error
            include "./app/views/inc/error_alert.php";
        }
    ?>
</div>