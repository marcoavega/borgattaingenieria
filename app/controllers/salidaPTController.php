<?php
namespace app\controllers;

use app\models\mainModel;

class salidaPTController extends mainModel
{
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

    /* Método para obtener las opciones de salidas */
    public function obtenerOpcionesSalidas()
    {
        $consulta = "SELECT id_salida, numero_salida FROM salidas_producto_terminado";
        $stmt = $this->conectar()->prepare($consulta);
        $stmt->execute();
        $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $opciones = "";
        foreach ($resultados as $fila) {
            $opciones .= "<option value='{$fila['id_salida']}'>{$fila['numero_salida']}</option>";
        }
        return $opciones;
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


    public function registrarSalidaControlador()
    {
        // Generando número de salida automático
        $ultimoNumero = $this->obtenerUltimoNumero();
        $numero_salida = 'VS-' . str_pad($ultimoNumero + 1, 8, '0', STR_PAD_LEFT);

        // Almacenando datos
        $id_empleado = $this->limpiarCadena($_POST['id_empleado']);
        $receptor = $this->limpiarCadena($_POST['receptor']);
        $id_almacen_destino = $this->limpiarCadena($_POST['id_almacen_destino']);
       

        // Verificando campos obligatorios
        if (empty($id_empleado) || empty($receptor) || empty($id_almacen_destino)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        $datosRegistro = [
            [
                "campo_nombre" => "numero_salida",
                "campo_marcador" => ":NumeroSalida",
                "campo_valor" => $numero_salida
            ],
            [
                "campo_nombre" => "id_empleado",
                "campo_marcador" => ":IdEmpleado",
                "campo_valor" => $id_empleado
            ],
            [
                "campo_nombre" => "receptor",
                "campo_marcador" => ":Receptor",
                "campo_valor" => $receptor
            ],
            [
                "campo_nombre" => "id_almacen_destino",
                "campo_marcador" => ":Destino",
                "campo_valor" => $id_almacen_destino
            ]
        ];

        $registrar_salida = $this->guardarDatos("salidas_producto_terminado", $datosRegistro);

        if ($registrar_salida->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Éxito",
                "texto" => "El número de salida $numero_salida se registró con éxito",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar la salida, contacte con su administrador",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    private function obtenerUltimoNumero()
    {
        $consulta_ultimo_numero = "SELECT MAX(CAST(SUBSTRING(numero_salida, 4) AS UNSIGNED)) AS ultimo_numero FROM salidas_producto_terminado WHERE numero_salida LIKE 'VS-%'";
        $resultado = $this->ejecutarConsulta($consulta_ultimo_numero)->fetch();
        return $resultado ? intval($resultado['ultimo_numero']) : 0;
    }






   /* Método para listar las salidas */
   public function listarSalidaControlador($pagina, $registros, $url, $busqueda)
{
    $pagina = $this->limpiarCadena($pagina);
    $registros = $this->limpiarCadena($registros);
    $url = $this->limpiarCadena($url);
    $url = APP_URL . $url . "/";
    $busqueda = $this->limpiarCadena($busqueda);
    $tabla = "";

    // Consulta con JOIN para obtener los datos relevantes
    $consulta_datos = "
    SELECT 
        sp.numero_salida, 
        e.nombre_empleado, 
        sp.fecha_salida, 
        sp.receptor,
        dst.id_detalle_salida, 
        dst.id_numero_lote, 
        nl.numero_lote,
        dst.id_numero_serie, 
        ns.numero_serie,
        sp.id_almacen_destino,
        a.nombre_almacen,
        p.id_producto,
        p.codigo_producto,
        p.nombre_producto,
        dst.id_producto
    FROM 
        salidas_producto_terminado sp
    LEFT JOIN 
        detalle_salidas_producto_terminado dst ON sp.id_salida = dst.id_salida
    LEFT JOIN 
        empleados e ON sp.id_empleado = e.id_empleado
    LEFT JOIN 
        numeros_lote nl ON dst.id_numero_lote = nl.id_numero_lote
    LEFT JOIN 
        numeros_serie ns ON dst.id_numero_serie = ns.id_numero_serie
    LEFT JOIN 
        almacenes a ON sp.id_almacen_destino = a.id_almacen
    LEFT JOIN 
        productos p ON dst.id_producto = p.id_producto
    WHERE 
        sp.id_salida = :busqueda;
";

    $stmt = $this->conectar()->prepare($consulta_datos);
    $stmt->bindParam(':busqueda', $busqueda, \PDO::PARAM_INT);
    $stmt->execute();
    $datos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    if (empty($datos)) {
        return "No se encontraron resultados.";
    }

    $numero_salida = $datos[0]['numero_salida'];

    $tabla = '
    <button class="btn btn-primary" onclick="imprimirArea(\'areaImprimir\', \'' . $numero_salida . '\')">Imprimir</button>
    <div id="areaImprimir">
    <div class="container-fluid">
    <div style="text-align: center; margin: 20px 0;"></div>

    <div class="invoice">
        <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding-left: 5px; padding-right: 5px;">
            <p style="font-size: 14px; text-align: center;"><strong>Salida de Producto Terminado</strong></p>
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <img src="' . APP_URL . 'app/views/fotos/logo_orden.png" alt="logo" style="width:200px; height:auto;">
                <div>
                    <p style="font-size: 13px; padding: 0px; margin: 0px;"><strong>Salida de Producto Terminado:</strong>' . $numero_salida . '</p>
                    <p style="font-size: 13px; padding: 0px; margin: 0px;"><strong>Fecha:</strong> ' . date('d/m/Y', strtotime($datos[0]['fecha_salida'])) . '</p>
                    <p style="font-size: 13px; padding: 0px; margin: 0px;"><strong>Número de Orden:</strong> ' . $datos[0]['id_detalle_salida'] . '</p>
                    <p style="font-size: 13px; padding: 0px; margin: 0px;"><strong>Formato:</strong> FR-BI-ALM-06-02-1</p>
                </div>
            </div>
            <p style="margin-top: 0; margin-bottom: 0;">RADIOTECNOLOGÍA INDUSTRIAL S.A. DE C.V.</p>
            <p style="margin-top: 0; margin-bottom: 0;">RFC: RIN070219R38</p>
            <p style="margin-top: 0; margin-bottom: 0;">Calle Puebla Sur. Manzana 4. Lote 5 Nave B Int. 2 Col. Jardín Industrial</p>
            <p style="margin-top: 0; margin-bottom: 0;">Ixtapaluca. Edo. de México, C.P. 56535</p>
        </div>

        <div class="invoice-details" style="width: 100%; padding-top: 0%; font-size: 13px; margin: 0%;">
            <p style="text-align: left; border: 1px solid #000; margin-top: 0; margin-bottom: 0; padding: 2px; "><strong>Recibe:</strong> ' . $datos[0]['receptor'] . '</p>
            <p style="text-align: left; border: 1px solid #000; margin-top: 0; margin-bottom: 0; padding: 2px; "><strong>Almacén Destino:</strong> ' . $datos[0]['nombre_almacen'] . '</p>
        </div>

        <table class="table" style="width: 100%; padding-top: 2; font-size: 13px;">
            <thead>
                <tr>
                    <th style="text-align: center; border: 1px solid #000; padding: 5px;">Modelo</th>
                    <th style="text-align: center; border: 1px solid #000; padding: 5px;">Descripción</th>
                    <th style="text-align: center; border: 1px solid #000; padding: 5px;">Número de Lote</th>
                    <th style="text-align: center; border: 1px solid #000; padding: 5px;">Número de Serie</th>
                </tr>
            </thead>
            <tbody>';

    foreach ($datos as $rows) {
        $tabla .= '
        <tr>
            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['codigo_producto'] . '</td>
            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['nombre_producto'] . '</td>
            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['numero_lote'] . '</td>
            <td style="text-align: center; border: 1px solid #000; padding: 5px;">' . $rows['numero_serie'] . '</td>
        </tr>';
    }

    // Agregar los campos de firma
    $tabla .= '
    <tr>
        <td colspan="4" style="text-align: center; border: 1px solid #000; padding: 10px;">
            <div style="display: flex; justify-content: space-between;">
                <div>
                    <p style="padding-bottom: 20px;"><strong>Autoriza</strong></p>
                    <input type="text" style="width: 100%; border: none; border-bottom: 1px solid #000;" readonly>
                    <p><strong>Gerencia de Planta</strong></p>
                </div>
                <div>
                    <p style="padding-bottom: 20px;"><strong>Verifica y Aprueba</strong></p>
                    <input type="text" style="width: 100%; border: none; border-bottom: 1px solid #000;" readonly>
                    <p><strong>Aseguramiento de Calidad:</strong></p>
                </div>
                <div>
                    <p style="padding-bottom: 20px;"><strong>Recibe:</strong></p>
                    <input type="text" style="width: 100%; border: none; border-bottom: 1px solid #000;" readonly>
                    <p><strong>Nombre y firma</strong></p>
                </div>
            </div>

<div ">
               
                <div>
                    <div class="container" style="padding-top: 10px;">
                        <div class="row">
                            <div class="col-12">
                                <p class="text-start"><strong>Observaciones:</strong></p>
                            </div>
                        </div>
                    </div>
                    <input type="text" style="width: 100%; border: none; border-bottom: 1px solid #000;" readonly>
                </div>
                
            </div>

        </td>
    </tr>';

    // Agregar el texto de "Sello" que solo se verá en la impresión
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
        ventanaImpresion.document.write("<html><head><title>' . $datos[0]['numero_salida'] . '</title>");
        // Aquí puedes agregar tus estilos CSS
        ventanaImpresion.document.write("<style>");
        ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");

        ventanaImpresion.document.write("</style>");
        
        ventanaImpresion.document.write("</head><body>");
        ventanaImpresion.document.write(contenido);
        ventanaImpresion.document.write("</body></html>");
        ventanaImpresion.document.close();
        ventanaImpresion.print();
    }
    </script>';

    $tabla .= '</tbody></table>
        </div>
        </div></div></div>';

    return $tabla;
}


    
    

    

  

}
