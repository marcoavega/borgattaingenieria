<?php
use app\controllers\facturaController;

$insFactura = new facturaController();
?>

<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>facturaNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Capturar
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>facturaPNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Alta
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>facturaSearch/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Consultar/Imprimir
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>movFactura/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Sacar Reporte
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10">
            <div class="container-fluid py-4">
                <h4 class="text-center mb-4">Lista de Facturas</h4>

                <?php
                $resultado = $insFactura->listarFacturaControlador($url[1], 99999999, $url[0], '');
                $facturas_agrupadas = $resultado['facturas_agrupadas'];
                ?>

                <div class="accordion mt-4" id="accordionFacturas">
                    <?php foreach ($facturas_agrupadas as $año => $meses): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading<?php echo $año; ?>">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $año; ?>" aria-expanded="true" aria-controls="collapse<?php echo $año; ?>">
                                    <?php echo $año; ?>
                                </button>
                            </h2>
                            <div id="collapse<?php echo $año; ?>" class="accordion-collapse collapse show" aria-labelledby="heading<?php echo $año; ?>" data-bs-parent="#accordionFacturas">
                                <div class="accordion-body">
                                    <?php foreach ($meses as $mes => $semanas): ?>
                                        <h5><?php echo $mes; ?></h5>
                                        <?php foreach ($semanas as $semana => $facturas): ?>
                                            <h6>Semana <?php echo $semana; ?></h6>
                                            <ul class="list-group mb-3">
                                                <?php foreach ($facturas as $factura): ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>Número de Factura: <?php echo $factura['numero_factura']; ?></strong><br>
                                                            Fecha: <?php echo $factura['fecha']; ?><br>
                                                            Proveedor: <?php echo $factura['nombre_proveedor']; ?><br>
                                                            Total: <?php echo number_format($factura['total_factura'], 2); ?> <?php echo $factura['nombre_moneda']; ?>
                                                        </div>
                                                        <button class="btn btn-primary btn-sm" onclick='imprimirFactura(<?php echo json_encode($factura); ?>)'>Imprimir</button>
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

<style>
    body {
        font-size: 0.9rem;
    }
    .form-label {
        font-size: 0.85rem;
    }
    .form-select-sm, .form-control-sm {
        font-size: 0.85rem;
    }
    .btn-sm {
        font-size: 0.85rem;
    }
</style>

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

    function imprimirFactura(factura) {
        console.log(factura); // Para depuración
        var contenido = `
            <div class="invoice">
                <div style="margin-top: 1px; font-size: 13px; border: 1px solid #000; padding: 5px;">
                    <p style="font-size: 14px; text-align: center;"><strong>Captura de Factura</strong></p>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <img src="<?php echo APP_URL; ?>app/views/fotos/logo_orden.png" alt="logo" style="width:200px; height:auto;">
                        <div>
                            <p><strong>Registro Número:</strong> ${factura.num_factura}</p>
                            <p><strong>Fecha:</strong> ${factura.fecha}</p>
                            <p><strong>Fecha de emisión:</strong> ${factura.fecha_emision}</p>
                            <p><strong>Fecha de vencimiento:</strong> ${factura.fecha_vencimiento}</p>
                            <p style="font-size: 13px;"><strong>Formato:</strong> PR-12-F07</p>
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
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Número de Factura</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Num Factura</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Proveedor</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">RFC</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Subtotal</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">IVA</th>
                            <th style="text-align: center; border: 1px solid #000; padding: 5px;">Total con IVA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;">${factura.num_factura}</td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;">${factura.numero_factura}</td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;">${factura.nombre_proveedor}</td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;">${factura.RFC_proveedor}</td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;">${parseFloat(factura.precio_sin_iva).toFixed(2)}</td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;">${(parseFloat(factura.precio_sin_iva) * 0.16).toFixed(2)}</td>
                            <td style="text-align: center; border: 1px solid #000; padding: 5px;">${parseFloat(factura.total_factura).toFixed(2)}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        var ventanaImpresion = window.open('', '_blank');
        ventanaImpresion.document.write('<html><head><title>Factura: ' + factura.numero_factura + '</title>');
        ventanaImpresion.document.write('<style>');
        ventanaImpresion.document.write('body { font-family: Arial, sans-serif; line-height: 1; }');
        ventanaImpresion.document.write('table { border-collapse: collapse; width: 100%; }');
        ventanaImpresion.document.write('th, td { border: 1px solid black; padding: 5px; text-align: center; }');
        ventanaImpresion.document.write('</style>');
        ventanaImpresion.document.write('</head><body>');
        ventanaImpresion.document.write(contenido);
        ventanaImpresion.document.write('</body></html>');
        ventanaImpresion.document.close();
        ventanaImpresion.print();
    }
</script>