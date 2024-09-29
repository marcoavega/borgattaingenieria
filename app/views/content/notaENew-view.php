<?php
use app\controllers\notaEntradaController;

$insProduct = new notaEntradaController();
$opcionesProveedores = $insProduct->obtenerOpcionesProveedores();
$opcionesEmpleados = $insProduct->obtenerEmpleados();
?>

<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>notaENew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Nueva Nota
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>notaEPNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Alta de Productos
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>notaESearch/" class="nav-link active" aria-current="page">
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
                <h4 class="text-center mb-4">Nueva Nota de Entrada</h4>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <?php include "./app/views/inc/btn_back2.php"; ?>

                        <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/notaEntradaAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="modulo_nota_entrada" value="registrar">

                            <div class="mb-3">
                                <label for="id_proveedor" class="form-label">Datos Proveedor</label>
                                <select class='form-select form-select-sm' name='id_proveedor' id='id_proveedor' required>
                                    <option value="">Selecciona un proveedor</option>
                                    <?php echo $opcionesProveedores; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_empleado" class="form-label">Nombre de empleado que registra:</label>
                                <select class='form-select form-select-sm' name='id_empleado' id='id_empleado' required>
                                    <option value="">Empleado que registra</option>
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
    .form-select-sm {
        font-size: 0.85rem;
    }
    .btn-sm {
        font-size: 0.85rem;
    }
</style>