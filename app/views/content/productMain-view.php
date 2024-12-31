<?php
use app\controllers\productController;
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
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10">
            <div class="container py-4">
                <h4 class="text-center mb-4">Gestión de Productos</h4>

                <!-- Sección de productos que necesitan resurtirse -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Productos que necesitan resurtirse (Almacén General)</h5>
                        <button onclick="imprimirStocksFaltantes()" class="btn btn-primary btn-sm">Imprimir Stocks Faltantes</button>
                    </div>
                    <div class="card-body">
                        <!-- Selector de categorías -->
                        <div class="mb-3">
                            <label for="categoriaSelector" class="form-label">Filtrar por categoría:</label>
                            <select id="categoriaSelector" class="form-select form-select-sm">
                                <option value="">Todas las categorías</option>
                                <?php
                                $insProduct = new productController();
                                $categorias = $insProduct->obtenerCategorias();
                                foreach ($categorias as $categoria) {
                                    echo "<option value='" . $categoria['id_categoria'] . "'>" . htmlspecialchars($categoria['nombre_categoria']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered" id="tablaStocksFaltantes">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th>Stock Actual (General)</th>
                                        <th>Stock Deseado</th>
                                        <th>Faltante</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="productosBody">
                                    <?php
                                    $productosAResurtir = $insProduct->obtenerProductosAResurtir();

                                    if (!empty($productosAResurtir)) {
                                        foreach ($productosAResurtir as $producto) {
                                            $faltante = $producto['stock_deseado'] - $producto['stock_general'];
                                            echo "<tr data-categoria='" . $producto['id_categoria'] . "'>
                                                <td>" . htmlspecialchars($producto['codigo_producto']) . "</td>
                                                <td>" . htmlspecialchars($producto['nombre_producto']) . "</td>
                                                <td>" . htmlspecialchars($producto['nombre_categoria']) . "</td>
                                                <td>" . htmlspecialchars($producto['stock_general']) . "</td>
                                                <td>" . htmlspecialchars($producto['stock_deseado']) . "</td>
                                                <td class='text-danger'>" . htmlspecialchars($faltante) . "</td>
                                                <td>
                                                    <a href='" . APP_URL . "productEntrance/" . $producto['id_producto'] . "/' class='btn btn-primary btn-sm'>Entrada</a>
                                                </td>
                                            </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7' class='text-center'>No hay productos que necesiten resurtirse en el Almacén General en este momento.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Aquí puedes agregar más secciones o contenido para la gestión de productos -->

            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('categoriaSelector').addEventListener('change', function() {
    var selectedCategoria = this.value;
    var rows = document.querySelectorAll('#productosBody tr');
    
    rows.forEach(function(row) {
        if (selectedCategoria === '' || row.getAttribute('data-categoria') === selectedCategoria) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

function imprimirStocksFaltantes() {
    var categoriaSeleccionada = document.getElementById('categoriaSelector').value;
    var titulo = 'Stocks Faltantes - ' + (categoriaSeleccionada ? document.getElementById('categoriaSelector').options[document.getElementById('categoriaSelector').selectedIndex].text : 'Todas las categorías');
    
    var contenido = document.getElementById('tablaStocksFaltantes').cloneNode(true);
    var filas = contenido.querySelectorAll('tbody tr');
    
    filas.forEach(function(fila) {
        if (fila.style.display === 'none') {
            fila.parentNode.removeChild(fila);
        } else {
            fila.removeChild(fila.lastElementChild); // Remover la columna de acciones
        }
    });

    var ventanaImpresion = window.open('', '_blank');
    ventanaImpresion.document.write('<html><head><title>' + titulo + '</title>');
    ventanaImpresion.document.write('<style>');
    ventanaImpresion.document.write('body { font-family: Arial, sans-serif; font-size: 12px; }');
    ventanaImpresion.document.write('table { width: 100%; border-collapse: collapse; }');
    ventanaImpresion.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
    ventanaImpresion.document.write('th { background-color: #f2f2f2; }');
    ventanaImpresion.document.write('.text-danger { color: red; }');
    ventanaImpresion.document.write('</style>');
    ventanaImpresion.document.write('</head><body>');
    ventanaImpresion.document.write('<h1>' + titulo + '</h1>');
    ventanaImpresion.document.write(contenido.outerHTML);
    ventanaImpresion.document.write('</body></html>');
    ventanaImpresion.document.close();
    ventanaImpresion.print();
}
</script>

<style>
    body {
        font-size: 0.9rem;
    }
    .form-label {
        font-size: 0.85rem;
    }
    .form-select-sm, .form-control-sm, .btn-sm {
        font-size: 0.85rem;
    }
    .table-sm th, .table-sm td {
        padding: 0.3rem;
        font-size: 0.85rem;
    }
</style>