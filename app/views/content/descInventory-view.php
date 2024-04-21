<!-- Contenedor principal -->
<div class="container-fluid mb-4">
    <?php
    // Obtiene el ID del producto a editar
    $id = $insLogin->limpiarCadena($url[1]);
    ?>
    <!-- Título de la página -->
    <h1 class="display-4 text-center">Descontar Inventario</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center"></h2>
</div>

<!-- Contenedor para el formulario de edición de producto -->
<div class="container py-4">
    <?php
    // Importa el controlador de productos
    use app\controllers\inventoryController;

    // Crea una instancia del controlador
    $insInventory = new inventoryController();

    // Obtiene las opciones de categorías, proveedores, unidades de medida y tipos de moneda
    $opcionesProductos = $insInventory->obtenerOpcionesProductos();
    $opcionesAlmacenes = $insInventory->obtenerOpcionesAlmacenes();
 
    // Comprueba si se obtuvieron los datos del producto
    // Obtiene los datos del producto a editar
    $datos = $insLogin->seleccionarDatos("Unico", "productos", "id_producto", $id);
    $datos2 = $insLogin->seleccionarDatos2("Unico", "stock_almacen", "id_producto", $id);

    if ($datos->rowCount() == 1) {
        $datos = $datos->fetch();
        ?>
    <?php
    // Incluye el botón de regreso
    include "./app/views/inc/btn_back2.php";
    ?>
    <!-- Formulario de edición de producto -->
    <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/inventoryAjax.php"
        method="POST" autocomplete="off">

        <!-- Campo oculto para el módulo de producto y el ID del producto -->
        <input type="hidden" name="modulo_Inventory" value="registrar">
        <input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">

        <!-- Campo para el código del producto -->
        <div class="mb-3">
            <label for="id_producto" class="form-label">Id Producto</label>
            <input type="text" class="form-control" id="id_producto" name="id_producto" maxlength="100"
                value="<?php echo $datos['id_producto']; ?>" required readonly>
        </div>

        <!-- Campo para mostrar el nombre del producto -->
<div class="mb-3">
    <label for="nombre_producto" class="form-label">Nombre del Producto</label>
    <input type="text" class="form-control" id="nombre_producto" value="<?php echo htmlspecialchars($datos['nombre_producto']); ?>" readonly>
</div>


<?php
$datos = $insLogin->seleccionarDatos2("Unico", "productos", "id_producto", $id);
if ($datos->rowCount() > 0) {
    while ($fila = $datos->fetch(PDO::FETCH_ASSOC)) {
        echo '<div>';
        echo '<p>Stock en ' . $fila['nombre_almacen'] . ': ' . $fila['stock'] . '</p>';
        echo '</div>';
    }
} else {
    echo '<p>Error: Producto no encontrado.</p>';
}?>
       
       
       <!-- Campo de selección para el almacén de origen -->
<div class="mb-3">
    <label for="id_almacen_origen" class="form-label">Almacén de origen</label>
    <select class='form-control' name='id_almacen_origen' id='id_almacen_origen' required>
        <option value="">Selecciona un almacén de origen</option>
        <?php echo $opcionesAlmacenes; ?>
    </select>
</div>

<!-- Campo para la cantidad de producto a descontar -->
<div class="mb-3">
    <label for="cantidad" class="form-label">Cantidad a descontar:</label>
    <input type="number" class="form-control" id="cantidad" name="cantidad" required>
</div>
       

        <!-- Botón para enviar el formulario -->
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
            <button type="submit" class="btn btn-primary">Realizar movimiento</button>
        </div>
    </form>

    <?php
    } else {
        // Si no se obtuvieron los datos del producto, muestra un mensaje de error
        include "./app/views/inc/error_alert.php";
    }
    ?>
</div>
