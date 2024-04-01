<?php
    // Establece el nombre de la sesión al valor definido en la constante APP_SESSION_NAME
    session_name(APP_SESSION_NAME);

    // Configura los parámetros de la cookie de sesión para mayor seguridad y para que expire cuando se cierre el navegador
    session_set_cookie_params([
        'lifetime' => 0,             // La cookie expira cuando se cierra el navegador
        'secure' => true,            // Envía la cookie solo sobre HTTPS
        'httponly' => true,          // Hace la cookie accesible solo a través del protocolo HTTP
        'samesite' => 'Strict',      // Previene ataques de tipo CSRF
    ]);

    // Inicia una nueva sesión o reanuda una sesión existente
    session_start();

    // Regenera el ID de la sesión para prevenir el secuestro de sesión
    session_regenerate_id(true);

    // Comprueba si se ha establecido la variable de sesión LAST_ACTIVITY
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600000)) {
        // Si ha pasado más de 30 minutos desde la última actividad del usuario, destruye la sesión
        session_unset();     // Libera todas las variables de sesión
        session_destroy();   // Destruye toda la información registrada de la sesión
    }

    // Actualiza la última actividad del usuario a la hora actual
    $_SESSION['LAST_ACTIVITY'] = time();
?>