<?php
// Importa el controlador de productos
use app\controllers\productController;
// Crea una instancia del controlador
$insProduct = new productController();
// Muestra la lista de productos
echo $insProduct->listarProductKit($url[1], 200, $url[0], "");
?>