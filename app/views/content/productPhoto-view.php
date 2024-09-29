<?php
// Asegúrate de que todas las clases necesarias estén importadas
use app\controllers\productController;

// Obtiene el ID del producto a editar
$id = $insLogin->limpiarCadena($url[1]);

// Crea una instancia del controlador de productos
$insProduct = new productController();
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
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productInvent/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Inventario
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10">
            <div class="container py-4">
                <h4 class="text-center">Foto de producto</h4>
                <h5 class="lead text-center mb-4">Actualizar foto de producto</h5>

                <?php
                // Incluye el botón de regreso
                include "./app/views/inc/btn_back2.php";

                // Obtiene los datos del producto a editar
                $datos = $insLogin->seleccionarDatos("Unico", "productos", "id_producto", $id);

                // Comprueba si se obtuvieron los datos del producto
                if ($datos->rowCount() == 1) {
                    $datos = $datos->fetch();
                ?>

                <!-- Muestra el nombre del producto -->
                <h5 class="text-center mb-4"><?php echo $datos['nombre_producto']; ?></h5>

                <!-- Muestra la foto actual del producto y el formulario para actualizar la foto -->
                <div class="row g-5">
                    <div class="col-md-5">
                        <?php if(is_file("./app/views/img/img/".$datos['url_imagen'])){ ?>
                        <!-- Muestra la foto actual del producto -->
                        <div class="mb-4">
                            <img class="img-thumbnail" src="<?php echo APP_URL; ?>app/views/img/img/<?php echo $datos['url_imagen']; ?>">
                        </div>
                        
                        <!-- Formulario para eliminar la foto actual -->
                        <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off" >
                            <input type="hidden" name="modulo_product" value="eliminarFoto">
                            <input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">
                            <button type="submit" class="btn btn-danger">Eliminar foto</button>
                        </form>
                        <?php }else{ ?>
                        <!-- Si el producto no tiene una foto, muestra una foto por defecto -->
                        <div class="mb-4">
                            <img class="img-thumbnail" src="<?php echo APP_URL; ?>app/views/fotos/default.png">
                        </div>
                        <?php }?>
                    </div>

                    <!-- Formulario para subir una nueva foto -->
                    <div class="col-md-7">
                        <form class="mb-4 FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" enctype="multipart/form-data" autocomplete="off" >
                            <input type="hidden" name="modulo_product" value="actualizarFoto">
                            <input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">
                            
                            <label for="url_imagen" class="form-label">Foto o imagen del producto</label>
                            <input class="form-control" type="file" id="url_imagen" name="url_imagen" accept=".jpg, .png, .jpeg">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                <button type="submit" class="btn btn-primary">Actualizar foto</button>
                            </div>
                        </form>
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