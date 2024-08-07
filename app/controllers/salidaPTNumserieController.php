<?php

namespace app\controllers;

use app\models\mainModel;

class salidaPTNumserieController extends mainModel
{
    public function obtenerOpcionesNumeroVS()
    {
        $consulta_vs = "SELECT * FROM salidas_producto_terminado ORDER BY numero_salida";
        $datos_vs = $this->ejecutarConsulta($consulta_vs);
        $opciones_vs = "";

        while ($vs = $datos_vs->fetch()) {
            $opciones_vs .= '<option value="' . $vs['id_salida'] . '">'
                . $vs['numero_salida'] . '</option>';
        }

        return $opciones_vs;
    }

    public function obtenerOpcionesNumeroLote()
    {
        $consulta_nl = "SELECT * FROM numeros_lote ORDER BY numero_lote";
        $datos_nl = $this->ejecutarConsulta($consulta_nl);
        $opciones_nl = "";

        while ($nl = $datos_nl->fetch()) {
            $opciones_nl .= '<option value="' . $nl['id_numero_lote'] . '">'
                . $nl['numero_lote'] . '</option>';
        }

        return $opciones_nl;
    }

    public function obtenerOpcionesNumeroSerie()
    {
        $consulta_ns = "SELECT * FROM numeros_serie ORDER BY numero_serie";
        $datos_ns = $this->ejecutarConsulta($consulta_ns);
        $opciones_ns = "";

        while ($ns = $datos_ns->fetch()) {
            $opciones_ns .= '<option value="' . $ns['id_numero_serie'] . '">'
                . $ns['numero_serie'] . '</option>';
        }

        return $opciones_ns;
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

    public function obtenerOpcionesProductos()
    {
        $consulta_productos = "SELECT * FROM productos WHERE id_categoria = 11 ORDER BY nombre_producto DESC";
        $datos_productos = $this->ejecutarConsulta($consulta_productos);
        $opciones_productos = "";

        while ($productos = $datos_productos->fetch()) {
            $opciones_productos .= '<option value="' . $productos['id_producto'] . '">'
                . $productos['codigo_producto'] . ' - '
                . $productos['nombre_producto'] . '</option>';
        }

        return $opciones_productos;
    }

    public function registrarSalidaPTControlador()
    {
        // Almacenando datos
        $id_salida = $_POST['id_salida'];
        $id_numero_lote = $_POST['id_numero_lote'];
        $id_producto = $_POST['id_producto'];
        $id_numero_serie = $_POST['id_numero_serie'];
        
       
        // Verificando campos obligatorios
        if ($id_salida == "" || $id_numero_lote == "" || $id_numero_serie == "" || $id_producto == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        $datos_reg = [
            [
                "campo_nombre" => "id_salida",
                "campo_marcador" => ":IdSalida",
                "campo_valor" => $id_salida
            ],
            [
                "campo_nombre" => "id_numero_lote",
                "campo_marcador" => ":NumeroLote",
                "campo_valor" => $id_numero_lote
            ],
            [
                "campo_nombre" => "id_producto",
                "campo_marcador" => ":IdProducto",
                "campo_valor" => $id_producto
            ],
            [
                "campo_nombre" => "id_numero_serie",
                "campo_marcador" => ":NumeroSerie",
                "campo_valor" => $id_numero_serie
            ]
        ];

        $registrar_detalle_salidas = $this->guardarDatos("detalle_salidas_producto_terminado", $datos_reg);

        if ($registrar_detalle_salidas->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Registrado",
                "texto" => "Se registró con éxito",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar, por favor consulte su administrador",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }
}
?>
