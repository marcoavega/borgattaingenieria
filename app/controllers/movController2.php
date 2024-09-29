<?php

namespace app\controllers;

use app\models\mainModel;

class movController2 extends mainModel
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
     public function obtenerEmpleados()
    {
        $consulta_empleados = "SELECT * FROM empleados ORDER BY nombre_empleado";
        $datos_empleados = $this->ejecutarConsulta($consulta_empleados);
        $opciones_empleados = "";

        while ($empleados = $datos_empleados->fetch()) {
            $opciones_empleados .= '<option value="' . $empleados['id_empleado'] . '">'
                . $empleados['nombre_empleado'] . '</option>';
        }

        return $opciones_empleados;
    }

    public function obtenerMovimientos()
    {
        $consulta_movimientos = "SELECT * FROM movimientos ORDER BY id_movimiento desc";
        $datos_movimientos = $this->ejecutarConsulta($consulta_movimientos);
        $opciones_movimientos = "";

        while ($movimientos = $datos_movimientos->fetch()) {
            $opciones_movimientos .= '<option value="' . $movimientos['id_movimiento'] . '">
            '. $movimientos['id_movimiento'] . ''."  ".''. $movimientos['fecha_movimiento'] . '</option>';
        }

        return $opciones_movimientos;
    }

   
 /*----------  Controlador listar  ----------*/
 public function listarMovControlador2($pagina, $registros, $url, $busqueda)
 {
     $pagina = $this->limpiarCadena($pagina);
     $registros = $this->limpiarCadena($registros);
     $url = $this->limpiarCadena($url);
     $url = APP_URL . $url . "/";
     $busqueda = $this->limpiarCadena($busqueda);

     $consulta_datos = "SELECT
         movimientos.id_movimiento,
         productos.codigo_producto,
         productos.nombre_producto,
         origen.nombre_almacen AS nombre_almacen_origen,
         destino.nombre_almacen AS nombre_almacen_destino,
         empleados.nombre_empleado,
         movimientos.cantidad,
         movimientos.nota_movimiento,
         movimientos.fecha_movimiento
     FROM
         movimientos
     JOIN productos ON movimientos.id_producto = productos.id_producto
     JOIN almacenes AS origen ON movimientos.id_almacen_origen = origen.id_almacen
     JOIN almacenes AS destino ON movimientos.id_almacen_destino = destino.id_almacen
     JOIN empleados ON movimientos.id_empleado = empleados.id_empleado
     ORDER BY movimientos.fecha_movimiento DESC";

     $datos = $this->ejecutarConsulta($consulta_datos);
     $datos = $datos->fetchAll();

     $movimientos_agrupados = [];
     foreach ($datos as $movimiento) {
         $fecha = new \DateTime($movimiento['fecha_movimiento']);
         $año = $fecha->format('Y');
         $mes = $fecha->format('F Y');
         $semana = $fecha->format('W');

         $movimientos_agrupados[$año][$mes][$semana][] = $movimiento;
     }

     return $movimientos_agrupados;
 }
 










}