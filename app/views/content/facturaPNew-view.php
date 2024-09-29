<?php
use app\controllers\facturaProductosController;

$insfactura = new facturaProductosController();
$insNombreProducto = new facturaProductosController();
$insCodigoProducto = new facturaProductosController();
$insUnidadesMedida = new facturaProductosController();

$opcionesFacturas = $insfactura->obtenerOpcionesfactura();
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
                    <a href="<?php echo APP_URL; ?>facturaNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Capturar
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>facturaPNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Alta
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>facturaSearch/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Consultar/Imprimir
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>movFactura/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Sacar Reporte
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10">
            <div class="container-fluid py-4">
                <h4 class="text-center mb-4">Alta de productos en Factura</h4>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <?php include "./app/views/inc/btn_back2.php"; ?>

                        <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/facturaProductosAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="modulo_factura_productos" value="registrar">

                            <div class="mb-3">
                                <label for="id_factura" class="form-label">Factura</label>
                                <select class='form-select form-select-sm' name='id_factura' id='id_factura' required>
                                    <option value="">Seleccione una Factura</option>
                                    <?php echo $opcionesFacturas; ?>
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
                                <label for="total" class="form-label">Precio total con IVA:</label>
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
    var precioSinIVA = parseFloat(document.getElementById("precio_sin_IVA").value);
    var precioTotal = precioSinIVA * 1.16;
    document.getElementById("total").value = precioTotal.toFixed(2);
}

document.getElementById("precio_sin_IVA").addEventListener("input", calcularPrecioTotal);
</script>