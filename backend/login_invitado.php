<?php
// backend/login_invitado.php
session_start();

// 1. Incluimos la base de datos
require_once __DIR__ . '/../class/data_base.php';
$db = new DataBase();

/** * CONFIGURACIÓN DEL INVITADO
 * Debes tener un usuario en tu tabla 'usuarios' con este correo o este ID.
 * Cambia el ID '999' por el ID real de tu usuario invitado en la BD.
 */
$id_invitado = 2; 

// 2. Verificamos que el usuario invitado exista realmente
$usuario = $db->select("SELECT id, email FROM usuarios WHERE id = ?", [$id_invitado]);

if (!empty($usuario)) {
    // 3. Iniciamos la sesión manualmente
    $_SESSION['usuario_id'] = $usuario[0]['id'];
    $_SESSION['usuario_email'] = $usuario[0]['email'];
    $_SESSION['es_invitado'] = true; // Opcional, por si quieres identificarlo

    // 4. Redirigimos al home
    header("Location: ../views/home.php");
    exit();
} else {
    // Si no existe, damos un error simple
    echo "<script>alert('Error: Usuario invitado no configurado en la base de datos.'); window.location.href='../index.php';</script>";
    exit();
}
?>