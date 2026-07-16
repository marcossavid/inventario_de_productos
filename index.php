<?php
// index.php


// Si no hay usuario logueado, vamos al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

// Si está logueado, vamos a la home
header("Location: views/home.php");
exit();
?>