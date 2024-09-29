<?php
use app\controllers\ordenGastoProductosController;

// Crea una instancia del controlador
$insOrdenGasto = new ordenGastoProductosController();
$insNombreProducto = new ordenGastoProductosController();
$insCodigoProducto = new ordenGastoProductosController();
$insUnidadesMedida = new ordenGastoProductosController();

// Obtiene las opciones necesarias
$opcionesOrdenes = $insOrdenGasto->obtenerOpcionesOrdenGasto();
$opcionesNombreProductos = $insNombreProducto->obtenerOpcionesNombreProductos();
$opcionesCodigoProductos = $insCodigoProducto->obtenerOpcionesCodigoProductos();
$opcionesUnidadesMedida = $insUnidadesMedida->obtenerOpcionesUnidadesMedida();
?>

<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>orderGNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Nueva orden
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>orderGPNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Alta de productos
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>orderGSearch/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Consultar
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10">
            <div class="container-fluid py-4">
                <h4 class="text-center mb-4">Alta de productos en Orden de Gasto</h4>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <?php include "./app/views/inc/btn_back2.php"; ?>

                        <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/ordenGastoProductosAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="modulo_orden_gasto_productos" value="registrar">

                            <div class="mb-3">
                                <label for="id_orden_gasto" class="form-label">Órdenes de gasto</label>
                                <select class='form-select form-select-sm' name='id_orden_gasto' id='id_orden_gasto' required>
                                    <option value="">Selecciona una orden</option>
                                    <?php echo $opcionesOrdenes; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="nombre_producto" class="form-label">Nombre Producto:</label>
                                <textarea class="form-control form-control-sm" id="nombre_producto" name="nombre_producto" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad:</label>
                                <input type="number" class="form-control form-control-sm" id="cantidad" name="cantidad" required>
                            </div>

                            <div class="mb-3">
                                <label for="unidad_medida" class="form-label">Unidad de Medida</label>
                                <select class="form-select form-select-sm" name="unidad_medida" id="unidad_medida" required>
                                    <option value="">Selecciona una unidad de medida</option>
                                    <?php echo $opcionesUnidadesMedida; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="precio_sin_IVA" class="form-label">Precio sin IVA:</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control form-control-sm" id="precio_sin_IVA" name="precio_sin_IVA" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="total" class="form-label">Precio total:</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control form-control-sm" id="total" name="total" required readonly>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        font-size: 0.9rem;
    }
    .form-label {
        font-size: 0.85rem;
    }
    .form-select-sm, .form-control-sm {
        font-size: 0.85rem;
    }
    .btn-sm {
        font-size: 0.85rem;
    }
</style>

<script>
    function calcularPrecioTotal() {
        var cantidad = parseFloat(document.getElementById("cantidad").value);
        var precioSinIVA = parseFloat(document.getElementById("precio_sin_IVA").value);
        var precioTotal = cantidad * precioSinIVA;
        document.getElementById("total").value = precioTotal.toFixed(2);
    }

    document.getElementById("cantidad").addEventListener("input", calcularPrecioTotal);
    document.getElementById("precio_sin_IVA").addEventListener("input", calcularPrecioTotal);
</script>