<?php
// backend/registro.php
require_once '../class/data_base.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    // IMPORTANTE: password_hash es el estándar de seguridad en PHP
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $db = new DataBase();
    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
    
    try {
        if ($db->insert($sql, [$nombre, $email, $password])) {
            echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.'); window.location.href='../login.html';</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('El email ya está registrado o hubo un error.'); window.history.back();</script>";
    }
}
?>