<style>
    .banner-principal1, .banner-principal2 {
        margin: 1%;
        background-size: contain;
        background-position: top center;
        background-repeat: no-repeat;
        height: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
    }

    .banner-principal1 {
        background-image: url('<?php echo APP_URL; ?>app/views/img/herra.webp');
    }
    .banner-principal2 {
        background-image: url('<?php echo APP_URL; ?>app/views/img/kit.png');
    }

    .banner-texto h1 {
        font-size: 4rem;
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

    /* Media queries para mejorar la adaptabilidad en dispositivos más pequeños */
    @media (max-width: 768px) {
        .banner-principal1, .banner-principal2 {
            height: 200px; /* Reducción de la altura del banner */
        }

        .banner-texto h1 {
            font-size: 2rem; /* Reducción del tamaño del título */
        }

        .banner-texto p {
            font-size: 1rem; /* Reducción del tamaño del subtítulo */
        }

        .banner-texto .btn {
            padding: 0.4rem 1.5rem; /* Ajuste del padding del botón */
        }
    }
</style>



<div class="row">
  <div class="col-md-6">
    <div class="banner-principal1">
      <div class="banner-texto">
        <h1 class="display-4">ALMACEN</h1>
        <p class="lead">CONSULTAR.</p>
        <a href="<?php echo APP_URL; ?>menuStorage/" class="btn btn-primary">ENTRAR</a>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="banner-principal2">
      <div class="banner-texto">
        <h1 class="display-4">KIT ARTICULADOR <br> BORGATTA</h1>
        <p class="lead">CONSULTAR.</p>
        <a href="<?php echo APP_URL; ?>kitArticulador/" class="btn btn-primary">ENTRAR</a>
      </div>
    </div>
  </div>
</div>

