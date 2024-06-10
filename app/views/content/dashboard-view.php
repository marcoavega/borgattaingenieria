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
                <div class="banner" style="background-image: url('<?php echo APP_URL; ?>app/views/img/herra.webp');">
                    <div class="banner-texto">
                        <h1 class="display-4">ALMACEN</h1>
                        <p class="lead">CONSULTAR.</p>
                        <a href="<?php echo APP_URL; ?>menuStorage/" class="btn btn-primary">ENTRAR</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="banner" style="background-image: url('<?php echo APP_URL; ?>app/views/img/kit.png');">
                    <div class="banner-texto">
                        <h1 class="display-4">KIT ARTICULADOR <br> BORGATTA</h1>
                        <p class="lead">CONSULTAR.</p>
                        <a href="<?php echo APP_URL; ?>kitArticulador/" class="btn btn-primary">ENTRAR</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="banner" style="background-image: url('<?php echo APP_URL; ?>app/views/img/maq.webp');">
                    <div class="banner-texto">
                        <h1 class="display-4">Herramientas Maquinados</h1>
                        <p class="lead">CONSULTAR.</p>
                        <a href="<?php echo APP_URL; ?>herramientasMaquinado/" class="btn btn-primary">ENTRAR</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="banner" style="background-image: url('<?php echo APP_URL; ?>app/views/img/conteo.webp');">
                    <div class="banner-texto">
                        <h1 class="display-4">Conteo de Inventario</h1>
                        <p class="lead">CONSULTAR.</p>
                        <a href="<?php echo APP_URL; ?>inventoryList/" class="btn btn-primary">ENTRAR</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="banner" style="background-image: url('<?php echo APP_URL; ?>app/views/img/');">
                    <div class="banner-texto">
                        <h1 class="display-4">Producto terminado</h1>
                        <a href="<?php echo APP_URL; ?>productoTerminado/" class="btn btn-primary">ENTRAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
</body>