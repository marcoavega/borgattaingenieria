<!-- Contenedor principal -->
<div class="container mb-4">
    <!-- Títulos de la página -->
    <h1 class="display-4 text-center">Usuarios</h1>
    <h2 class="lead text-center">Nuevo usuario</h2>
</div>

<!-- Contenedor para el formulario de creación de usuario -->
<div class="container py-4">

    <div class="row">

        <div class="col-lg-8 mx-auto">
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