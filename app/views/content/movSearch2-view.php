<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>movList/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Movimientos
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>movSearch/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Por Nombre
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>movSearch2/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Por Movimiento
                    </a>
                </li>
            </ul>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10">
            <!-- Contenedor principal -->
            <div class="container-fluid mb-4">
                <!-- Título de la página -->
                <h4 class="text-center">Movimientos</h4>
                <!-- Subtítulo de la página -->
                <h5 class="lead text-center">Buscar movimiento</h5>
            </div>

            <!-- Contenedor para el formulario de búsqueda y los resultados de la búsqueda -->
            <div class="container py-4">
                <?php
                    // Importa el controlador de productos
                    use app\controllers\movController2;

                    // Crea una instancia del controlador
                    $insMov = new movController2();
                    
                    $opcionesMovimientos2 = $insMov->obtenerMovimientos();

                    // Comprueba si no hay una búsqueda en curso
                    if(!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])){
                ?>
                <!-- Formulario de búsqueda -->
                <form class="FormularioAjax row g-3 mb-4" action="<?php echo APP_URL; ?>app/ajax/buscadorMovAjax2.php" method="POST" autocomplete="off" >
                    <!-- Campo de entrada para la búsqueda -->
                    <div class="mb-3">
                        <label for="orden" class="form-label">Movimientos</label>
                        <select class='form-control' name='txt_buscador' id='orden' required>
                            <option value="">Seleccione fecha de movimiento</option>
                            <?php echo $opcionesMovimientos2; ?>
                        </select>
                    </div>
                    <!-- Botón para enviar el formulario -->
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3">Buscar</button>
                    </div>
                    <!-- Campos ocultos para el módulo de búsqueda y la URL del módulo -->
                    <input type="hidden" name="modulo_buscador" value="buscar">
                    <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                </form>

                <?php }else{ ?>
                <!-- Si hay una búsqueda en curso, muestra la consulta de búsqueda y un botón para eliminar la búsqueda -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6>Estás buscando: <strong>"<?php echo $_SESSION[$url[0]]; ?>"</strong></h6>
                    <!-- Botón para eliminar la búsqueda -->
                    <form class="FormularioAjax d-inline-block" action="<?php echo APP_URL; ?>app/ajax/buscadorMovAjax2.php" method="POST" autocomplete="off" >
                        <!-- Campos ocultos para el módulo de búsqueda y la URL del módulo -->
                        <input type="hidden" name="modulo_buscador" value="eliminar">
                        <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar búsqueda</button>
                    </form>
                </div>
                <?php
                    // Muestra los resultados de la búsqueda
                    echo $insMov->listarMovControlador2($url[1],99999999,$url[0],$_SESSION[$url[0]]);
                    }
                ?>
            </div>
        </div>
    </div>
</div>