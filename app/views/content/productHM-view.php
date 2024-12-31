<?php
// Importa el controlador de productos
use app\controllers\productController;
// Crea una instancia del controlador
$insProduct = new productController();
// Muestra la lista de productos
echo $insProduct->listarProductHM($url[1], 54, $url[0], "");
?>