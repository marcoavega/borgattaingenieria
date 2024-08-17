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
