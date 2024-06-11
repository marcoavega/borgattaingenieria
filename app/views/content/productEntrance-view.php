<!-- Contenedor principal -->
<div class="container-fluid mb-4">
    <h1 class="display-4 text-center">Ingresar Stock</h1>
    <h2 class="lead text-center">Agregar cantidad</h2>
</div>

<!-- Contenedor para el formulario de edición de producto -->
<div class="container py-4">
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

    // Incluye el botón de regreso
    include "./app/views/inc/btn_back2.php";
    ?>
    <!-- Formulario de edición de producto -->
    <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/productAjax.php"
        method="POST" autocomplete="off">
        <input type="hidden" name="modulo_product" value="actualizarStock">
        <input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">

        <!-- Campo de selección para el almacen -->
        <div class="mb-3">
            <label for="almacen" class="form-label">Selecciones el almacen</label>
            <select class="form-control" name="almacen" id="almacen" required>
                <option value="">Seleccione un almacen</option>
                <?php echo $opcionesAlmacen; ?>
            </select>
        </div>

        <!-- Resto del formulario como antes -->
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