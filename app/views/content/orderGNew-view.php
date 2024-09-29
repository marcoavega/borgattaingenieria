<?php
use app\controllers\ordenGastoController;

// Crea una instancia del controlador
$insProduct = new ordenGastoController();
$insMoneda = new ordenGastoController();

// Obtiene las opciones necesarias
$opcionesProveedores = $insProduct->obtenerOpcionesProveedores();
$opcionesTiposMoneda = $insMoneda->obtenerOpcionesMonedas();
$opcionesEmpleados = $insProduct->obtenerEmpleados();
$opcionesUsos = $insProduct->obtenerUsos();
$opcionesMetodosPago = $insProduct->obtenerMetodosPago();
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
                <h4 class="text-center mb-4">Nueva Orden de Gasto</h4>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <?php include "./app/views/inc/btn_back2.php"; ?>

                        <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/ordenGastoAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="modulo_orden_gasto" value="registrar">

                            <div class="mb-3">
                                <label for="id_proveedor" class="form-label">Datos Proveedor</label>
                                <select class='form-select form-select-sm' name='id_proveedor' id='id_proveedor' required>
                                    <option value="">Selecciona un proveedor</option>
                                    <?php echo $opcionesProveedores; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_moneda" class="form-label">Tipos de moneda</label>
                                <select class='form-select form-select-sm' name='id_moneda' id='id_moneda' required>
                                    <option value="">Selecciona un tipo de moneda</option>
                                    <?php echo $opcionesTiposMoneda; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_empleado" class="form-label">Nombre de empleado que solicita:</label>
                                <select class='form-select form-select-sm' name='id_empleado' id='id_empleado' required>
                                    <option value="">Empleado que solicita</option>
                                    <?php echo $opcionesEmpleados; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_uso" class="form-label">Uso de CFDI:</label>
                                <select class='form-select form-select-sm' name='id_uso' id='id_uso' required>
                                    <option value="">Seleccione el uso de CFDI</option>
                                    <?php echo $opcionesUsos; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_metodo" class="form-label">Métodos de pago:</label>
                                <select class='form-select form-select-sm' name='id_metodo' id='id_metodo' required>
                                    <option value="">Seleccione el método de pago</option>
                                    <?php echo $opcionesMetodosPago; ?>
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
    .form-select-sm {
        font-size: 0.85rem;
    }
    .btn-sm {
        font-size: 0.85rem;
    }
</style>