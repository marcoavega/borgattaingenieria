<!-- Contenedor SVG para los íconos que se usarán en la barra de navegación. El estilo "display: none" se usa para ocultar este contenedor. -->
<svg xmlns="http://www.w3.org/2000/svg" style="display: none">
    <!-- Definición de varios íconos (circle-half, moon-stars-fill, sun-fill) -->
</svg>

<!-- Inicio de la barra de navegación -->
<nav class="navbar navbar-expand-lg py-3 border border" data-bs-theme="">
    <div class="container-fluid">

        <!-- Enlace de la navbar a la página de inicio del panel de control 
        <a class="navbar-item" href="<?php echo APP_URL; ?>dashboard/">
             Logo de la empresa 
            <img src="<?php echo APP_URL; ?>app/views/img/blogo.png" alt="" width="112" height="28" title="Borgatta">
        </a>
-->

        <!-- Botón para desplegar la navbar en dispositivos móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenedor para los elementos de la navbar que se colapsarán en dispositivos móviles -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Enlaces de la navbar -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Enlace a la página de inicio -->
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo APP_URL; ?>dashboard/">BORGATTA INGENIERÍA</a>
                </li>

                <!-- Menú desplegable para las acciones relacionadas con los usuarios -->
                <?php if ($_SESSION['permiso'] == 1) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Usuarios
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>userNew/">Nuevo</a></li>
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>userList/">Lista</a></li>
                        </ul>
                    </li>
                <?php } ?>

                <!-- Menú desplegable para las acciones relacionadas con los productos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Consultar
                    </a>
                    <ul class="dropdown-menu">
                    <?php if ($_SESSION['permiso'] == 1) { ?>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>productConsult/">Consultar artículos prueba</a></li>
                        <?php } ?>
                        <li><a class="dropdown-item" href="http://localhost/borgattaingenieria/busqueda.php">Consultar artículos</a></li>
                    </ul>

                    <!-- Menú desplegable para las acciones relacionadas con los productos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Productos
                    </a>
                    <ul class="dropdown-menu">
                        <?php if ($_SESSION['permiso'] == 1) { ?>
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>productNew/">Nuevo</a></li>
                        <?php } ?>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>productList/">Lista</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>productSearch/">Buscar</a></li>
                    </ul>
                </li>

                <?php if ($_SESSION['permiso'] == 1) { ?>
                    <!-- Menú desplegable para las acciones relacionadas con los productos -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Stock de almacenes
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>stockAlmNew/">Nuevo Registro</a></li>
                        </ul>
                    </li>
                <?php } ?>

                <!-- Menú desplegable para las acciones relacionadas con los movimientos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Movimientos
                    </a>
                    <ul class="dropdown-menu">
                        <?php if ($_SESSION['permiso'] == 1) { ?>
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>movUpdate/">Nuevo</a></li>
                        <?php } ?>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>movList/">Consultar Todos</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>movSearch/">Buscar por nombre</a></li>
                    </ul>

                </li>


                <!-- Menú desplegable para las acciones relacionadas con los proveedores -->
                <?php if ($_SESSION['permiso'] == 1) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Proveedores
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>provNew/">Nuevo</a></li>
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>provList/">Lista</a></li>
                        </ul>
                    </li>
                <?php } ?>

                <!-- Menú desplegable para las acciones relacionadas con los proveedores -->
                <?php if ($_SESSION['permiso'] == 1) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ordenes de compra
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderCNew/">Nueva orden</a></li>
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderCPNew/">Alta de productos en orden</a></li>
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderSearch/">Consultar</a></li>
                        </ul>
                    </li>
                <?php } ?>


            </ul>

            <!-- Botón para cambiar el tema (light, dark, auto) -->
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item dropdown w-25" data-bs-theme="auto">
                    <button class="btn btn-link nav-link py-1 px-0 px-lg-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static">
                        <svg class="bi my-1 theme-icon-active" width="16" height="16" fill="currentColor">
                            <use href="#circle-half"></use>
                        </svg>
                        <span class="d-lg-none ms-2">Toggle theme</span>
                    </button>

                    <!-- Menú desplegable para seleccionar el tema -->
                    <ul class="dropdown-menu dropdown-menu-end px-1" aria-labelledby="bd-theme">
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light">
                                <svg class="bi me-2 opacity-50 theme-icon" width="16" height="16" fill="currentColor">
                                    <use href="#sun-fill"></use>
                                </svg>
                                Light
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark">
                                <svg class="bi me-2 opacity-50 theme-icon" width="16" height="16" fill="currentColor">
                                    <use href="#moon-stars-fill"></use>
                                </svg>
                                Dark
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto">
                                <svg class="bi me-2 opacity-50 theme-icon" width="16" height="16" fill="currentColor">
                                    <use href="#circle-half"></use>
                                </svg>
                                Auto
                            </button>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Información del usuario y opciones para la cuenta de usuario -->
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item dropdown w-25" data-bs-theme="auto">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <!-- Muestra la foto del usuario. Si no tiene una foto personalizada, muestra una foto por defecto. -->
                            <?php
                            if (is_file("./app/views/fotos/" . $_SESSION['foto'])) {
                                echo '<img class="img-fluid img-thumbnail" width="50" height="30" src="' . APP_URL . 'app/views/fotos/' . $_SESSION['foto'] . '">';
                            } else {
                                echo '<img class="img-fluid img-thumbnail" width="50" height="30" src="' . APP_URL . 'app/views/fotos/default.png">';
                            }
                            ?>
                            <!-- Menú desplegable con opciones para la cuenta del usuario -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $_SESSION['usuario']; ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo APP_URL . "userUpdate/" . $_SESSION['id'] . "/"; ?>">Mi
                                            cuenta</a></li>
                                    <li><a class="dropdown-item" href="<?php echo APP_URL . "userPhoto/" . $_SESSION['id'] . "/"; ?>">Mi
                                            foto</a></li>
                                    <!-- Enlace para cerrar la sesión -->
                                    <li><a class="dropdown-item" href="<?php echo APP_URL . "logOut/"; ?>" id="btn_exit">Salir</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>