<!-- Contenedor principal -->
<div class="container-fluid py-4">
    <!-- Título de la página -->
    <h1 class="display-4 text-center">Registrar Stock Almacenes</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center">Nuevo Registro</h2>

    <!-- Contenedor para el formulario de creación de producto -->
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <?php
            // Importa el controlador de productos
            use app\controllers\stockController;

            // Crea una instancia del controlador
            $stockProduct = new stockController();

            // Obtiene las opciones de categorías, proveedores, unidades de medida y tipos de moneda
            $opcionesProductos = $stockProduct->obtenerOpcionesProductos();
            $opcionesAlmacenes = $stockProduct->obtenerOpcionesAlmacenes();
            ?>
            <?php
            // Incluye el botón de regreso
            include "./app/views/inc/btn_back.php";
            ?>
            <!-- Formulario de creación de producto -->
            <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/stockAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                <!-- Campo oculto para el módulo de producto -->

                <input type="hidden" name="modulo_stock" value="registrar">

                <!-- Campo de selección para la unidad de medida del producto -->
                <div class="mb-3">
                    <label for="id_producto" class="form-label">Producto</label>
                    <select class="form-control" name="id_producto" id="id_producto" required>
                        <option value="">Seleccione un producto</option>
                        <?php echo $opcionesProductos; ?>
                    </select>
                </div>

                <!-- Campo de selección para el tipo de moneda del producto -->
                <div class="mb-3">
                    <label for="id_almacen" class="form-label">Almacen</label>
                    <select class="form-control" name="id_almacen" id="id_almacen" required>
                        <option value="">Seleccione un almacen</option>
                        <?php echo $opcionesAlmacenes; ?>
                    </select>
                </div>

               <!-- Campo para la cantidad de producto -->
               <div class="mb-3">
                    <label for="stock" class="form-label">Cantidad a Ingresar:</label>
                    <input type="number" class="form-control" id="stock" name="stock" required>
                </div>

                <!-- Botón para enviar el formulario -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>