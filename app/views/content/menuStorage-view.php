<style>
    .kit-articulador-container {
        padding: 4rem 0 3rem;
        background-color: transparent;
    }

    .kit-articulador-container .media-object {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .kit-articulador-container .media-object:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .kit-articulador-container .media-body {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .kit-articulador-container .media-title {
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .kit-articulador-container .media-text {
        color: #e0e0e0;
        font-size: 1rem;
    }

    .kit-articulador-container .icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #007bff;
    }

    .btn-back {
        position: absolute;
        top: 5rem;
        left: 1rem;
        z-index: 1000;
    }
</style>

<div class="container-fluid kit-articulador-container position-relative">
    <div class="btn-back">
        <?php include "./app/views/inc/btn_back2.php"; ?>
    </div>
    
    <div class="container">
        <div class="mb-5">
            <h1 class="display-4 text-center text-white">INVENTARIO</h1>
        </div>

        <div class="row g-4 justify-content-center">
            <?php if ($_SESSION['permiso'] == 1) { ?>
            <div class="col-12 col-md-6 col-lg-4">
                <a href="<?php echo APP_URL; ?>productNew/" class="text-decoration-none">
                    <div class="media-object">
                        <div class="media-body">
                            <i class="fas fa-plus-circle icon"></i>
                            <h5 class="media-title">Alta de artículo</h5>
                            <p class="media-text">Registro nuevo de artículos</p>
                        </div>
                    </div>
                </a>
            </div>
            <?php } ?>

            <div class="col-12 col-md-6 col-lg-4">
                <a href="<?php echo APP_URL; ?>productList/" class="text-decoration-none">
                    <div class="media-object">
                        <div class="media-body">
                            <i class="fas fa-list icon"></i>
                            <h5 class="media-title">Listado</h5>
                            <p class="media-text">Lista de todos los artículos</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>