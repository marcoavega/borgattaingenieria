<?php
use app\controllers\facturaController;

$insProduct = new facturaController();
$insMoneda = new facturaController();

$opcionesProveedores = $insProduct->obtenerOpcionesProveedores();
$opcionesTiposMoneda = $insMoneda->obtenerOpcionesMonedas();
$opcionesEmpleados = $insProduct->obtenerEmpleados();
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
                <h4 class="text-center mb-4">Captura de Factura</h4>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <?php include "./app/views/inc/btn_back2.php"; ?>

                        <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/facturaAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="modulo_factura" value="registrar">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="numero_factura" class="form-label">Número de Factura:</label>
                                    <input type="text" class="form-control form-control-sm" id="numero_factura" name="numero_factura">
                                </div>
                                <div class="col-md-6">
                                    <label for="id_proveedor" class="form-label">Datos Proveedor</label>
                                    <select class='form-select form-select-sm' name='id_proveedor' id='id_proveedor' required>
                                        <option value="">Selecciona un proveedor</option>
                                        <?php echo $opcionesProveedores; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="fecha_emision" class="form-label">Fecha de Emisión:</label>
                                    <input type="date" class="form-control form-control-sm" id="fecha_emision" name="fecha_emision" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento:</label>
                                    <input type="date" class="form-control form-control-sm" id="fecha_vencimiento" name="fecha_vencimiento" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="id_moneda" class="form-label">Tipos de moneda</label>
                                <select class='form-select form-select-sm' name='id_moneda' id='id_moneda' required>
                                    <option value="">Selecciona un tipo de moneda</option>
                                    <?php echo $opcionesTiposMoneda; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_empleado" class="form-label">Nombre de empleado que captura:</label>
                                <select class='form-select form-select-sm' name='id_empleado' id='id_empleado' required>
                                    <option value="">Empleado que captura</option>
                                    <?php echo $opcionesEmpleados; ?>
                                </select>
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