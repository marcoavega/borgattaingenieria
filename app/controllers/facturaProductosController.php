<?php

namespace app\controllers;

use app\models\mainModel;

class facturaProductosController extends mainModel
{

    
    public function obtenerOpcionesProveedores()
    {
        $consulta_proveedores = "SELECT * FROM proveedores ORDER BY nombre_proveedor";
        $datos_proveedores = $this->ejecutarConsulta($consulta_proveedores);
        $opciones_proveedores = "";

        while ($proveedor = $datos_proveedores->fetch()) {
            $opciones_proveedores .= '<option value="' . $proveedor['id_proveedor'] . '">'
                . $proveedor['nombre_proveedor'] . '</option>';
        }

        return $opciones_proveedores;
    }
   
    public function obtenerOpcionesfactura()
    {
        $consulta_factura = "SELECT * FROM facturas ORDER BY num_factura";
        $datos_factura = $this->ejecutarConsulta($consulta_factura);
        $opciones_factura = "";

        while ($factura = $datos_factura->fetch()) {
            $opciones_factura .= '<option value="' . $factura['id_factura'] . '">'
                . $factura['num_factura'] . '</option>';
        }

        return $opciones_factura;
    }



public function obtenerOpcionesNombreProductos()
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


public function obtenerOpcionesCodigoProductos()
    {
        $consulta_codigo_productos = "SELECT * FROM productos ORDER BY id_producto";
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
        $consulta_unidades = "SELECT * FROM unidades_medida ORDER BY nombre_unidad";
        $datos_unidades = $this->ejecutarConsulta($consulta_unidades);
        $opciones_unidades = "";

        while ($unidad = $datos_unidades->fetch()) {
            $opciones_unidades .= '<option value="' . $unidad['id_unidad'] . '">'
                . $unidad['nombre_unidad'] . '</option>';
        }

        return $opciones_unidades;
    }


    /*----------  Controlador registrar usuario  ----------*/
    public function registrarFacturaProductosControlador()
    {
        
    
# Almacenando datos#

$id_factura = $_POST['id_factura'];
$precio_sin_IVA = $_POST['precio_sin_IVA'];
$total = $_POST['total'];



# Verificando campos obligatorios #
if ($id_factura == "" || $precio_sin_IVA == "" || $total == ""  ) {
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
        "campo_nombre" => "id_factura",
        "campo_marcador" => ":Factura",
        "campo_valor" => $id_factura
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

$registrar_factura = $this->guardarDatos("detalle_factura", $detalle_datos_reg);

if ($registrar_factura->rowCount() == 1) {
    $alerta = [
    "tipo" => "limpiar",
    "titulo" => "Factura Registrada",
    "texto" => "La factura se registró con éxito",
    "icono" => "success"
];

} else {

    $alerta = [
        "tipo" => "simple",
        "titulo" => "Ocurrió un error inesperado",
        "texto" => "No se pudo registrar la factura, por favor intente nuevamente",
        "icono" => "error"
    ];
}

return json_encode($alerta);


    
    }

    
}