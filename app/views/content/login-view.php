<div id="login" class="container">
	<div class="row-fluid">
		<div class="span12">
			<div class="login well well-small">

				<main class="form-signin w-100 m-auto">
					<form class="" action="" method="POST" autocomplete="off">

						<div class="center">
							<img class="mb-12 rounded" <?php echo 'src="' . APP_URL . 'app/views/img/logo.png"' ?> alt=""
								width="72" height="57">
							<h1 class="h3 mb-3 fw-normal">Borgatta Ingeniería</h1>
						</div>
						<div class="form-floating">
							<input type="text" class="form-control" id="floatingInput" placeholder="Usuario"
								name="login_usuario" pattern="[a-zA-Z0-9]{4,30}" maxlength="30" required>
							<label for="floatingInput">Usuario</label>
						</div>
						<div class="form-floating">
							<input type="password" class="form-control" id="floatingPassword" placeholder="Password"
								name="login_clave" pattern="[a-zA-Z0-9$@.-]{5,100}" maxlength="100" required>
							<label for="floatingPassword">Clave</label>
						</div>

						<button class="btn btn-primary w-100 py-2" type="submit">Ingresar</button>

					</form>
				</main>
			</div>
		</div>
	</div>
</div>


<div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
	<button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button"
		aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
		<svg class="bi my-1 theme-icon-active" width="1em" height="1em">
			<use href="#circle-half"></use>
		</svg>
		<span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
	</button>
	<ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
		<li>
			<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light"
				aria-pressed="false">
				<svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
					<use href="#sun-fill"></use>
				</svg>
				Light
				<svg class="bi ms-auto d-none" width="1em" height="1em">
					<use href="#check2"></use>
				</svg>
			</button>
		</li>
		<li>
			<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark"
				aria-pressed="false">
				<svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
					<use href="#moon-stars-fill"></use>
				</svg>
				Dark
				<svg class="bi ms-auto d-none" width="1em" height="1em">
					<use href="#check2"></use>
				</svg>
			</button>
		</li>
		<li>
			<button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto"
				aria-pressed="true">
				<svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
					<use href="#circle-half"></use>
				</svg>
				Auto
				<svg class="bi ms-auto d-none" width="1em" height="1em">
					<use href="#check2"></use>
				</svg>
			</button>
		</li>
	</ul>
</div>

<?php
if (isset($_POST['login_usuario']) && isset($_POST['login_clave'])) {
	$insLogin->iniciarSesionControlador();
}
?>