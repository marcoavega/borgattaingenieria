<?php
use app\controllers\clientController;

// Obtiene el ID del cliente a editar
$id = $insLogin->limpiarCadena($url[1]);

// Crea una instancia del controlador
$insCliente = new clientController();

// Obtiene los datos del cliente a editar
$datos = $insLogin->seleccionarDatos("Unico", "clientes", "id_cliente", $id);
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
                    <a href="<?php echo APP_URL; ?>clientList/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Lista de Clientes
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>clientNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Nuevo
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10">
            <div class="container py-4">
                <h4 class="text-center mb-4">Editar Cliente</h4>

                <?php include "./app/views/inc/btn_back2.php"; ?>

                <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/clientAjax.php" method="POST" autocomplete="off">
                    <input type="hidden" name="modulo_cliente" value="actualizar">
                    <input type="hidden" name="id_cliente" value="<?php echo $datos['id_cliente']; ?>">

                    <div class="mb-3">
                        <label for="nombre_cliente" class="form-label">Nombre del Cliente</label>
                        <input type="text" class="form-control form-control-sm" id="nombre_cliente" name="nombre_cliente" value="<?php echo htmlspecialchars($datos['nombre_cliente']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="rfc_cliente" class="form-label">RFC del Cliente</label>
                        <input type="text" class="form-control form-control-sm" id="rfc_cliente" name="rfc_cliente" value="<?php echo htmlspecialchars($datos['rfc_cliente']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control form-control-sm" id="direccion" name="direccion" required><?php echo htmlspecialchars($datos['direccion']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" value="<?php echo htmlspecialchars($datos['email']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control form-control-sm" id="telefono" name="telefono" value="<?php echo htmlspecialchars($datos['telefono']); ?>" required>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">Actualizar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        font-size: 0.9rem;
    }
    .form-label {
        font-size: 0.85rem;
    }
    .btn {
        font-size: 0.85rem;
    }
</style>