<svg xmlns="http://www.w3.org/2000/svg" style="display: none">
    <!-- Definición de varios íconos (circle-half, moon-stars-fill, sun-fill) -->
</svg>
<style>
        .navbar-dark .navbar-brand,
        .navbar-dark .dropdown-item {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar-dark .navbar-brand:hover,
        .navbar-dark .dropdown-item:hover {
            background-color: #495057;
            color: #ffffff;
        }
    </style>
<div class="d-flex">
    <nav class="sidebar navbar-dark bg-dark flex-shrink-0" style="height: 100vh; position: fixed; top: 0; left: 0; width: 250px;">
        <div style="height: 100%; overflow-y: auto; padding-top: 5%;">
            <div class="accordion" id="accordionSidebar">
                <?php if ($_SESSION['permiso'] == 1) { ?>
                    <button class="navbar-brand btn btn-link text-white" onclick="location.href='<?php echo APP_URL; ?>dashboard/';">
                        BORGATTA INGENIERÍA
                    </button>
                <?php } ?>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingUsuarios">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUsuarios" aria-expanded="false" aria-controls="collapseUsuarios">
                            Usuarios
                        </button>
                    </h2>
                    <div id="collapseUsuarios" class="accordion-collapse collapse" aria-labelledby="headingUsuarios" data-bs-parent="#accordionSidebar">
                        <div class="accordion-body">
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>userNew/">Crear Nuevo usuario</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>userList/">Lista de Usuarios</a>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingProductos">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProductos" aria-expanded="false" aria-controls="collapseProductos">
                            Productos
                        </button>
                    </h2>
                    <div id="collapseProductos" class="accordion-collapse collapse" aria-labelledby="headingProductos" data-bs-parent="#accordionSidebar">
                        <div class="accordion-body">
                            <?php if ($_SESSION['permiso'] == 1) { ?>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>productNew/">Alta de Artículos Nuevos</a>
                            <?php } ?>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>productList/">Lista de Artículos</a>
                        </div>
                    </div>
                </div>

                <?php if ($_SESSION['permiso'] == 1) { ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingMovimientos">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMovimientos" aria-expanded="false" aria-controls="collapseMovimientos">
                            Movimientos
                        </button>
                    </h2>
                    <div id="collapseMovimientos" class="accordion-collapse collapse" aria-labelledby="headingMovimientos" data-bs-parent="#accordionSidebar">
                        <div class="accordion-body">
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>movList/">Consultar Todos</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>movSearch/">Buscar por nombre</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>movSearch2/">Buscar por movimiento</a>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if ($_SESSION['permiso'] == 1) { ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingProveedores">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProveedores" aria-expanded="false" aria-controls="collapseProveedores">
                            Proveedores
                        </button>
                    </h2>
                    <div id="collapseProveedores" class="accordion-collapse collapse" aria-labelledby="headingProveedores" data-bs-parent="#accordionSidebar">
                        <div class="accordion-body">
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>provNew/">Nuevo</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>provList/">Lista</a>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if ($_SESSION['permiso'] == 1) { ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOrdenesCompra">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenesCompra" aria-expanded="false" aria-controls="collapseOrdenesCompra">
                            Ordenes de Compra
                        </button>
                    </h2>
                    <div id="collapseOrdenesCompra" class="accordion-collapse collapse" aria-labelledby="headingOrdenesCompra" data-bs-parent="#accordionSidebar">
                        <div class="accordion-body">
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>orderCNew/">Nueva orden</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>orderCPNew/">Alta de productos en orden</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>orderSearch/">Consultar</a>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if ($_SESSION['permiso'] == 1) { ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOrdenesGasto">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenesGasto" aria-expanded="false" aria-controls="collapseOrdenesGasto">
                            Ordenes de Gasto
                        </button>
                    </h2>
                    <div id="collapseOrdenesGasto" class="accordion-collapse collapse" aria-labelledby="headingOrdenesGasto" data-bs-parent="#accordionSidebar">
                        <div class="accordion-body">
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>orderGNew/">Nueva orden</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>orderGPNew/">Alta de productos en orden</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>orderGSearch/">Consultar</a>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if ($_SESSION['permiso'] == 1) { ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingNotaEntrada">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNotaEntrada" aria-expanded="false" aria-controls="collapseNotaEntrada">
                            Nota de Entrada
                        </button>
                    </h2>
                    <div id="collapseNotaEntrada" class="accordion-collapse collapse" aria-labelledby="headingNotaEntrada" data-bs-parent="#accordionSidebar">
                        <div class="accordion-body">
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>notaENew/">Nueva Nota</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>notaEPNew/">Alta de Productos en Nota</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>notaESearch/">Consultar</a>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if ($_SESSION['permiso'] == 1) { ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFacturas">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFacturas" aria-expanded="false" aria-controls="collapseFacturas">
                            Facturas
                        </button>
                    </h2>
                    <div id="collapseFacturas" class="accordion-collapse collapse" aria-labelledby="headingFacturas" data-bs-parent="#accordionSidebar">
                        <div class="accordion-body">
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>facturaNew/">Capturar Factura</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>facturaPNew/">Alta</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>facturaSearch/">Consultar e imprimir</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>movFactura/">Sacar Reporte</a>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if ($_SESSION['permiso'] == 1) { ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingControlProcesos">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseControlProcesos" aria-expanded="false" aria-controls="collapseControlProcesos">
                            Control de Procesos
                        </button>
                    </h2>
                    <div id="collapseControlProcesos" class="accordion-collapse collapse" aria-labelledby="headingControlProcesos" data-bs-parent="#accordionSidebar">
                        <div class="accordion-body">
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>regNumeroLote/">Registrar Número de Lote</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>consultaNumeroLote/">Consultar Números de Lote</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>regNumeroSerie/">Registar Número de Serie</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>consultaNumeroSerie/">Consultar Números de Serie</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>salidasProductoTerminado/">Registrar Salidas de Producto Terminado</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>salidaPTNew/">Registro Salidas de Numeros serie de Producto Terminado</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>salidaPTSearch/">Cosultar Vale de Salida</a>
                            <a class="dropdown-item" href="<?php echo APP_URL; ?>numSerSearch/">Cosultar Registros</a>



                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </nav>

    <div class="container-fluid" style="margin-left: 250px;">
        <?php
        // Mostrando el contenido principal
        if (isset($_GET['views'])) {
            $url = explode("/", $_GET['views']);
            $vista = $viewsController->obtenerVistasControlador($url[0]);
            if ($vista != "login" && $vista != "404") {
                require_once $vista;
            }
        }
        ?>
    </div>
</div>
