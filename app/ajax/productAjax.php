<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\productController;

	if(isset($_POST['modulo_product'])){

		$insProduct = new productController();

		if($_POST['modulo_product']=="registrar"){
			echo $insProduct->registrarProductControlador();
		}

		if($_POST['modulo_product']=="eliminar"){
			echo $insProduct->eliminarProductControlador();
		}

		if($_POST['modulo_product']=="actualizar"){
			echo $insProduct->actualizarProductControlador();
		}

		if($_POST['modulo_product']=="eliminarFoto"){
			echo $insProduct->eliminarFotoProductControlador();
		}

		if($_POST['modulo_product']=="actualizarFoto"){
			echo $insProduct->actualizarFotoProductControlador();
		}

		if($_POST['modulo_product']=="actualizarStock"){
			echo $insProduct->agregarCantidadProductControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}