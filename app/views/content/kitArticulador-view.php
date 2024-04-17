<style>
    .media-row {
        display: flex;
        flex-wrap: wrap;
        margin: -0.5rem; /* Añade un margen negativo para compensar el padding interno */
    }

    .media-object {
        flex: 1 0 50%; /* Cada objeto toma el 50% del ancho de la fila */
        padding: 0.5rem; /* Padding para el espacio entre objetos */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease-in-out;
    }

    .media-object:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .media-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .media-body {
        padding: 1rem;
    }

    .media-title {
        font-size: 1.25rem;
    }

    .media-text {
        font-size: 1rem;
    }
    .media-row {
    display: flex;
    flex-wrap: wrap;
    margin: -0.25rem; /* Reduce el margen negativo para menos espaciado entre objetos */
}

.media-object {
    flex: 1 0 46%; /* Reduce el ancho para dar más espacio entre los objetos */
    padding: 0.25rem; /* Menos padding para evitar encimamiento */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    background-color: transparent; /* Fondo transparente */
    border-radius: 5px;
    overflow: hidden;
    margin: 0.5rem; /* Añade margen para separar los objetos */
}

.media-object:hover {
    transform: scale(1.03);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.media-image {
    width: 100%;
    height: 180px; /* Reduce la altura de la imagen */
    object-fit: cover;
}

.media-body {
    padding: 0.75rem;
}

.media-title {
    font-size: 1.25rem;
    margin-bottom: 0.3rem;
}

.media-text {
    font-size: 0.9rem;
}
.media-row {
    display: flex;
    flex-wrap: wrap;
    margin: -0.25rem; /* Ajusta según sea necesario */
}

.media-object {
    flex: 1 0 100%; /* Ocupa el 100% del ancho en dispositivos móviles */
    padding: 0.25rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    background-color: transparent;
    border-radius: 5px;
    overflow: hidden;
    margin: 0.5rem;
}

@media (min-width: 768px) { /* Establece un punto de quiebre para pantallas medianas y grandes */
    .media-object {
        flex: 1 0 46%; /* Vuelve al 46% para pantallas de al menos 768px de ancho */
    }
}

.media-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.media-body {
    padding: 0.75rem;
}

.media-title {
    font-size: 1.25rem;
    margin-bottom: 0.3rem;
}

.media-text {
    font-size: 0.9rem;
}

</style>

<!-- Contenedor principal -->
<div class="container-fluid py-4">
    <div class="mb-4">
        <h1 class="display-4 text-center">KIT ARTICULADOR</h1>
    </div>
    <?php include "./app/views/inc/btn_back.php"; ?>

    <div class="media-row">
        <!-- CPI -->
        <div class="media-object">
            <a href="URL_DESTINO_CPI" style="text-decoration: none; color: inherit;">
                <img src="<?php echo APP_URL; ?>app/views/img/cpi.png" alt="CPI" class="media-image">
                <div class="media-body">
                    <h5 class="media-title">CPI</h5>
                    <p class="media-text">Piezas para armar CPI</p>
                </div>
            </a>
        </div>

        <!-- ARTICULADOR -->
        <div class="media-object">
            <a href="URL_DESTINO_ARTICULADOR" style="text-decoration: none; color: inherit;">
                <img src="<?php echo APP_URL; ?>app/views/img/articulador.png" alt="Articulador" class="media-image">
                <div class="media-body">
                    <h5 class="media-title">ARTICULADOR</h5>
                    <p class="media-text">Piezas para armar ARTICULADOR</p>
                </div>
            </a>
        </div>

        <!-- ARCO FACIAL -->
        <div class="media-object">
            <a href="URL_DESTINO_ARCO" style="text-decoration: none; color: inherit;">
                <img src="<?php echo APP_URL; ?>app/views/img/arco.png" alt="Arco Facial" class="media-image">
                <div class="media-body">
                    <h5 class="media-title">ARCO FACIAL</h5>
                    <p class="media-text">Piezas para ARCO FACIAL</p>
                </div>
            </a>
        </div>

        <!-- KIT DE ARTICULADOR -->
        <div class="media-object">
            <a href="URL_DESTINO_KIT" style="text-decoration: none; color: inherit;">
                <img src="<?php echo APP_URL; ?>app/views/img/kit.png" alt="Kit de Articulador" class="media-image">
                <div class="media-body">
                    <h5 class="media-title">KIT DE ARTICULADOR</h5>
                    <p class="media-text">Piezas para armar kit de articulador completo (CPI, ARTICULADOR, ARCO FACIAL)</p>
                </div>
            </a>
        </div>
    </div>
</div>
