<?php
use app\controllers\provController;

// Obtiene el ID del proveedor a editar
$id = $insLogin->limpiarCadena($url[1]);

// Crea una instancia del controlador
$insProduct = new provController();

// Obtiene los datos del proveedor a editar
$datos = $insLogin->seleccionarDatos("Unico", "proveedores", "id_proveedor", $id);

// Comprueba si se obtuvieron los datos del proveedor
if ($datos->rowCount() != 1) {
    include "./app/views/inc/error_alert.php";
    exit;
}
$datos = $datos->fetch();
?>

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
                <h4 class="text-center mb-4">Editar Proveedor</h4>

                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <?php
                        // Incluye el botón de regreso
                        include "./app/views/inc/btn_back2.php";
                        ?>
                        <!-- Formulario de edición de proveedor -->
                        <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/proveedorAjax.php" method="POST" autocomplete="off">
                            <input type="hidden" name="modulo_proveedor" value="actualizar">
                            <input type="hidden" name="id_proveedor" value="<?php echo $datos['id_proveedor']; ?>">

                            <div class="mb-3">
                                <label for="nombre_proveedor" class="form-label">Nombre Proveedor</label>
                                <input type="text" class="form-control form-control-sm" id="nombre_proveedor" name="nombre_proveedor" maxlength="100" value="<?php echo $datos['nombre_proveedor']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="RFC_proveedor" class="form-label">RFC Proveedor</label>
                                <input type="text" class="form-control form-control-sm" id="RFC_proveedor" name="RFC_proveedor" pattern="[a-zA-Z0-9$@.-]{3,100}" maxlength="13" value="<?php echo $datos['RFC_proveedor']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="email_proveedor" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control form-control-sm" id="email_proveedor" name="email_proveedor" maxlength="100" value="<?php echo $datos['email_proveedor']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="telefono_proveedor" class="form-label">Teléfono</label>
                                <input type="text" class="form-control form-control-sm" id="telefono_proveedor" name="telefono_proveedor" maxlength="20" value="<?php echo $datos['telefono_proveedor']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="direccion_proveedor" class="form-label">Dirección</label>
                                <textarea class="form-control form-control-sm" id="direccion_proveedor" name="direccion_proveedor" rows="3" maxlength="500" required><?php echo $datos['direccion_proveedor']; ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="contacto_proveedor" class="form-label">Nombre de contacto Proveedor</label>
                                <input type="text" class="form-control form-control-sm" id="contacto_proveedor" name="contacto_proveedor" maxlength="100" value="<?php echo $datos['contacto_proveedor']; ?>" required>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
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