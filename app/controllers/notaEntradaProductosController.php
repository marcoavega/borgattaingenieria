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
                             ORDER BY numero_orden DESC";
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
        $consulta_notas = "SELECT * FROM notas_entrada ORDER BY numero_nota_entrada DESC";
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
        $consulta = "SELECT * FROM productos ORDER BY id_producto";
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
        $consulta = "SELECT * FROM productos ORDER BY id_producto";
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
    $nombre_producto = $_POST['nombre_producto'];
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    $unidad_medida = $_POST['unidad_medida'];
    $almacen = 1;

    # Verificando campos obligatorios #
    if ($nombre_producto == "" || $id_producto == "" || $cantidad == "" || $unidad_medida == "" || $id_nota_entrada == "") {
        $alerta = [
            "tipo" => "simple",
            "titulo" => "Ocurrió un error inesperado",
            "texto" => "No has llenado todos los campos que son obligatorios",
            "icono" => "error"
        ];
        return json_encode($alerta);
        exit();
    }

    # Generando número de partida automáticamente #
    $consulta_ultima_partida = "SELECT MAX(numero_partida) as ultima_partida FROM detalle_nota_entrada WHERE id_nota_entrada = :id_nota_entrada";
    $stmt = $this->conectar()->prepare($consulta_ultima_partida);
    $stmt->execute([':id_nota_entrada' => $id_nota_entrada]);
    $resultado = $stmt->fetch();
    $numero_partida = ($resultado['ultima_partida'] ?? 0) + 1;

    $detalle_datos_reg = [
        [
            "campo_nombre" => "id_nota_entrada",
            "campo_marcador" => ":IdNota",
            "campo_valor" => $id_nota_entrada
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
    
    // Verificando producto y actualizando stock
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
    } else {
        // Si no existe el registro en stock_almacen, lo insertamos
        $actualizarAlmacen = $this->ejecutarConsulta("INSERT INTO stock_almacen (id_producto, id_almacen, stock) VALUES ('$id_producto', $almacen, $cantidad)");
    }

    if ($registrar_nota_entrada->rowCount() == 1 && $actualizarProducto && $actualizarAlmacen) {
        $alerta = [
            "tipo" => "recargar",
            "titulo" => "Producto Registrado y Stock Actualizado",
            "texto" => "El producto se agregó a la nota de entrada con éxito y el stock se actualizó correctamente",
            "icono" => "success"
        ];
    } else {
        $alerta = [
            "tipo" => "simple",
            "titulo" => "Ocurrió un error inesperado",
            "texto" => "No se pudo registrar el producto o actualizar el stock, por favor intente nuevamente",
            "icono" => "error"
        ];
    }

    return json_encode($alerta);
}
}
