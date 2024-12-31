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
                    <a href="<?php echo APP_URL; ?>entradaPTNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registro Entradas Nº Serie
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>entradaPTSearch/" class="nav-link active" aria-current="page">
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
            <h4 class="text-center">Entradas de Producto Terminado</h4>
            <!-- Subtítulo de la página -->
            <h5 class="text-center">Alta de Números de Lote y Serie</h5>

            <!-- Contenedor para el formulario de creación de producto -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <?php
                    // Importa el controlador de productos
                    use app\controllers\entradaPTNumserieController;

                    // Crea una instancia del controlador
                    $insDatos = new entradaPTNumserieController();

                    // Obtiene las opciones de órdenes de compra y unidades de medida
                    $OpcionesNumeroVE = $insDatos->obtenerOpcionesNumeroVE();
                    $opcionesNumeroLote = $insDatos->obtenerOpcionesNumeroLote();
                    $opcionesNumeroSerie = $insDatos->obtenerOpcionesNumeroSerie();
                    $opcionesAlmacenes = $insDatos->obtenerOpcionesAlmacenes();
                    $opcionesProductos = $insDatos->obtenerOpcionesProductos();
                    ?>

                    <?php
                    // Incluye el botón de regreso
                    include "./app/views/inc/btn_back2.php";
                    ?>
                    
                    <!-- Formulario de creación de orden -->
                    <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/entradaPTSerieAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <!-- Campo oculto para el módulo de orden compra -->
                        <input type="hidden" name="modulo_entrada_pt" value="registrar">

                        <div class="row">
                            <!-- Campo de selección -->
                            <div class="mb-3">
                                <label for="id_entrada" class="form-label">Número de Vale de Entrada</label>
                                <select class="form-control" name="id_entrada" id="id_entrada" required>
                                    <option value="">Seleccione un Vale de Entrada</option>
                                    <?php echo $OpcionesNumeroVE; ?>
                                </select>
                            </div>

                            <!-- Campo de selección -->
                            <div class="mb-3">
                                <label for="id_numero_lote" class="form-label">Número de Lote</label>
                                <select class="form-control" name="id_numero_lote" id="id_numero_lote" required>
                                    <option value="">Seleccione un Número de Lote</option>
                                    <?php echo $opcionesNumeroLote; ?>
                                </select>
                            </div>

                            <!-- Campo de selección para la unidad de medida del producto -->
                            <div class="mb-3">
                                <label for="id_producto" class="form-label">Producto</label>
                                <select class="form-control" name="id_producto" id="id_producto" required>
                                    <option value="">Seleccione un producto</option>
                                    <?php echo $opcionesProductos; ?>
                                </select>
                            </div>

                            <!-- Campo de selección para la unidad de medida del producto -->
                            <div class="mb-3">
                                <label for="id_numero_serie" class="form-label">Número de Serie</label>
                                <select class="form-control" name="id_numero_serie" id="id_numero_serie" required>
                                    <option value="">Seleccione un Registro</option>
                                    <?php echo $opcionesNumeroSerie; ?>
                                </select>
                            </div>
                        </div><!-- termina row -->

                        <!-- Botón para enviar el formulario -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>