<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\searchMovController2;

	if(isset($_POST['modulo_buscador'])){

		$insBuscador = new searchMovController2();

		if($_POST['modulo_buscador']=="buscar"){
			echo $insBuscador->iniciarBuscadorControlador2();
		}
		if($_POST['modulo_buscador']=="eliminar"){
			echo $insBuscador->eliminarBuscadorControlador2();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}