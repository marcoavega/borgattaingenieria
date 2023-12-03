<div class="container is-fluid mb-6">
	<?php 
		$id=$insLogin->limpiarCadena($url[1]);
	?>
	<h1 class="title">Foto de producto</h1>
	<h2 class="subtitle">Actualizar foto de producto</h2>
</div>


<div class="container pb-6 pt-6">
	<?php
	
		include "./app/views/inc/btn_back.php";

        $datos = $insLogin->seleccionarDatos("Unico", "productos", "id_producto", $id);

		if($datos->rowCount()==1){
			$datos=$datos->fetch();
	?>

	<h2 class="title has-text-centered"><?php echo $datos['nombre_producto']; ?></h2>

	<div class="columns">
		<div class="column is-two-fifths">
            <?php if(is_file("./app/views/img/img/".$datos['url_imagen'])){ ?>
			<figure class="image mb-6">
                <img class="is-rounded" src="<?php echo APP_URL; ?>app/views/img/img/<?php echo $datos['url_imagen']; ?>">
			</figure>
			
			<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off" >

				<input type="hidden" name="modulo_product" value="eliminarFoto">
                <input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">

				<p class="has-text-centered">
					<button type="submit" class="button is-danger is-rounded">Eliminar foto</button>
				</p>
			</form>
			<?php }else{ ?>
			<figure class="image mb-6">
			  	<img class="is-rounded" src="<?php echo APP_URL; ?>app/views/fotos/default.png">
			</figure>
			<?php }?>
		</div>


		<div class="column">
			<form class="mb-6 has-text-centered FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" enctype="multipart/form-data" autocomplete="off" >

				<input type="hidden" name="modulo_product" value="actualizarFoto">
				<input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">
				
				<label>Foto o imagen del usuario</label><br>

				<div class="file has-name is-boxed is-justify-content-center mb-6">
				  	<label class="file-label">
						<input class="file-input" type="file" name="url_imagen" accept=".jpg, .png, .jpeg" >
						<span class="file-cta">
							<span class="file-label">
								Seleccione una foto
							</span>
						</span>
						<span class="file-name">JPG, JPEG, PNG. (MAX 5MB)</span>
					</label>
				</div>
				<p class="has-text-centered">
					<button type="submit" class="button is-success is-rounded">Actualizar foto</button>
				</p>
			</form>
		</div>
	</div>
	<?php
		}else{
			include "./app/views/inc/error_alert.php";
		}
	?>
</div>