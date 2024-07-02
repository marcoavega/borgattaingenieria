
    <style>
        /* Ocultar la barra de navegación por defecto */
        .navbar-hidden {
            top: -50px;
            transition: top 0.3s;
        }

        /* Mostrar la barra de navegación al pasar el cursor */
        .navbar-hidden:hover {
            top: 0;
        }
    </style>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top navbar-hidden">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo APP_URL; ?>dashboard/">BORGATTA INGENIERÍA</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto">
        <!-- Aquí puedes agregar más elementos de navegación si es necesario -->
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Opciones de usuario
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="<?php echo APP_URL . "userUpdate/" . $_SESSION['id'] . "/"; ?>">Mi cuenta</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL . "userPhoto/" . $_SESSION['id'] . "/"; ?>">Mi foto</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL . "logOut/"; ?>">Salir</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Bootstrap JS and dependencies -->

<script>
document.addEventListener("DOMContentLoaded", function() {
  const navbar = document.querySelector(".navbar-hidden");

  window.addEventListener("mousemove", function(event) {
    if (event.clientY < 50) {
      navbar.style.top = "0";
    } else {
      navbar.style.top = "-50px";
    }
  });
});
</script>
