<?php
use app\controllers\notaEntradaProductosController;

$insNotaEntradaProductos = new notaEntradaProductosController();

$opcionesOrdenes = $insNotaEntradaProductos->obtenerOpcionesOrdenCompra();
$opcionesUnidadesMedida = $insNotaEntradaProductos->obtenerOpcionesUnidadesMedida();
$opcionesNotasEntrada = $insNotaEntradaProductos->obtenerOpcionesNotas(); 
$opcionesProductos = $insNotaEntradaProductos->obtenerOpcionesProducto();
$opcionesProductosId = $insNotaEntradaProductos->obtenerOpcionesProductoId();
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
                <h4 class="text-center mb-4">Alta de productos en Nota de Entrada</h4>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <?php include "./app/views/inc/btn_back2.php"; ?>

                        <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/notaEntradaProductosAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="modulo_nota_entrada_productos" value="registrar">

                            <div class="mb-3">
                                <label for="id_nota_entrada" class="form-label">Nota Entrada</label>
                                <select class="form-select form-select-sm" name="id_nota_entrada" id="id_nota_entrada" required>
                                    <option value="">Selecciona una Nota</option>
                                    <?php echo $opcionesNotasEntrada; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="numero_orden" class="form-label">Orden de compra</label>
                                <select class="form-select form-select-sm" name="numero_orden" id="numero_orden" required>
                                    <option value="">Selecciona una Orden</option>
                                    <?php echo $opcionesOrdenes; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="nombre_producto" class="form-label">Nombre de Producto</label>
                                <select class="form-select form-select-sm" name="nombre_producto" id="nombre_producto" required>
                                    <option value="">Selecciona un Producto</option>
                                    <?php echo $opcionesProductos; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_producto" class="form-label">Confirmar nombre de Producto</label>
                                <select class="form-select form-select-sm" name="id_producto" id="id_producto" required>
                                    <option value="">Selecciona un Producto</option>
                                    <?php echo $opcionesProductosId; ?>
                                </select>
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