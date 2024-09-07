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
              <img src="https://img.icons8.com/ios-filled/50/ffffff/user.png" alt="User Icon" class="nav-icon">
              Usuarios
            </div>
          </a>
        </li>
        <?php } ?>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo APP_URL; ?>productMain/" id="productosDropdown" role="button" aria-expanded="false">
            <div class="d-flex flex-column align-items-center">
              <img src="https://img.icons8.com/ios-glyphs/30/ffffff/box.png" alt="Products Icon" class="nav-icon">
              Productos
            </div>
          </a>
        </li>
        
        <?php if ($_SESSION['permiso'] == 1) { ?>
          <li class="nav-item">
          <a class="nav-link" href="<?php echo APP_URL; ?>movementsMain/" id="productosDropdown" role="button" aria-expanded="false">
            <div class="d-flex flex-column align-items-center">
              <img src="https://img.icons8.com/ios-glyphs/30/ffffff/shuffle.png" alt="Movements Icon" class="nav-icon">
              Movimientos
              </div>
          </a>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link " href="#" id="proveedoresDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="d-flex flex-column align-items-center">
              <img src="https://img.icons8.com/ios-glyphs/30/ffffff/truck.png" alt="Suppliers Icon" class="nav-icon">
              Proveedores
            </div>
          </a>
          <ul class="dropdown-menu" aria-labelledby="proveedoresDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>provNew/">Nuevo</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>provList/">Lista</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link " href="#" id="clientesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="d-flex flex-column align-items-center">
              <img src="https://img.icons8.com/ios-glyphs/30/ffffff/business-contact.png" alt="Clients Icon" class="nav-icon">
              Clientes
            </div>
          </a>
          <ul class="dropdown-menu" aria-labelledby="clientesDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>clientNew/">Nuevo</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>clientList/">Lista</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" id="ordenesCompraDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="d-flex flex-column align-items-center">
              <img src="https://img.icons8.com/ios-glyphs/30/ffffff/shopping-cart.png" alt="Purchase Orders Icon" class="nav-icon">
              Órdenes Compra
            </div>
          </a>
          <ul class="dropdown-menu" aria-labelledby="ordenesCompraDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderCNew/">Nueva orden</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderCPNew/">Alta de productos</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderSearch/">Consultar</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" id="ordenesGastoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="d-flex flex-column align-items-center">
              <img src="https://img.icons8.com/ios-glyphs/30/ffffff/purchase-order.png" alt="Expense Orders Icon" class="nav-icon">
              Órdenes Gasto
            </div>
          </a>
          <ul class="dropdown-menu" aria-labelledby="ordenesGastoDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderGNew/">Nueva orden</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderGPNew/">Alta de productos</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderGSearch/">Consultar</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" id="notaEntradaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="d-flex flex-column align-items-center">
              <img src="https://img.icons8.com/ios-glyphs/30/ffffff/checklist.png" alt="Entry Note Icon" class="nav-icon">
              Nota Entrada
            </div>
          </a>
          <ul class="dropdown-menu" aria-labelledby="notaEntradaDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>notaENew/">Nueva Nota</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>notaEPNew/">Alta de Productos</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>notaESearch/">Consultar</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" id="facturasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="d-flex flex-column align-items-center">
              <img src="https://img.icons8.com/ios-glyphs/30/ffffff/invoice.png" alt="Invoices Icon" class="nav-icon">
              Facturas
            </div>
          </a>
          <ul class="dropdown-menu" aria-labelledby="facturasDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>facturaNew/">Capturar</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>facturaPNew/">Alta</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>facturaSearch/">Consultar/Imprimir</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>movFactura/">Sacar Reporte</a></li>
          </ul>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="<?php echo APP_URL; ?>salidaTerminadoMain/" id="productosDropdown" role="button" aria-expanded="false">
            <div class="d-flex flex-column align-items-center">
              <img src="https://img.icons8.com/ios-glyphs/30/ffffff/settings.png" alt="Products Icon" class="nav-icon">
              Salida Terminado
            </div>
          </a>
        </li>

        <?php } ?>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" id="userOptionsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
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

.navbar .nav-link {
  
}

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