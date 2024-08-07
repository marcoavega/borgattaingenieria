<!-- Contenedor principal -->
<div class="container-fluid py-4">
    <?php
    // Obtiene el ID del producto a editar
    $id = $insLogin->limpiarCadena($url[1]);
    ?>
    <!-- Título de la página -->
    <h1 class="display-4 text-center">Productos</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center">Nuevo Producto</h2>

    <!-- Contenedor para el formulario de creación de producto -->
    <div class="row justify-content-center">
        <div class="col-lg-6">
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
            ?>
            <?php
            // Incluye el botón de regreso
            include "./app/views/inc/btn_back2.php";
            ?>
            <!-- Formulario de creación de producto -->
            <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                <!-- Campo oculto para el módulo de producto -->

                <input type="hidden" name="modulo_product" value="registrar">

                <!-- Campo para el código del producto -->
                <div class="mb-3">
                    <label for="codigo_producto" class="form-label">Código Producto:</label>
                    <input type="text" class="form-control" id="codigo_producto" name="codigo_producto" maxlength="30" required>
                </div>

                <!-- Campo para el nombre del producto -->
                <div class="mb-3">
                    <label for="nombre_producto" class="form-label">Nombre Producto:</label>
                    <textarea class="form-control" id="nombre_producto" name="nombre_producto" maxlength="180" required></textarea>
                </div>


                <!-- Campo para el precio del producto -->
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio $:</label>
                    <input type="text" class="form-control" id="precio" name="precio" required>
                </div>

                <!-- Campo para el precio del producto -->
                <div class="mb-3">
                    <label for="ubicacion" class="form-label">Asignar ubicación:</label>
                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                </div>

                <!-- Campo para la cantidad de producto -->
                <div class="mb-3">
                    <label for="stock" class="form-label">Cantidad a Ingresar:</label>
                    <input type="number" class="form-control" id="stock" name="stock" required>
                </div>

                <!-- Campo de selección para la categoría del producto -->
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoría</label>
                    <select class='form-control' name='categoria' id='categoria' required>
                        <option value="">Selecciona una categoría</option>
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

                <!-- Campo de selección para el proveedor del producto -->
                <div class="mb-3">
                    <label for="proveedor" class="form-label">Proveedor</label>
                    <select class='form-control' name='proveedor' id='proveedor' required>
                        <option value="">Selecciona un proveedor</option>
                        <?php echo $opcionesProveedores; ?>
                    </select>
                </div>

                <!-- Campo de selección para la unidad de medida del producto -->
                <div class="mb-3">
                    <label for="unidad_medida" class="form-label">Unidad de Medida</label>
                    <select class="form-control" name="unidad_medida" id="unidad_medida" required>
                        <option value="">Selecciona una unidad de medida</option>
                        <?php echo $opcionesUnidadesMedida; ?>
                    </select>
                </div>

                <!-- Campo de selección para el tipo de moneda del producto -->
                <div class="mb-3">
                    <label for="tipo_moneda" class="form-label">Tipo de Moneda</label>
                    <select class="form-control" name="tipo_moneda" id="tipo_moneda" required>
                        <option value="">Selecciona un tipo de moneda</option>
                        <?php echo $opcionesTiposMoneda; ?>
                    </select>
                </div>

                <!-- Campo para subir la foto del producto -->
                <div class="mb-3">
                    <label for="url_imagen" class="form-label">Subir Foto</label>
                    <input class="form-control" type="file" id="url_imagen" name="url_imagen" accept=".jpg, .png, .jpeg">
                </div>

                <!-- Botón para enviar el formulario -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>