<!-- Contenedor principal -->
<div class="container-fluid mb-4">
    <?php
    // Obtiene el ID del producto a editar
    $id = $insLogin->limpiarCadena($url[1]);
    ?>
    <!-- Título de la página -->
    <h1 class="display-4 text-center">Descontar Inventario</h1>
    <!-- Subtítulo de la página -->
    <h2 class="lead text-center"></h2>
</div>

<!-- Contenedor para el formulario de edición de producto -->
<div class="container py-4">
    <?php
    // Importa el controlador de productos
    use app\controllers\inventoryController;

    // Crea una instancia del controlador
    $insInventory = new inventoryController();

    // Obtiene las opciones de categorías, proveedores, unidades de medida y tipos de moneda
    $opcionesProductos = $insInventory->obtenerOpcionesProductos();
    $opcionesAlmacenes = $insInventory->obtenerOpcionesAlmacenes();
 
    // Comprueba si se obtuvieron los datos del producto
    // Obtiene los datos del producto a editar
    $datos = $insLogin->seleccionarDatos("Unico", "productos", "id_producto", $id);
    $datos2 = $insLogin->seleccionarDatos2("Unico", "stock_almacen", "id_producto", $id);

    if ($datos->rowCount() == 1) {
        $datos = $datos->fetch();
        ?>
    <?php
    // Incluye el botón de regreso
    include "./app/views/inc/btn_back2.php";
    ?>
    <!-- Formulario de edición de producto -->
    <form class="FormularioAjax p-4 border rounded-3" action="<?php echo APP_URL; ?>app/ajax/inventoryAjax.php"
        method="POST" autocomplete="off">

        <!-- Campo oculto para el módulo de producto y el ID del producto -->
        <input type="hidden" name="modulo_Inventory" value="registrar">
        <input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">

        <!-- Campo para el código del producto 
        <div class="mb-3">
            <label for="id_producto" class="form-label">Id Producto</label>
            <input type="text" class="form-control" id="id_producto" name="id_producto" maxlength="100"
                value="<?php // echo $datos['id_producto']; ?>" required readonly>
        </div>-->

        <!-- Campo para mostrar el nombre del producto -->
<div class="mb-3">
    <label for="nombre_producto" class="form-label">Nombre del Producto</label>
    <input type="text" class="form-control" id="nombre_producto" value="<?php echo htmlspecialchars($datos['nombre_producto']); ?>" readonly>
</div>


<?php
$datos = $insLogin->seleccionarDatos2("Unico", "productos", "id_producto", $id);
if ($datos->rowCount() > 0) {
    while ($fila = $datos->fetch(PDO::FETCH_ASSOC)) {
        echo '<div>';
        echo '<input type="text" class="form-control w-100" name="stock_' . htmlspecialchars($fila['nombre_almacen'], ENT_QUOTES, 'UTF-8') . '" value="Stock en ' . htmlspecialchars($fila['nombre_almacen'], ENT_QUOTES, 'UTF-8') . ': ' . htmlspecialchars($fila['stock'], ENT_QUOTES, 'UTF-8') . '" readonly>';
        echo '</div>';
    }
} else {
    echo '<p>Error: Producto no encontrado.</p>';
}?>
       
       
       <!-- Campo de selección para el almacén de origen -->
<div class="mb-3">
    <label for="id_almacen_origen" class="form-label">Almacén</label>
    <select class='form-control' name='id_almacen_origen' id='id_almacen_origen' required>
        <option value="">Selecciona un almacén a descontar</option>
        <?php echo $opcionesAlmacenes; ?>
    </select>
</div>

<!-- Campo para la cantidad de producto a descontar -->
<div class="mb-3">
    <label for="stock" class="form-label">Cantidad a descontar:</label>
    <input type="number" class="form-control" id="stock" name="stock" required>
</div>
       

        <!-- Botón para enviar el formulario -->
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
            <button type="submit" class="btn btn-primary">Realizar movimiento</button>
        </div>
    </form>

    <?php
    } else {
        // Si no se obtuvieron los datos del producto, muestra un mensaje de error
        include "./app/views/inc/error_alert.php";
    }
    ?>
</div>
<script>
   // Seleccionamos todos los formularios con la clase ".FormularioAjax"
const formularios_ajax = document.querySelectorAll(".FormularioAjax");

// Iteramos sobre cada formulario encontrado
formularios_ajax.forEach(formularios => {

    // Añadimos un event listener para el evento submit de cada formulario
    formularios.addEventListener("submit",function(e){
        
        // Prevenimos el comportamiento por defecto del evento submit
        e.preventDefault();

        // Usamos la librería SweetAlert para mostrar un mensaje de confirmación
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Quieres realizar la acción solicitada",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, realizar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.isConfirmed){
                // Si el usuario confirma, recogemos los datos del formulario
                let data = new FormData(this);
                let method = this.getAttribute("method");
                let action = this.getAttribute("action");

                // Configuramos los headers de la petición
                let encabezados = new Headers();

                // Configuramos la petición
                let config = {
                    method: method,
                    headers: encabezados,
                    mode: 'cors',
                    cache: 'no-cache',
                    body: data
                };

                // Realizamos la petición
                fetch(action,config)
                .then(respuesta => respuesta.json())
                .then(respuesta =>{ 
                    // Llamamos a la función alertas_ajax con la respuesta recibida
                    return alertas_ajax(respuesta);
                });
            }
        });
    });
});

// Esta función muestra diferentes alertas dependiendo del tipo de alerta recibida
function alertas_ajax(alerta){
    if(alerta.tipo=="simple"){
        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        });
    }else if(alerta.tipo=="recargar"){
        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if(result.isConfirmed){
                // Si el usuario confirma, recargamos la página
                location.reload();
            }
        });
    } else if(alerta.tipo=="limpiar"){
        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if(result.isConfirmed){
                // Si el usuario confirma, recargamos la página
                location.reload();
            }
        });
    }else if(alerta.tipo=="redireccionar"){
        // Si el tipo de alerta es redireccionar, redirigimos al usuario a la url especificada
        window.location.href=alerta.url;
    }
}

// Seleccionamos el botón con id "btn_exit"
let btn_exit=document.getElementById("btn_exit");

// Añadimos un event listener para el evento click del botón
btn_exit.addEventListener("click", function(e){
    // Prevenimos el comportamiento por defecto del evento click
    e.preventDefault();
    
    Swal.fire({
        title: '¿Quieres salir del sistema?',
        text: "La sesión actual se cerrará y saldrás del sistema",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, salir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, le redirigimos a la url especificada en el href del botón
            let url=this.getAttribute("href");
            window.location.href=url;
        }
    });
});

</script>