<!-- Contenedor principal -->
<div class="container-fluid mb-4">
    <?php 
        // Obtiene el ID del usuario a actualizar
        $id=$insLogin->limpiarCadena($url[1]);

        // Comprueba si el ID del usuario a actualizar es el mismo que el ID del usuario logueado
        if($id==$_SESSION['id']){ 
    ?>
    <!-- Si el usuario está actualizando su propia foto de perfil, muestra estos títulos -->
    <h1 class="display-4">Mi foto de perfil</h1>
    <h2 class="lead">Actualizar foto de perfil</h2>
    <?php }else{ ?>
    <!-- Si el usuario está actualizando la foto de perfil de otro usuario, muestra estos títulos -->
    <h1 class="display-4">Usuarios</h1>
    <h2 class="lead">Actualizar foto de perfil</h2>
    <?php } ?>
</div>

<!-- Contenedor para el formulario de actualización de la foto de perfil -->
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

    <!-- Muestra la foto actual del usuario y el formulario para actualizar la foto -->
    <div class="row g-5">
        <div class="col-md-5">
            <?php if(is_file("./app/views/fotos/".$datos['usuario_foto'])){ ?>
            <!-- Muestra la foto actual del usuario -->
            <div class="mb-4">
                <img class="img-thumbnail" src="<?php echo APP_URL; ?>app/views/fotos/<?php echo $datos['usuario_foto']; ?>">
            </div>
            
            <!-- Formulario para eliminar la foto actual -->
            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_usuario" value="eliminarFoto">
                <input type="hidden" name="usuario_id" value="<?php echo $datos['usuario_id']; ?>">
                <button type="submit" class="btn btn-danger">Eliminar foto</button>
            </form>
            <?php }else{ ?>
            <!-- Si el usuario no tiene una foto, muestra una foto por defecto -->
            <div class="mb-4">
                <img class="img-thumbnail" src="<?php echo APP_URL; ?>app/views/fotos/default.png">
            </div>
            <?php }?>
        </div>

        <!-- Formulario para subir una nueva foto -->
        <div class="col-md-7">
            <form class="mb-4 FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" enctype="multipart/form-data" autocomplete="off" >
                <input type="hidden" name="modulo_usuario" value="actualizarFoto">
                <input type="hidden" name="usuario_id" value="<?php echo $datos['usuario_id']; ?>">
                
                <label for="usuario_foto" class="form-label">Foto o imagen del usuario</label>
                <input class="form-control" type="file" id="usuario_foto" name="usuario_foto" accept=".jpg, .png, .jpeg">
                <p class="form-text text-muted">JPG, JPEG, PNG. (MAX 5MB)</p>
                <button type="submit" class="btn btn-success mt-3">Actualizar foto</button>
            </form>
        </div>
    </div>

    <?php
        }else{
            // Si no se obtuvieron los datos del usuario, muestra un mensaje de error
            include "./app/views/inc/error_alert.php";
        }
    ?>
</div>