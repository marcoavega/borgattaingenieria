<!-- Contenedor principal -->
<div class="container-fluid mb-4">
    <?php
    // Obtiene el ID del producto a editar
    $id = $insLogin->limpiarCadena($url[1]);
    ?>
    <!-- Título de la página -->
    <h1 class="display-4 text-center">Proveedores</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center">Editar Proveedores</h2>
</div>

<!-- Contenedor para el formulario de edición de producto -->
<div class="container py-4">
    <?php
    // Importa el controlador de productos
    use app\controllers\provController;

    // Crea una instancia del controlador
    $insProduct = new provController();

   
    // Obtiene los datos del producto a editar
    $datos = $insLogin->seleccionarDatos("Unico", "proveedores", "id_proveedor", $id);

    // Comprueba si se obtuvieron los datos del producto
    if ($datos->rowCount() == 1) {
        $datos = $datos->fetch();
        ?>

        <!-- Formulario de edición de producto -->
        <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/proveedorAjax.php" method="POST" autocomplete="off">
            <!-- Campo oculto para el módulo de producto y el ID del producto -->
            <input type="hidden" name="modulo_proveedor" value="actualizar">
            <input type="hidden" name="id_proveedor" value="<?php echo $datos['id_proveedor']; ?>">

            <!-- Campo para el nombre del producto -->
            <div class="mb-3">
                <label for="nombre_proveedor" class="form-label">Nombre Proveedor:</label>
                <input type="text" class="form-control" id="nombre_proveedor" name="nombre_proveedor" pattern="[a-zA-Z0-9$@.-]{3,100}" maxlength="1000" value="<?php echo $datos['nombre_proveedor']; ?>" required>
            </div>

            <!-- Botón para enviar el formulario -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>

        <?php
    } else {
        // Si no se obtuvieron los datos del producto, muestra un mensaje de error
        include "./app/views/inc/error_alert.php";
    }
    ?>
</div>