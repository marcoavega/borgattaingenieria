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
            
            <h4 class="text-center">Nuevo Número de Serie</h4>

            <!-- Contenedor para el formulario de creación de producto -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <?php
                    // Importa el controlador de productos
                    use app\controllers\numSerieController;

                    // Crea una instancia del controlador
                    $insLotes = new numSerieController();

                    // Obtiene las opciones de proveedores.
                    $opcionesLotes = $insLotes->obtenerOpcionesNumLotes();
                    
                    ?>
                   
                    <!-- Formulario de creación de orden -->
                    <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/numSerieAjax.php"
                        method="POST" autocomplete="off" enctype="multipart/form-data">
                        <!-- Campo oculto para el módulo de orden compra -->
                        <input type="hidden" name="modulo_numero_serie" value="registrar">

                        <div class="row">
                            <!-- Campo de selección para el proveedor del producto -->
                            <div class="mb-3">
                                <label for="id_lote" class="form-label">Lotes disponibles</label>
                                <select class='form-control' name='id_lote' id='id_lote' >
                                    <option value="">Selecciona un Lote</option>
                                    <?php echo $opcionesLotes; ?>
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