<style>
    .kit-articulador-container .img-fluid {
        height: 200px; /* Altura fija para todas las imágenes */
        object-fit: cover; /* Asegura que la imagen cubra completamente el área sin deformarse */
    }

    .kit-articulador-container .media-object {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background-color: transparent;
        border-radius: 5px;
        overflow: hidden;
        text-align: center; /* Centrado de texto */
    }

    .kit-articulador-container .media-object:hover {
        transform: scale(1.03);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    
    .kit-articulador-container .media-body {
        padding: 0.75rem;
        color: white; /* Cambio de color de texto a blanco */
    }

    .kit-articulador-container .media-title, .kit-articulador-container .media-text {
        margin-bottom: 0.3rem;
    }
</style>

<div class="container-fluid py-4 kit-articulador-container">
    <div class="mb-4">
        <h1 class="display-4 text-center text-white">KIT ARTICULADOR</h1>
    </div>
    
    <?php include "./app/views/inc/btn_back2.php"; ?>

    <!-- Fila kit -->
   

    <!-- Fila kit completo -->
    <div class="row g-3 justify-content-center">
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">PIEZAS MAQUINADOS KIT</h5>
                    <p class="card-text">Piezas maquinadas por CNC</p>
                    <a href="<?php echo APP_URL; ?>piezasMaquinadosKit/" class="btn btn-primary mt-auto">Ver más</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">TORNILLERIA MAQUINADOS KIT</h5>
                    <p class="card-text">Tornilleria por área de maquinado</p>
                    <a href="<?php echo APP_URL; ?>tornilleriaMaquinadosKit/" class="btn btn-primary mt-auto">Ver más</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">TORNILLERIA COMPRA EXTERNA PARA KIT</h5>
                    <p class="card-text">Tornilleria de compras externas</p>
                    <a href="<?php echo APP_URL; ?>tornilleriaExternaKit/" class="btn btn-primary mt-auto">Ver más</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">PIEZAS COMPRA EXTERNA PARA KIT</h5>
                    <p class="card-text">Piezas compras externas</p>
                    <a href="<?php echo APP_URL; ?>piezasExternasKit/" class="btn btn-primary mt-auto">Ver más</a>
                </div>
            </div>
        </div>
    </div>
</div>


