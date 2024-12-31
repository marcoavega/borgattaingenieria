<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>entradasProductoTerminado/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Entradas
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>entradaPTNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registro Entradas Nº Serie
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>entradaPTSearch/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Consultar Vale Entradas
                    </a>
                </li>
            </ul>
            <hr>
          
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10 py-4">
            <!-- Título de la página -->
            <h4 class="text-center">Entradas de Producto Terminado</h4>
            <!-- Subtítulo de la página -->
            <h5 class="text-center">Nueva Entrada</h5>

            <!-- Contenedor para el formulario de creación de producto -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <?php
                    // Importa el controlador de productos
                    use app\controllers\entradaPTController;

                    // Crea una instancia del controlador
                    $insDatos = new entradaPTController();

                    // Obtiene las opciones de empleados.
                    $opcionesEmpleados = $insDatos->obtenerEmpleados();
                    $opcionesAlmacenes = $insDatos->obtenerOpcionesAlmacenes();
                    ?>
                    <?php
                    // Incluye el botón de regreso
                    include "./app/views/inc/btn_back2.php";
                    ?>
                    <!-- Formulario de creación de orden -->
                    <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/entradaPTAjax.php"
                        method="POST" autocomplete="off" enctype="multipart/form-data">
                        <!-- Campo oculto para el módulo de orden compra -->
                        <input type="hidden" name="modulo_entrada_producto" value="registrar">

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
    </div>
</div>