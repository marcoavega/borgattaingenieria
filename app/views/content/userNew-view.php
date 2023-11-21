<div id="login" class="container">
		<div class="login well well-small center">
			<h1 class="title">Usuarios</h1>
			<h2 class="subtitle">Nuevo usuario</h2>
	</div>
</div>

<div id="login" class="container">
	<div class="row-fluid">
		<div class="span12">
			<div class="login well well-small">
				<main class="form-signin w-100 m-auto">

					<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST"
						autocomplete="off" enctype="multipart/form-data">
						<input type="hidden" name="modulo_usuario" value="registrar">
						<div class="mb-3">
							<label for="" class="form-label">Usuaurio</label>
							<input type="text" class="form-control" name="usuario_usuario"
								pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
						</div>
						<div class="mb-3">
							<label for="exampleInputPassword1" class="form-label">Clave</label>
							<input type="password" class="form-control" id="exampleInputPassword1"
								name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
						</div>
						<div class="mb-3">
							<label for="exampleInputPassword2" class="form-label">Repetir Clave</label>
							<input type="password" class="form-control" id="exampleInputPassword2"
								name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
						</div>
						<div class="input-group mb-3">
							<label class="input-group-text" for="inputGroupFile01">Subir Foto</label>
							<input type="file" class="form-control" id="inputGroupFile01" name="usuario_foto"
								accept=".jpg, .png, .jpeg">
						</div>
						<p class="has-text-centered">
							<button type="reset" class="btn btn-secondary">Limpiar</button>
							<button type="submit" class="btn btn-primary">Guardar</button>
						</p>
					</form>

				</main>
			</div>
		</div>
	</div>
</div>