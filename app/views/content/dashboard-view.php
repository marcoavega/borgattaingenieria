<style>
       .dashboard-card {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    border-radius: 15px;
    overflow: hidden;
}
.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.card-body {
    height: 250px;
}
.card-content {
    border-radius: 10px;
}
.btn-primary {
    width: 100%;
}
    </style>
</head>
<div class="container my-4">
    <h1 class="text-center mb-4">Dashboard de Almacén</h1>
    <div class="row g-4">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex flex-column justify-content-between" style="background-image: url('<?php echo APP_URL; ?>app/views/img/herra.webp'); background-size: cover; background-position: center;">
                    <div class="card-content text-white text-center p-3" style="background-color: rgba(0,0,0,0.6);">
                        <h2 class="card-title">ALMACÉN</h2>
                        <p class="card-text">Gestión del inventario principal</p>
                    </div>
                    <a href="<?php echo APP_URL; ?>menuStorage/" class="btn btn-primary mt-3">ENTRAR</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex flex-column justify-content-between" style="background-image: url('<?php echo APP_URL; ?>app/views/img/kit.png'); background-size: cover; background-position: center;">
                    <div class="card-content text-white text-center p-3" style="background-color: rgba(0,0,0,0.6);">
                        <h2 class="card-title">KIT ARTICULADOR BORGATTA</h2>
                        <p class="card-text">Consulta y gestión de kits</p>
                    </div>
                    <a href="<?php echo APP_URL; ?>kitArticulador/" class="btn btn-primary mt-3">ENTRAR</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex flex-column justify-content-between" style="background-image: url('<?php echo APP_URL; ?>app/views/img/maq.webp'); background-size: cover; background-position: center;">
                    <div class="card-content text-white text-center p-3" style="background-color: rgba(0,0,0,0.6);">
                        <h2 class="card-title">Herramientas Maquinados</h2>
                        <p class="card-text">Gestión de herramientas especiales</p>
                    </div>
                    <a href="<?php echo APP_URL; ?>herramientasMaquinado/" class="btn btn-primary mt-3">ENTRAR</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex flex-column justify-content-between" style="background-image: url('<?php echo APP_URL; ?>app/views/img/conteo.webp'); background-size: cover; background-position: center;">
                    <div class="card-content text-white text-center p-3" style="background-color: rgba(0,0,0,0.6);">
                        <h2 class="card-title">Conteo de Inventario</h2>
                        <p class="card-text">Realiza y consulta conteos</p>
                    </div>
                    <a href="<?php echo APP_URL; ?>inventoryList/" class="btn btn-primary mt-3">ENTRAR</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex flex-column justify-content-between" style="background-image: url('<?php echo APP_URL; ?>app/views/img/producto.jpg'); background-size: cover; background-position: center;">
                    <div class="card-content text-white text-center p-3" style="background-color: rgba(0,0,0,0.6);">
                        <h2 class="card-title">Producto terminado</h2>
                        <p class="card-text">Gestión de productos finales</p>
                    </div>
                    <a href="<?php echo APP_URL; ?>productoTerminado/" class="btn btn-primary mt-3">ENTRAR</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex flex-column justify-content-between" style="background-image: url('<?php echo APP_URL; ?>app/views/img/proceso.jpg'); background-size: cover; background-position: center;">
                    <div class="card-content text-white text-center p-3" style="background-color: rgba(0,0,0,0.6);">
                        <h2 class="card-title">Control de procesos</h2>
                        <p class="card-text">Monitoreo y gestión de procesos</p>
                    </div>
                    <a href="<?php echo APP_URL; ?>controlProcesos/" class="btn btn-primary mt-3">ENTRAR</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex flex-column justify-content-between" style="background-image: url('<?php echo APP_URL; ?>app/views/img/proceso.jpg'); background-size: cover; background-position: center;">
                    <div class="card-content text-white text-center p-3" style="background-color: rgba(0,0,0,0.6);">
                        <h2 class="card-title">Facturacion</h2>
                        <p class="card-text">Crear Facturas</p>
                    </div>
                    <a href="<?php echo APP_URL; ?>facturacion/" class="btn btn-primary mt-3">ENTRAR</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex flex-column justify-content-between" style="background-image: url('<?php echo APP_URL; ?>app/views/img/'); background-size: cover; background-position: center;">
                    <div class="card-content text-white text-center p-3" style="background-color: rgba(0,0,0,0.6);">
                        <h2 class="card-title">Lotes</h2>
                        <p class="card-text">Control de Lotes</p>
                    </div>
                    <a href="<?php echo APP_URL; ?>controlLotes/" class="btn btn-primary mt-3">ENTRAR</a>
                </div>
            </div>
        </div>
    </div>
</div>