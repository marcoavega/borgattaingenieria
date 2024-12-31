<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>entradasProductoTerminado/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Entradas
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>salidaPTNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registro Entradas Nº Serie
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>salidaPTSearch/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Consultar Vale Entradas
                    </a>
                </li>
            </ul>
            
            <hr>

        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10 py-4">
            <!-- Título de la página -->
            <h4 class="text-center">Entradas de Productos Terminados</h4>
            <!-- Subtítulo de la página -->
            <h5 class="text-center">Buscar Entrada</h5>

            <!-- Contenedor para el formulario de búsqueda y los resultados de la búsqueda -->
            <div class="container">
                <?php
                    // Importa el controlador de salidas
                    use app\controllers\entradaPTController;

                    // Crea una instancia del controlador
                    $insEntrada= new entradaPTController();

                    $opcionesEntradas = $insEntrada->obtenerOpcionesEntradas();

                    // Comprueba si no hay una búsqueda en curso
                    if(!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])){
                ?>
                    <?php
                        // Incluye el botón de regreso
                        include "./app/views/inc/btn_back2.php";
                    ?>
                    <!-- Formulario de búsqueda -->
                    <form class="FormularioAjax row g-3 mb-4" action="<?php echo APP_URL; ?>app/ajax/buscadorEntradaPTAjax.php" method="POST" autocomplete="off" >
                        <!-- Campo de entrada para la búsqueda -->
                        <div class="mb-3">
                            <label for="orden" class="form-label">Salidas</label>
                            <select class='form-control' name='txt_buscador' id='orden' required>
                                <option value="">Seleccione una entrada para consultar</option>
                                <?php echo $opcionesEntradas; ?>
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
                <?php } else { ?>
                    <!-- Si hay una búsqueda en curso, muestra la consulta de búsqueda y un botón para eliminar la búsqueda -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h3">Estás buscando: <strong>"<?php echo $_SESSION[$url[0]]; ?>"</strong></h2>
                        <!-- Botón para eliminar la búsqueda -->
                        <form class="FormularioAjax d-inline-block" action="<?php echo APP_URL; ?>app/ajax/buscadorEntradaPTAjax.php" method="POST" autocomplete="off" >
                            <!-- Campos ocultos para el módulo de búsqueda y la URL del módulo -->
                            <input type="hidden" name="modulo_buscador" value="eliminar">
                            <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                            <button type="submit" class="btn btn-danger">Eliminar búsqueda</button>
                        </form>
                    </div>
                    <?php
                        // Muestra los resultados de la búsqueda
                        echo $insEntrada->listarEntradaControlador($url[1], 99999999, $url[0], $_SESSION[$url[0]]);
                    }
                ?>
            </div>
        </div>
    </div>
</div>