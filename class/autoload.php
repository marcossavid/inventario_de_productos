<?php
// class/autoload.php
spl_autoload_register(function($clase) {
    $archivo = strtolower($clase) . '.php';
    $ruta = __DIR__ . '/' . $archivo;
    
    // Si la clase ya existe, no hagas nada
    if (class_exists($clase, false)) {
        return;
    }
    
    if (file_exists($ruta)) {
        require_once $ruta;
    }
});
?>