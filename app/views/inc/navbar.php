<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo APP_URL; ?>dashboard/">
      <img src="<?php echo APP_URL; ?>app/views/img/logo.png" alt="BORGATTA INGENIERÍA" height="50">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">

      <ul class="navbar-nav me-auto">

        <?php if ($_SESSION['permiso'] == 1) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo APP_URL; ?>userMain/" id="UserDropdown" role="button" aria-expanded="false">
              <div class="d-flex flex-column align-items-center">
                <img src="<?php echo APP_URL; ?>app/views/img/icons/fa-solid--user-cog.svg" alt="User Icon" class="nav-icon">
                Usuarios
              </div>
            </a>
          </li>
        <?php } ?>

        <?php if ($_SESSION['permiso'] == 1) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo APP_URL; ?>almacenMain/" id="UserDropdown" role="button" aria-expanded="false">
              <div class="d-flex flex-column align-items-center">
                <img src="<?php echo APP_URL; ?>app/views/img/icons/vaadin--storage.svg" alt="User Icon" class="nav-icon">
                Almacenes
              </div>
            </a>
          </li>
        <?php } ?>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo APP_URL; ?>productMain/" id="productosDropdown" role="button" aria-expanded="false">
            <div class="d-flex flex-column align-items-center">
              <img src="<?php echo APP_URL; ?>app/views/img/icons/fluent-mdl2--product-variant.svg" alt="Products Icon" class="nav-icon">
              Productos
            </div>
          </a>
        </li>

        <?php if ($_SESSION['permiso'] == 1) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo APP_URL; ?>movementsMain/" id="productosDropdown" role="button" aria-expanded="false">
              <div class="d-flex flex-column align-items-center">
                <img src="<?php echo APP_URL; ?>app/views/img/icons/material-symbols--move-up.svg" alt="Movements Icon" class="nav-icon">
                Movimientos
              </div>
            </a>
          </li>
        <?php } ?>

        <?php if ($_SESSION['permiso'] == 1) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo APP_URL; ?>provMain/" id="productosDropdown" role="button" aria-expanded="false">
              <div class="d-flex flex-column align-items-center">
                <img src="<?php echo APP_URL; ?>app/views/img/icons/carbon--ibm-z-cloud-provisioning.svg" alt="Suppliers Icon" class="nav-icon">
                Proveedores
              </div>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo APP_URL; ?>clientMain/" id="productosDropdown" role="button" aria-expanded="false">
              <div class="d-flex flex-column align-items-center">
                <img src="<?php echo APP_URL; ?>app/views/img/icons/gis--map-user.svg" alt="Suppliers Icon" class="nav-icon">
                Clientes
              </div>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo APP_URL; ?>orderCMain/" id="productosDropdown" role="button" aria-expanded="false">
              <div class="d-flex flex-column align-items-center">
                <img src="<?php echo APP_URL; ?>app/views/img/icons/icon-park-solid--buy.svg" alt="Suppliers Icon" class="nav-icon">
                Órdenes Compra
              </div>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo APP_URL; ?>orderGMain/" id="productosDropdown" role="button" aria-expanded="false">
              <div class="d-flex flex-column align-items-center">
                <img src="<?php echo APP_URL; ?>app/views/img/icons/icon-park-outline--buy.svg" alt="Suppliers Icon" class="nav-icon">
                Órdenes Gasto
              </div>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo APP_URL; ?>notaEMain/" id="productosDropdown" role="button" aria-expanded="false">
              <div class="d-flex flex-column align-items-center">
                <img src="<?php echo APP_URL; ?>app/views/img/icons/octicon--note-16.svg" alt="Suppliers Icon" class="nav-icon">
                Nota Entrada
              </div>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo APP_URL; ?>facturaMain/" id="productosDropdown" role="button" aria-expanded="false">
              <div class="d-flex flex-column align-items-center">
                <img src="<?php echo APP_URL; ?>app/views/img/icons/material-symbols--fact-check.svg" alt="Products Icon" class="nav-icon">
                Facturas
              </div>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo APP_URL; ?>salidaTerminadoMain/" id="productosDropdown" role="button" aria-expanded="false">
              <div class="d-flex flex-column align-items-center">
                <img src="<?php echo APP_URL; ?>app/views/img/icons/hugeicons--product-loading.svg" alt="Products Icon" class="nav-icon">
                Salida Terminado
              </div>
            </a>
          </li>


          <li class="nav-item">
            <a class="nav-link" href="<?php echo APP_URL; ?>entradaTerminadoMain/" id="productosDropdown" role="button" aria-expanded="false">
              <div class="d-flex flex-column align-items-center">
                <img src="<?php echo APP_URL; ?>app/views/img/icons/hugeicons--product-loading.svg" alt="Products Icon" class="nav-icon">
                Entrada Terminado
              </div>
            </a>
          </li>

        <?php } ?>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" id="userOptionsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo APP_URL; ?>app/views/img/icons/la--user-solid.svg" alt="" width="32" height="32" class="rounded-circle me-2">
            <i class="fas fa-user fa-sm"></i> Usuario
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userOptionsDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL . "userUpdate/" . $_SESSION['id'] . "/"; ?>">Mi cuenta</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL . "userPhoto/" . $_SESSION['id'] . "/"; ?>">Mi foto</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL . "logOut/"; ?>">Salir</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
  .navbar {
    font-size: 0.75rem;
    padding-bottom: 0.2rem;

  }

  .navbar .nav-link {}

  .navbar .fas {
    font-size: 0.75rem;
    margin-right: 0.2rem;
  }

  .navbar-brand {
    font-size: 0.85rem;
    padding: 0.3rem 0.6rem;
  }

  .dropdown-menu {
    font-size: 0.7rem;
  }

  .dropdown-item {
    padding: 0.25rem 0.75rem;
  }

  .nav-icon {
    width: 24px;
    height: 24px;
    margin-bottom: 0.2rem;
  }



  /* Ajustar el contenido principal para tener en cuenta la barra de navegación fija */
</style>