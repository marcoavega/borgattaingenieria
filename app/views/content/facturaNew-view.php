<!-- Contenedor principal -->
<div class="container-fluid py-4">

    <!-- Título de la página -->
    <h1 class="display-4 text-center">Captura de Factura</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center">Nueva Captura</h2>

    <!-- Contenedor para el formulario de creación de producto -->
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <?php
            // Importa el controlador de productos
            use app\controllers\facturaController;

            // Crea una instancia del controlador
            $insProduct = new facturaController();
            $insMoneda = new facturaController();


            // Obtiene las opciones de proveedores.
            $opcionesProveedores = $insProduct->obtenerOpcionesProveedores();
            $opcionesTiposMoneda = $insMoneda->obtenerOpcionesMonedas();
            $opcionesEmpleados = $insProduct->obtenerEmpleados();
            ?>
            <?php
            // Incluye el botón de regreso
            include "./app/views/inc/btn_back2.php";
            ?>
            <!-- Formulario de creación de orden -->
            <form class="FormularioAjax p-4 border rounded-3"
                action="<?php echo APP_URL; ?>app/ajax/facturaAjax.php" method="POST" autocomplete="off"
                enctype="multipart/form-data">
                <!-- Campo oculto para el módulo de orden compra -->
                <input type="hidden" name="modulo_factura" value="registrar">

                <div class="row">
                    <!-- Campo para el número de orden (generado automáticamente) -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="numero_orden" class="form-label">Número de Factura:</label>
                            <input type="text" class="form-control" id="numero_factura" name="numero_factura">
                        </div>
                    </div>

                    <!-- Campo de selección para el proveedor del producto -->
                    <div class="mb-3">
                        <label for="id_proveedor" class="form-label">Datos Proveedor</label>
                        <select class='form-control' name='id_proveedor' id='id_proveedor' required>
                            <option value="">Selecciona un proveedor</option>
                            <?php echo $opcionesProveedores; ?>
                        </select>
                    </div>

                    <!-- Campo para la fecha de emisión -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_emision" class="form-label">Fecha de Emisión:</label>
                            <input type="date" class="form-control" id="fecha_emision" name="fecha_emision" required>
                        </div>
                    </div>

                    <!-- Campo para la fecha de vencimiento -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento:</label>
                            <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
                        </div>
                    </div>
                </div><!-- termina row -->

                <!-- Campo de selección -->
                <div class="mb-3">
                    <label for="id_moneda" class="form-label">Tipos de moneda</label>
                    <select class='form-control' name='id_moneda' id='id_moneda' required>
                        <option value="">Selecciona un tipo de moneda</option>
                        <?php echo $opcionesTiposMoneda; ?>
                    </select>
                </div>
                <!-- Campo de selección para el nombre de empleado -->
                <div class="form-group mt-3">
                    <label for="id_almacen_origen" class="form-label">Nombre de empleado que captura:</label>
                    <select class='form-control' name='id_empleado' id='id_empleado' required>
                        <option value="">Empleado que captura</option>
                        <?php echo $opcionesEmpleados; ?>
                    </select>
                </div>
                <!-- Botón para enviar el formulario -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
