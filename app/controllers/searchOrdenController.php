<?php

namespace app\controllers;

use app\models\mainModel;

class searchOrdenController extends mainModel
{

	/*----------  Controlador modulos de busquedas  ----------*/
	public function modulosBusquedaControlador($modulo)
	{

		$listaModulos = ['userSearch', 'orderSearch'];

		if (in_array($modulo, $listaModulos)) {
			return false;
		} else {
			return true;
		}
	}


	/*----------  Controlador iniciar busqueda  ----------*/
	public function iniciarBuscadorControlador()
	{

		$url = ($_POST['modulo_url']);
		$texto = ($_POST['txt_buscador']);

		if ($this->modulosBusquedaControlador($url)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "No podemos procesar la petición en este momento",
				"icono" => "error"
			];
			return json_encode($alerta);
			exit();
		}

		if ($texto == "") {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "Introduce un termino de busqueda",
				"icono" => "error"
			];
			return json_encode($alerta);
			exit();
		}


		$_SESSION[$url] = $texto;

		$alerta = [
			"tipo" => "redireccionar",
			"url" => APP_URL . $url . "/"
		];

		return json_encode($alerta);
	}


	/*----------  Controlador eliminar busqueda  ----------*/
	public function eliminarBuscadorControlador()
	{

		$url = ($_POST['modulo_url']);

		if ($this->modulosBusquedaControlador($url)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "No podemos procesar la petición en este momento",
				"icono" => "error"
			];
			return json_encode($alerta);
			exit();
		}

		unset($_SESSION[$url]);

		$alerta = [
			"tipo" => "redireccionar",
			"url" => APP_URL . $url . "/"
		];

		return json_encode($alerta);
	}

}