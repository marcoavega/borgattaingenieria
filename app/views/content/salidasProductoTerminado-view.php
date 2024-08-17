<!-- Contenedor principal -->
<div class="container-fluid py-4">

    <!-- Título de la página -->
    <h1 class="display-4 text-center">Salidas de Producto Terminado</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center">Nueva salida</h2>

    <!-- Contenedor para el formulario de creación de producto -->
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <?php
            // Importa el controlador de productos
            use app\controllers\salidaPTController;

            // Crea una instancia del controlador
            $insDatos = new salidaPTController();

            // Obtiene las opciones de empleados.
            $opcionesEmpleados = $insDatos->obtenerEmpleados();
            $opcionesAlmacenes = $insDatos->obtenerOpcionesAlmacenes();
            ?>
            <?php
            // Incluye el botón de regreso
            include "./app/views/inc/btn_back2.php";
            ?>
            <!-- Formulario de creación de orden -->
            <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/salidaPTAjax.php"
                method="POST" autocomplete="off" enctype="multipart/form-data">
                <!-- Campo oculto para el módulo de orden compra -->
                <input type="hidden" name="modulo_salida_producto" value="registrar">

                <div class="row">

                    <!-- Campo de selección para el nombre de empleado -->
                    <div class="form-group mt-3">
                        <label for="id_empleado" class="form-label">Nombre de empleado que registra:</label>
                        <select class='form-control' name='id_empleado' id='id_empleado'>
                            <option value="">Empleado que registra</option>
                            <?php echo $opcionesEmpleados; ?>
                        </select>
                    </div>
                     <!-- Campo de selección para el almacen del producto -->
                    <div class="form-group mt-3">
                        <label for="id_almacen_destino" class="form-label">Almacen de destino</label>
                        <select class='form-control' name='id_almacen_destino' id='id_almacen_destino' required>
                            <option value="">Selecciona un almacen</option>
                            <?php echo $opcionesAlmacenes; ?>
                        </select>
                    </div>
                    <!-- Campo para el código del producto -->
                    <div class="mb-3">
                        <label for="receptor" class="form-label">¿Quién Recibe?:</label>
                        <input type="text" class="form-control" id="receptor" name="receptor"
                            maxlength="30" placeholder="Nombre de quien recibe" required>
                    </div>
                    <!-- Botón para enviar el formulario -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>