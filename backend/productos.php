<?php
//autor marcos savid
//archivo de backend->productos.php
require_once '../class/productos.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // *** VERIFICACIÓN CRÍTICA ***
    if (empty($_POST) && !empty($_FILES)) {
         die("ERROR: La petición es POST, pero \$POST está vacío. Revisa 'post_max_size' y 'upload_max_filesize' en php.ini.");
    }
    // ***************************
    $nombre = $_POST['nombre'] ?? NULL;
    $descripcion = $_POST['descripcion'] ?? NULL;
    $categoria = $_POST['categoria'] ?? NULL;
    $precio = $_POST['precio'] ?? NULL;

    // Procesar Imagen
    $imagen = NULL;

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
    echo "<script>alert('Producto guardado correctamente'); window.location.href='../views/home.html';</script>";
} else {
    echo "<script>alert('Error al guardar el producto'); window.history.back();</script>";
}

} else {
    // Si no es POST, incluye la vista del formulario
    include 'views/productos.html';
}    
?>