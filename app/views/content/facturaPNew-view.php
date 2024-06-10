 <!-- Contenedor principal -->
 <div class="container-fluid py-4">

<!-- Título de la página -->
<h1 class="display-4 text-center">Captura de Factura</h1>
<!-- Subtítulo de la página -->
<h2 class="lead text-center">Alta de productos en Factura</h2>

<!-- Contenedor para el formulario de creación de producto -->
<div class="row justify-content-center">
    <div class="col-lg-6">
        <?php
        // Importa el controlador de productos
        use app\controllers\facturaProductosController;

        // Crea una instancia del controlador
        $insfactura = new facturaProductosController();
        $insNombreProducto = new facturaProductosController();
        $insCodigoProducto = new facturaProductosController();
        $insUnidadesMedida = new facturaProductosController();

        // Obtiene las opciones de proveedores.
        $opcionesFacturas = $insfactura->obtenerOpcionesfactura();
        $opcionesNombreProductos = $insNombreProducto->obtenerOpcionesNombreProductos();
        $opcionesCodigoProductos = $insCodigoProducto->obtenerOpcionesCodigoProductos();
        $opcionesUnidadesMedida = $insUnidadesMedida->obtenerOpcionesUnidadesMedida();
        ?>
        <?php
        // Incluye el botón de regreso
        include "./app/views/inc/btn_back2.php";
        ?>
        <!-- Formulario de creación de orden -->
        <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/facturaProductosAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
            <!-- Campo oculto para el módulo de orden compra -->
            <input type="hidden" name="modulo_factura_productos" value="registrar">

            <div class="row">

                <!-- Campo de selección -->
                <div class="mb-3">
                    <label for="id_factura" class="form-label">Factura</label>
                    <select class='form-control' name='id_factura' id='id_factura' required>
                        <option value="">Seleccione una Factura</option>
                        <?php echo $opcionesFacturas; ?>
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
                    <label for="total" class="form-label">Precio total con IVA:</label>
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
// Función para calcular el precio total incluyendo IVA
function calcularPrecioTotal() {
    // Obtiene el precio sin IVA
    var precioSinIVA = parseFloat(document.getElementById("precio_sin_IVA").value);

    // Calcula el precio total incluyendo el 16% de IVA
    var precioTotal = precioSinIVA * 1.16;

    // Establece el precio total en el campo correspondiente
    document.getElementById("total").value = precioTotal.toFixed(2);
}

// Agrega eventos oninput al campo de precio sin IVA para llamar a la función calcularPrecioTotal
document.getElementById("precio_sin_IVA").addEventListener("input", calcularPrecioTotal);
</script>
