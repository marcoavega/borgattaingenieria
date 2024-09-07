<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>regNumeroLote/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Nº Lote
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>consultaNumeroLote/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Consultar Nº Lote
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>regNumeroSerie/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Nº Serie
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>consultaNumeroSerie/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Consultar Nº Serie
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>salidasProductoTerminado/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Salidas
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>salidaPTNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registro Salidas Nº Serie
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>salidaPTSearch/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Consultar Vale Salida
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>numSerSearch/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Consultar Registros
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10 py-4">
            <div class="container-fluid mb-4">
                <!-- Título de la página -->
                <h4 class="text-center">Números de Serie</h4>
                <!-- Subtítulo de la página -->
                <h5 class="text-center">Buscar Números</h5>
            </div>

            <!-- Contenedor para el formulario de búsqueda y los resultados de la búsqueda -->
            <div class="container">
                <?php
                    // Importa el controlador de productos
                    use app\controllers\numSerieController;

                    // Crea una instancia del controlador
                    $insLotes = new numSerieController();

                    // Obtiene las opciones de proveedores.
                    $opcionesLotes = $insLotes->obtenerOpcionesNumLotes();

                    // Comprueba si no hay una búsqueda en curso
                    if (!isset($_SESSION[$url[0]]) || empty($_SESSION[$url[0]])) {
                        // Incluye el botón de regreso
                        include "./app/views/inc/btn_back2.php";
                ?>
                <!-- Formulario de búsqueda -->
                <form class="FormularioAjax row g-3 mb-4" action="<?php echo APP_URL; ?>app/ajax/buscadorNumSerieAjax.php" method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label for="orden" class="form-label">Consultar Números de Serie de Lotes</label>
                        <select class="form-control" name="txt_buscador" id="orden" required>
                            <option value="">Seleccionar un lote para consultar</option>
                            <?php echo $opcionesLotes; ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3">Buscar</button>
                    </div>
                    <input type="hidden" name="modulo_buscador" value="buscar">
                    <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                </form>

                <?php
                    } else {
                        // Si hay una búsqueda en curso, muestra la consulta de búsqueda y un botón para eliminar la búsqueda
                ?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3">Estás buscando: <strong>"<?php echo $_SESSION[$url[0]]; ?>"</strong></h2>
                    <!-- Botón para eliminar la búsqueda -->
                    <form class="FormularioAjax d-inline-block" action="<?php echo APP_URL; ?>app/ajax/buscadorNumSerieAjax.php" method="POST" autocomplete="off">
                        <input type="hidden" name="modulo_buscador" value="eliminar">
                        <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                        <button type="submit" class="btn btn-danger">Eliminar búsqueda</button>
                    </form>
                </div>
                <?php
                        // Muestra los resultados de la búsqueda
                        echo $insLotes->listarNumSerieControlador($_SESSION[$url[0]]);
                    }
                ?>
            </div>
        </div>
    </div>
</div>