<svg xmlns="http://www.w3.org/2000/svg" style="display: none">
    <!-- Definición de varios íconos (circle-half, moon-stars-fill, sun-fill) -->
</svg>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo APP_URL; ?>dashboard/">B.I.</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if ($_SESSION['permiso'] == 1) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Usuarios</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>userNew/">Crear Nuevo usuario</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>userList/">Lista de Usuarios</a></li>
                    </ul>
                </li>
                <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Productos</a>
                    <ul class="dropdown-menu">
                        <?php if ($_SESSION['permiso'] == 1) { ?>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>productNew/">Alta de Artículos Nuevos</a></li>
                        <?php } ?>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>productList/">Lista de Artículos</a></li>
                       <!-- <li><a class="dropdown-item" href="<?php echo APP_URL; ?>productSearch/">Buscar Artículos</a></li> -->
                    </ul>
                </li>
                <?php if ($_SESSION['permiso'] == 1) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Movimientos</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>movList/">Consultar Todos</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>movSearch/">Buscar por nombre</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>movSearch2/">Buscar por movimiento</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php if ($_SESSION['permiso'] == 1) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Proveedores</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>provNew/">Nuevo</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>provList/">Lista</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php if ($_SESSION['permiso'] == 1) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Ordenes de Compra</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderCNew/">Nueva orden</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderCPNew/">Alta de productos en orden</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderSearch/">Consultar</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php if ($_SESSION['permiso'] == 1) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Ordenes de Gasto</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderGNew/">Nueva orden</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderGPNew/">Alta de productos en orden</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderGSearch/">Consultar</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php if ($_SESSION['permiso'] == 1) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Nota de Entrada</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>notaENew/">Nueva Nota</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>notaEPNew/">Alta de Productos en Nota</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>notaESearch/">Consultar</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php if ($_SESSION['permiso'] == 1) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Facturas</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>facturaNew/">Capturar Factura</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>facturaPNew/">Alta</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>facturaSearch/">Consultar e imprimir</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>movFactura/">Sacar Reporte</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>venceFactura/">Vencimiento de facturas</a></li>
                    </ul>
                </li>
                <?php } ?>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown" data-bs-theme="auto">
                    <button class="btn btn-link nav-link py-1 px-0 px-lg-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static">
                        <svg class="bi my-1 theme-icon-active" width="16" height="16" fill="currentColor">
                            <use href="#circle-half"></use>
                        </svg>
                        <span class="d-lg-none ms-2">Toggle theme</span>
                    </button>
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
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item dropdown" data-bs-theme="auto">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $_SESSION['usuario']; ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo APP_URL . "userUpdate/" . $_SESSION['id'] . "/"; ?>">Mi cuenta</a></li>
                                    <li><a class="dropdown-item" href="<?php echo APP_URL . "userPhoto/" . $_SESSION['id'] . "/"; ?>">Mi foto</a></li>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeSwitcher = document.getElementById('bd-theme');
        const storedTheme = localStorage.getItem('theme') || 'auto';

        const getPreferredTheme = () => {
            if (storedTheme === 'auto') {
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }
            return storedTheme;
        };

        const setTheme = theme => {
            if (theme === 'auto') {
                document.documentElement.setAttribute('data-bs-theme', getPreferredTheme());
            } else {
                document.documentElement.setAttribute('data-bs-theme', theme);
            }
            localStorage.setItem('theme', theme);
        };

        setTheme(storedTheme);

        themeSwitcher.addEventListener('click', event => {
            const theme = event.target.getAttribute('data-bs-theme-value');
            if (theme) {
                setTheme(theme);
            }
        });
    });
</script>
