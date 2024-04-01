<?php

namespace app\controllers;

use app\models\mainModel;

class stockController extends mainModel
{

    public function obtenerOpcionesProductos()
    {
        $consulta_productos = "SELECT * FROM productos ORDER BY id_producto DESC";
        $datos_productos = $this->ejecutarConsulta($consulta_productos);
        $opciones_productos = "";

        while ($producto = $datos_productos->fetch()) {
            $opciones_productos .= '<option value="' . $producto['id_producto'] . '">
            '. $producto['id_producto'] . ' '. " ".' '. $producto['nombre_producto'] .'</option>';
        }

            return $opciones_productos;
    }

    public function obtenerOpcionesAlmacenes()
    {
        $consulta_almacenes = "SELECT * FROM almacenes ORDER BY nombre_almacen";
        $datos_almacenes = $this->ejecutarConsulta($consulta_almacenes);
        $opciones_almacenes = "";

        while ($almacen = $datos_almacenes->fetch()) {
            $opciones_almacenes .= '<option value="' . $almacen['id_almacen'] . '">'
                . $almacen['nombre_almacen'] . '</option>';
        }

        return $opciones_almacenes;
    }


    public function registrarStockControlador(){

        # Almacenando datos#
        $id_producto = $this->limpiarCadena($_POST['id_producto']);
        $id_almacen = $this->limpiarCadena($_POST['id_almacen']);
        $stock = $this->limpiarCadena($_POST['stock']);


        # Verificando campos obligatorios #
        if (
            $id_producto == "" || $id_almacen == "" || $stock == ""
        ) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        $stock_datos_reg = [

            [
                "campo_nombre" => "id_producto",
                "campo_marcador" => ":IdProducto",
                "campo_valor" => $id_producto
            ],
            [
                "campo_nombre" => "id_almacen",
                "campo_marcador" => ":IdAlmacen",
                "campo_valor" => $id_almacen
            ],
            [
                "campo_nombre" => "stock",
                "campo_marcador" => ":Stock",
                "campo_valor" => $stock
            ]
        ];


        $registrar_stock = $this->guardarDatos("stock_almacen", $stock_datos_reg);

        if ($registrar_stock->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Stock registrado",
                "texto" => "El stock se registró con éxito",
                "icono" => "success"
            ];


            
        } else {
       
        $alerta = [
            "tipo" => "simple",
            "titulo" => "Ocurrió un error inesperado",
            "texto" => "No se pudo registrar el producto, por favor inténtelo nuevamente",
            "icono" => "error"
        ];

    }

    return json_encode($alerta);

    }



}