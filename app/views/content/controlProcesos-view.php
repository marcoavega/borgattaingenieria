<style>
        .banner {
            margin: 1%;
            background-size: cover;
            background-position: center;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            border-radius: 15px;
            overflow: hidden;
        }

        .banner-texto h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .banner-texto p {
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .banner-texto .btn {
            font-size: 1rem;
            padding: 0.5rem 2rem;
        }

        @media (max-width: 768px) {
            .banner {
                height: 150px;
            }

            .banner-texto h1 {
                font-size: 1.5rem;
            }

            .banner-texto p {
                font-size: 1rem;
            }

            .banner-texto .btn {
                padding: 0.4rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container my-4">

        <div class="row g-3">

             <div class="col-12 col-md-6">
                <div class="banner" style="background-image: url('<?php echo APP_URL; ?>app/views/img/');">
                    <div class="banner-texto">
                        <h1 class="display-4">Registro de Números de Lote</h1>
                        <a href="<?php echo APP_URL; ?>regNumeroLote/" class="btn btn-primary">ENTRAR</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="banner" style="background-image: url('<?php echo APP_URL; ?>app/views/img/');">
                    <div class="banner-texto">
                        <h1 class="display-4">Consultar Números de Lote</h1>
                        <a href="<?php echo APP_URL; ?>consultaNumeroLote/" class="btn btn-primary">ENTRAR</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-3">

             <div class="col-12 col-md-6">
                <div class="banner" style="background-image: url('<?php echo APP_URL; ?>app/views/img/');">
                    <div class="banner-texto">
                        <h1 class="display-4">Registro de Números de Serie</h1>
                        <a href="<?php echo APP_URL; ?>regNumeroSerie/" class="btn btn-primary">ENTRAR</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="banner" style="background-image: url('<?php echo APP_URL; ?>app/views/img/');">
                    <div class="banner-texto">
                        <h1 class="display-4">Consultar Números de Serie</h1>
                        <a href="<?php echo APP_URL; ?>consultaNumeroSerie/" class="btn btn-primary">ENTRAR</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-3">

             <div class="col-12 col-md-6">
                <div class="banner" style="background-image: url('<?php echo APP_URL; ?>app/views/img/');">
                    <div class="banner-texto">
                        <h1 class="display-4">Registrar Salidas de Producto Terminado</h1>
                        <a href="<?php echo APP_URL; ?>salidasProductoTerminado/" class="btn btn-primary">ENTRAR</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="banner" style="background-image: url('<?php echo APP_URL; ?>app/views/img/');">
                    <div class="banner-texto">
                        <h1 class="display-4">Registro Salidas de Numeros serie de Producto Terminado</h1>
                        <a href="<?php echo APP_URL; ?>salidaPTNew/" class="btn btn-primary">ENTRAR</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-3">

             <div class="col-12 col-md-6">
                <div class="banner" style="background-image: url('<?php echo APP_URL; ?>app/views/img/');">
                    <div class="banner-texto">
                        <h1 class="display-4">Cosultar Vale de Salida</h1>
                        <a href="<?php echo APP_URL; ?>salidaPTSearch/" class="btn btn-primary">ENTRAR</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="banner" style="background-image: url('<?php echo APP_URL; ?>app/views/img/');">
                    <div class="banner-texto">
                        <h1 class="display-4">Cosultar Registros</h1>
                        <a href="<?php echo APP_URL; ?>numSerSearch/" class="btn btn-primary">ENTRAR</a>
                    </div>
                </div>
            </div>


        </div>

    </div>
   
</body>