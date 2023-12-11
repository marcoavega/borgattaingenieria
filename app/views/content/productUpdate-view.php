<!-- Contenedor principal -->
<div class="container-fluid mb-4">
    <?php
    // Obtiene el ID del producto a editar
    $id = $insLogin->limpiarCadena($url[1]);
    ?>
    <!-- Título de la página -->
    <h1 class="display-4 text-center">Productos</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center">Editar Producto</h2>
</div>

<!-- Contenedor para el formulario de edición de producto -->
<div class="container py-4">
    <?php
    // Importa el controlador de productos
    use app\controllers\productController;

    // Crea una instancia del controlador
    $insProduct = new productController();

    // Obtiene las opciones de categorías, proveedores, unidades de medida y tipos de moneda
    $opcionesCategorias = $insProduct->obtenerOpcionesCategorias();
    $opcionesProveedores = $insProduct->obtenerOpcionesProveedores();
    $opcionesUnidadesMedida = $insProduct->obtenerOpcionesUnidadesMedida();
    $opcionesTiposMoneda = $insProduct->obtenerOpcionesTiposMoneda();

    // Obtiene los datos del producto a editar
    $datos = $insLogin->seleccionarDatos("Unico", "productos", "id_producto", $id);

    // Comprueba si se obtuvieron los datos del producto
    if ($datos->rowCount() == 1) {
        $datos = $datos->fetch();
        ?>

        <!-- Formulario de edición de producto -->
        <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off">
            <!-- Campo oculto para el módulo de producto y el ID del producto -->
            <input type="hidden" name="modulo_product" value="actualizar">
            <input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">

            <!-- Campo para el código del producto -->
            <div class="mb-3">
                <label for="codigo_producto" class="form-label">Código Producto:</label>
                <input type="text" class="form-control" id="codigo_producto" name="codigo_producto" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" value="<?php echo $datos['codigo_producto']; ?>" required>
            </div>

            <!-- Campo para el nombre del producto -->
            <div class="mb-3">
                <label for="nombre_producto" class="form-label">Nombre Producto:</label>
                <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="1000" value="<?php echo $datos['nombre_producto']; ?>" required>
            </div>

            <!-- Campo para el precio del producto -->
            <div class="mb-3">
                <label for="precio" class="form-label">Precio en Pesos $:</label>
                <input type="text" class="form-control" id="precio" name="precio" value="<?php echo $datos['precio']; ?>" required>
            </div>

            <!-- Campo para la cantidad de producto -->
            <div class="mb-3">
                <label for="stock" class="form-label">Cantidad a Ingresar:</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $datos['stock']; ?>" required>
            </div>

            <!-- Campo de selección para la categoría del producto -->
            <div class="form-group">
                <label for="categoria" class="form-label">Categoría</label>
                <select class='form-control' name='categoria' id='categoria' required>
                    <option value="">Selecciona una categoría</option>
                    <?php echo $opcionesCategorias; ?>
                </select>
            </div>

            <!-- Campo de selección para el proveedor del producto -->
            <div class="form-group mt-3">
                <label for="proveedor" class="form-label">Proveedor</label>
                <select class='form-control' name='proveedor' id='proveedor' required>
                    <option value="">Selecciona un proveedor</option>
                    <?php echo $opcionesProveedores; ?>
                </select>
            </div>

            <!-- Campo de selección para la unidad de medida del producto -->
            <div class="form-group mt-3">
                <label for="unidad_medida" class="form-label">Unidad de Medida</label>
                <select class="form-control" name="unidad_medida" id="unidad_medida" required>
                    <option value="">Selecciona una unidad de medida</option>
                    <?php echo $opcionesUnidadesMedida; ?>
                </select>
            </div>

            <!-- Campo de selección para el tipo de moneda del producto -->
            <div class="form-group mt-3">
                <label for="tipo_moneda" class="form-label">Tipo de Moneda</label>
                <select class="form-control" name="tipo_moneda" id="tipo_moneda" required>
                    <option value="">Selecciona un tipo de moneda</option>
                    <?php echo $opcionesTiposMoneda; ?>
                </select>
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