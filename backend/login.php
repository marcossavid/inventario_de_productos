<?php
//login.php
// --- INICIO DE SEGURIDAD Y CLASES ---
require_once __DIR__ . '/../class/session.php';
require_once __DIR__ . '/../class/autoload.php';
// --- FIN DE SEGURIDAD Y CLASES ---
require_once '../class/data_base.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = new DataBase();
    // Usamos el método select que ya tienes
    $usuario = $db->select("SELECT * FROM usuarios WHERE email = ?", [$email]);

    // Verificamos si existe el usuario y la contraseña coincide
    if ($usuario && password_verify($password, $usuario[0]['password'])) {
        $_SESSION['usuario_id'] = $usuario[0]['id'];
        // Redirigimos al home
        header("Location: ../views/home.php");
        exit();
    } else {
        // En lugar de una página en blanco con texto, mostramos una alerta y volvemos atrás
        echo "<script>alert('Email o contraseña incorrectos.'); window.location.href='../login.html';</script>";
        exit();
    }
} else {
    // Si alguien entra a login.php sin enviar el formulario, lo mandamos al login
    header("Location: ../login.html");
    exit();
}
?>