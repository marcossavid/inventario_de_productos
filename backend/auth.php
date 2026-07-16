<?php
// backend/auth.php
require_once __DIR__ . '/../class/session.php';
// Comenta la siguiente línea para probar:
// require_once __DIR__ . '/../class/autoload.php';

if (!isset($_SESSION['usuario_id'])) {
    // Si es AJAX, responde JSON. Si no, redirige.
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Sesión expirada.']);
        exit;
    }
    header("Location: ../login.html"); // Usa ruta absoluta a la raíz
    exit();
}
$usuario_id = $_SESSION['usuario_id'];
?>