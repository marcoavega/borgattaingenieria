<div id="login" class="container">
	<div class="login well well-small center">
		<h1 class="title">Productos</h1>
		<h2 class="subtitle">Nuevo Producto</h2>
	</div>
</div>

<?php
// Incluye el controlador necesario
use app\controllers\productController;

// Crea una instancia del controlador
$insProduct = new productController();

// Obtén las opciones de categorías
$opcionesCategorias = $insProduct->obtenerOpcionesCategorias();
// Obtener opciones de proveedores
$opcionesProveedores = $insProduct->obtenerOpcionesProveedores();
// Obtener opciones de unidades medida
$opcionesUnidadesMedida = $insProduct->obtenerOpcionesUnidadesMedida();
// Obtener opciones de unidades monedas
$opcionesTiposMoneda = $insProduct->obtenerOpcionesTiposMoneda();

?>

<div id="login" class="container">

    <div class="row-fluid">

        <div class="span12">

            <div class="login well well-small">

                <main class="form-signin w-100 m-auto">

                    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST"
                        autocomplete="off" enctype="multipart/form-data">

                        <input type="hidden" name="modulo_product" value="registrar">

                        <div class="mb-3">
                            <label for="" class="form-label">Código Producto:</label>
                            <input type="text" class="form-control" name="codigo_producto"
                                pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Nombre Producto:</label>
                            <input type="text" class="form-control" name="nombre_producto"
                                pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="1000" required>
                        </div>


                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2"
                                style="height: 100px" name="descripcion"></textarea>
                            <label for="floatingTextarea2">Descripción:</label>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Precio en Pesos $:</label>
                            <input type="text" class="form-control" name="precio" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Cantidad a Ingresar:</label>
                            <input type="number" class="form-control" name="stock" required>
                        </div>


                        <div class="form-group">
                            <label for="categoria" class="col-sm-3 control-label">Categoría</label>
                            <div class="col-sm-12">
                                <select class='form-control' name='categoria' id='categoria' required>
                                    <option value="">Selecciona una categoría</option>
                                    <?php echo $opcionesCategorias; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="proveedor" class="col-sm-12 control-label">Proveedor</label>
                            <div class="col-sm-12">
                                <select class='form-control' name='proveedor' id='proveedor' required>
                                    <option value="">Selecciona un proveedor</option>
                                    <?php echo $opcionesProveedores; ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="unidad_medida" class="col-sm-12 control-label">Unidad de Medida</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="unidad_medida" id="unidad_medida" required>
                                    <option value="">Selecciona una unidad de medida</option>
                                    <?php echo $opcionesUnidadesMedida; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tipo_moneda" class="col-sm-12 control-label">Tipo de Moneda</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="tipo_moneda" id="tipo_moneda" required>
                                    <option value="">Selecciona un tipo de moneda</option>
                                    <?php echo $opcionesTiposMoneda; ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-12 control-label" for="inputGroupFile01">Subir Foto</label>
                            <div class="col-sm-12">
                                <input type="file" class="form-control" id="inputGroupFile01" name="url_imagen"
                                    accept=".jpg, .png, .jpeg">
                            </div>
                        </div>

                        <div class="text-center mt-4" style="margin-bottom: 20px;">
                            <!-- Puedes ajustar el valor según tus necesidades -->
                            <button type="reset" class="btn btn-secondary me-2">Limpiar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>

                    </form>

                </main>

            </div>

        </div>

    </div>

</div>
