<!-- Contenedor principal -->
<div class="container-fluid mb-4">
    <h1 class="display-4">Almacenes</h1>
    <h2 class="lead">Actualizar almacén</h2>
</div>

<!-- Contenedor para el formulario de actualización -->
<div class="container py-4">
    <?php
        // Incluye el botón de regreso
        include "./app/views/inc/btn_back2.php";

        // Obtiene el ID del almacén a actualizar
        $id = $insLogin->limpiarCadena($url[1]);

        // Obtiene los datos del almacén a actualizar
        $datos = $insLogin->seleccionarDatos("Unico", "almacenes", "id_almacen", $id);

        // Comprueba si se obtuvieron los datos del almacén
        if($datos->rowCount() == 1){
            $datos = $datos->fetch();
    ?>

    <!-- Muestra el nombre del almacén -->
    <h2 class="h3 text-center mb-4"><?php echo $datos['nombre_almacen']; ?></h2>

    <!-- Formulario para actualizar los datos del almacén -->
    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/almacenAjax.php" method="POST" autocomplete="off" >
        <!-- Campo oculto para el módulo de almacén -->
        <input type="hidden" name="modulo_almacen" value="actualizar">
        <!-- Campo oculto para el ID del almacén -->
        <input type="hidden" name="id_almacen" value="<?php echo $datos['id_almacen']; ?>">

        <!-- Campo para el nombre del almacén -->
        <div class="mb-3">
            <label for="nombre_almacen" class="form-label">Nombre del Almacén</label>
            <input type="text" class="form-control" id="nombre_almacen" name="nombre_almacen" value="<?php echo $datos['nombre_almacen']; ?>" required>
        </div>

        <!-- Aquí puedes agregar más campos si tu tabla de almacenes tiene más columnas -->

        <!-- Botón para enviar el formulario -->
        <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-success">Actualizar</button>
        </div>
    </form>

    <?php
        } else {
            // Si no se obtuvieron los datos del almacén, muestra un mensaje de error
            include "./app/views/inc/error_alert.php";
        }
    ?>
</div>