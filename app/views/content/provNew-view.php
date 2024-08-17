<!-- Contenedor principal -->
<div class="container mb-4">
    <!-- Títulos de la página -->
    <h1 class="display-4 text-center">Proveedores</h1>
    <h2 class="lead text-center">Nuevo Proveedor</h2>
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
            <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/proveedorAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                <!-- Campo oculto para el módulo de usuario -->
                <input type="hidden" name="modulo_proveedor" value="registrar">

                <!-- Campo para el nombre de Proveedor -->
                <div class="mb-3">
                    <label for="nombre_proveedor" class="form-label">Nombre Proveedor</label>
                    <input type="text" class="form-control" id="nombre_proveedor" name="nombre_proveedor" maxlength="100" required>
                </div>
                <!-- Campo para el RFC de Proveedor -->
                <div class="mb-3">
                    <label for="RFC_proveedor" class="form-label">RFC Proveedor</label>
                    <input type="text" class="form-control" id="RFC_proveedor" name="RFC_proveedor" maxlength="13" required>
                </div>
                <!-- Campo para el email -->
                <div class="mb-3">
                    <label for="email_proveedor" class="form-label">Correo electronico</label>
                    <input type="mail" class="form-control" id="email_proveedor" name="email_proveedor" maxlength="100" required>
                </div>
                <!-- Campo para el telefono -->
                <div class="mb-3">
                    <label for="telefono_proveedor" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono_proveedor" name="telefono_proveedor" maxlength="20" required>
                </div>
                <!-- Campo para la direccion-->
                <div class="mb-3">
                    <label for="direccion_proveedor" class="form-label">Dirección</label>
                    <textarea class="form-control" id="direccion_proveedor" name="direccion_proveedor" rows="3" maxlength="500"></textarea>
                </div>
                <!-- Campo para el contacto -->
                <div class="mb-3">
                    <label for="contacto_proveedor" class="form-label">Nombre de contacto Proveedor</label>
                    <input type="text" class="form-control" id="contacto_proveedor" name="contacto_proveedor" maxlength="100" required>
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