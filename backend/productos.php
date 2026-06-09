<?php
//autor marcos savid
//archivo de backend->productos.php
require_once '../class/productos.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // --- ACCIÓN 1: ELIMINAR DESDE EL HOME VIA AJAX ---
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

    // --- ACCIÓN 2: EDITAR DESDE EL MODAL DEL HOME VIA AJAX ---
    if (isset($_POST['action']) && $_POST['action'] === 'editar') {
        ob_clean();
        header('Content-Type: application/json; charset=utf-8');

        $id = $_POST['id'] ?? NULL;
        $sku = $_POST['sku'] ?? NULL;
        $nombre = $_POST['nombre'] ?? NULL;
        $cantidad = $_POST['cantidad'] ?? 0; 
        $categoria = $_POST['categoria'] ?? NULL;
        $precio = $_POST['precio'] ?? NULL;
        $imagen = NULL;

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Falta el ID del producto para poder editarlo.']);
            exit;
        }

        // Si subieron una imagen nueva, la procesamos
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreOriginal = $_FILES['imagen']['name'];
            $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
            $nuevoNombre = uniqid('img_') . '.' . $extension;
            $rutaDestino = "../assets/img/" . $nuevoNombre;
            
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                $imagen = $nuevoNombre; 
            }
        }

        // Primero instanciamos el objeto y DESPUÉS le pasamos los datos
        $producto = new Productos();
        $producto->setId($id);
        $producto->setSku($sku);
        $producto->setNombre($nombre);
        $producto->setCantidad($cantidad); // 🎯 CORREGIDO
        $producto->setCategoria($categoria);
        $producto->setPrecio($precio);
        $producto->setImagen($imagen); 

        if ($producto->actualizar()) {
            echo json_encode(['success' => true, 'message' => 'Producto actualizado con éxito.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se realizaron cambios o hubo un error en la base de datos.']);
        }
        exit;
    }

    // --- ACCIÓN 3: GUARDADO TRADICIONAL (Alta de Producto) ---
    if (empty($_POST) && !empty($_FILES)) {
         die("ERROR: La petición es POST, pero \$POST está vacío.");
    }
    
    $nombre = $_POST['nombre'] ?? NULL;
    $sku = $_POST['sku'] ?? NULL; 
    $cantidad = $_POST['cantidad'] ?? 0; 
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

    // Instanciamos y seteamos la cantidad correctamente
    $producto = new Productos();
    $producto->setNombre($nombre);
    $producto->setSku($sku); 
    $producto->setCantidad($cantidad); // 🎯 CORREGIDO
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
    
    // CASO A: Petición desde el Home para ver la lista completa
    if (isset($_GET['action']) && $_GET['action'] === 'listarHome') {
        ob_clean();
        $producto = new Productos();
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