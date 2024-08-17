 <!-- Contenedor principal -->
<div class="container-fluid py-4">

    <!-- Título de la página -->
    <h1 class="display-4 text-center">Orden de Compra</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center">Alta de productos en Orden</h2>

    <!-- Contenedor para el formulario de creación de producto -->
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <?php
            // Importa el controlador de productos
            use app\controllers\ordenCompraProductosController;

            // Crea una instancia del controlador
            $insOrdencompra = new ordenCompraProductosController();
            $insNombreProducto = new ordenCompraProductosController();
            $insCodigoProducto = new ordenCompraProductosController();
            $insUnidadesMedida = new ordenCompraProductosController();


            // Obtiene las opciones de proveedores.
            $opcionesOrdenes = $insOrdencompra->obtenerOpcionesOrdenCompra();
            $opcionesNombreProductos = $insNombreProducto->obtenerOpcionesNombreProductos();
            $opcionesCodigoProductos = $insCodigoProducto->obtenerOpcionesCodigoProductos();
            $opcionesUnidadesMedida = $insUnidadesMedida->obtenerOpcionesUnidadesMedida();

            ?>
            <?php
            // Incluye el botón de regreso
            include "./app/views/inc/btn_back2.php";
            ?>
            <!-- Formulario de creación de orden -->
            <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/ordenCompraProductosAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                <!-- Campo oculto para el módulo de orden compra -->
                <input type="hidden" name="modulo_orden_compra_productos" value="registrar">

                <div class="row">

                    <!-- Campo de selección -->
        <div class="mb-3">
            <label for="id_orden_compra" class="form-label">Ordenes de compra</label>
            <select class='form-control' name='id_orden_compra' id='id_orden_compra' required>
                <option value="">Selecciona una orden</option>
                <?php echo $opcionesOrdenes; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="numero_partida" class="form-label">Numero de partida:</label>
            <input type="number" class="form-control" id="numero_partida" name="numero_partida" required>
        </div>


        <div class="mb-3">
            <label for="nombre_producto" class="form-label">Nombre Producto:</label>
            <textarea class="form-control" id="nombre_producto" name="nombre_producto" required></textarea>
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


        <div class="mb-3">
            <label for="precio_sin_IVA" class="form-label">Precio sin IVA:</label>
            <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="text" class="form-control" id="precio_sin_IVA" name="precio_sin_IVA" required>
            </div>
        </div>

        <!-- Campo para el precio total -->
        <div class="mb-3">
            <label for="total" class="form-label">Precio total:</label>
            <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="text" class="form-control" id="total" name="total" required readonly>
            </div>
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

<script>
    // Función para calcular el precio total
    function calcularPrecioTotal() {
        // Obtiene la cantidad y el precio sin IVA
        var cantidad = parseFloat(document.getElementById("cantidad").value);
        var precioSinIVA = parseFloat(document.getElementById("precio_sin_IVA").value);

        // Calcula el precio total
        var precioTotal = cantidad * precioSinIVA;

        // Establece el precio total en el campo correspondiente
        document.getElementById("total").value = precioTotal.toFixed(2);
    }

    // Agrega eventos oninput a los campos de cantidad y precio sin IVA para llamar a la función calcularPrecioTotal
    document.getElementById("cantidad").addEventListener("input", calcularPrecioTotal);
    document.getElementById("precio_sin_IVA").addEventListener("input", calcularPrecioTotal);
</script>
