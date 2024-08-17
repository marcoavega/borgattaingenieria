<?php

namespace app\controllers;

use app\models\mainModel;

class notaEntradaProductosController extends mainModel
{
    public function obtenerOpcionesOrdenCompra()
    {
        $consulta_ordenes = "SELECT numero_orden COLLATE utf8mb4_general_ci AS numero_orden, 'Gasto' AS tipo
                             FROM ordenes_gasto
                             UNION
                             SELECT numero_orden COLLATE utf8mb4_general_ci AS numero_orden, 'Compra' AS tipo
                             FROM ordenes_compra
                             ORDER BY numero_orden";
        $datos_ordenes = $this->ejecutarConsulta($consulta_ordenes);
        $opciones_ordenes = "";

        while ($orden = $datos_ordenes->fetch()) {
            $opciones_ordenes .= '<option value="' . $orden['numero_orden'] . '">' . $orden['numero_orden'] . ' (' . $orden['tipo'] . ')</option>';
        }

        return $opciones_ordenes;
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

    public function obtenerOpcionesNotas()
    {
        $consulta_notas = "SELECT * FROM notas_entrada ORDER BY numero_nota_entrada";
        $datos_notas = $this->ejecutarConsulta($consulta_notas);
        $opciones_notas = "";

        while ($nota = $datos_notas->fetch()) {
            $opciones_notas .= '<option value="' . $nota['id_nota_entrada'] . '">'
                . $nota['numero_nota_entrada'] . '</option>';
        }

        return $opciones_notas;
    }

    public function obtenerOpcionesProducto()
    {
        $consulta = "SELECT * FROM productos ORDER BY nombre_producto";
        $datos = $this->ejecutarConsulta($consulta);
        $opciones = "";

        while ($dato = $datos->fetch()) {
            $opciones .= '<option value="' . $dato['nombre_producto'] . '">
            '. $dato['id_producto'] . '-'. $dato['nombre_producto'] . '</option>';
        }

        return $opciones;
    }

    public function obtenerOpcionesProductoId()
    {
        $consulta = "SELECT * FROM productos ORDER BY nombre_producto";
        $datos = $this->ejecutarConsulta($consulta);
        $opciones = "";

        while ($dato = $datos->fetch()) {
            $opciones .= '<option value="' . $dato['id_producto'] . '">
            '. $dato['id_producto'] . '-'. $dato['nombre_producto'] . '</option>';
        }

        return $opciones;
    }




    public function registrarNotaEntradaProductosControlador()
    {
        # Almacenando datos #
        
        $id_nota_entrada = $_POST['id_nota_entrada'];
        $numero_orden = $_POST['numero_orden'];
        $numero_partida = $_POST['numero_partida'];
        $nombre_producto = $_POST['nombre_producto'];
        $id_producto = $_POST['id_producto'];
        $cantidad = $_POST['cantidad'];
        $unidad_medida = $_POST['unidad_medida'];
        $almacen = 1;

        # Verificando campos obligatorios #
        if ($numero_orden == "" || $numero_partida == "" || $nombre_producto == "" || $id_producto == "" || $cantidad == "" || $unidad_medida == "" || $id_nota_entrada == "") {
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
                "campo_nombre" => "id_nota_entrada",
                "campo_marcador" => ":IdNota",
                "campo_valor" => $id_nota_entrada
            ],
            [
                "campo_nombre" => "numero_orden",
                "campo_marcador" => ":NumeroOrden",
                "campo_valor" => $numero_orden
            ],
            [
                "campo_nombre" => "numero_partida",
                "campo_marcador" => ":NumeroPartida",
                "campo_valor" => $numero_partida
            ],
            [
                "campo_nombre" => "nombre_producto",
                "campo_marcador" => ":NombreProducto",
                "campo_valor" => $nombre_producto
            ],
            [
                "campo_nombre" => "id_producto",
                "campo_marcador" => ":IdProducto",
                "campo_valor" => $id_producto
            ],
            [
                "campo_nombre" => "cantidad",
                "campo_marcador" => ":Cantidad",
                "campo_valor" => $cantidad
            ],
            [
                "campo_nombre" => "id_unidad_medida",
                "campo_marcador" => ":IdUnidad",
                "campo_valor" => $unidad_medida
            ]
        ];

        $registrar_nota_entrada = $this->guardarDatos("detalle_nota_entrada", $detalle_datos_reg);
        if ($registrar_nota_entrada->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Nota Registrada",
                "texto" => "La nota se registró con éxito",
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


        // Verificando producto
        $datos = $this->ejecutarConsulta("SELECT * FROM productos WHERE id_producto='$id_producto'");
        if ($datos->rowCount() <= 0) {
            return json_encode([
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado el producto en el sistema",
                "icono" => "error"
            ]);
        } else {
            $datos = $datos->fetch();
            $stockActual = $datos['stock'];  // Stock actual del producto
        }
    
        // Actualizar el stock en la tabla de productos
        $stockFinal = $stockActual + $cantidad;
        $actualizarProducto = $this->ejecutarConsulta("UPDATE productos SET stock = '$stockFinal' WHERE id_producto='$id_producto'");
    
        // Actualizar el stock en la tabla stock_almacenes para el almacén general (id_almacen = 1)
        $datosAlmacen = $this->ejecutarConsulta("SELECT stock FROM stock_almacen WHERE id_producto='$id_producto' AND id_almacen = $almacen");
        if ($datosAlmacen->rowCount() > 0) {
            $filaAlmacen = $datosAlmacen->fetch();
            $stockAlmacenActual = $filaAlmacen['stock'];
            $stockAlmacenFinal = $stockAlmacenActual + $cantidad;
            $actualizarAlmacen = $this->ejecutarConsulta("UPDATE stock_almacen SET stock = '$stockAlmacenFinal' WHERE id_producto='$id_producto' AND id_almacen = $almacen");
        }
        if ($actualizarProducto && $actualizarAlmacen) {
            return json_encode([
                "tipo" => "recargar",
                "titulo" => "Producto actualizado",
                "texto" => "Los datos del producto se actualizaron correctamente",
                "icono" => "success"
            ]);
        } else {
            return json_encode([
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos podido actualizar los datos del producto, por favor intente nuevamente",
                "icono" => "error"
            ]);
        }

        if ($registrar_nota_entrada->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Nota Registrada",
                "texto" => "La nota se registró con éxito",
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
