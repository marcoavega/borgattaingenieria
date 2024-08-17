<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\provController;

	if(isset($_POST['modulo_proveedor'])){

		$insProveedor = new provController();       

		if($_POST['modulo_proveedor']=="registrar"){
			echo $insProveedor->registrarProveedorControlador();
		}

		if($_POST['modulo_proveedor']=="actualizar"){
			echo $insProveedor->actualizarProveedorControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}