<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>provList/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Lista
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>provNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10">
            <div class="container-fluid py-4">
                <h4 class="text-center mb-4">Nuevo Proveedor</h4>

                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <?php
                        // Incluye el botón de regreso
                        include "./app/views/inc/btn_back2.php";
                        ?>
                        <!-- Formulario de creación de proveedor -->
                        <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/proveedorAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="modulo_proveedor" value="registrar">

                            <div class="mb-3">
                                <label for="nombre_proveedor" class="form-label">Nombre Proveedor</label>
                                <input type="text" class="form-control form-control-sm" id="nombre_proveedor" name="nombre_proveedor" maxlength="100" required>
                            </div>

                            <div class="mb-3">
                                <label for="RFC_proveedor" class="form-label">RFC Proveedor</label>
                                <input type="text" class="form-control form-control-sm" id="RFC_proveedor" name="RFC_proveedor" maxlength="13" required>
                            </div>

                            <div class="mb-3">
                                <label for="email_proveedor" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control form-control-sm" id="email_proveedor" name="email_proveedor" maxlength="100" required>
                            </div>

                            <div class="mb-3">
                                <label for="telefono_proveedor" class="form-label">Teléfono</label>
                                <input type="text" class="form-control form-control-sm" id="telefono_proveedor" name="telefono_proveedor" maxlength="20" required>
                            </div>

                            <div class="mb-3">
                                <label for="direccion_proveedor" class="form-label">Dirección</label>
                                <textarea class="form-control form-control-sm" id="direccion_proveedor" name="direccion_proveedor" rows="3" maxlength="500"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="contacto_proveedor" class="form-label">Nombre de contacto Proveedor</label>
                                <input type="text" class="form-control form-control-sm" id="contacto_proveedor" name="contacto_proveedor" maxlength="100" required>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-secondary btn-sm">Limpiar</button>
                                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        font-size: 0.85rem;
    }
    .form-label {
        font-size: 0.8rem;
    }
    .form-control-sm {
        font-size: 0.8rem;
    }
    .btn-sm {
        font-size: 0.75rem;
    }
</style>