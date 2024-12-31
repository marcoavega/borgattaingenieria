<?php

use app\controllers\productController;
use app\controllers\almacenController;

$insProduct = new productController();
$insAlmacen = new almacenController();

$categorias = $insProduct->obtenerCategorias();
$almacenes = $insAlmacen->obtenerAlmacenes();
$subcategorias = $insProduct->obtenerSubCategorias(); // Obtén las subcategorías
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
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productHM/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#home" />
                        </svg>
                        Listado Herramientas Maquinados
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productKit/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#home" />
                        </svg>
                        Listado Kit
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>productDelt/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#home" />
                        </svg>
                        Producto Terminado
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10">
            <h4 class="my-3">Inventario de Productos</h4>

            <!-- Botón de impresión -->
            <button class="btn btn-primary btn-sm mb-2" onclick="imprimirInventario()">Imprimir Inventario</button>

            <!-- Filtro de categorías -->
            <div class="mb-2">
                <label for="categoriaSelector" class="form-label">Filtrar por categoría:</label>
                <select id="categoriaSelector" class="form-select form-select-sm">
                    <option value="">Todas las categorías</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria['id_categoria']; ?>">
                            <?php echo htmlspecialchars($categoria['nombre_categoria']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Filtro de subcategorías -->
            <div class="mb-2">
                <label for="subcategoriaSelector" class="form-label">Filtrar por subcategoría:</label>
                <select id="subcategoriaSelector" class="form-select form-select-sm">
                    <option value="">Todas las subcategorías</option>
                    <?php foreach ($subcategorias as $subcategoria): ?>
                        <option value="<?php echo $subcategoria['id_subcategoria']; ?>">
                            <?php echo htmlspecialchars($subcategoria['nombre_subcategoria']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


            <!-- Selección de almacenes -->
            <div class="mb-2">
                <label class="form-label">Seleccionar almacenes:</label>
                <div>
                    <?php foreach ($almacenes as $almacen): ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input almacen-checkbox" type="checkbox"
                                id="almacen<?php echo $almacen['id_almacen']; ?>"
                                value="<?php echo $almacen['id_almacen']; ?>"
                                <?php echo ($almacen['nombre_almacen'] == 'Almacen General') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="almacen<?php echo $almacen['id_almacen']; ?>">
                                <?php echo htmlspecialchars($almacen['nombre_almacen']); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Tabla de inventario -->
            <div id="areaImprimir" class="table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Ubicación</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <?php foreach ($almacenes as $almacen): ?>
                                <th class="almacen-<?php echo $almacen['id_almacen']; ?>"><?php echo htmlspecialchars($almacen['nombre_almacen']); ?></th>
                                <th class="almacen-<?php echo $almacen['id_almacen']; ?>">Físico <?php echo htmlspecialchars($almacen['nombre_almacen']); ?></th>
                                <th class="almacen-<?php echo $almacen['id_almacen']; ?>">Diferencia <?php echo htmlspecialchars($almacen['nombre_almacen']); ?></th>
                            <?php endforeach; ?>
                            <th>Total Stock Virtual</th>
                            <th>Total Stock Físico</th>
                            <th>Diferencia Total</th>
                            <th>Valor Total Virtual</th>
                            <th>Valor Total Físico</th>
                        </tr>
                    </thead>
                    <tbody id="inventarioBody">
                        <?php
                        $productos = $insProduct->obtenerProductosConStock();
                        foreach ($productos as $producto):
                        ?>
                            <tr data-categoria="<?php echo $producto['id_categoria']; ?>" 
                            data-subcategoria="<?php echo $producto['id_subcategoria']; ?>"> <!-- Agregar data-subcategoria -->
                                <td><?php echo htmlspecialchars($producto['id_producto']); ?></td>    
                                <td><?php echo htmlspecialchars($producto['codigo_producto']); ?></td>
                                <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                                <td><?php echo htmlspecialchars($producto['ubicacion'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($producto['nombre_categoria']); ?></td>
                                <td class="precio"><?php echo number_format($producto['precio'], 2); ?></td>
                                <?php foreach ($almacenes as $almacen):
                                    $stockActual = isset($producto['stocks'][$almacen['id_almacen']]) ? $producto['stocks'][$almacen['id_almacen']] : 0;
                                ?>
                                    <td class="almacen-<?php echo $almacen['id_almacen']; ?> stock-virtual"><?php echo $stockActual; ?></td>
                                    <td class="almacen-<?php echo $almacen['id_almacen']; ?>">
                                        <input type="number" class="form-control form-control-sm stock-fisico"
                                            data-producto="<?php echo $producto['id_producto']; ?>"
                                            data-almacen="<?php echo $almacen['id_almacen']; ?>"
                                            onchange="calcularDiferencia(this)">
                                    </td>
                                    <td class="almacen-<?php echo $almacen['id_almacen']; ?> diferencia"></td>
                                <?php endforeach; ?>
                                <td class="total-stock-virtual">0</td>
                                <td class="total-stock-fisico">0</td>
                                <td class="diferencia-total">0</td>
                                <td class="valor-total-virtual">0</td>
                                <td class="valor-total-fisico">0</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
        <tr>
            <th colspan="6">Totales</th>
            <?php foreach ($almacenes as $almacen): ?>
                <th class="almacen-<?php echo $almacen['id_almacen']; ?> total-almacen-virtual">0</th>
                <th class="almacen-<?php echo $almacen['id_almacen']; ?> total-almacen-fisico">0</th>
                <th class="almacen-<?php echo $almacen['id_almacen']; ?> total-almacen-diferencia">0</th>
            <?php endforeach; ?>
            <th id="granTotalStockVirtual">0</th>
            <th id="granTotalStockFisico">0</th>
            <th id="granTotalDiferencia">0</th>
            <th id="granTotalValorVirtual">0</th>
            <th id="granTotalValorFisico">0</th>
        </tr>
        <tr class="table-info">
            <th colspan="6">Diferencia en Valor Total</th>
            <?php foreach ($almacenes as $almacen): ?>
                <th class="almacen-<?php echo $almacen['id_almacen']; ?>" colspan="3">-</th>
            <?php endforeach; ?>
            <th colspan="3">-</th>
            <th colspan="2" id="granTotalValorDiferencia">$0.00</th>
        </tr>
    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        font-size: 0.8rem;
    }

    .form-label,
    .form-check-label {
        font-size: 0.75rem;
    }

    .form-select-sm,
    .form-control-sm,
    .btn-sm {
        font-size: 0.75rem;
        padding: 0.1rem 0.3rem;
    }

    .table-sm th,
    .table-sm td {
        padding: 0.2rem;
    }

    #areaImprimir {
        max-height: 70vh;
        overflow-y: auto;
    }

    .table-responsive {
        position: relative;
    }

    .table thead th {
        position: sticky;
        top: 0;
        background-color: #343a40;
        color: white;
        z-index: 1;
    }

    .table-responsive {
    max-height: 70vh;
    overflow-y: auto;
    overflow-x: auto;
    max-width: 100%;
}

.table {
    min-width: 1500px; /* Asegura que la tabla tenga un ancho mínimo para forzar el scroll */
}

/* Mantener los headers fijos mientras se hace scroll */
.table thead th {
    position: sticky;
    top: 0;
    background-color: #343a40;
    color: white;
    z-index: 1;
}
</style>

<script>


document.getElementById('categoriaSelector').addEventListener('change', filtrarProductos);
document.getElementById('subcategoriaSelector').addEventListener('change', filtrarProductos);

function filtrarProductos() {
    const selectedCategoria = document.getElementById('categoriaSelector').value;
    const selectedSubcategoria = document.getElementById('subcategoriaSelector').value;
    const rows = document.querySelectorAll('#inventarioBody tr');
    
    rows.forEach(function(row) {
        const categoria = row.getAttribute('data-categoria');
        const subcategoria = row.getAttribute('data-subcategoria');

        const categoriaMatch = selectedCategoria === '' || categoria === selectedCategoria;
        const subcategoriaMatch = selectedSubcategoria === '' || subcategoria === selectedSubcategoria;

        if (categoriaMatch && subcategoriaMatch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    calcularTotales();
}



    function calcularDiferencia(input) {
        const row = input.closest('tr');
        const stockActual = parseInt(input.parentElement.previousElementSibling.textContent);
        const stockFisico = parseInt(input.value) || 0;
        const diferencia = stockFisico - stockActual;
        input.parentElement.nextElementSibling.textContent = diferencia;
        input.parentElement.nextElementSibling.classList.toggle('text-danger', diferencia < 0);
        input.parentElement.nextElementSibling.classList.toggle('text-success', diferencia > 0);
        calcularTotales();
    }

    function calcularTotales() {
    const rows = document.querySelectorAll('#inventarioBody tr');
    let granTotalStockVirtual = 0;
    let granTotalStockFisico = 0;
    let granTotalDiferencia = 0;
    let granTotalValorVirtual = 0;
    let granTotalValorFisico = 0;

    // Totales por almacén
    const almacenTotales = {};
    document.querySelectorAll('.almacen-checkbox:checked').forEach(checkbox => {
        const almacenId = checkbox.value;
        almacenTotales[almacenId] = {
            virtual: 0,
            fisico: 0,
            diferencia: 0
        };
    });

    rows.forEach(row => {
        if (row.style.display !== 'none') {  // Solo considerar filas visibles
            let rowTotalStockVirtual = 0;
            let rowTotalStockFisico = 0;
            const precio = parseFloat(row.querySelector('.precio').textContent.replace(/,/g, ''));

            // Calcular totales por almacén para esta fila
            document.querySelectorAll('.almacen-checkbox:checked').forEach(checkbox => {
                const almacenId = checkbox.value;
                const stockVirtual = parseInt(row.querySelector(`.almacen-${almacenId}.stock-virtual`).textContent) || 0;
                const stockFisico = parseInt(row.querySelector(`.almacen-${almacenId} input.stock-fisico`).value) || 0;
                const diferencia = stockFisico - stockVirtual;

                rowTotalStockVirtual += stockVirtual;
                rowTotalStockFisico += stockFisico;

                // Actualizar totales por almacén
                almacenTotales[almacenId].virtual += stockVirtual;
                almacenTotales[almacenId].fisico += stockFisico;
                almacenTotales[almacenId].diferencia += diferencia;
            });

            // Calcular y mostrar totales de la fila
            const rowDiferenciaTotal = rowTotalStockFisico - rowTotalStockVirtual;
            const rowValorTotalVirtual = rowTotalStockVirtual * precio;
            const rowValorTotalFisico = rowTotalStockFisico * precio;

            // Actualizar las celdas de totales en la fila
            row.querySelector('.total-stock-virtual').textContent = rowTotalStockVirtual;
            row.querySelector('.total-stock-fisico').textContent = rowTotalStockFisico;
            row.querySelector('.diferencia-total').textContent = rowDiferenciaTotal;
            row.querySelector('.valor-total-virtual').textContent = rowValorTotalVirtual.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' });
            row.querySelector('.valor-total-fisico').textContent = rowValorTotalFisico.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' });

            // Acumular totales generales
            granTotalStockVirtual += rowTotalStockVirtual;
            granTotalStockFisico += rowTotalStockFisico;
            granTotalDiferencia += rowDiferenciaTotal;
            granTotalValorVirtual += rowValorTotalVirtual;
            granTotalValorFisico += rowValorTotalFisico;
        }
    });

    // Actualizar totales por almacén en el pie de tabla
    Object.entries(almacenTotales).forEach(([almacenId, totales]) => {
        const virtualCell = document.querySelector(`tfoot .almacen-${almacenId}.total-almacen-virtual`);
        const fisicoCell = document.querySelector(`tfoot .almacen-${almacenId}.total-almacen-fisico`);
        const diferenciaCell = document.querySelector(`tfoot .almacen-${almacenId}.total-almacen-diferencia`);
        
        if (virtualCell) virtualCell.textContent = totales.virtual;
        if (fisicoCell) fisicoCell.textContent = totales.fisico;
        if (diferenciaCell) diferenciaCell.textContent = totales.diferencia;
    });

    // Actualizar totales generales en el pie de tabla
    document.getElementById('granTotalStockVirtual').textContent = granTotalStockVirtual;
    document.getElementById('granTotalStockFisico').textContent = granTotalStockFisico;
    document.getElementById('granTotalDiferencia').textContent = granTotalDiferencia;
    document.getElementById('granTotalValorVirtual').textContent = granTotalValorVirtual.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' });
    document.getElementById('granTotalValorFisico').textContent = granTotalValorFisico.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' });

    // Calcular y mostrar la diferencia en valor total
    const diferenciaTotalValor = granTotalValorFisico - granTotalValorVirtual;
    const diferenciaTotalElement = document.getElementById('granTotalValorDiferencia');
    diferenciaTotalElement.textContent = diferenciaTotalValor.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' });
    
    // Agregar clase de color según si la diferencia es positiva o negativa
    diferenciaTotalElement.classList.remove('text-success', 'text-danger');
    if (diferenciaTotalValor > 0) {
        diferenciaTotalElement.classList.add('text-success');
    } else if (diferenciaTotalValor < 0) {
        diferenciaTotalElement.classList.add('text-danger');
    }
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
        calcularTotales();
    });

    document.querySelectorAll('.almacen-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const almacenId = this.value;
            const columns = document.querySelectorAll(`.almacen-${almacenId}`);
            columns.forEach(function(column) {
                column.style.display = checkbox.checked ? '' : 'none';
            });
            calcularTotales();
        });
    });

    // Inicializar la visibilidad de las columnas y calcular totales iniciales
    document.querySelectorAll('.almacen-checkbox').forEach(function(checkbox) {
        const almacenId = checkbox.value;
        const columns = document.querySelectorAll(`.almacen-${almacenId}`);
        columns.forEach(function(column) {
            column.style.display = checkbox.checked ? '' : 'none';
        });
    });
    calcularTotales();

    function imprimirInventario() {
    // Copiar los valores de los inputs al texto visible antes de imprimir
    document.querySelectorAll('.stock-fisico').forEach(input => {
        const parent = input.parentElement;
        const value = input.value || '0'; // Si el input está vacío, usa '0'
        const span = document.createElement('span');
        span.textContent = value;
        span.className = 'stock-fisico-imprimible'; // Clase para personalización en impresión
        parent.appendChild(span);
        input.style.display = 'none'; // Ocultar los inputs en la vista de impresión
    });

    // Capturar el contenido del área de impresión
    const contenido = document.getElementById('areaImprimir').innerHTML;

    // Crear nueva ventana para impresión
    const ventanaImpresion = window.open('', '_blank');
    ventanaImpresion.document.write('<html><head><title>Inventario de Productos</title>');

    // Estilos CSS para impresión
    ventanaImpresion.document.write('<style>');
    ventanaImpresion.document.write('body { font-family: Arial, sans-serif; font-size: 10px; }');
    ventanaImpresion.document.write('table { width: 100%; border-collapse: collapse; }');
    ventanaImpresion.document.write('th, td { border: 1px solid #000; padding: 3px; text-align: center; }');
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

    // Restaurar los inputs después de imprimir
    document.querySelectorAll('.stock-fisico-imprimible').forEach(span => {
        const parent = span.parentElement;
        const input = parent.querySelector('.stock-fisico');
        input.style.display = ''; // Mostrar los inputs nuevamente
        parent.removeChild(span); // Eliminar los spans temporales
    });
}

</script>