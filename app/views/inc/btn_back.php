<!-- Contenedor para el botón de regreso. Las clases 'd-flex', 'pt-4' y 'pb-4' se usan para agregar relleno en la parte superior e inferior, respectivamente. -->
<div class="d-flex pt-4 pb-4">
    <!-- Botón para regresar a la página anterior. La clase 'btn' es una clase general para botones en Bootstrap y 'btn-primary' le da al botón un estilo específico (color de fondo azul). -->
    <button class="btn btn-primary btn-back">Ir a Inicio</button>
</div>

<!-- Código JavaScript para agregar un evento de clic al botón de regreso -->
<script type="text/javascript">
    // Selecciona el botón de regreso
    let btn_back = document.querySelector(".btn-back");

    // Agrega un evento de clic al botón de regreso
    btn_back.addEventListener('click', function(e){
        // Previene el comportamiento por defecto del evento de clic
        e.preventDefault();
        // Regresa al usuario a la página anterior
        window.location.href = '<?php echo APP_URL; ?>/dashboard';
        //window.history.back();
    });
</script>