<?php
use app\controllers\clientController;

$insCliente = new clientController();
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
                        Lista
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>clientNew/" class="nav-link active" aria-current="page">
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
                <h4 class="text-center mb-4">Lista de Clientes</h4>

                <!-- Contenedor para la lista de clientes -->
                <div id="clientesTableContainer">
                    <?php
                    // Muestra la lista de clientes
                    echo $insCliente->listarClientesControlador($url[1], 99999, $url[0], "");
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