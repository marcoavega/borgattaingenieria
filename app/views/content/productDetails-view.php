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
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#home" />
                        </svg>
                        Lista de Productos
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#home" />
                        </svg>
                        Registrar Nuevo
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productInvent/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#home" />
                        </svg>
                        Inventario
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10">
            <div class="container py-4">
                <?php
                // Incluye el botón de regreso
                include "./app/views/inc/btn_back2.php";
                ?>
                <?php
                // Obtiene el ID del producto a mostrar
                $id = $insLogin->limpiarCadena($url[1]);

                // Crea una instancia del controlador de productos
                $insProduct = new productController();

                // Obtiene los datos del producto
                $producto = $insProduct->obtenerDetallesProductoConAlmacenes($id);

                // Comprueba si se obtuvieron los datos del producto
                if ($producto) {
                ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="card-title">Detalles del Producto: <?php echo htmlspecialchars($producto['nombre_producto']); ?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <!-- Imagen del producto -->
                                            <?php
                                            if (!empty($producto['url_imagen'])) {
                                                $rutaImagen = APP_URL . 'app/views/img/img/' . $producto['url_imagen'];
                                                if (file_exists($_SERVER['DOCUMENT_ROOT'] . parse_url($rutaImagen, PHP_URL_PATH))) {
                                                    echo '<img src="' . $rutaImagen . '" alt="Imagen del producto" class="img-fluid mb-3">';
                                                } else {
                                                    echo '<p class="text-muted">Imagen no disponible</p>';
                                                }
                                            } else {
                                                echo '<p class="text-muted">Sin imagen</p>';
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Código:</strong> <?php echo htmlspecialchars($producto['codigo_producto']); ?></p>
                                                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($producto['nombre_producto']); ?></p>
                                                    <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($producto['ubicacion']); ?></p>
                                                    <p><strong>Stock Deseado:</strong> <?php echo htmlspecialchars($producto['stock_deseado']); ?></p>
                                                    <p><strong>Precio de Compra:</strong> <?php echo number_format($producto['precio'], 2); ?></p>
                                                    <p><strong>Precio de Venta:</strong> <?php echo number_format($producto['precio_venta'], 2); ?></p>
                                                    <p><strong>Categoría:</strong> <?php echo htmlspecialchars($producto['nombre_categoria']); ?></p>
                                                    <p><strong>Subcategoría:</strong> <?php echo htmlspecialchars($producto['nombre_subcategoria']); ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Proveedor:</strong> <?php echo htmlspecialchars($producto['nombre_proveedor']); ?></p>
                                                    <p><strong>Unidad:</strong> <?php echo htmlspecialchars($producto['nombre_unidad']); ?></p>
                                                    <p><strong>Moneda:</strong> <?php echo htmlspecialchars($producto['nombre_moneda']); ?></p>
                                                    <p><strong>Fecha de Registro:</strong> <?php echo date('d/m/Y H:i', strtotime($producto['fecha_registro'])); ?></p>
                                                    <?php if ($producto['peso'] !== null): ?>
    <p><strong>Peso (Kg.):</strong> <?php echo number_format($producto['peso'], 4); ?></p>
<?php endif; ?>
<?php if ($producto['altura'] !== null): ?>
    <p><strong>Altura:</strong> <?php echo number_format($producto['altura'], 4); ?> M (<?php echo number_format($producto['altura'] * 39.3701, 4); ?> in)</p>
<?php endif; ?>
<?php if ($producto['largo'] !== null): ?>
    <p><strong>Largo:</strong> <?php echo number_format($producto['largo'], 4); ?> M (<?php echo number_format($producto['largo'] * 39.3701, 4); ?> in)</p>
<?php endif; ?>
<?php if ($producto['ancho'] !== null): ?>
    <p><strong>Ancho:</strong> <?php echo number_format($producto['ancho'], 4); ?> M (<?php echo number_format($producto['ancho'] * 39.3701, 4); ?> in)</p>
<?php endif; ?>
<?php if ($producto['diametro'] !== null): ?>
    <p><strong>Diámetro:</strong> <?php echo number_format($producto['diametro'], 4); ?> M (<?php echo number_format($producto['diametro'] * 39.3701, 4); ?> in)</p>
<?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de acción en horizontal -->
                            <div class="card mt-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <?php
                                        $actions = [
                                            ['url' => 'productPhoto', 'text' => 'Foto', 'class' => 'btn-warning'],
                                            ['url' => 'productUpdate', 'text' => 'Actualizar', 'class' => 'btn-success'],
                                            ['url' => 'productEntrance', 'text' => 'Entrada', 'class' => 'btn-light'],
                                            ['url' => 'movUpdate', 'text' => 'Movimiento Entre Almacenes', 'class' => 'btn-info'],
                                            ['url' => 'descInventory', 'text' => 'Descontar', 'class' => 'btn-danger']
                                        ];

                                        foreach ($actions as $action) {
                                            echo '<a href="' . APP_URL . $action['url'] . '/' . $producto['id_producto'] . '/" class="btn ' . $action['class'] . ' btn-sm mb-2">' . $action['text'] . '</a>';
                                        }
                                        ?>
                                        <!-- Botón de eliminar -->
                                        <button onclick="eliminarProducto(<?php echo $producto['id_producto']; ?>)" class="btn btn-danger btn-sm mb-2">Eliminar Producto</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock en almacenes -->
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
                                                if (isset($producto['almacenes']) && is_array($producto['almacenes'])) {
                                                    foreach ($producto['almacenes'] as $almacen) {
                                                        echo "<tr>
                                                            <td>" . htmlspecialchars($almacen['nombre_almacen']) . "</td>
                                                            <td>" . htmlspecialchars($almacen['stock']) . "</td>
                                                        </tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='2'>No hay información de stock disponible.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
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

<script>
    function eliminarProducto(id) {
        if (confirm("¿Estás seguro de que quieres eliminar este producto?")) {
            let formData = new FormData();
            formData.append('modulo_product', 'eliminar');
            formData.append('id_producto', id);

            fetch('<?php echo APP_URL; ?>app/ajax/productAjax.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.tipo === "recargar") {
                        alert(data.texto);
                        window.location.href = '<?php echo APP_URL; ?>productList/';
                    } else {
                        alert(data.texto);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al intentar eliminar el producto');
                });
        }
    }
</script>