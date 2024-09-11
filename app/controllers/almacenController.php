<?php

namespace app\controllers;
use app\models\mainModel;

class almacenController extends mainModel {


	public function registrarAlmacenControlador(){
    $nombre = $this->limpiarCadena($_POST['nombre_almacen']);

    if($nombre == ""){
        return json_encode([
            "tipo" => "simple",
            "titulo" => "Campo vacío",
            "texto" => "El nombre del almacén es obligatorio",
            "icono" => "error"
        ]);
    }

    $almacen_datos_reg = [
        [
            "campo_nombre" => "nombre_almacen",
            "campo_marcador" => ":Nombre",
            "campo_valor" => $nombre
        ]
    ];

    $debug_info = ["pasos" => []];

    // Registrar el almacén
    $almacenResult = $this->guardarDatos2("almacenes", $almacen_datos_reg);
    $debug_info["pasos"][] = "Registro de almacén: " . ($almacenResult['success'] ? "Exitoso" : "Fallido");

    if ($almacenResult['success']) {
        $id_almacen_recien_insertado = $almacenResult['lastInsertId'];
        $debug_info["id_nuevo_almacen"] = $id_almacen_recien_insertado;

        // Contar productos existentes
        $count_productos = $this->ejecutarConsulta("SELECT COUNT(*) as total FROM productos");
        $total_productos = $count_productos->fetch()['total'];
        $debug_info["total_productos"] = $total_productos;

        // Procesar por lotes
        $batch_size = 100; // Ajusta este número según sea necesario
        $offset = 0;
        $total_insertados = 0;

        while ($offset < $total_productos) {
            $query = "INSERT INTO stock_almacen (id_producto, id_almacen, stock)
                      SELECT id_producto, $id_almacen_recien_insertado, 0
                      FROM productos
                      LIMIT $offset, $batch_size
                      ON DUPLICATE KEY UPDATE stock = 0";
            
            $resultado = $this->ejecutarConsulta($query);
            
            if ($resultado !== false) {
                $total_insertados += $resultado->rowCount();
            } else {
                $debug_info["pasos"][] = "Error en lote, offset: $offset";
                break;
            }

            $offset += $batch_size;
        }

        $debug_info["total_insertados"] = $total_insertados;

        if ($total_insertados > 0) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Almacén registrado",
                "texto" => "El almacén $nombre se registró y se agregó o actualizó para $total_insertados productos",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error en inserción/actualización",
                "texto" => "No se pudieron agregar o actualizar los productos para el nuevo almacén",
                "icono" => "error"
            ];
        }
    } else {
        $alerta = [
            "tipo" => "simple",
            "titulo" => "Error de registro",
            "texto" => "No se pudo registrar el almacén: " . $almacenResult['error'],
            "icono" => "error"
        ];
    }

    $alerta["debug_info"] = $debug_info;
    return json_encode($alerta);
}


    /*----------  Controlador eliminar almacén  ----------*/
    public function eliminarAlmacenControlador(){
        $id = $this->limpiarCadena($_POST['id_almacen']);

        # Verificando almacén
        $check_almacen = $this->ejecutarConsulta("SELECT * FROM almacenes WHERE id_almacen='$id'");
        if($check_almacen->rowCount() <= 0){
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El almacén que intenta eliminar no existe en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $datos = $check_almacen->fetch();
        }

        # Verificando productos en almacén
        $check_productos = $this->ejecutarConsulta("SELECT id_producto FROM stock_almacen WHERE id_almacen='$id' AND stock > 0 LIMIT 1");
        if($check_productos->rowCount() > 0){
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No podemos eliminar el almacén debido a que tiene productos con stock",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Eliminando almacén
        $eliminarAlmacen = $this->eliminarRegistro("almacenes", "id_almacen", $id);

        if($eliminarAlmacen->rowCount() == 1){
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Almacén eliminado",
                "texto" => "El almacén " . $datos['nombre_almacen'] . " ha sido eliminado del sistema correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos podido eliminar el almacén " . $datos['nombre_almacen'] . " del sistema, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }


    public function actualizarAlmacenControlador(){
        // Obtener y limpiar el ID del almacén
        $id = $this->limpiarCadena($_POST['id_almacen']);
    
        // Verificar si el almacén existe
        $check_almacen = $this->ejecutarConsulta("SELECT * FROM almacenes WHERE id_almacen='$id'");
        if($check_almacen->rowCount() <= 0){
            return json_encode([
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado el almacén en el sistema",
                "icono" => "error"
            ]);
        }
        $datos = $check_almacen->fetch();
    
        // Obtener y limpiar el nuevo nombre del almacén
        $nombre = $this->limpiarCadena($_POST['nombre_almacen']);
    
        // Verificar que el nombre no esté vacío
        if($nombre == ""){
            return json_encode([
                "tipo" => "simple",
                "titulo" => "Campo vacío",
                "texto" => "El nombre del almacén es obligatorio",
                "icono" => "error"
            ]);
        }
    
        // Verificar el formato del nombre
        if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{3,100}", $nombre)){
            return json_encode([
                "tipo" => "simple",
                "titulo" => "Formato incorrecto",
                "texto" => "El nombre del almacén no cumple con el formato requerido",
                "icono" => "error"
            ]);
        }
    
        // Verificar si el nuevo nombre ya existe (solo si ha cambiado)
        if($nombre != $datos['nombre_almacen']){
            $check_nombre = $this->ejecutarConsulta("SELECT nombre_almacen FROM almacenes WHERE nombre_almacen='$nombre' AND id_almacen != '$id'");
            if($check_nombre->rowCount() > 0){
                return json_encode([
                    "tipo" => "simple",
                    "titulo" => "Nombre duplicado",
                    "texto" => "El nombre ingresado ya está en uso por otro almacén",
                    "icono" => "error"
                ]);
            }
        }
    
        // Preparar los datos para la actualización
        $almacen_datos_up = [
            [
                "campo_nombre" => "nombre_almacen",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $nombre
            ]
        ];
    
        $condicion = [
            "condicion_campo" => "id_almacen",
            "condicion_marcador" => ":ID",
            "condicion_valor" => $id
        ];
    
        // Intentar actualizar el almacén
        if($this->actualizarDatos("almacenes", $almacen_datos_up, $condicion)){
            return json_encode([
                "tipo" => "recargar",
                "titulo" => "Almacén actualizado",
                "texto" => "Los datos del almacén se actualizaron correctamente",
                "icono" => "success"
            ]);
        } else {
            return json_encode([
                "tipo" => "simple",
                "titulo" => "Error en la actualización",
                "texto" => "No se pudo actualizar el almacén. Por favor, intente nuevamente",
                "icono" => "error"
            ]);
        }
    }


    public function listarAlmacenesControlador($pagina, $registros, $url, $busqueda){

        $pagina = $this->limpiarCadena($pagina);
        $registros = $this->limpiarCadena($registros);
        $url = $this->limpiarCadena($url);
        $url = APP_URL.$url."/";
        $busqueda = $this->limpiarCadena($busqueda);
        $tabla = "";
    
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
    
        if(isset($busqueda) && $busqueda != ""){
            $consulta_datos = "SELECT * FROM almacenes WHERE nombre_almacen LIKE '%$busqueda%' ORDER BY nombre_almacen ASC LIMIT $inicio,$registros";
            $consulta_total = "SELECT COUNT(id_almacen) FROM almacenes WHERE nombre_almacen LIKE '%$busqueda%'";
        } else {
            $consulta_datos = "SELECT * FROM almacenes ORDER BY nombre_almacen ASC LIMIT $inicio,$registros";
            $consulta_total = "SELECT COUNT(id_almacen) FROM almacenes";
        }
    
        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();
    
        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int) $total->fetchColumn();
    
        $numeroPaginas = ceil($total / $registros);
    
        $tabla .= '
        <div class="container-fluid">
        <div class="row">
            <!-- Menú lateral -->
            <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'almacenList/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Lista de Almacenes
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="' . APP_URL . 'almacenNew/" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Registrar Nuevo Almacén
                        </a>
                    </li>
                </ul>
                <hr>
            </div>
    
            <!-- Contenido principal -->
            <div class="col-12 col-md-9 col-lg-10">
                <div class="container-fluid mb-4">
                    <h4 class="text-center">Almacenes</h4>
                    <h5 class="lead text-center">Lista de almacenes</h5>
                </div>
    
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="table-primary text-center">
                                <th>#</th>
                                <th>Nombre del Almacén</th>
                                <th colspan="2">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>';
    
        if($total >= 1 && $pagina <= $numeroPaginas){
            $contador = $inicio + 1;
            $pag_inicio = $inicio + 1;
            foreach($datos as $rows){
                $tabla .= '
                    <tr class="text-center">
                        <td>'.$contador.'</td>
                        <td>'.$rows['nombre_almacen'].'</td>
                        <td>
                            <a href="'.APP_URL.'almacenUpdate/'.$rows['id_almacen'].'/" class="btn btn-info btn-sm">Actualizar</a>
                        </td>
                        <td>
                            <form class="FormularioAjax" action="'.APP_URL.'app/ajax/almacenAjax.php" method="POST" autocomplete="off">
                                <input type="hidden" name="modulo_almacen" value="eliminar">
                                <input type="hidden" name="id_almacen" value="'.$rows['id_almacen'].'">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                ';
                $contador++;
            }
            $pag_final = $contador - 1;
        } else {
            if($total >= 1){
                $tabla .= '
                    <tr class="text-center">
                        <td colspan="4">
                            <a href="'.$url.'1/" class="btn btn-link mt-4 mb-4">
                                Haga clic acá para recargar el listado
                            </a>
                        </td>
                    </tr>
                ';
            } else {
                $tabla .= '
                    <tr class="text-center">
                        <td colspan="4">
                            No hay registros en el sistema
                        </td>
                    </tr>
                ';
            }
        }
    
        $tabla .= '</tbody></table>
                </div>
            </div>
        </div>
        </div>';
    
        return $tabla;
    }


    /*----------  Controlador detalles del almacén  ----------*/
    public function detallesAlmacenControlador($id){
        $id = $this->limpiarCadena($id);

        $check_almacen = $this->ejecutarConsulta("SELECT * FROM almacenes WHERE id_almacen='$id'");
        if($check_almacen->rowCount() <= 0){
            return "El almacén no existe en el sistema";
        } else {
            $datos = $check_almacen->fetch();

            $productos = $this->ejecutarConsulta("
                SELECT p.nombre_producto, sa.stock 
                FROM stock_almacen sa
                JOIN productos p ON sa.id_producto = p.id_producto
                WHERE sa.id_almacen = '$id'
                ORDER BY p.nombre_producto ASC
            ");

            $tabla = '
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="table-primary text-center">
                            <th>Producto</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
            ';

            while($row = $productos->fetch()){
                $tabla .= '
                    <tr>
                        <td>'.$row['nombre_producto'].'</td>
                        <td class="text-center">'.$row['stock'].'</td>
                    </tr>
                ';
            }

            $tabla .= '</tbody></table></div>';

            return "
                <h2>Detalles del Almacén: ".$datos['nombre_almacen']."</h2>
                <p>ID: ".$datos['id_almacen']."</p>
                <h3>Productos en este almacén:</h3>
                ".$tabla;
        }
    }

    /*----------  Controlador buscar almacén  ----------*/
    public function buscarAlmacenControlador(){
        $busqueda = $this->limpiarCadena($_POST['busqueda']);

        if(empty($busqueda)){
            return "Ingrese un término de búsqueda";
        }

        $consulta = "SELECT * FROM almacenes WHERE nombre_almacen LIKE '%$busqueda%' ORDER BY nombre_almacen ASC";
        $conexion = $this->conectar();
        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        $tabla = "";
        if(count($datos) > 0){
            $tabla .= "<table class='table table-hover table-bordered table-sm'>";
            $tabla .= "<thead><tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr></thead>";
            $tabla .= "<tbody>";
            foreach($datos as $row){
                $tabla .= "<tr>";
                $tabla .= "<td>".$row['id_almacen']."</td>";
                $tabla .= "<td>".$row['nombre_almacen']."</td>";
                $tabla .= "<td>
                    <a href='".APP_URL."almacenUpdate/".$row['id_almacen']."/' class='btn btn-success btn-sm'>Actualizar</a>
                    <a href='".APP_URL."almacenDetails/".$row['id_almacen']."/' class='btn btn-info btn-sm'>Detalles</a>
                </td>";
                $tabla .= "</tr>";
            }
            $tabla .= "</tbody></table>";
        } else {
            $tabla = "<p class='text-center'>No se encontraron resultados</p>";
        }

        return $tabla;
    }




}