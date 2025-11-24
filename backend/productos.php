<?php

require_once '../class/productos.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    $categoria = $_POST['categoria'] ?? null;
    $precio = $_POST['precio'] ?? null;

    // Procesar Imagen
    $imagen = null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreOriginal = $_FILES['imagen']['name'];
        $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
        
        // Generar nombre Unico
        $nuevoNombre = uniqid('img_') . '.' . $extension;
        
        // Ruta destino
        $rutaDestino = "../assets/img/" . $nuevoNombre;
        
        // Mover archivo
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            $imagen = $nuevoNombre; // Guardamos solo el nombre en DB
        } else {
            die('Error al mover la imagen al servidor.');
        }
    }
// Crear producto
$producto = new Productos();
$producto->setNombre($nombre);
$producto->setDescripcion($descripcion);
$producto->setCategoria($categoria);
$producto->setPrecio($precio);
$producto->setImagen($imagen);

if ($producto->guardar()) {
    echo "<script>alert('Producto guardado correctamente'); window.location.href='views/lista_productos.html';</script>";
} else {
    echo "<script>alert('Error al guardar el producto'); window.history.back();</script>";
}

} else {
    include 'views/productos.html';
}    