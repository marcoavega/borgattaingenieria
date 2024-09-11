<!-- Contenedor principal -->
<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>almacenList/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Lista de Almacenes
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>almacenNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Nuevo Almacén
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Formulario de creación de almacén -->
        <div class="col-md-9 col-lg-10">
            <!-- Título de la página -->
            <h4 class="text-center">Gestión de Almacenes</h4>
            <!-- Subtítulo de la página -->
            <h5 class="lead text-center">Nuevo Almacén</h5>

            <!-- Formulario de creación de almacén -->
            <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/almacenAjax.php" method="POST" autocomplete="off">
                <!-- Campo oculto para el módulo de almacén -->
                <input type="hidden" name="modulo_almacen" value="registrar">

                <!-- Campo para el nombre del almacén -->
                <div class="mb-3">
                    <label for="nombre_almacen" class="form-label">Nombre del Almacén</label>
                    <input type="text" class="form-control" id="nombre_almacen" name="nombre_almacen" maxlength="100" required>
                </div>

                <!-- Botones para limpiar el formulario y enviar el formulario -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-secondary">Limpiar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>