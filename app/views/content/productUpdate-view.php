<div class="container is-fluid mb-6">
    <?php
    $id = $insLogin->limpiarCadena($url[1]);
        ?>
        <h1 class="title">Productos</h1>
        <h2 class="subtitle">Editar Producto</h2>
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


<div class="container pb-6 pt-6">
    <?php

    include "./app/views/inc/btn_back.php";

    $datos = $insLogin->seleccionarDatos("Unico", "productos", "id_producto", $id);

    if ($datos->rowCount() == 1) {
        $datos = $datos->fetch();
        ?>

        <div id="login" class="container">

            <div class="row-fluid">

                <div class="span12">

                    <div class="login well well-small">

                        <main class="form-signin w-100 m-auto">

                            <h2 class="title has-text-centered">
                                <?php echo $datos['nombre_producto']; ?>
                            </h2>

                            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php"
                                method="POST" autocomplete="off">

                                <input type="hidden" name="modulo_product" value="actualizar">
                                <input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">


                                <div class="mb-3">
                            <label for="" class="form-label">Código Producto:</label>
                            <input type="text" class="form-control" name="codigo_producto"
                                pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" value="<?php echo $datos['codigo_producto']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Nombre Producto:</label>
                            <input type="text" class="form-control" name="nombre_producto"
                                pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="1000" value="<?php echo $datos['nombre_producto']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Precio en Pesos $:</label>
                            <input type="text" class="form-control" name="precio" value="<?php echo $datos['precio']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Cantidad a Ingresar:</label>
                            <input type="number" class="form-control" name="stock" value="<?php echo $datos['stock']; ?>" required>
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


                        <div class="text-center mt-4" style="margin-bottom: 20px;">
                            <!-- Puedes ajustar el valor según tus necesidades -->
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>


                            </form>

                        </main>

                    </div>

                </div>

            </div>

        </div>


        <?php
    } else {
        include "./app/views/inc/error_alert.php";
    }
    ?>