<div class="main-container has-background-black">
	<form class="box login has-background-dark has-text-white" action="" method="POST" autocomplete="off">
		
	<div class="columns is-flex is-justify-content-center">
    	<figure class="image is-128x128">
    		<?php
    				echo '<img class="is-rounded" src="'.APP_URL.'app/views/img/logo.png">';
    		?>
		</figure>
  	</div>
	
		<h5 class="title is-5 has-text-centered is-uppercase has-text-white">LOGIN</h5>
		<div class="field">
			<label class="label has-text-white">Usuario</label>
			<div class="control">
				<input class="input" type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,30}" maxlength="30"
					required>
			</div>
		</div>
		<div class="field">
			<label class="label has-text-white">Clave</label>
			<div class="control">
				<input class="input" type="password" name="login_clave" pattern="[a-zA-Z0-9$@.-]{5,100}" maxlength="100"
					required>
			</div>
		</div>
		<p class="has-text-centered mb-4 mt-3">
			<button type="submit" class="button is-primary is-focused ">Iniciar sesion</button>
		</p>

	</form>
</div>

<?php
if (isset($_POST['login_usuario']) && isset($_POST['login_clave'])) {
	$insLogin->iniciarSesionControlador();
}
?>