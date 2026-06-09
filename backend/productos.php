<?php
//autor marcos savid
//archivo de backend->productos.php
require_once '../class/productos.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // --- NUEVO: ACCIÓN PARA ELIMINAR DESDE EL HOME VIA AJAX ---
    if (isset($_POST['action']) && $_POST['action'] === 'eliminar') {
        ob_clean();
        header('Content-Type: application/json; charset=utf-8');
        
        $id = $_POST['id'] ?? NULL;
        
        if ($id) {
            $producto = new Productos();
            if ($producto->eliminar($id)) {
                echo json_encode(['success' => true, 'message' => 'Producto eliminado correctamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el producto de la base de datos.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ID de producto no válido.']);
        }
        exit;
    }

    // --- (Tu código existente para procesar el guardado de producto tradicional) ---
    if (empty($_POST) && !empty($_FILES)) {
         die("ERROR: La petición es POST, pero \$POST está vacío.");
    }
    
    $nombre = $_POST['nombre'] ?? NULL;
    $descripcion = $_POST['descripcion'] ?? NULL;
    $categoria = $_POST['categoria'] ?? NULL; 
    $precio = $_POST['precio'] ?? NULL;
    $imagen = NULL;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreOriginal = $_FILES['imagen']['name'];
        $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
        $nuevoNombre = uniqid('img_') . '.' . $extension;
        $rutaDestino = "../assets/img/" . $nuevoNombre;
        
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            $imagen = $nuevoNombre; 
        }
    }

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
    // --- CANAL GET ---
    
    // CASO A: Petición desde el Home para ver la lista completa con nombres de categorías
    if (isset($_GET['action']) && $_GET['action'] === 'listarHome') {
        ob_clean();
        $producto = new Productos();
        // Usamos el método con INNER JOIN que armaste en class/productos.php
        $listaProductos = $producto->listarConCategorias(); 
        
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($listaProductos ?? []);
        exit;
    }

    // CASO B: Petición desde productos.html para cargar el elemento <select>
    ob_start(); 
    require_once '../class/categorias.php';
    $objCategorias = new Categorias();
    $listaCategorias = $objCategorias->listarTodas(); 
    ob_clean(); 

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($listaCategorias ?? []);
    exit; 
}    
?>