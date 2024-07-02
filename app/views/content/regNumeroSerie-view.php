<!-- Contenedor principal -->
<div class="container-fluid py-4">
    <h1 class="display-4 text-center">Números de Serie</h1>
    <h2 class="lead text-center">Nuevo Número de Serie</h2>



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
            <?php
            // Incluye el botón de regreso
            include "./app/views/inc/btn_back2.php";
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