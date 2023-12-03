<div class="container is-fluid mb-6">
	<h1 class="title">Productos</h1>
	<h2 class="subtitle">Lista de productos</h2>
</div>
<div class="container pb-6 pt-6">

	<div class="form-rest mb-6 mt-6"></div>

	<?php
		use app\controllers\productController;

		$insUsuario = new productController();
		
		echo $insUsuario->listarProductControlador($url[1],30,$url[0],"");
	?>

</div>