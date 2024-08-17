<!-- Contenedor principal -->
<div class="container-fluid py-4">

    <!-- Título de la página -->
    <h1 class="display-4 text-center">Nota entrada</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center">Alta de productos en Nota</h2>

    <!-- Contenedor para el formulario de creación de producto -->
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <?php
            // Importa el controlador de productos
            use app\controllers\notaEntradaProductosController;

            // Crea una instancia del controlador
            $insNotaEntradaProductos = new notaEntradaProductosController();

            // Obtiene las opciones de órdenes de compra y unidades de medida
            $opcionesOrdenes = $insNotaEntradaProductos->obtenerOpcionesOrdenCompra();
            $opcionesUnidadesMedida = $insNotaEntradaProductos->obtenerOpcionesUnidadesMedida();
            $opcionesNotasEntrada = $insNotaEntradaProductos->obtenerOpcionesNotas(); 
            $opcionesProductos = $insNotaEntradaProductos->obtenerOpcionesProducto();
            $opcionesProductosId = $insNotaEntradaProductos->obtenerOpcionesProductoId();
            ?>

            <?php
            // Incluye el botón de regreso
            include "./app/views/inc/btn_back2.php";
            ?>
            
            <!-- Formulario de creación de orden -->
            <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/notaEntradaProductosAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                <!-- Campo oculto para el módulo de orden compra -->
                <input type="hidden" name="modulo_nota_entrada_productos" value="registrar">

                <div class="row">

                <!-- Campo de selección -->
                <div class="mb-3">
                        <label for="id_nota_entrada" class="form-label">Nota Entrada</label>
                        <select class="form-control" name="id_nota_entrada" id="id_nota_entrada" required>
                            <option value="">Selecciona una Nota</option>
                            <?php echo $opcionesNotasEntrada; ?>
                        </select>
                    </div>

                    <!-- Campo de selección -->
                    <div class="mb-3">
                        <label for="numero_orden" class="form-label">Orden de compra</label>
                        <select class="form-control" name="numero_orden" id="numero_orden" required>
                            <option value="">Selecciona una Orden</option>
                            <?php echo $opcionesOrdenes; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="numero_partida" class="form-label">Numero de partida:</label>
                        <input type="text" class="form-control" id="numero_partida" name="numero_partida" required>
                    </div>

                    <div class="mb-3">
                        <label for="nombre_producto" class="form-label">Nombre de Producto</label>
                        <select class="form-control" name="nombre_producto" id="nombre_producto" required>
                            <option value="">Selecciona un Producto</option>
                            <?php echo $opcionesProductos; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_producto" class="form-label">Confirmar nombre de Producto</label>
                        <select class="form-control" name="id_producto" id="id_producto" required>
                            <option value="">Selecciona un Producto</option>
                            <?php echo $opcionesProductosId; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad:</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                    </div>

                    <!-- Campo de selección para la unidad de medida del producto -->
                    <div class="mb-3">
                        <label for="unidad_medida" class="form-label">Unidad de Medida</label>
                        <select class="form-control" name="unidad_medida" id="unidad_medida" required>
                            <option value="">Selecciona una unidad de medida</option>
                            <?php echo $opcionesUnidadesMedida; ?>
                        </select>
                    </div>

                </div><!-- termina row -->

                <!-- Botón para enviar el formulario -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>

        </div>
    </div>
</div>
