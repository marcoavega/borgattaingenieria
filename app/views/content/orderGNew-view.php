<!-- Contenedor principal -->
<div class="container-fluid py-4">

    <!-- Título de la página -->
    <h1 class="display-4 text-center">Orden de Gasto</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center">Nueva Orden</h2>

    <!-- Contenedor para el formulario de creación de producto -->
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <?php
            // Importa el controlador de productos
            use app\controllers\ordenGastoController;

            // Crea una instancia del controlador
            $insProduct = new ordenGastoController();
            $insMoneda = new ordenGastoController();

            // Obtiene las opciones de proveedores.
            $opcionesProveedores = $insProduct->obtenerOpcionesProveedores();
            $opcionesTiposMoneda = $insMoneda->obtenerOpcionesMonedas();
            $opcionesEmpleados = $insProduct->obtenerEmpleados();
            $opcionesUsos = $insProduct->obtenerUsos();
            $opcionesMetodosPago = $insProduct->obtenerMetodosPago(); 
            ?>
            <?php
            // Incluye el botón de regreso
            include "./app/views/inc/btn_back2.php";
            ?>
            <!-- Formulario de creación de orden -->
            <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/ordenGastoAjax.php"
                method="POST" autocomplete="off" enctype="multipart/form-data">
                <!-- Campo oculto para el módulo de orden compra -->
                <input type="hidden" name="modulo_orden_gasto" value="registrar">

                <div class="row">
                    <!-- Campo para el número de orden (generado automáticamente) -->
                    <!--<div class="col-md-6">
                        <div class="form-group">
                            <label for="numero_orden" class="form-label">Numero de orden:</label>
                            <input type="text" class="form-control" id="numero_orden" name="numero_orden" value="<?//php echo $numero_orden_generado; ?>" readonly>
                        </div>
                    </div> -->

                    <!-- Campo de selección para el proveedor del producto -->
                    <div class="mb-3">
                        <label for="id_proveedor" class="form-label">Datos Proveedor</label>
                        <select class='form-control' name='id_proveedor' id='id_proveedor' required>
                            <option value="">Selecciona un proveedor</option>
                            <?php echo $opcionesProveedores; ?>
                        </select>
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
                    <label for="id_almacen_origen" class="form-label">Nombre de empleado que solicita:</label>
                    <select class='form-control' name='id_empleado' id='id_empleado' required>
                        <option value="">Empleado que solicita</option>
                        <?php echo $opcionesEmpleados; ?>
                    </select>
                </div>
                 <!-- Campo de selección para el nombre de empleado -->
                <div class="form-group mt-3">
                    <label for="id_uso" class="form-label">Uso de CFDI:</label>
                    <select class='form-control' name='id_uso' id='id_uso' required>
                        <option value="">Seleccione el uso de CFDI</option>
                        <?php echo $opcionesUsos; ?>
                    </select>
                </div>
                  <!-- Campo de selección para el nombre de empleado -->
                <div class="form-group mt-3">
                    <label for="id_metodo" class="form-label">Metodos de pago:</label>
                    <select class='form-control' name='id_metodo' id='id_metodo' required>
                        <option value="">Seleccione el metodo de pago</option>
                        <?php echo $opcionesMetodosPago; ?>
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