<?php

// Registro del autoloader para cargar clases automáticamente
spl_autoload_register(function($clase){

    // Construyendo la ruta del archivo de la clase
    $archivo = __DIR__ . "/" . $clase . ".php";
    $archivo = str_replace("\\", "/", $archivo);

    // Verificando si el archivo existe y cargándolo
    if (is_file($archivo)) {
        require_once $archivo;
    } 
});
