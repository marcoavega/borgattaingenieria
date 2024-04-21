<?php

namespace app\controllers;

use app\models\mainModel;

class inventoryController extends mainModel
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
    public function descontarInventarioControlador() {
        $id_producto = $this->limpiarCadena($_POST['id_producto']);
        $id_almacen_origen = $this->limpiarCadena($_POST['id_almacen_origen']);
        $cantidad = $this->limpiarCadena($_POST['cantidad']);
        
        $stock_actual = $this->obtenerStock($id_producto, $id_almacen_origen);
        
        if ($stock_actual && $stock_actual['stock'] >= $cantidad) {
            $nuevo_stock = $stock_actual['stock'] - $cantidad;
            $this->actualizarStock($id_producto, $id_almacen_origen, $nuevo_stock);
             // Después de actualizar el inventario, redirigir a la página principal o a una página específica
        header("Location: " . APP_URL);
        exit();
        }
    
        // Después de actualizar el inventario, redirigir a la página principal o a una página específica
        header("Location: " . APP_URL);
        exit();
    }
    
    



}