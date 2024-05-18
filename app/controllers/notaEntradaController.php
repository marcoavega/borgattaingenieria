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
        $consulta_notas = "SELECT * FROM notas_entrada ORDER BY numero_nota_entrada";
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
        $numero_nota_entrada = 'NE-' . str_pad($ultimoNumeroOrden + 1, 3, '0', STR_PAD_LEFT);

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

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        $consulta_datos = "SELECT * FROM detalle_nota_entrada LIMIT 10;";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($datos)) {
            return "No se encontraron resultados.";
        }

        $tabla = '
        <button class="btn btn-primary" onclick="imprimirArea(\'areaImprimir\')">Imprimir</button>
        <div id="areaImprimir">
        <div class="container-fluid">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Número de Orden</th>
                    <th>Número de Partida</th>
                    <th>Nombre del Producto</th>
                    <th>Cantidad</th>
                    <th>ID Unidad de Medida</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($datos as $rows) {
            $tabla .= '
            <tr>
                <td>' . $rows['id_detalle_nota'] . '</td>
                <td>' . $rows['numero_orden'] . '</td>
                <td>' . $rows['numero_partida'] . '</td>
                <td>' . $rows['nombre_producto'] . '</td>
                <td>' . $rows['cantidad'] . '</td>
                <td>' . $rows['id_unidad_medida'] . '</td>
            </tr>';
        }

        $tabla .= '
            </tbody>
        </table>
        </div>
        </div>';


     
$ordenActual = '';
foreach ($datos as $rows) {
    if ($ordenActual !== $rows['numero_nota_entrada']) {
        if ($ordenActual !== '') {
            // Cierra la tabla anterior si no es la primera orden
            $tabla .= '</tbody>';
    
            $tabla .= '</table><hr>';
        }
        $ordenActual = $rows['numero_nota_entrada'];
        $tabla .= '
        <div class="invoice">
        <div style="display: flex; align-items: center;justify-content: space-between;">
            <img src="' . APP_URL . 'app/views/fotos/logo_orden.png" alt="logo" style="width:250px; height:auto; margin-right: 20px;">
            <div>
                <h5>Orden de Gasto: ' . $rows['numero_nota_entrada'] . '</h5>
                <p><strong>Fecha:</strong> ' . date('d/m/Y', strtotime($rows['fecha'])) . '</p>
            </div>
        </div>
        <div style="margin-top: 1px; margin-bottom: 10px;">
            <p style="margin-top: 0; margin-bottom: 0;">RADIOTECNOLOGÍA INDUSTRIAL S.A. DE C.V.</p>
            <p style="margin-top: 0; margin-bottom: 0;">RFC: RIN070219R38</p>
            <p style="margin-top: 0; margin-bottom: 0;">Calle Puebla Sur. Manzana 4. Lote 5 Nave B Int. 2 Col. Jardín Industrial</p>
            <p style="margin-top: 0; margin-bottom: 0;">Ixtapaluca. Edo. de México, C.P. 56535</p>
        </div>


    <table class="table" style="width: 100%; padding-top: 10;">
                <thead>
                    <tr>
                        <th style="text-align: center;">Partida</th>
                        <th style="text-align: center;">Producto</th>
                        <th style="text-align: center;">Cantidad</th>
                        <th style="text-align: center;">U.M.</th>
                        <th style="text-align: center;">Precio</th>
                        <th style="text-align: center;">Importe</th>
                    </tr>
                </thead>
                <tbody>';
    }
// Continúa 
$tabla .= '  
            <tr>
                <td style="text-align: center;">' . $rows['numero_partida'] . '</td>
                <td style="text-align: center;">' . $rows['nombre_producto'] . '</td>
                <td style="text-align: center;">' . $rows['cantidad'] . '</td>
                <td style="text-align: center;">' . $rows['nombre_unidad'] . '</td>
            </tr>
            ';
}
// Cierra la última tabla
if ($ordenActual !== '') {
    // Agrega la fila de totales
    $tabla .= '
    <tfoot>


<tr>
    <td colspan="6" style="text-align: right; white-space: nowrap;">
        <strong>Empleado que solicita:</strong> 
        <span style="margin-left: 20px;"></span>
        <div style="display: inline;">' . $rows['nombre_empleado'] . '</div>
    </td>
</tr>


</tfoot>

</div>

';
    $tabla .= '</tbody></table></div>';
}

$tabla .= '</div>';


$tabla .= '<script>


function imprimirArea(id) {
    var contenido = document.getElementById(id).innerHTML;
    var ventanaImpresion = window.open("", "_blank");
   
    
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



$tabla .= '
</div>';

        if ($total > 0 && $pagina <= $numeroPaginas) {
            $tabla .= '<nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center">';
            if ($pagina > 1) {
                $tabla .= '<li class="page-item"><a class="page-link" href="' . $url . ($pagina - 1) . '">Anterior</a></li>';
            }
            for ($i = 1; $i <= $numeroPaginas; $i++) {
                $tabla .= '<li class="page-item ' . ($i == $pagina ? 'active' : '') . '"><a class="page-link" href="' . $url . $i . '">' . $i . '</a></li>';
            }
            if ($pagina < $numeroPaginas) {
                $tabla .= '<li class="page-item"><a class="page-link" href="' . $url . ($pagina + 1) . '">Siguiente</a></li>';
            }
            $tabla .= '</ul>
            </nav>';
        }

        return $tabla;
        
    }

  

}
