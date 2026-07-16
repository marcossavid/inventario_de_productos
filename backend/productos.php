<?php
// backend/productos.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/auth.php';
if (!class_exists('Productos')) require_once __DIR__ . '/../class/productos.php';
if (!class_exists('Categorias')) require_once __DIR__ . '/../class/categorias.php';

ob_clean();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? 'guardar'; // Si no viene acción, asume guardar
    $producto = new Productos();

    // --- ACCIÓN: ELIMINAR ---
    if ($action === 'eliminar') {
        header('Content-Type: application/json; charset=utf-8');
        $id = $_POST['id'] ?? null;
        if ($id && $producto->eliminarPorUsuario($id, $usuario_id)) {
            echo json_encode(['success' => true, 'message' => 'Producto eliminado.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar.']);
        }
        exit;
    }

    // --- ACCIÓN: EDITAR ---
    if ($action === 'editar') {
        header('Content-Type: application/json; charset=utf-8');
        $producto->setId($_POST['id']);
        $producto->setUsuarioId($usuario_id);
        $producto->setSku($_POST['sku']);
        $producto->setNombre($_POST['nombre']);
        $producto->setCantidad($_POST['cantidad']);
        $producto->setCategoria($_POST['categoria']);
        $producto->setPrecio($_POST['precio']);
        
        if ($producto->actualizarPorUsuario()) {
            echo json_encode(['success' => true, 'message' => 'Actualizado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar.']);
        }
        exit;
    }

    // --- ACCIÓN: GUARDAR (Alta) ---
    try {
        $producto->setNombre($_POST['nombre'] ?? '');
        $producto->setSku($_POST['sku'] ?? '');
        $producto->setCantidad($_POST['cantidad'] ?? 0);
        $producto->setPrecio($_POST['precio'] ?? 0);
        $producto->setCategoria($_POST['categoria'] ?? 0);
        $producto->setUsuarioId($usuario_id);

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $nombreImagen = time() . '_' . $_FILES['imagen']['name'];
            move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../assets/uploads/' . $nombreImagen);
            $producto->setImagen($nombreImagen);
        }

        if ($producto->guardar()) {
            header('Location: ../views/productos.php?msg=exito');
        } else {
            throw new Exception("Error al guardar en base de datos.");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    exit;

} else {
    // --- LÓGICA GET (Listado) ---
    header('Content-Type: application/json; charset=utf-8');

    if (isset($_GET['action']) && $_GET['action'] === 'listarHome') {
        $producto = new Productos();
        echo json_encode($producto->listarPorUsuario($usuario_id) ?? []);
    } else {
        $objCategorias = new Categorias();
        echo json_encode($objCategorias->listarPorUsuario($usuario_id) ?? []);
    }
    exit;
}
?>