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

    <!-- Fila principal con Bootstrap -->
    <div class="row g-3 justify-content-center">
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="media-object">
                <a href="URL_DESTINO_CPI" class="text-decoration-none">
                    <img src="<?php echo APP_URL; ?>app/views/img/cpi.png" alt="CPI" class="img-fluid">
                    <div class="media-body">
                        <h5 class="media-title">CPI</h5>
                        <p class="media-text">Piezas para armar CPI</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="media-object">
                <a href="URL_DESTINO_ARTICULADOR" class="text-decoration-none">
                    <img src="<?php echo APP_URL; ?>app/views/img/articulador.png" alt="Articulador" class="img-fluid">
                    <div class="media-body">
                        <h5 class="media-title">ARTICULADOR</h5>
                        <p class="media-text">Piezas para armar ARTICULADOR</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="media-object">
                <a href="URL_DESTINO_ARCO" class="text-decoration-none">
                    <img src="<?php echo APP_URL; ?>app/views/img/arco.png" alt="Arco Facial" class="img-fluid">
                    <div class="media-body">
                        <h5 class="media-title">ARCO FACIAL</h5>
                        <p class="media-text">Piezas para ARCO FACIAL</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="media-object">
                <a href="URL_DESTINO_KIT" class="text-decoration-none">
                    <img src="<?php echo APP_URL; ?>app/views/img/kit.png" alt="Kit de Articulador" class="img-fluid">
                    <div class="media-body">
                        <h5 class="media-title">KIT DE ARTICULADOR</h5>
                        <p class="media-text">Piezas para armar kit de articulador completo.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>