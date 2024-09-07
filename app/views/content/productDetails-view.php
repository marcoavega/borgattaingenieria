<?php
// Asegúrate de que todas las clases necesarias estén importadas
use app\controllers\productController;

// Contenedor principal
?>
<div class="container-fluid">
    <div class="row">
       <!-- Menú lateral -->
       <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productList/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Lista de Productos
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Nuevo
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10">
            <div class="container py-4">
                <?php 
                // Obtiene el ID del producto a mostrar
                $id = $insLogin->limpiarCadena($url[1]);

                // Crea una instancia del controlador de productos
                $insProduct = new productController();

                // Obtiene los datos del producto
                $producto = $insProduct->obtenerDetallesProducto($id);

                // Comprueba si se obtuvieron los datos del producto
                if ($producto) {
                ?>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title">Detalles del Producto: <?php echo htmlspecialchars($producto['nombre_producto']); ?></h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Código:</strong> <?php echo htmlspecialchars($producto['codigo_producto']); ?></p>
                                        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($producto['nombre_producto']); ?></p>
                                        <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($producto['ubicacion']); ?></p>
                                        <p><strong>Precio:</strong> <?php echo number_format($producto['precio'], 2); ?></p>
                                        <p><strong>Categoría:</strong> <?php echo htmlspecialchars($producto['nombre_categoria']); ?></p>
                                        <p><strong>Subcategoría:</strong> <?php echo htmlspecialchars($producto['nombre_subcategoria']); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Proveedor:</strong> <?php echo htmlspecialchars($producto['nombre_proveedor']); ?></p>
                                        <p><strong>Unidad:</strong> <?php echo htmlspecialchars($producto['nombre_unidad']); ?></p>
                                        <p><strong>Moneda:</strong> <?php echo htmlspecialchars($producto['nombre_moneda']); ?></p>
                                        <p><strong>Fecha de Registro:</strong> <?php echo date('d/m/Y H:i', strtotime($producto['fecha_registro'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Nueva sección para el stock en almacenes -->
                        <div class="card mt-3">
                            <div class="card-header bg-info text-white">
                                <h4 class="card-title">Stock en Almacenes</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Almacén</th>
                                                <th>Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $almacenes = [
                                                'General' => 'stock_general',
                                                'Maquinados' => 'stock_maquinados',
                                                'Ensamble' => 'stock_ensamble',
                                                'Dental Trade' => 'stock_dental',
                                                'Terminado' => 'stock_terminado',
                                                'RT Producto Terminado' => 'stock_rtproducto',
                                                'Ventas' => 'stock_ventas',
                                                'Descarte Terminado' => 'stock_descarte_terminado',
                                                'Descarte Desgaste' => 'stock_descarte_desgaste'
                                            ];
                                            foreach ($almacenes as $nombre => $campo) {
                                                echo "<tr>
                                                    <td>{$nombre}</td>
                                                    <td>" . (isset($producto[$campo]) ? $producto[$campo] : '0') . "</td>
                                                </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h4 class="card-title">Imagen del Producto</h4>
                            </div>
                            <div class="card-body text-center">
                                <?php
                                if (!empty($producto['url_imagen'])) {
                                    $rutaImagen = APP_URL . 'app/views/img/img/' . $producto['url_imagen'];
                                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . parse_url($rutaImagen, PHP_URL_PATH))) {
                                        echo '<img src="' . $rutaImagen . '" alt="Imagen del producto" class="img-fluid">';
                                    } else {
                                        echo '<p>La imagen no se encuentra en el servidor.</p>';
                                        echo '<p>Ruta de la imagen: ' . $rutaImagen . '</p>';
                                    }
                                } else {
                                    echo '<p>No hay imagen disponible para este producto.</p>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header bg-secondary text-white">
                                <h4 class="card-title">Acciones</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center">
                                    <?php
                                    $actions = [
                                        ['url' => 'productPhoto', 'text' => 'Foto', 'class' => 'btn-warning'],
                                        ['url' => 'productUpdate', 'text' => 'Actualizar', 'class' => 'btn-success'],
                                        ['url' => 'productEntrance', 'text' => 'Entrada', 'class' => 'btn-light'],
                                        ['url' => 'movUpdate', 'text' => 'Movimiento Entre Almacenes', 'class' => 'btn-info'],
                                        ['url' => 'descInventory', 'text' => 'Descontar', 'class' => 'btn-danger']
                                    ];

                                    foreach ($actions as $action) {
                                        echo '<a href="' . APP_URL . $action['url'] . '/' . $producto['id_producto'] . '/" class="btn ' . $action['class'] . ' btn-sm w-100 mb-2 rounded">' . $action['text'] . '</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                } else {
                    // Si no se obtuvieron los datos del producto, muestra un mensaje de error
                    include "./app/views/inc/error_alert.php";
                }
                ?>
            </div>
        </div>
    </div>
</div>
Last edited just now


