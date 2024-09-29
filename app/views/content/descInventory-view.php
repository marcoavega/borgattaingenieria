<?php
use app\controllers\inventoryController;

$id = $insLogin->limpiarCadena($url[1]);
$insInventory = new inventoryController();
$opcionesAlmacenes = $insInventory->obtenerOpcionesAlmacenes();
$datos = $insLogin->seleccionarDatos("Unico", "productos", "id_producto", $id);

if ($datos->rowCount() != 1) {
    include "./app/views/inc/error_alert.php";
    exit;
}
$datos = $datos->fetch();
?>

<div class="container-fluid">
    <div class="row">
       <!-- Menú lateral -->
       <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productList/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Lista de Productos
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Nuevo
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productInvent/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Inventario
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10">
            <div class="container py-4">
                <h4 class="text-center mb-4">Descontar Inventario</h4>

                <?php include "./app/views/inc/btn_back2.php"; ?>

                <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/inventoryAjax.php" method="POST" autocomplete="off">
                    <input type="hidden" name="modulo_Inventory" value="registrar">
                    <input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">

                    <div class="mb-3">
                        <label for="nombre_producto" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control form-control-sm" id="nombre_producto" value="<?php echo htmlspecialchars($datos['nombre_producto']); ?>" readonly>
                    </div>

                    <?php
                    $stockData = $insLogin->seleccionarDatos2("Unico", "productos", "id_producto", $id);
                    if ($stockData->rowCount() > 0) {
                        while ($fila = $stockData->fetch(PDO::FETCH_ASSOC)) {
                            echo '<div class="mb-2">';
                            echo '<input type="text" class="form-control form-control-sm" value="Stock en ' . htmlspecialchars($fila['nombre_almacen'], ENT_QUOTES, 'UTF-8') . ': ' . htmlspecialchars($fila['stock'], ENT_QUOTES, 'UTF-8') . '" readonly>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p class="text-danger">Error: Producto no encontrado.</p>';
                    }
                    ?>

                    <div class="mb-3">
                        <label for="id_almacen_origen" class="form-label">Almacén</label>
                        <select class="form-select form-select-sm" name="id_almacen_origen" id="id_almacen_origen" required>
                            <option value="">Selecciona un almacén a descontar</option>
                            <?php echo $opcionesAlmacenes; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label">Cantidad a descontar:</label>
                        <input type="number" class="form-control form-control-sm" id="stock" name="stock" required>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">Realizar movimiento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    body { font-size: 0.9rem; }
    .form-label { font-size: 0.85rem; }
    .btn { font-size: 0.85rem; }
</style>