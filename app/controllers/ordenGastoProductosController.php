<?php

namespace app\controllers;

use app\models\mainModel;

class ordenGastoProductosController extends mainModel
{

    
    public function obtenerOpcionesProveedores()
    {
        $consulta_proveedores = "SELECT * FROM proveedores ORDER BY nombre_proveedor DESC";
        $datos_proveedores = $this->ejecutarConsulta($consulta_proveedores);
        $opciones_proveedores = "";

        while ($proveedor = $datos_proveedores->fetch()) {
            $opciones_proveedores .= '<option value="' . $proveedor['id_proveedor'] . '">'
                . $proveedor['nombre_proveedor'] . '</option>';
        }

        return $opciones_proveedores;
    }
   
    public function obtenerOpcionesOrdenGasto()
    {
        $consulta_orden_gasto = "SELECT * FROM ordenes_gasto ORDER BY numero_orden DESC";
        $datos_orden = $this->ejecutarConsulta($consulta_orden_gasto);
        $opciones_ordenes = "";

        while ($orden_compra = $datos_orden->fetch()) {
            $opciones_ordenes .= '<option value="' . $orden_compra['id_orden_gasto'] . '">'
                . $orden_compra['numero_orden'] . '</option>';
        }

        return $opciones_ordenes;
    }



public function obtenerOpcionesNombreProductos()
    {
        $consulta_productos = "SELECT * FROM productos ORDER BY id_producto DESC";
        $datos_productos = $this->ejecutarConsulta($consulta_productos);
        $opciones_productos = "";

        while ($productos = $datos_productos->fetch()) {
            $opciones_productos .= '<option value="' . $productos['id_producto'] . '">'
                . $productos['codigo_producto'] . " " . $productos['nombre_producto'] . '</option>';
        }

        return $opciones_productos;
    }


public function obtenerOpcionesCodigoProductos()
    {
        $consulta_codigo_productos = "SELECT * FROM productos ORDER BY id_producto DESC";
        $datos_codigo_productos = $this->ejecutarConsulta($consulta_codigo_productos);
        $opciones_codigo_productos = "";

        while ($codigo_producto = $datos_codigo_productos->fetch()) {
            $opciones_codigo_productos .= '<option value="' . $codigo_producto['id_proveedor'] . '">'
                . $codigo_producto['codigo_producto'] . '</option>';
        }

        return $opciones_codigo_productos;
    }


public function obtenerOpcionesUnidadesMedida()
    {
        $consulta_unidades = "SELECT * FROM unidades_medida ORDER BY nombre_unidad DESC";
        $datos_unidades = $this->ejecutarConsulta($consulta_unidades);
        $opciones_unidades = "";

        while ($unidad = $datos_unidades->fetch()) {
            $opciones_unidades .= '<option value="' . $unidad['id_unidad'] . '">'
                . $unidad['nombre_unidad'] . '</option>';
        }

        return $opciones_unidades;
    }


    /*----------  Controlador registrar usuario  ----------*/
    public function registrarOrdenGastoProductosControlador()
    {
        
    
# Almacenando datos#

$id_orden_gasto = $_POST['id_orden_gasto'];
/*$numero_partida = $_POST['numero_partida'];*/
$nombre_producto = $_POST['nombre_producto'];
$cantidad = $_POST['cantidad'];
$unidad_medida = $_POST['unidad_medida'];
$precio_sin_IVA = $_POST['precio_sin_IVA'];
$total = $_POST['total'];



# Verificando campos obligatorios #
if ($id_orden_gasto == "" || $nombre_producto == "" || $cantidad == "" || $precio_sin_IVA == "" || $total == "" || $unidad_medida == "" ) {
    $alerta = [
        "tipo" => "simple",
        "titulo" => "Ocurrió un error inesperado",
        "texto" => "No has llenado todos los campos que son obligatorios",
        "icono" => "error"
    ];
    return json_encode($alerta);
    exit();
}




$detalle_datos_reg = [

    [
        "campo_nombre" => "id_orden_gasto",
        "campo_marcador" => ":OrdenGasto",
        "campo_valor" => $id_orden_gasto
    ],
    /*
    [
        "campo_nombre" => "numero_partida",
        "campo_marcador" => ":NumerPartida",
        "campo_valor" => $numero_partida
    ],
    */
    [
        "campo_nombre" => "nombre_producto",
        "campo_marcador" => ":NombreProducto",
        "campo_valor" => $nombre_producto
    ],
    [
        "campo_nombre" => "cantidad",
        "campo_marcador" => ":Cantidad",
        "campo_valor" => $cantidad
    ],
    [
        "campo_nombre" => "id_unidad",
        "campo_marcador" => ":IdUnidad",
        "campo_valor" => $unidad_medida
    ],
    [
        "campo_nombre" => "precio_sin_IVA",
        "campo_marcador" => ":PrecioSinIva",
        "campo_valor" => $precio_sin_IVA
    ],
    [
        "campo_nombre" => "total",
        "campo_marcador" => ":Total",
        "campo_valor" => $total
    ]
   
];

$registrar_orden_gasto = $this->guardarDatos("detalle_orden_gasto", $detalle_datos_reg);

if ($registrar_orden_gasto->rowCount() == 1) {
    $alerta = [
    "tipo" => "limpiar",
    "titulo" => "Orden Registrada",
    "texto" => "La orden de gasto se registró con éxito",
    "icono" => "success"
];

} else {

    $alerta = [
        "tipo" => "simple",
        "titulo" => "Ocurrió un error inesperado",
        "texto" => "No se pudo registrar la orden de gasto, por favor intente nuevamente",
        "icono" => "error"
    ];
}

return json_encode($alerta);


    
    }

    
}