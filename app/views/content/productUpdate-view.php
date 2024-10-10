<!-- Contenedor principal -->
<div class="container-fluid">
    <?php
    // Obtiene el ID del producto a editar
    $id = $insLogin->limpiarCadena($url[1]);
    ?>
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productList/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Lista de Productos
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Nuevo
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productInvent/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Inventario
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Formulario de creación de producto -->
        <div class="col-md-9 col-lg-10">
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

          <!-- Título de la página -->
<h4 class="text-center">Productos</h4>
<!-- Subtítulo de la página -->
<h5 class="lead text-center">Actualizar Producto</h5>

<!-- Formulario de edición de producto -->
<form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off">
    <!-- Campo oculto para el módulo de producto y el ID del producto -->
    <input type="hidden" name="modulo_product" value="actualizar">
    <input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">

    <div class="row">
        <div class="col-md-6">
            <!-- Campo para el código del producto -->
            <div class="mb-3">
                <label for="codigo_producto" class="form-label">Código Producto:</label>
                <input type="text" class="form-control" id="codigo_producto" name="codigo_producto" maxlength="100" value="<?php echo $datos['codigo_producto']; ?>" required>
            </div>

            <!-- Campo para el nombre del producto -->
            <div class="mb-3">
                <label for="nombre_producto" class="form-label">Nombre Producto:</label>
                <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" value="<?php echo $datos['nombre_producto']; ?>" required>
            </div>

            <!-- Campo para el precio de compra del producto -->
            <div class="mb-3">
                <label for="precio" class="form-label">Precio de Compra $:</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo $datos['precio']; ?>" required>
            </div>

            <!-- Campo para el precio de venta del producto (opcional) -->
            <div class="mb-3">
                <label for="precio_venta" class="form-label">Precio de Venta $ (opcional):</label>
                <input type="number" step="0.01" class="form-control" id="precio_venta" name="precio_venta" value="<?php echo $datos['precio_venta']; ?>">
            </div>
        </div>

        <div class="col-md-6">
            <!-- Campo para la ubicación del producto -->
            <div class="mb-3">
                <label for="ubicacion" class="form-label">Asignar ubicación:</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="<?php echo $datos['ubicacion']; ?>" required>
            </div>

            <!-- Campo para la cantidad de producto -->
            <div class="mb-3">
                <label for="stock" class="form-label">Cantidad a Ingresar:</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $datos['stock']; ?>" required>
            </div>

            <!-- Campo para el stock deseado -->
            <div class="mb-3">
                <label for="stock_deseado" class="form-label">Stock Deseado:</label>
                <input type="number" class="form-control" id="stock_deseado" name="stock_deseado" value="<?php echo $datos['stock_deseado']; ?>" required>
            </div>
        </div>
    </div>

    <!-- Campos para las dimensiones (opcionales) -->
    <div class="row mt-4">
        <h5 class="mb-3">Dimensiones (Opcional)</h5>
        <div class="col-md-4 mb-3">
            <label for="peso" class="form-label">Peso (Kg):</label>
            <input type="number" step="0.0001" class="form-control" id="peso" name="peso" value="<?php echo $datos['peso']; ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label for="altura" class="form-label">Altura (M):</label>
            <input type="number" step="0.0001" class="form-control" id="altura" name="altura" value="<?php echo $datos['altura']; ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label for="largo" class="form-label">Largo (M):</label>
            <input type="number" step="0.0001" class="form-control" id="largo" name="largo" value="<?php echo $datos['largo']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="ancho" class="form-label">Ancho (M):</label>
            <input type="number" step="0.0001" class="form-control" id="ancho" name="ancho" value="<?php echo $datos['ancho']; ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label for="diametro" class="form-label">Diámetro (M):</label>
            <input type="number" step="0.0001" class="form-control" id="diametro" name="diametro" value="<?php echo $datos['diametro']; ?>">
        </div>
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
    </div>
</div>