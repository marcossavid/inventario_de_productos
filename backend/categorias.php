<?php
/*autor Marcos Savid*/
require_once '../class/categorias.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $nombre = $_POST['nombre'] ?? '';

    if (!empty($nombre)) {

        $categoria = new Categorias();
        $categoria->setNombre($nombre);
        $categoria->guardar();

        echo "<script>alert('Categoría guardada correctamente'); 
        window.location.href='../views/home.html';</script>";

    } else {

        echo "<script>alert('Debe ingresar un nombre de categoría'); 
        window.history.back();</script>";
    }

}
?>
