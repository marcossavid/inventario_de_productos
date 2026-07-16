<?php
// --- INICIO DE SEGURIDAD Y CLASES ---
require_once __DIR__ . '/../class/session.php';
require_once __DIR__ . '/../class/autoload.php';
// --- FIN DE SEGURIDAD Y CLASES ---
session_unset(); // Borra las variables de sesión
session_destroy(); // Destruye la sesión
header("Location: ../login.html"); // Regresa al login
exit();
?>