<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>regNumeroLote/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Nº Lote
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>consultaNumeroLote/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Consultar Nº Lote
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>regNumeroSerie/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Nº Serie
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>consultaNumeroSerie/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Consultar Nº Serie
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>salidasProductoTerminado/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Salidas
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>salidaPTNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registro Salidas Nº Serie
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>salidaPTSearch/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Consultar Vale Salida
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>numSerSearch/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Consultar Registros
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9 col-lg-10 py-4">
            
            <h4 class="text-center">Nuevo Número de Serie</h4>

            <!-- Contenedor para el formulario de creación de producto -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <?php
                    // Importa el controlador de productos
                    use app\controllers\numSerieController;

                    // Crea una instancia del controlador
                    $instanciasLoteProducto = new numSerieController();

                    // Obtiene las opciones de proveedores.
                    $opcionesLotes = $instanciasLoteProducto->obtenerOpcionesNumLotes();
                    $opcionesProductoFinal= $instanciasLoteProducto->obtenerOpcionesProductoFinal();
                    
                    
                    ?>
                   
                  <!-- Formulario de creación de orden -->
<!-- Asegúrate de incluir SweetAlert2 en tu header -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Formulario de creación de orden -->
<form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/numSerieAjax.php"
    method="POST" autocomplete="off" enctype="multipart/form-data" id="formNumSerie">
    <!-- Campo oculto para el módulo de orden compra -->
    <input type="hidden" name="modulo_numero_serie" value="registrar">

    <div class="row">
        <!-- Campo de selección para el proveedor del producto -->
        <div class="mb-3">
            <label for="id_lote" class="form-label">Lotes disponibles</label>
            <select class='form-control' name='id_lote' id='id_lote' required>
                <option value="">Selecciona un Lote</option>
                <?php echo $opcionesLotes; ?>
            </select>
        </div>
    </div>

    <div class="row">
        <!-- Campo de selección para el producto -->
        <div class="mb-3">
            <label for="id_p_f" class="form-label">Productos Disponibles</label>
            <select class='form-control' name='id_p_f' id='id_p_f' required>
                <option value="">Selecciona un Producto</option>
                <?php echo $opcionesProductoFinal; ?>
            </select>
        </div>
    </div>

    <div class="row">
        <!-- Campo de selección para cantidad de números de serie -->
        <div class="mb-3">
            <label for="cantidad_series" class="form-label">Cantidad de números de serie a generar</label>
            <select class='form-control' name='cantidad_series' id='cantidad_series' required>
                <?php
                for($i = 1; $i <= 100; $i++) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <!-- Botón para enviar el formulario -->
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
        <button type="submit" class="btn btn-primary" id="submitBtn">Guardar</button>
    </div>
</form>

<script>
document.getElementById('formNumSerie').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Deshabilitar el botón mientras se procesa
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Procesando...';
    
    // Crear objeto FormData con los datos del formulario
    const formData = new FormData(this);
    
    // Realizar la petición AJAX
    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.text(); // Primero obtenemos el texto de la respuesta
    })
    .then(responseText => {
        console.log('Respuesta del servidor:', responseText); // Debug
        
        let data;
        try {
            data = JSON.parse(responseText);
        } catch (e) {
            console.error('Error al parsear JSON:', e);
            console.log('Texto recibido:', responseText);
            throw new Error('Respuesta no válida del servidor');
        }

        // Verificar que data tenga la estructura esperada
        if (!data || !data.tipo || !data.titulo || !data.texto) {
            throw new Error('Estructura de respuesta inválida');
        }

        // Mostrar la alerta con SweetAlert2
        return Swal.fire({
            icon: data.icono || 'info',
            title: data.titulo,
            text: data.texto,
            confirmButtonText: 'Aceptar'
        });
    })
    .then((result) => {
        if (result.isConfirmed) {
            // Limpiar el formulario solo si la operación fue exitosa
            document.getElementById('formNumSerie').reset();
            
            // Opcional: recargar la página
            // window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error detallado:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error en el proceso',
            text: 'Hubo un problema al procesar la solicitud. Por favor, intente nuevamente.'
        });
    })
    .finally(() => {
        // Reactivar el botón
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Guardar';
    });
});
</script>