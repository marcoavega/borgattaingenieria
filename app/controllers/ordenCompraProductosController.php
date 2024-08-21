<?php

namespace app\controllers;

use app\models\mainModel;

class ordenCompraProductosController extends mainModel
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
   
    public function obtenerOpcionesOrdenCompra()
    {
        $consulta_orden_compra = "SELECT * FROM ordenes_compra ORDER BY numero_orden DESC";
        $datos_orden = $this->ejecutarConsulta($consulta_orden_compra);
        $opciones_ordenes = "";

        while ($orden_compra = $datos_orden->fetch()) {
            $opciones_ordenes .= '<option value="' . $orden_compra['id_orden_compra'] . '">'
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
    public function registrarOrdenCompraProductosControlador()
    {
        
    
# Almacenando datos#

$id_orden_compra = $_POST['id_orden_compra'];
#$numero_partida = $_POST['numero_partida'];#
$nombre_producto = $_POST['nombre_producto'];
$cantidad = $_POST['cantidad'];
$unidad_medida = $_POST['unidad_medida'];
$precio_sin_IVA = $_POST['precio_sin_IVA'];
$total = $_POST['total'];



# Verificando campos obligatorios #
if ($id_orden_compra == ""  || $nombre_producto == "" || $cantidad == "" || $precio_sin_IVA == "" || $total == "" || $unidad_medida == "" ) {
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
        "campo_nombre" => "id_orden_compra",
        "campo_marcador" => ":OrdenCompra",
        "campo_valor" => $id_orden_compra
    ],/*
    [
        "campo_nombre" => "numero_partida",
        "campo_marcador" => ":NumerPartida",
        "campo_valor" => $numero_partida
    ],*/
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

$registrar_orden_compra = $this->guardarDatos("detalle_orden_compra", $detalle_datos_reg);

if ($registrar_orden_compra->rowCount() == 1) {
    $alerta = [
    "tipo" => "limpiar",
    "titulo" => "Orden Registrada",
    "texto" => "La orden se registró con éxito",
    "icono" => "success"
];

} else {

    $alerta = [
        "tipo" => "simple",
        "titulo" => "Ocurrió un error inesperado",
        "texto" => "No se pudo registrar la orden, por favor intente nuevamente",
        "icono" => "error"
    ];
}

return json_encode($alerta);


    
    }

    
}