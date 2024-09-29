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
    <h5 class="lead text-center">Nuevo Producto</h5>
            <!-- Formulario de creación de producto -->

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
                <input type="text" class="form-control" id="nombre_producto" name="nombre_producto"  value="<?php echo $datos['nombre_producto']; ?>" required>
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

            
            <!-- Campo para la cantidad de producto -->
            <div class="mb-3">
                <label for="stock_deseado" class="form-label">Stock Deseado:</label>
                <input type="number" class="form-control" id="stock_deseado" name="stock_deseado" value="<?php echo $datos['stock_deseado']; ?>" required>
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