<?php
use app\controllers\productController;

$insProduct = new productController();
$opcionesAlmacen = $insProduct->obtenerAlmacenes();

// Obtiene el ID del producto de la URL o redirecciona si no está presente
$id = isset($url[1]) ? $insLogin->limpiarCadena($url[1]) : null;
if (empty($id)) {
    echo "<p>Error: ID del producto no especificado o inválido.</p>";
    exit;
}

// Intenta obtener los datos del producto
$datos = $insLogin->seleccionarDatos("Unico", "productos", "id_producto", $id);
if ($datos->rowCount() == 0) {
    echo "<p>Error: Producto no encontrado.</p>";
    exit;
} else {
    $datos = $datos->fetch();
}
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
                <h4 class="text-center">Ingresar Stock</h4>
                <h5 class="lead text-center mb-4">Agregar cantidad</h5>

                <?php
                // Incluye el botón de regreso
                include "./app/views/inc/btn_back2.php";
                ?>

                <!-- Formulario de ingreso de stock -->
                <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/productAjax.php"
                    method="POST" autocomplete="off">
                    <input type="hidden" name="modulo_product" value="actualizarStock">
                    <input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">

                    <!-- Campo de selección para el almacen -->
                    <div class="mb-3">
                        <label for="almacen" class="form-label">Seleccione el almacén</label>
                        <select class="form-control" name="almacen" id="almacen" required>
                            <option value="">Seleccione un almacén</option>
                            <?php echo $opcionesAlmacen; ?>
                        </select>
                    </div>

                    <!-- Campo para ingresar la cantidad -->
                    <div class="mb-3">
                        <label for="stock" class="form-label">Cantidad a Ingresar:</label>
                        <input type="number" class="form-control" id="stock" name="stock" required>
                    </div>

                    <!-- Botón para enviar el formulario -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button type="submit" class="btn btn-primary">Actualizar Stock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>