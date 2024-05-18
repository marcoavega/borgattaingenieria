<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\searchNotaEController;

	if(isset($_POST['modulo_buscador'])){

		$insBuscador = new searchNotaEController();

		if($_POST['modulo_buscador']=="buscar"){
			echo $insBuscador->iniciarBuscadorControlador();
		}

		if($_POST['modulo_buscador']=="eliminar"){
			echo $insBuscador->eliminarBuscadorControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}