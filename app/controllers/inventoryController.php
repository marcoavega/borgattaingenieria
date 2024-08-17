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

        
        # Almacenando datos#

        $id_producto = $this->limpiarCadena($_POST['id_producto']);
        $id_almacen_origen = $this->limpiarCadena($_POST['id_almacen_origen']);
        $stock = $this->limpiarCadena($_POST['stock']);


        // Validar que los campos no estén vacíos
        if (empty($id_producto) || empty($id_almacen_origen) || empty($stock) ) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios" ,
                "icono" => "error"
            ];

            return json_encode($alerta);
        }
        $stock_actual = $this->obtenerStock($id_producto, $id_almacen_origen);
        if ($stock_actual && $stock_actual['stock'] >= $stock) {
            //     $nuevo_stock = $stock_actual['stock'] - $stock;

          //Restar stock del almacén de origen
          $restarStockOrigen = "UPDATE stock_almacen SET stock = stock - $stock WHERE id_producto = $id_producto AND id_almacen = $id_almacen_origen";


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

          return json_encode($alerta);

        } else {
  
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar el movimiento de salida, la cantidad es mayor al disponible",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);

    //    $id_producto = $this->limpiarCadena($_POST['id_producto']);
      //  $id_almacen_origen = $this->limpiarCadena($_POST['id_almacen_origen']);
      //  $stock = $this->limpiarCadena($_POST['stock']);
       // $stock_actual = $this->obtenerStock($id_producto, $id_almacen_origen);
        
       // if ($stock_actual && $stock_actual['stock'] >= $stock) {
       //     $nuevo_stock = $stock_actual['stock'] - $stock;
        //    $this->actualizarStock($id_producto, $id_almacen_origen, $nuevo_stock);
             // Después de actualizar el inventario, redirigir a la página principal o a una página específica
       // header("Location: " . APP_URL);
      //  exit();
      //  }
    
        // Después de actualizar el inventario, redirigir a la página principal o a una página específica
      //  header("Location: " . APP_URL);
      //  exit();
   }
   
}