<!-- Contenedor principal -->
<div class="container-fluid">
    <?php
    // Obtiene el ID del producto a editar
    $id = $insLogin->limpiarCadena($url[1]);
    ?>
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
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productHM/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Listado Herramientas Maquinados
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productKit/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Listado Kit
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productDelt/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Producto Terminado
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Formulario de creación de producto -->
        <div class="col-md-9 col-lg-10">
            <?php
            // Importa el controlador de productos
            use app\controllers\productController;

            // Crea una instancia del controlador
            $insProduct = new productController();

            // Obtiene las opciones de categorías, proveedores, unidades de medida y tipos de moneda
            $opcionesCategorias = $insProduct->obtenerOpcionesCategorias();
            $opcionesProveedores = $insProduct->obtenerOpcionesProveedores();
            $opcionesUnidadesMedida = $insProduct->obtenerOpcionesUnidadesMedida();
            $opcionesTiposMoneda = $insProduct->obtenerOpcionesTiposMoneda();
            $opcionesSubCategorias = $insProduct->obtenerOpcionesSubCategorias();
            ?>
            <!-- Título de la página -->
            <div class="container mt-5">
                <h2 class="text-center mb-4">Registro de Nuevo Producto</h2>
                <form class="FormularioAjax p-4 border rounded-3 bg-dark" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="modulo_product" value="registrar">

                    <div class="row">
                        <!-- Columna izquierda -->
                        <div class="col-md-6">
                            <h4 class="mb-3">Información Básica</h4>
                            <div class="mb-3">
                                <label for="codigo_producto" class="form-label">Código Producto</label>
                                <input type="text" class="form-control" id="codigo_producto" name="codigo_producto" maxlength="30" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre_producto" class="form-label">Nombre Producto</label>
                                <textarea class="form-control" id="nombre_producto" name="nombre_producto" maxlength="180" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="ubicacion" class="form-label">Ubicación</label>
                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="precio" class="form-label">Precio de Compra ($)</label>
                                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="precio_venta" class="form-label">Precio de Venta ($) (Opcional)</label>
                                    <input type="number" step="0.01" class="form-control" id="precio_venta" name="precio_venta">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="stock" class="form-label">Cantidad a Ingresar</label>
                                    <input type="number" class="form-control" id="stock" name="stock" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="stock_deseado" class="form-label">Stock Deseado</label>
                                    <input type="number" class="form-control" id="stock_deseado" name="stock_deseado" required>
                                </div>
                            </div>
                        </div>

                        <!-- Columna derecha -->
                        <div class="col-md-6">
                            <h4 class="mb-3">Detalles y Categorización</h4>
                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoría</label>
                                <select class='form-control' name='categoria' id='categoria' required>
                                    <option value="">Selecciona una categoría</option>
                                    <?php echo $opcionesCategorias; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="subcategoria" class="form-label">Sub-Categoría</label>
                                <select class='form-control' name='subcategoria' id='subcategoria' required>
                                    <option value="">Selecciona una sub-categoría</option>
                                    <?php echo $opcionesSubCategorias; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="proveedor" class="form-label">Proveedor</label>
                                <select class='form-control' name='proveedor' id='proveedor' required>
                                    <option value="">Selecciona un proveedor</option>
                                    <?php echo $opcionesProveedores; ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="unidad_medida" class="form-label">Unidad de Medida</label>
                                    <select class="form-control" name="unidad_medida" id="unidad_medida" required>
                                        <option value="">Selecciona una unidad</option>
                                        <?php echo $opcionesUnidadesMedida; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_moneda" class="form-label">Tipo de Moneda</label>
                                    <select class="form-control" name="tipo_moneda" id="tipo_moneda" required>
                                        <option value="">Selecciona moneda</option>
                                        <?php echo $opcionesTiposMoneda; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <h5 class="mb-3">Dimensiones (Opcional)</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="peso" class="form-label">Peso (Kg.)</label>
                                        <input type="number" step="0.0001" class="form-control" id="peso" name="peso">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="altura" class="form-label">Altura (M)</label>
                                        <input type="number" step="0.0001" class="form-control" id="altura" name="altura">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="largo" class="form-label">Largo (M)</label>
                                        <input type="number" step="0.0001" class="form-control" id="largo" name="largo">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="ancho" class="form-label">Ancho (M)</label>
                                        <input type="number" step="0.0001" class="form-control" id="ancho" name="ancho">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="diametro" class="form-label">Diámetro (M)</label>
                                        <input type="number" step="0.0001" class="form-control" id="diametro" name="diametro">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <label for="url_imagen" class="form-label">Subir Foto del Producto</label>
                            <input class="form-control" type="file" id="url_imagen" name="url_imagen" accept=".jpg, .png, .jpeg">
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Guardar Producto</button>
                    </div>
                </form>
            </div>