<?php
use app\controllers\provController;

$insProveedor = new provController();

$pagina = 1;
$registros = 1000000; // Ajusta este número según tus necesidades
$url = "provList";
$busqueda = ""; // Mantenemos esto vacío ya que no hay búsqueda
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
                <h4 class="mb-4">Lista de Proveedores</h4>

                <!-- Contenedor para la tabla de proveedores -->
                <div id="proveedoresTableContainer">
                    <?php
                    $tabla = $insProveedor->listarProvedoresControlador($pagina, $registros, $url, $busqueda);
                    echo $tabla;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        font-size: 0.85rem;
    }
    .table {
        font-size: 0.8rem;
    }
    .table th, .table td {
        padding: 0.5rem;
    }
    .btn-sm {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
</style>