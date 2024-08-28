<!-- Contenedor principal -->
<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>userList/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Lista de Usuarios
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>userNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Nuevo
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Formulario de creación de usuario -->
        <div class="col-md-9 col-lg-10">
            <!-- Título de la página -->
            <h4 class="text-center">Usuarios</h4>
            <!-- Subtítulo de la página -->
            <h5 class="lead text-center">Nuevo Usuario</h5>

            <?php
            // Incluye el botón de regreso
            include "./app/views/inc/btn_back2.php";
            ?>

            <!-- Formulario de creación de usuario -->
            <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                <!-- Campo oculto para el módulo de usuario -->
                <input type="hidden" name="modulo_usuario" value="registrar">

                <!-- Campo para el nombre de usuario -->
                <div class="mb-3">
                    <label for="usuario_usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario_usuario" name="usuario_usuario" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>

                <!-- Campos para la clave -->
                <div class="mb-3">
                    <label for="usuario_clave_1" class="form-label">Clave</label>
                    <input type="password" class="form-control" id="usuario_clave_1" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
                <div class="mb-3">
                    <label for="usuario_clave_2" class="form-label">Repetir Clave</label>
                    <input type="password" class="form-control" id="usuario_clave_2" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>

                <!-- Campo para subir la foto del usuario -->
                <div class="mb-3">
                    <label for="usuario_foto" class="form-label">Subir Foto</label>
                    <input class="form-control" type="file" id="usuario_foto" name="usuario_foto" accept=".jpg, .png, .jpeg">
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