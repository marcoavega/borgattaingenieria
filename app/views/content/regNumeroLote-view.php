<!-- Contenedor principal -->
<div class="container-fluid py-4">
    <h1 class="display-4 text-center">Números de Lote</h1>
    <h2 class="lead text-center">Nuevo Número de Lote</h2>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <?php
            // Incluye el botón de regreso
            include "./app/views/inc/btn_back2.php";
            ?>


            <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/numLoteAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">

                <input type="hidden" name="modulo_numero_lote" value="registrar">

                <div class="mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio:</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" >
                </div>

                <div class="mb-3">
                    <label for="fecha_fin" class="form-label">Fecha de Fin:</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" >
                </div>


                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>
