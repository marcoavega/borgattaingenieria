// Seleccionamos todos los formularios con la clase ".FormularioAjax"
const formularios_ajax = document.querySelectorAll(".FormularioAjax");

// Iteramos sobre cada formulario encontrado
formulario.addEventListener("submit", function(e) {
    e.preventDefault();
    let data = new FormData(this);
    let action = this.getAttribute("action");
    let method = this.getAttribute("method");

    fetch(action, {
        method: method,
        body: data
    })
    .then(response => response.json())
    .then(data => {
        if (data.tipo === "success") {
            window.location.reload();  // Recarga la página para reflejar los cambios en el stock
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.texto
            });
        }
    })
    .catch(error => console.error('Error:', error));
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
    }else if(alerta.tipo=="limpiar"){
        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if(result.isConfirmed){
                // Si el usuario confirma, limpiamos el formulario
                document.querySelector(".FormularioAjax").reset();
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

document.querySelectorAll(".FormularioAjax").forEach(formulario => {
    formulario.addEventListener("submit", function(e) {
        e.preventDefault(); // Prevenir el comportamiento por defecto de enviar formulario
        let data = new FormData(this); // Crear un FormData con los datos del formulario
        fetch(this.getAttribute("action"), {
            method: this.getAttribute("method"), // Método POST generalmente
            body: data  // Datos del formulario
        })
        .then(response => {
            if(response.ok) {
                window.location.reload(); // Recargar la página si la respuesta es exitosa
            } else {
                throw new Error('Algo salió mal en el servidor.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: No se pudo completar la solicitud.'); // Alerta simple si hay un error
        });
    });
});
