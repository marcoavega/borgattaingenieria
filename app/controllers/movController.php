<?php

namespace app\controllers;

use app\models\mainModel;

class movController extends mainModel
{

    public function obtenerOpcionesProductos()
    {
        $consulta_productos = "SELECT * FROM productos ORDER BY id_producto";
        $datos_productos = $this->ejecutarConsulta($consulta_productos);
        $opciones_productos = "";

        while ($productos = $datos_productos->fetch()) {
            $opciones_productos .= '<option value="' . $productos['id_producto'] . '">'
                . $productos['codigo_producto'] . " " . $productos['nombre_producto'] . '</option>';
        }

        return $opciones_productos;
    }
    public function obtenerOpcionesAlmacenes()
    {
        $consulta_almacenes = "SELECT * FROM almacenes ORDER BY nombre_almacen";
        $datos_almacenes = $this->ejecutarConsulta($consulta_almacenes);
        $opciones_almacenes = "";

        while ($almacenes = $datos_almacenes->fetch()) {
            $opciones_almacenes .= '<option value="' . $almacenes['id_almacen'] . '">'
                . $almacenes['nombre_almacen'] . '</option>';
        }

        return $opciones_almacenes;
    }


    /*----------  Controlador registrar proveedor  ----------*/
    public function registrarMovimientoControlador()
    {

        # Almacenando datos#

        $id_producto = $this->limpiarCadena($_POST['id_producto']);
        $id_almacen_origen = $this->limpiarCadena($_POST['id_almacen_origen']);
        $id_almacen_destino = $this->limpiarCadena($_POST['id_almacen_destino']);
        $cantidad = $this->limpiarCadena($_POST['cantidad']);
        $nota = $this->limpiarCadena($_POST['nota']);


        // Validar que los campos no estén vacíos
        if (empty($id_producto) || empty($id_almacen_origen) || empty($id_almacen_destino) || empty($cantidad) || empty($nota)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];

            return json_encode($alerta);
        }


        $movimiento_datos_reg = [

            [
                "campo_nombre" => "id_producto",
                "campo_marcador" => ":Producto",
                "campo_valor" => $id_producto
            ],
            [
                "campo_nombre" => "id_almacen_origen",
                "campo_marcador" => ":Origen",
                "campo_valor" => $id_almacen_origen
            ],
            [
                "campo_nombre" => "id_almacen_destino",
                "campo_marcador" => ":Destino",
                "campo_valor" => $id_almacen_destino
            ],
            [
                "campo_nombre" => "cantidad",
                "campo_marcador" => ":Cantidad",
                "campo_valor" => $cantidad
            ],
            [
                "campo_nombre" => "nota",
                "campo_marcador" => ":Nota",
                "campo_valor" => $nota
            ]

        ];

        $registrar_movimiento = $this->guardarDatos("movimientos", $movimiento_datos_reg);

        if ($registrar_movimiento->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Movimiento registrado",
                "texto" => "El movimiento se registro con exito",
                "icono" => "success"
            ];
        } else {

            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar el movimiento, por favor intente nuevamente",
                "icono" => "error"
            ];
        }





        # Verificando usuario #
        $check_inventario = $this->ejecutarConsulta("SELECT * FROM stock_almacen");
        if ($check_inventario->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hay registros favor de contactar con el administrador",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        //Restar stock del almacén de origen
        $restarStockOrigen = "UPDATE stock_almacen SET stock = stock - $cantidad WHERE id_producto = $id_producto AND id_almacen = $id_almacen_origen";


        $resultadoRestar = $this->ejecutarConsulta($restarStockOrigen);
        if ($resultadoRestar->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Movimiento registrado",
                "texto" => "El movimiento de salida se registro con exito",
                "icono" => "success"
            ];
        } else {

            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar el movimiento de salida, por favor intente nuevamente",
                "icono" => "error"
            ];
        }
        //Sumar stock al almacén de destino
        $sumarStockDestino = "UPDATE stock_almacen SET stock = stock + $cantidad WHERE id_producto = $id_producto AND id_almacen = $id_almacen_destino";

        $resultadoSumar = $this->ejecutarConsulta($sumarStockDestino);
        if ($resultadoSumar->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Movimiento registrado",
                "texto" => "El movimiento de entrada se registro con exito",
                "icono" => "success"
            ];
        } else {

            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar el movimiento de entrada, por favor intente nuevamente",
                "icono" => "error"
            ];
        }








        return json_encode($alerta);

    }



}