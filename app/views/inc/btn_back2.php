<!-- Contenedor para el botón de regreso. Se reduce el padding superior e inferior -->
<div class="d-flex pt-2 pb-2">
    <!-- Botón con tamaño pequeño y menor padding usando solo clases de Bootstrap -->
    <button class="btn btn-primary btn-sm px-2 py-1 btn-back">Regresar</button>
</div>

<!-- Código JavaScript para agregar un evento de clic al botón de regreso -->
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        // Selecciona el botón de regreso
        let btn_back = document.querySelector(".btn-back");

        if (btn_back) {
            // Agrega un evento de clic al botón de regreso
            btn_back.addEventListener('click', function(e){
                // Previene el comportamiento por defecto del evento de clic
                e.preventDefault();
                // Regresa al usuario a la página anterior
                window.history.back();
            });
        } else {
            console.error('El botón de regreso no se encontró en la página.');
        }
    });
</script>
