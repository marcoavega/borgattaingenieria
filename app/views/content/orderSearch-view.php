<?php
use app\controllers\ordenCompraController;

$insProduct = new ordenCompraController();
$insOrden = new ordenCompraController();

$opcionesOrdenes = $insOrden->obtenerOpcionesOrdenes();
?>

<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>orderCNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Nueva orden
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>orderCPNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Alta de productos
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>orderSearch/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Consultar
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10">
            <div class="container-fluid py-4">
                <h4 class="text-center mb-4">Buscar Orden de Compra</h4>

                <?php
                if(!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])){
                    include "./app/views/inc/btn_back2.php";
                ?>
                    <form class="FormularioAjax row g-3 mb-4" action="<?php echo APP_URL; ?>app/ajax/buscadorOrdenAjax.php" method="POST" autocomplete="off" >
                        <div class="mb-3">
                            <label for="orden" class="form-label">Órdenes de Compra</label>
                            <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-sm mb-3">Buscar</button>
                        </div>
                            <div class="lista-ordenes" id="orden">
                                <?php echo $opcionesOrdenes; ?>
                            </div>
                            <input type="hidden" name="txt_buscador" id="txt_buscador" value="">
                        </div>
                       
                        <input type="hidden" name="modulo_buscador" value="buscar">
                        <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                    </form>
                <?php 
                } else { 
                ?>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5>Estás buscando: <strong>"<?php echo $_SESSION[$url[0]]; ?>"</strong></h5>
                        <form class="FormularioAjax d-inline-block" action="<?php echo APP_URL; ?>app/ajax/buscadorOrdenAjax.php" method="POST" autocomplete="off" >
                            <input type="hidden" name="modulo_buscador" value="eliminar">
                            <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar búsqueda</button>
                        </form>
                    </div>
                <?php
                    echo $insProduct->listarOrderControlador($url[1],99999999,$url[0],$_SESSION[$url[0]]);
                }
                ?>
            </div>
        </div>
    </div>
</div>

<style>
     body {
        font-size: 0.9rem;
    }

    .form-label {
        font-size: 0.85rem;
    }

    .form-select-sm,
    .form-control-sm {
        font-size: 0.85rem;
    }

    .btn-sm {
        font-size: 0.85rem;
    }

    .lista-ordenes {
        max-height: 300px;
        overflow-y: auto;
    }

    .orden-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #eee;
    }

    .lista-ordenes {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .orden-item {
        padding: 0.375rem 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .orden-item:hover {
        background-color: black;
    }

    .orden-item.selected {
        background-color: black;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        font-weight: bold;
    }

    .lista-ordenes {
        max-height: 500px;
        overflow-y: auto;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .mes-anio {
        background-color: gray;
        padding: 0.5rem;
        font-weight: bold;
        border-bottom: 1px solid #ced4da;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .orden-item {
        padding: 0.375rem 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border-bottom: 1px solid #e9ecef;
    }

    .orden-item:hover {
        background-color: black;
    }

    .orden-item.selected {
        background-color: black;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        font-weight: bold;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var listaOrdenes = document.querySelector('.lista-ordenes');
    var txtBuscador = document.getElementById('txt_buscador');

    listaOrdenes.addEventListener('click', function(e) {
        if (e.target.classList.contains('orden-item')) {
            // Remover selección previa
            var prevSelected = listaOrdenes.querySelector('.selected');
            if (prevSelected) prevSelected.classList.remove('selected');
            
            // Seleccionar el nuevo item
            e.target.classList.add('selected');
            
            // Actualizar el valor del input oculto
            txtBuscador.value = e.target.getAttribute('data-value');
        }
    });
});
</script>