<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>movList/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Movimientos
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>movSearch/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Por Nombre
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>movSearch2/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Por Movimiento
                    </a>
                </li>
            </ul>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10">
            <div class="container-fluid mb-4">
                <h4 class="text-center">Movimientos</h4>
                <h5 class="lead text-center">Lista de movimientos</h5>
            </div>

            <div class="container py-4">
                <?php
                use app\controllers\movController2;
                $insMov = new movController2();
                $movimientos_agrupados = $insMov->listarMovControlador2($url[1], 99999999, $url[0], '');
                ?>

                <div class="accordion" id="accordionMovimientos">
                    <?php foreach ($movimientos_agrupados as $año => $meses): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading<?php echo $año; ?>">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $año; ?>" aria-expanded="true" aria-controls="collapse<?php echo $año; ?>">
                                    <?php echo $año; ?>
                                </button>
                            </h2>
                            <div id="collapse<?php echo $año; ?>" class="accordion-collapse collapse show" aria-labelledby="heading<?php echo $año; ?>" data-bs-parent="#accordionMovimientos">
                                <div class="accordion-body">
                                    <?php foreach ($meses as $mes => $semanas): ?>
                                        <h5><?php echo $mes; ?></h5>
                                        <?php foreach ($semanas as $semana => $movimientos): ?>
                                            <h6>Semana <?php echo $semana; ?></h6>
                                            <ul class="list-group mb-3">
                                                <?php foreach ($movimientos as $movimiento): ?>
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <strong>ID: <?php echo $movimiento['id_movimiento']; ?></strong> - 
                                                                Fecha: <?php echo date('d/m/Y', strtotime($movimiento['fecha_movimiento'])); ?><br>
                                                                Producto: <?php echo $movimiento['codigo_producto'] . ' - ' . $movimiento['nombre_producto']; ?><br>
                                                                De: <?php echo $movimiento['nombre_almacen_origen']; ?> 
                                                                A: <?php echo $movimiento['nombre_almacen_destino']; ?><br>
                                                                Cantidad: <?php echo $movimiento['cantidad']; ?> - 
                                                                Empleado: <?php echo $movimiento['nombre_empleado']; ?><br>
                                                                Motivo: <?php echo $movimiento['nota_movimiento']; ?>
                                                            </div>
                                                            <button class="btn btn-primary btn-sm" onclick="imprimirMovimiento(<?php echo htmlspecialchars(json_encode($movimiento), ENT_QUOTES, 'UTF-8'); ?>)">Imprimir</button>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var accordionItems = document.querySelectorAll('.accordion-item');
        accordionItems.forEach(function(item) {
            var header = item.querySelector('.accordion-header');
            header.addEventListener('click', function() {
                item.querySelector('.accordion-collapse').classList.toggle('show');
            });
        });
    });

    function imprimirMovimiento(movimiento) {
    console.log(movimiento); // Para depuración
    var contenido = `
        <div class="invoice">
            <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding: 5px;">
                <p style="font-size: 14px; text-align: center;"><strong>Movimientos de Almacenes</strong></p>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <img src="<?php echo APP_URL; ?>app/views/fotos/logo_orden.png" alt="logo" style="width:200px; height:auto;">
                    <div>
                        <h5>Movimiento de almacen: ${movimiento.id_movimiento}</h5>
                        <p><strong>Fecha:</strong> ${movimiento.fecha_movimiento}</p>
                        <p style="font-size: 13px;"><strong>Formato:</strong>  PR-12-F03</p>
                    </div>
                </div>
                <p style="margin-top: 0; margin-bottom: 0; text-align: left;">RADIOTECNOLOGÍA INDUSTRIAL S.A. DE C.V.</p>
                <p style="margin-top: 0; margin-bottom: 0; text-align: left;">RFC: RIN070219R38</p>
                <p style="margin-top: 0; margin-bottom: 0; text-align: left;">Calle Puebla Sur. Manzana 4. Lote 5 Nave B Int. 2 Col. Jardín Industrial</p>
                <p style="margin-top: 0; margin-bottom: 0; text-align: left;">Ixtapaluca. Edo. de México, C.P. 56535</p>
            </div>
    
            <table class="table" style="width: 100%; padding-top: 10; font-size: 13px;">
                <thead>
                    <tr>
                        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Código</th>
                        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Producto</th>
                        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Almacén origen</th>
                        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Almacén destino</th>
                        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Cantidad</th>
                        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Empleado</th>
                        <th style="text-align: center; border: 1px solid #000; padding: 5px;">Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">${movimiento.codigo_producto}</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">${movimiento.nombre_producto}</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">${movimiento.nombre_almacen_origen}</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">${movimiento.nombre_almacen_destino}</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">${movimiento.cantidad}</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">${movimiento.nombre_empleado}</td>
                        <td style="text-align: center; border: 1px solid #000; padding: 5px;">${movimiento.nota_movimiento}</td>
                    </tr>
                </tbody>
            </table>
            <div class="w-100 text-center" style="padding: 20px; border-top: 1px solid #ccc; margin-top: 20px;">
                <div><label>Firma de Recibido:</label><div style="width: 235px; height: 60px; border-bottom: 1px solid #000; margin: 0 auto;"></div></div>
                <div><label style="margin-top: 20px;">Fecha de Impresión:</label><span>${new Date().toLocaleDateString()}</span></div>
            </div>
        </div>
    `;

    var ventanaImpresion = window.open("", "_blank");
    ventanaImpresion.document.write("<html><head><title>Movimiento de almacen: " + movimiento.id_movimiento + "-" + movimiento.fecha_movimiento + "</title>");
    ventanaImpresion.document.write("<style>");
    ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; text-align: center; }");
    ventanaImpresion.document.write("table { border-collapse: collapse; width: 100%; margin: 0 auto; }");
    ventanaImpresion.document.write("th, td { border: 1px solid black; padding: 8px; text-align: center; }");
    ventanaImpresion.document.write("th { background-color: #f2f2f2; }");
    ventanaImpresion.document.write("</style>");
    ventanaImpresion.document.write("</head><body>");
    ventanaImpresion.document.write(contenido);
    ventanaImpresion.document.write("</body></html>");
    ventanaImpresion.document.close();
    ventanaImpresion.print();
}
</script>