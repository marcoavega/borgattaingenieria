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
    $opcionesSubCategorias = $insProduct->obtenerOpcionesSubCategorias();

    // Obtiene los datos del producto a editar
    $datos = $insLogin->seleccionarDatos("Unico", "productos", "id_producto", $id);

    // Comprueba si se obtuvieron los datos del producto
    if ($datos->rowCount() == 1) {
        $datos = $datos->fetch();
        ?>
<?php
            // Incluye el botón de regreso
            include "./app/views/inc/btn_back2.php";
            ?>
        <!-- Formulario de edición de producto -->
        <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off">
            <!-- Campo oculto para el módulo de producto y el ID del producto -->
            <input type="hidden" name="modulo_product" value="actualizar">
            <input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">

            <!-- Campo para el código del producto -->
            <div class="mb-3">
                <label for="codigo_producto" class="form-label">Código Producto:</label>
                <input type="text" class="form-control" id="codigo_producto" name="codigo_producto"  maxlength="100" value="<?php echo $datos['codigo_producto']; ?>" required>
            </div>

            <!-- Campo para el nombre del producto -->
            <div class="mb-3">
                <label for="nombre_producto" class="form-label">Nombre Producto:</label>
                <input type="text" class="form-control" id="nombre_producto" name="nombre_producto"  value="<?php echo htmlspecialchars($datos['nombre_producto'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <!-- Campo de selección para el tipo de moneda del producto -->
            <div class="mb-3">
                    <label for="id_categoria" class="form-label">Categorias</label>
                    <select class="form-control" name="id_categoria" id="id_categoria" required>
                        <option value="">Seleccione una categoria</option>
                        <?php echo $opcionesCategorias; ?>
                    </select>
                </div>

                 <!-- Campo de selección para la subcategoría del producto -->
                 <div class="mb-3">
                    <label for="subcategoria" class="form-label">Sub-Categoría</label>
                    <select class='form-control' name='subcategoria' id='subcategoria' required>
                        <option value="">Selecciona una sub-categoría</option>
                        <?php echo $opcionesSubCategorias; ?>
                    </select>
                </div>

            <!-- Campo para el precio del producto -->
            <div class="mb-3">
                <label for="precio" class="form-label">Precio $:</label>
                <input type="text" class="form-control" id="precio" name="precio" value="<?php echo $datos['precio']; ?>" required>
            </div>

            <!-- Campo para el precio del producto -->
            <div class="mb-3">
                    <label for="ubicacion" class="form-label">Asignar ubicación:</label>
                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="<?php echo $datos['ubicacion']; ?>" required>
                </div>

            <!-- Campo para la cantidad de producto -->
            <div class="mb-3">
                <label for="stock" class="form-label">Cantidad a Ingresar:</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $datos['stock']; ?>" required>
            </div>

            <!-- Campo de selección para la categoría del producto -->
            

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