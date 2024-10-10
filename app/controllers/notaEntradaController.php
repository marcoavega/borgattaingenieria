<?php
namespace app\controllers;
//require_once "./app/views/libreriapdf/dompdf/autoload.inc.php";


use app\models\mainModel;

class notaEntradaController extends mainModel
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

    public function obtenerOpcionesOrdenCompra()
{
    $consulta_ordenes = "SELECT id_orden_gasto AS id, numero_orden, 'Gasto' AS tipo
                         FROM ordenes_gasto
                         UNION
                         SELECT id_orden_compra AS id, numero_orden, 'Compra' AS tipo
                         FROM ordenes_compra
                         ORDER BY numero_orden";
    $datos_ordenes = $this->ejecutarConsulta($consulta_ordenes);
    $opciones_ordenes = "";

    while ($orden = $datos_ordenes->fetch()) {
        $opciones_ordenes .= '<option value="' . $orden['id'] . '">' . $orden['numero_orden'] . ' (' . $orden['tipo'] . ')</option>';
    }

    return $opciones_ordenes;
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
    
    /*----------  Controlador registrar usuario  ----------*/
    public function registrarNotaEntradaControlador()
    {
        # Generando número de orden automático
        /*$ultimoNumeroOrden = $this->obtenerUltimoNumeroOrden();
        $numero_orden = 'ROC-' . str_pad($ultimoNumeroOrden + 1, 3, '0', STR_PAD_LEFT);
    */

        // Generando número de orden automático
        $ultimoNumeroOrden = $this->obtenerUltimoNumeroOrden();
        $numero_nota_entrada = 'NE-' . str_pad($ultimoNumeroOrden + 1, 8, '0', STR_PAD_LEFT);

        # Almacenando datos
        $id_proveedor = $_POST['id_proveedor'];
        $id_empleado = $this->limpiarCadena($_POST['id_empleado']);

        # Verificando campos obligatorios
        if ($id_proveedor == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        $nota_entrada_datos_reg = [
            [
                "campo_nombre" => "numero_nota_entrada",
                "campo_marcador" => ":NumeroNota",
                "campo_valor" => $numero_nota_entrada
            ],
            [
                "campo_nombre" => "id_proveedor",
                "campo_marcador" => ":IdProveedor",
                "campo_valor" => $id_proveedor
            ],
            [
                "campo_nombre" => "id_empleado",
                "campo_marcador" => ":IdEmpleado",
                "campo_valor" => $id_empleado
            ]
        ];

        $registrar_nota_entrada = $this->guardarDatos("notas_entrada", $nota_entrada_datos_reg);

        if ($registrar_nota_entrada->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Nota de Entrada registrada",
                "texto" => "La nota de entrada $numero_nota_entrada se registró con éxito",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar la nota de entrada, contacte con su administrador",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    private function obtenerUltimoNumeroOrden()
    {
        $consulta_ultimo_numero = "SELECT MAX(SUBSTRING(numero_nota_entrada, 5)) AS ultimo_numero FROM notas_entrada";
        $resultado = $this->ejecutarConsulta($consulta_ultimo_numero)->fetch();
        return $resultado ? intval($resultado['ultimo_numero']) : 0;
    }


    /*----------  Controlador listar productos  ----------*/
    public function listarNotaControlador($pagina, $registros, $url, $busqueda)
    {
        $pagina = $this->limpiarCadena($pagina);
        $registros = $this->limpiarCadena($registros);
        $url = $this->limpiarCadena($url);
        $url = APP_URL . $url . "/";
        $busqueda = $this->limpiarCadena($busqueda);
        $tabla = "";
    
        $consulta_datos = "
            SELECT 
                notas_entrada.id_nota_entrada, 
                notas_entrada.numero_nota_entrada, 
                proveedores.nombre_proveedor, 
                empleados.nombre_empleado, 
                notas_entrada.fecha, 
                detalle_nota_entrada.id_detalle_nota, 
                detalle_nota_entrada.numero_orden, 
                detalle_nota_entrada.nombre_producto, 
                detalle_nota_entrada.cantidad, 
                unidades_medida.nombre_unidad
            FROM 
                notas_entrada 
            LEFT JOIN 
                detalle_nota_entrada ON notas_entrada.id_nota_entrada = detalle_nota_entrada.id_nota_entrada 
            LEFT JOIN 
                proveedores ON notas_entrada.id_proveedor = proveedores.id_proveedor 
            LEFT JOIN 
                empleados ON notas_entrada.id_empleado = empleados.id_empleado 
            LEFT JOIN 
                unidades_medida ON detalle_nota_entrada.id_unidad_medida = unidades_medida.id_unidad 
            WHERE 
                notas_entrada.id_nota_entrada = :busqueda
            ORDER BY
                detalle_nota_entrada.id_detalle_nota
        ";
    
        $stmt = $this->conectar()->prepare($consulta_datos);
        $stmt->bindParam(':busqueda', $busqueda, \PDO::PARAM_INT);
        $stmt->execute();
        $datos = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
        if (empty($datos)) {
            return "No se encontraron resultados.";
        }
    
        $numero_nota_entrada = $datos[0]['numero_nota_entrada'];
    
        $tabla .= '
        <button class="btn btn-primary" onclick="imprimirArea(\'areaImprimir\')">Imprimir</button>
        <div id="areaImprimir">
            <div class="container-fluid">
                <div class="invoice">
                    <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding: 5px;">
                        <p style="font-size: 14px; text-align: center;"><strong>Nota de Entrada</strong></p>
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <img src="' . APP_URL . 'app/views/fotos/logo_orden.png" alt="logo" style="width:200px; height:auto;">
                            <div>
                                <p style="font-size: 13px; margin: 0;"><strong>Nota de Entrada:</strong> ' . $numero_nota_entrada . '</p>
                                <p style="font-size: 13px; margin: 0;"><strong>Fecha:</strong> ' . date('d/m/Y', strtotime($datos[0]['fecha'])) . '</p>
                                <p style="font-size: 13px; margin: 0;"><strong>Número de Orden:</strong> ' . $datos[0]['numero_orden'] . '</p>
                                <p style="font-size: 13px; margin: 0;"><strong>Formato:</strong> PR-12-F03</p>
                            </div>
                        </div>
                        <p style="margin: 0;">RADIOTECNOLOGÍA INDUSTRIAL S.A. DE C.V.</p>
                        <p style="margin: 0;">RFC: RIN070219R38</p>
                        <p style="margin: 0;">Calle Puebla Sur. Manzana 4. Lote 5 Nave B Int. 2 Col. Jardín Industrial</p>
                        <p style="margin: 0;">Ixtapaluca. Edo. de México, C.P. 56535</p>
                    </div>
                    
                    <div class="invoice-details" style="width: 100%; font-size: 13px; margin: 0;">
                        <p style="text-align: left; border: 1px solid #000; margin: 0; padding: 2px;"><strong>Proveedor:</strong> ' . $datos[0]['nombre_proveedor'] . '</p>
                        <p style="text-align: left; border: 1px solid #000; margin: 0; padding: 2px;"><strong>Recibe:</strong> ' . $datos[0]['nombre_empleado'] . '</p>
                    </div>
    
                    <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Partida</th>
                                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Producto</th>
                                <th style="text-align: center; border: 1px solid #000; padding: 5px;">Cantidad</th>
                                <th style="text-align: center; border: 1px solid #000; padding: 5px;">U.M.</th>
                            </tr>
                        </thead>
                        <tbody>';
    
        foreach ($datos as $index => $rows) {
            $tabla .= '
            <tr class="partida-row">
                <td style="text-align: center; border: 1px solid #000; padding: 5px;" class="numero-partida">' . ($index + 1) . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['nombre_producto'] . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['cantidad'] . '</td>
                <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['nombre_unidad'] . '</td>
            </tr>';
        }
    
        $tabla .= '
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
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
            .btn-primary { display: none; }
        }
        @media screen {
            .sello-impresion { display: none; }
        }
        </style>
        <div class="sello-impresion">Sello</div>
    
        <script>
        function numerarPartidas() {
            var rows = document.querySelectorAll(".partida-row");
            rows.forEach((row, index) => {
                row.querySelector(".numero-partida").textContent = index + 1;
            });
        }
    
        numerarPartidas();
    
        function imprimirArea(id) {
            var contenido = document.getElementById(id).innerHTML;
            var ventanaImpresion = window.open("", "_blank");
            ventanaImpresion.document.write("<html><head><title>' . $numero_nota_entrada . '</title>");
            ventanaImpresion.document.write("<style>");
            ventanaImpresion.document.write("body { font-family: Arial, sans-serif; }");
            ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; }");
            ventanaImpresion.document.write("th, td { border: 1px solid black; padding: 5px; text-align: center; }");
            ventanaImpresion.document.write(".sello-impresion { position: fixed; bottom: 50px; width: 100%; text-align: center; font-weight: bold; font-size: 13px; }");
            ventanaImpresion.document.write("</style>");
            ventanaImpresion.document.write("</head><body>");
            ventanaImpresion.document.write(contenido);
            ventanaImpresion.document.write("<div class=\'sello-impresion\'>Sello</div>");
            ventanaImpresion.document.write("</body></html>");
            ventanaImpresion.document.close();
            setTimeout(function() {
                ventanaImpresion.print();
                ventanaImpresion.close();
            }, 250);
        }
        </script>';
    
        return $tabla;
    }
    
  

}
