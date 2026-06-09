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
        $nuevoNombre = uniqid('img_') . '.' . $extension;
        $rutaDestino = "../assets/img/" . $nuevoNombre;
        
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            $imagen = $nuevoNombre; 
        } else {
            die('Error al mover la imagen al servidor.');
        }
    }

    // Crear producto y guardar
    $producto = new Productos();
    $producto->setNombre($nombre);
    $producto->setDescripcion($descripcion);
    $producto->setCategoria($categoria);
    $producto->setPrecio($precio);
    $producto->setImagen($imagen);

    if ($producto->guardar()) {
        echo "<script>alert('Producto guardado correctamente'); window.location.href='views/productos.html';</script>";
    } else {
        echo "<script>alert('Error al guardar el producto'); window.history.back();</script>";
    }

} else {
    // --- SECCIÓN FETCH ---
    // Forzamos que si hay un error previo de PHP no ensucie el JSON
    ob_clean(); 
    
    // Traemos la clase categoría que está afuera de backend
    require_once '../class/categorias.php';
    
    if (class_exists('Categorias')) {
        $objCategorias = new Categorias();
        
        // Verificamos si el método existe para que no tire Error 500
        if (method_exists($objCategorias, 'listarTodas')) {
            $listaCategorias = $objCategorias->listarTodas();
        } else {
            // Si no existe listarTodas(), usamos un método alternativo que tengas o mandamos vacío
            $listaCategorias = [];
        }
    } else {
        $listaCategorias = [];
    }

    // Devolvemos el JSON de manera estricta
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($listaCategorias ?? []);
    exit; 
}    
?>