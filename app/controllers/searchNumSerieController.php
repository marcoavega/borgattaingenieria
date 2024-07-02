<?php

namespace app\controllers;

use app\models\mainModel;

class searchNumSerieController extends mainModel
{
	
    public function iniciarBuscadorControlador()
    {
        $url = $_POST['modulo_url'];
        $texto = $this->limpiarCadena($_POST['txt_buscador']);

        if (empty($texto)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "Introduce un término de búsqueda",
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

    public function eliminarBuscadorControlador()
    {
        $url = $_POST['modulo_url'];

        if (isset($_SESSION[$url])) {
            unset($_SESSION[$url]);
        }

        $alerta = [
            "tipo" => "redireccionar",
            "url" => APP_URL . $url . "/"
        ];

        return json_encode($alerta);
    }
}
