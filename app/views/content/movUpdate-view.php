<!-- Contenedor principal -->
<div class="container-fluid mb-4">
    <?php
    // Obtiene el ID del producto a editar
    $id = $insLogin->limpiarCadena($url[1]);
    ?>
    <!-- Título de la página -->
    <h1 class="display-4 text-center">Movimiento entre almacenes</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center"></h2>
</div>

<!-- Contenedor para el formulario de edición de producto -->
<div class="container py-4">
    <?php
    // Importa el controlador de productos
    use app\controllers\movController;

    // Crea una instancia del controlador
    $insProduct = new movController();

    // Obtiene las opciones de categorías, proveedores, unidades de medida y tipos de moneda
    $opcionesProductos = $insProduct->obtenerOpcionesProductos();
    $opcionesProveedores = $insProduct->obtenerOpcionesAlmacenes();
    $opcionesEmpleados = $insProduct->obtenerEmpleados();

    // Comprueba si se obtuvieron los datos del producto
    // Obtiene los datos del producto a editar
    $datos = $insLogin->seleccionarDatos("Unico", "productos", "id_producto", $id);
    if ($datos->rowCount() == 1) {
        $datos = $datos->fetch();
        ?>
    <?php
    // Incluye el botón de regreso
    include "./app/views/inc/btn_back2.php";
    ?>
    <!-- Formulario de edición de producto -->
    <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/movimientoAjax.php"
        method="POST" autocomplete="off">

        <!-- Campo oculto para el módulo de producto y el ID del producto -->
        <input type="hidden" name="modulo_movimiento" value="registrar">
        <input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">

        <!-- Campo para el código del producto -->
        <div class="mb-3">
            <label for="id_producto" class="form-label">Id Producto</label>
            <input type="text" class="form-control" id="id_producto" name="id_producto" maxlength="100"
                value="<?php echo $datos['id_producto']; ?>" required readonly>
        </div>

        <!-- Campo para mostrar el nombre del producto -->
<div class="mb-3">
    <label for="nombre_producto" class="form-label">Nombre del Producto</label>
    <input type="text" class="form-control" id="nombre_producto" value="<?php echo htmlspecialchars($datos['nombre_producto']); ?>" readonly>
</div>
       
        <!-- Campo de selección para el almacen del producto -->
        <div class="form-group mt-3">
            <label for="id_almacen_origen" class="form-label">Almacen de origen</label>
            <select class='form-control' name='id_almacen_origen' id='id_almacen_origen' required>
                <option value="">Selecciona un almacen de origen</option>
                <?php echo $opcionesProveedores; ?>
            </select>
        </div>
        <!-- Campo de selección para el almacen del producto -->
        <div class="form-group mt-3">
            <label for="id_almacen_destino" class="form-label">Almacen de destino</label>
            <select class='form-control' name='id_almacen_destino' id='id_almacen_destino' required>
                <option value="">Selecciona un almacen</option>
                <?php echo $opcionesProveedores; ?>
            </select>
        </div>
        <!-- Campo para la cantidad de producto -->
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad a mover:</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
        </div>
        <!-- Campo de selección para el nombre de empleado -->
        <div class="form-group mt-3">
            <label for="id_almacen_origen" class="form-label">Nombre de empleado que solicita:</label>
            <select class='form-control' name='id_empleado' id='id_empleado' required>
                <option value="">Empleado que solicita</option>
                <?php echo $opcionesEmpleados; ?>
            </select>
        </div>
        <!-- Campo para el nombre de usuario -->
        <div class="mb-3">
            <label for="nota" class="form-label">Nota del movimiento</label>
            <input type="text" class="form-control" id="nota" name="nota" maxlength="500" required>
        </div>

        <!-- Botón para enviar el formulario -->
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
            <button type="submit" class="btn btn-primary">Realizar movimiento</button>
        </div>
    </form>

    <?php
    } else {
        // Si no se obtuvieron los datos del producto, muestra un mensaje de error
        include "./app/views/inc/error_alert.php";
    }
    ?>
</div>