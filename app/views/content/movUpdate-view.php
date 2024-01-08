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

    // Comprueba si se obtuvieron los datos del producto
   
        ?>

        <!-- Formulario de edición de producto -->
        <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off">
            <!-- Campo oculto para el módulo de producto y el ID del producto -->
            <input type="hidden" name="modulo_product" value="actualizar">
            <input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">

           

            <!-- Campo de selección para la categoría del producto -->
            <div class="form-group">
                <label for="nombre_producto" class="form-label">Producto</label>
                <select class='form-control' name='nombre_producto' id='nombre_producto' required>
                    <option value="">Selecciona un producto</option>
                    <?php echo $opcionesProductos; ?>
                </select>
            </div>

            <!-- Campo de selección para el almacen del producto -->
            <div class="form-group mt-3">
                <label for="nombre_almacen" class="form-label">Almacenes</label>
                <select class='form-control' name='nombre_almacen' id='nombre_almacen' required>
                    <option value="">Selecciona un almacen</option>
                    <?php echo $opcionesProveedores; ?>
                </select>
            </div>

            <!-- Botón para enviar el formulario -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>

        <?php
   
    ?>
</div>