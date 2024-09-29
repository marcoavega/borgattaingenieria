<?php
use app\controllers\notaEntradaController;

$insProduct = new notaEntradaController();
$insNota = new notaEntradaController();

$opcionesNotas = $insNota->obtenerOpcionesNotas();
?>

<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>notaENew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Nueva Nota
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>notaEPNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Alta de Productos
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>notaESearch/" class="nav-link active" aria-current="page">
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
                <h4 class="text-center mb-4">Buscar Nota de Entrada</h4>

                <?php
                if(!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])){
                    include "./app/views/inc/btn_back2.php";
                ?>
                    <form class="FormularioAjax row g-3 mb-4" action="<?php echo APP_URL; ?>app/ajax/buscadorNotaEAjax.php" method="POST" autocomplete="off" >
                        <div class="mb-3">
                            <label for="orden" class="form-label">Notas</label>
                            <select class='form-select form-select-sm' name='txt_buscador' id='orden' required>
                                <option value="">Notas de entrada para consultar</option>
                                <?php echo $opcionesNotas; ?>
                            </select>
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-sm mb-3">Buscar</button>
                        </div>
                        <input type="hidden" name="modulo_buscador" value="buscar">
                        <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                    </form>
                <?php 
                } else { 
                ?>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5>Estás buscando: <strong>"<?php echo $_SESSION[$url[0]]; ?>"</strong></h5>
                        <form class="FormularioAjax d-inline-block" action="<?php echo APP_URL; ?>app/ajax/buscadorNotaEAjax.php" method="POST" autocomplete="off" >
                            <input type="hidden" name="modulo_buscador" value="eliminar">
                            <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar búsqueda</button>
                        </form>
                    </div>
                <?php
                    echo $insProduct->listarNotaControlador($url[1], 99999999, $url[0], $_SESSION[$url[0]]);
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
    .form-select-sm, .form-control-sm {
        font-size: 0.85rem;
    }
    .btn-sm {
        font-size: 0.85rem;
    }
</style>