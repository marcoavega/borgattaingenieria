<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo APP_URL; ?>dashboard/">
      <small>BORGATTA INGENIERÍA</small>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto">
        <?php if ($_SESSION['permiso'] == 1) { ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="usuariosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-users fa-sm"></i> Usuarios
          </a>
          <ul class="dropdown-menu" aria-labelledby="usuariosDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>userNew/">Crear Nuevo</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>userList/">Lista</a></li>
          </ul>
        </li>
        <?php } ?>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="productosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-box fa-sm"></i> Productos
          </a>
          <ul class="dropdown-menu" aria-labelledby="productosDropdown">
            <?php if ($_SESSION['permiso'] == 1) { ?>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>productNew/">Alta de Artículos</a></li>
            <?php } ?>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>productList/">Lista</a></li>
          </ul>
        </li>
        
        <?php if ($_SESSION['permiso'] == 1) { ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="movimientosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-exchange-alt fa-sm"></i> Movimientos
          </a>
          <ul class="dropdown-menu" aria-labelledby="movimientosDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>movList/">Consultar Todos</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>movSearch/">Buscar por nombre</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>movSearch2/">Buscar por movimiento</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="proveedoresDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-truck fa-sm"></i> Proveedores
          </a>
          <ul class="dropdown-menu" aria-labelledby="proveedoresDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>provNew/">Nuevo</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>provList/">Lista</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="clientesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-tie fa-sm"></i> Clientes
          </a>
          <ul class="dropdown-menu" aria-labelledby="clientesDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>clientNew/">Nuevo</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>clientList/">Lista</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="ordenesCompraDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-shopping-cart fa-sm"></i> Órdenes Compra
          </a>
          <ul class="dropdown-menu" aria-labelledby="ordenesCompraDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderCNew/">Nueva orden</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderCPNew/">Alta de productos</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderSearch/">Consultar</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="ordenesGastoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-file-invoice-dollar fa-sm"></i> Órdenes Gasto
          </a>
          <ul class="dropdown-menu" aria-labelledby="ordenesGastoDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderGNew/">Nueva orden</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderGPNew/">Alta de productos</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>orderGSearch/">Consultar</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="notaEntradaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-clipboard-check fa-sm"></i> Nota Entrada
          </a>
          <ul class="dropdown-menu" aria-labelledby="notaEntradaDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>notaENew/">Nueva Nota</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>notaEPNew/">Alta de Productos</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>notaESearch/">Consultar</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="facturasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-file-invoice fa-sm"></i> Facturas
          </a>
          <ul class="dropdown-menu" aria-labelledby="facturasDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>facturaNew/">Capturar</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>facturaPNew/">Alta</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>facturaSearch/">Consultar/Imprimir</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>movFactura/">Sacar Reporte</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="controlProcesosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-cogs fa-sm"></i> Control Procesos
          </a>
          <ul class="dropdown-menu" aria-labelledby="controlProcesosDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>regNumeroLote/">Registrar Nº Lote</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>consultaNumeroLote/">Consultar Nº Lote</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>regNumeroSerie/">Registrar Nº Serie</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>consultaNumeroSerie/">Consultar Nº Serie</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>salidasProductoTerminado/">Registrar Salidas PT</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>salidaPTNew/">Registro Salidas Nº Serie PT</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>salidaPTSearch/">Consultar Vale Salida</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>numSerSearch/">Consultar Registros</a></li>
          </ul>
        </li>
        <?php } ?>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userOptionsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
  padding-top: 0.2rem;
  padding-bottom: 0.2rem;
}

.navbar .nav-link {
  padding: 0.3rem 0.5rem;
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

@media (max-width: 991.98px) {
  .navbar-nav .dropdown-menu {
    position: static;
    float: none;
  }
  
  .navbar-nav .nav-item {
    padding: 0.1rem 0;
  }
}

/* Ajustar el contenido principal para tener en cuenta la barra de navegación fija */
body {
  padding-top: 3rem;
}
</style>