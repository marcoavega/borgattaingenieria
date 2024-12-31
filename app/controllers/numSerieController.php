<?php
namespace app\controllers;
//require_once "./app/views/libreriapdf/dompdf/autoload.inc.php";


use app\models\mainModel;

class numSerieController extends mainModel
{

   public function obtenerOpcionesNumLotes()
    {
        $consulta_lotes = "SELECT * FROM numeros_lote ORDER BY numero_lote";
        $datos_lotes = $this->ejecutarConsulta($consulta_lotes);
        $opciones_lotes = "";

        while ($lotes = $datos_lotes->fetch()) {
            $opciones_lotes .= '<option value="' . $lotes['id_numero_lote'] . '">'
                . $lotes['numero_lote'] . '</option>';
        }

        return $opciones_lotes;
    }


    public function obtenerOpcionesProductoFinal()
    {
        $consulta_productos = "SELECT * FROM productos_finales_venta ORDER BY id_productos_finales_venta";
        $datos_productos = $this->ejecutarConsulta($consulta_productos);
        $opciones_productos = "";

        while ($productos = $datos_productos->fetch()) {
            $opciones_productos .= '<option value="' . $productos['id_productos_finales_venta'] . '">
            '. $productos['nombre_producto_final_venta'] .' - 
            '. $productos['descripcion'] . '
            </option>
                ';
        }

        return $opciones_productos;
    }




    /*----------  Controlador registrar usuario  ----------*/
    public function registrarNumSerieControlador()
    {
        try {
            $id_producto = $this->limpiarCadena($_POST['id_p_f']);
            $id_numero_lote = $this->limpiarCadena($_POST['id_lote']);
            $cantidad_series = $this->limpiarCadena($_POST['cantidad_series']);
    
            if (empty($id_numero_lote) || empty($id_producto) || empty($cantidad_series)) {
                return json_encode([
                    "tipo" => "simple",
                    "titulo" => "Campos Incompletos",
                    "texto" => "Por favor, complete todos los campos requeridos",
                    "icono" => "warning"
                ]);
            }
    
            $cantidad_series = intval($cantidad_series);
            if ($cantidad_series < 1 || $cantidad_series > 100) {
                return json_encode([
                    "tipo" => "simple",
                    "titulo" => "Cantidad Inválida",
                    "texto" => "La cantidad debe estar entre 1 y 100",
                    "icono" => "warning"
                ]);
            }
    
            $producto_nombre = $this->obtenerNombreProducto($id_producto);
            if (!$producto_nombre) {
                return json_encode([
                    "tipo" => "simple",
                    "titulo" => "Error de Producto",
                    "texto" => "No se pudo obtener el nombre del producto",
                    "icono" => "error"
                ]);
            }
    
            $this->conectar()->beginTransaction();
            
            // Bloquear tabla para evitar race conditions
            $this->conectar()->exec('LOCK TABLES numeros_serie WRITE');
            
            $ultimoNumeroSerie = $this->obtenerUltimoNumeroSerie();
            $numerosGenerados = [];
            
            // Verificar duplicados antes de insertar
            for ($i = 1; $i <= $cantidad_series; $i++) {
                $nuevoNumero = $ultimoNumeroSerie + $i;
                $nuevoNumeroSerie = $producto_nombre . '-' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
                
                // Verificar si ya existe
                $stmt = $this->conectar()->prepare("SELECT COUNT(*) FROM numeros_serie WHERE numero_serie = ?");
                $stmt->execute([$nuevoNumeroSerie]);
                if ($stmt->fetchColumn() > 0) {
                    $this->conectar()->exec('UNLOCK TABLES');
                    $this->conectar()->rollBack();
                    return json_encode([
                        "tipo" => "simple",
                        "titulo" => "Error de Registro",
                        "texto" => "Número de serie duplicado detectado",
                        "icono" => "error"
                    ]);
                }
                
                $numerosGenerados[] = [
                    "numero" => $nuevoNumeroSerie,
                    "lote" => $id_numero_lote
                ];
            }
    
            // Insertar todos los números en una sola consulta
            $sql = "INSERT INTO numeros_serie (numero_serie, id_numero_lote) VALUES ";
            $values = [];
            $params = [];
            
            foreach ($numerosGenerados as $index => $num) {
                $values[] = "(?, ?)";
                $params[] = $num["numero"];
                $params[] = $num["lote"];
            }
            
            $sql .= implode(', ', $values);
            $stmt = $this->conectar()->prepare($sql);
            
            if (!$stmt->execute($params)) {
                $this->conectar()->exec('UNLOCK TABLES');
                $this->conectar()->rollBack();
                return json_encode([
                    "tipo" => "simple",
                    "titulo" => "Error de Registro",
                    "texto" => "Error al insertar los números de serie",
                    "icono" => "error"
                ]);
            }
    
            $this->conectar()->exec('UNLOCK TABLES');
            $this->conectar()->commit();
            
            return json_encode([
                "tipo" => "simple",
                "titulo" => "¡Registro Exitoso!",
                "texto" => "Se generaron " . count($numerosGenerados) . " números de serie correctamente",
                "icono" => "success"
            ]);
            
        } catch (\Exception $e) {
            if ($this->conectar()->inTransaction()) {
                $this->conectar()->exec('UNLOCK TABLES');
                $this->conectar()->rollBack();
            }
            
            return json_encode([
                "tipo" => "simple",
                "titulo" => "Error del Sistema",
                "texto" => "Ocurrió un error al procesar la solicitud",
                "icono" => "error"
            ]);
        }
    }
    
    private function obtenerNombreProducto($id_producto)
    {
        $consulta = "SELECT nombre_producto_final_venta FROM productos_finales_venta WHERE id_productos_finales_venta = :id";
        $stmt = $this->conectar()->prepare($consulta);
        $stmt->bindParam(':id', $id_producto, \PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado ? $resultado['nombre_producto_final_venta'] : false;
    }
    
    private function obtenerUltimoNumeroSerie()
    {
        // Modificado para obtener el último número global sin importar el producto
        $consulta_ultimo_numero = "SELECT MAX(CAST(SUBSTRING_INDEX(numero_serie, '-', -1) AS UNSIGNED)) AS ultimo_numero 
                                 FROM numeros_serie";
        $stmt = $this->conectar()->prepare($consulta_ultimo_numero);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado ? intval($resultado['ultimo_numero']) : 0;
    }

public function listarNumSerieControlador($busqueda)
{
    $busqueda = $this->limpiarCadena($busqueda);
    $tabla = "";

    // Consulta para obtener los números de serie correspondientes a los números de lote
    $consulta_datos = "
        SELECT 
            numeros_lote.numero_lote,
            numeros_serie.numero_serie,
            numeros_serie.fecha_registro,
            numeros_serie.aprobado,
            numeros_serie.id_numero_serie
        FROM 
            numeros_lote 
        LEFT JOIN 
            numeros_serie 
        ON 
            numeros_lote.id_numero_lote = numeros_serie.id_numero_lote 
        WHERE 
            numeros_lote.id_numero_lote = :busqueda;
    ";

    $stmt = $this->conectar()->prepare($consulta_datos);
    $stmt->bindParam(':busqueda', $busqueda, \PDO::PARAM_INT);
    $stmt->execute();
    $datos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    if (empty($datos)) {
        return "No se encontraron resultados.";
    }

    $numero_lote = $datos[0]['numero_lote'];

    $tabla = '
    <button class="btn btn-primary" onclick="imprimirArea(\'areaImprimir\', \'' . $numero_lote . '\')">Imprimir</button>
    <div id="areaImprimir">
    <div class="container-fluid">
    <div style="text-align: center; margin: 20px 0;">
            
        </div>

    <div class="invoice">

    <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding-left: 5px; padding-right: 5px;">
    <p style="font-size: 14px; text-align: center;"><strong>Números de Serie</strong></p>
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <div>
            <p style="font-size: 13px; padding: 0px; margin: 0px;"><strong>Número de Lote:</strong>' . $numero_lote . '</p>
        </div>
    </div>
    </div>
        
        <table class="table" style="width: 100%; padding-top: 2; font-size: 13px;">
            <thead>
                <tr>
                    <th style="text-align: center; border: 1px solid #000; padding: 5px;">Número de Serie</th>
                    <th style="text-align: center; border: 1px solid #000; padding: 5px;">Fecha de Registro</th>
                    <th style="text-align: center; border: 1px solid #000; padding: 5px;">Aprobado</th>
                </tr>
            </thead>
            <tbody>';

    foreach ($datos as $rows) {
        $checked = $rows['aprobado'] ? "checked" : "";
        $tabla .= '
        <tr>
            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['numero_serie'] . '</td>
            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['fecha_registro'] . '</td>
            <td style="text-align: center; border: 1px solid #000; padding: 5px;">
                <input type="checkbox" class="aprobar-checkbox" data-id="' . $rows['id_numero_serie'] . '" ' . $checked . '>
            </td>
        </tr>';
    }

    $tabla .= '
    <style>
    @media print {
        .sello-impresion {
            position: fixed;
            bottom: 50px;
            width: 100%;
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }
    }
    @media screen {
        .sello-impresion {
            display: none;
        }
    }
    </style>
    <div class="sello-impresion">Sello</div>
    ';

    $tabla .= '<script>
    function imprimirArea(id) {
        var contenido = document.getElementById(id).innerHTML;
        var ventanaImpresion = window.open("", "_blank");
        ventanaImpresion.document.write("<html><head><title>' . $numero_lote . '</title>");
        ventanaImpresion.document.write("<style>");
        ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
        ventanaImpresion.document.write("</style>");
        ventanaImpresion.document.write("</head><body>");
        ventanaImpresion.document.write(contenido);
        ventanaImpresion.document.write("</body></html>");
        ventanaImpresion.document.close();
        ventanaImpresion.print();
    }

    document.querySelectorAll(".aprobar-checkbox").forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            var id = this.getAttribute("data-id");
            var aprobado = this.checked ? 1 : 0;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "' . APP_URL . 'app/ajax/cambiarEstadoAprobadoAjax.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    alert(response.message);
                }
            };
            xhr.send("id_numero_serie=" + id + "&aprobado=" + aprobado);
        });
    });
    </script>';

    return $tabla;
}

public function cambiarEstadoAprobado($id_numero_serie, $aprobado)
{
    $consulta = "UPDATE numeros_serie SET aprobado = :aprobado WHERE id_numero_serie = :id_numero_serie";
    $stmt = $this->conectar()->prepare($consulta);
    $stmt->bindParam(':aprobado', $aprobado, \PDO::PARAM_BOOL);
    $stmt->bindParam(':id_numero_serie', $id_numero_serie, \PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return ["status" => "success", "message" => "Estado actualizado correctamente."];
    } else {
        return ["status" => "error", "message" => "No se pudo actualizar el estado."];
    }
}





}