<!-- Contenedor principal -->
<div class="container-fluid">
    <div class="row">
       <!-- Menú lateral -->
       <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>almacenList/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Lista de Almacenes
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>almacenNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Nuevo Almacén
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Formulario de creación de producto -->
        <div class="col-md-9 col-lg-10">
             <!-- Título de la página -->
            <h4 class="text-center">Almacenes</h4>
            <!-- Subtítulo de la página -->
            <!-- Formulario de creación de producto -->
        </div>
    </div>
</div>