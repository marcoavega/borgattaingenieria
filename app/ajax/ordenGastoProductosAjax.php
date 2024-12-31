<?php  
require_once "../../config/app.php"; 
require_once "../views/inc/session_start.php"; 
require_once "../../autoload.php";  

header('Content-Type: application/json');

use app\controllers\ordenGastoProductosController;   

try {
    if (isset($_POST['modulo_orden_gasto_productos'])) {     
        $insOrdenGastoProductos = new ordenGastoProductosController();      
        
        if ($_POST['modulo_orden_gasto_productos'] == "registrar") {         
            $resultado = $insOrdenGastoProductos->registrarOrdenGastoProductosControlador();
            
            // Ensure JSON is always returned
            if ($resultado === false) {
                echo json_encode([
                    'tipo' => 'simple',
                    'titulo' => 'Error',
                    'texto' => 'No se pudo procesar la solicitud',
                    'icono' => 'error'
                ]);
            } else {
                echo $resultado;
            }
        }  
    } else {     
        session_destroy();     
        header("Location: " . APP_URL . "login/"); 
    }
} catch (Exception $e) {
    // Log error and return JSON
    error_log($e->getMessage());
    echo json_encode([
        'tipo' => 'simple',
        'titulo' => 'Error del Servidor',
        'texto' => 'Ocurrió un error interno: ' . $e->getMessage(),
        'icono' => 'error'
    ]);
}
exit();
?>