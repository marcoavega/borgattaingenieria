<?php
use app\controllers\productController;
use app\controllers\almacenController;

$insProduct = new productController();
$insAlmacen = new almacenController();

$categorias = $insProduct->obtenerCategorias();
$almacenes = $insAlmacen->obtenerAlmacenes();
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
            <h2 class="my-4">Inventario de Productos</h2>

            <!-- Botón de impresión -->
            <button class="btn btn-primary mb-3" onclick="imprimirInventario()">Imprimir Inventario</button>

            <!-- Filtro de categorías -->
            <div class="mb-3">
                <label for="categoriaSelector" class="form-label">Filtrar por categoría:</label>
                <select id="categoriaSelector" class="form-select">
                    <option value="">Todas las categorías</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria['id_categoria']; ?>">
                            <?php echo htmlspecialchars($categoria['nombre_categoria']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tabla de inventario -->
            <div id="areaImprimir">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <?php foreach ($almacenes as $almacen): ?>
                                    <th><?php echo htmlspecialchars($almacen['nombre_almacen']); ?></th>
                                    <th>Físico <?php echo htmlspecialchars($almacen['nombre_almacen']); ?></th>
                                    <th>Diferencia <?php echo htmlspecialchars($almacen['nombre_almacen']); ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody id="inventarioBody">
                            <?php
                            $productos = $insProduct->obtenerProductosConStock();
                            foreach ($productos as $producto):
                            ?>
                                <tr data-categoria="<?php echo $producto['id_categoria']; ?>">
                                    <td><?php echo htmlspecialchars($producto['codigo_producto']); ?></td>
                                    <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                                    <td><?php echo htmlspecialchars($producto['nombre_categoria']); ?></td>
                                    <?php foreach ($almacenes as $almacen): 
                                        $stockActual = isset($producto['stocks'][$almacen['id_almacen']]) ? $producto['stocks'][$almacen['id_almacen']] : 0;
                                    ?>
                                        <td><?php echo $stockActual; ?></td>
                                        <td>
                                            <input type="number" class="form-control stock-fisico" 
                                                   data-producto="<?php echo $producto['id_producto']; ?>" 
                                                   data-almacen="<?php echo $almacen['id_almacen']; ?>" 
                                                   onchange="calcularDiferencia(this)">
                                        </td>
                                        <td class="diferencia"></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function calcularDiferencia(input) {
    const row = input.closest('tr');
    const stockActual = parseInt(input.parentElement.previousElementSibling.textContent);
    const stockFisico = parseInt(input.value) || 0;
    const diferencia = stockFisico - stockActual;
    input.parentElement.nextElementSibling.textContent = diferencia;
    input.parentElement.nextElementSibling.classList.toggle('text-danger', diferencia < 0);
    input.parentElement.nextElementSibling.classList.toggle('text-success', diferencia > 0);
}

document.getElementById('categoriaSelector').addEventListener('change', function() {
    const selectedCategoria = this.value;
    const rows = document.querySelectorAll('#inventarioBody tr');
    
    rows.forEach(function(row) {
        if (selectedCategoria === '' || row.getAttribute('data-categoria') === selectedCategoria) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

function imprimirInventario() {
    var contenido = document.getElementById('areaImprimir').innerHTML;
    var ventanaImpresion = window.open('', '_blank');
    ventanaImpresion.document.write('<html><head><title>Inventario de Productos</title>');
    
    // Estilos CSS para la impresión
    ventanaImpresion.document.write('<style>');
    ventanaImpresion.document.write('body { font-family: Arial, sans-serif; font-size: 12px; }');
    ventanaImpresion.document.write('table { width: 100%; border-collapse: collapse; }');
    ventanaImpresion.document.write('th, td { border: 1px solid #000; padding: 5px; text-align: center; }');
    ventanaImpresion.document.write('th { background-color: #f2f2f2; }');
    ventanaImpresion.document.write('.text-danger { color: red; }');
    ventanaImpresion.document.write('.text-success { color: green; }');
    ventanaImpresion.document.write('</style>');
    
    ventanaImpresion.document.write('</head><body>');
    ventanaImpresion.document.write('<h1>Inventario de Productos</h1>');
    ventanaImpresion.document.write(contenido);
    ventanaImpresion.document.write('</body></html>');
    ventanaImpresion.document.close();
    ventanaImpresion.print();
}
</script>