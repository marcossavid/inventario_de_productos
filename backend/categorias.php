<?php
// backend/categorias.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/auth.php'; // Incluimos autenticación primero
require_once __DIR__ . '/../class/autoload.php'; // Incluimos el autoload

$objCategorias = new Categorias();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // --- ACCIÓN: LISTAR ---
    if ($action === 'listarCategorias') {
        $lista = $objCategorias->listarPorUsuario($usuario_id);
        if ($lista) {
            foreach ($lista as $cat) {
                echo "<tr id='fila-categoria-{$cat['id']}'>
                        <td>{$cat['id']}</td>
                        <td>{$cat['nombre']}</td>
                        <td class='text-center'>
                            <button class='btn btn-danger btn-sm btn-eliminar' data-id='{$cat['id']}'>Eliminar</button>
                        </td>
                      </tr>";
            }
        }
    }

    // --- ACCIÓN: ELIMINAR ---
    elseif ($action === 'eliminarCategoria') {
        $id = intval($_POST['id'] ?? 0);
        $resultado = $objCategorias->eliminarPorUsuario($id, $usuario_id);
        echo json_encode(['success' => $resultado, 'message' => $resultado ? 'Categoría eliminada' : 'Error al eliminar']);
        exit;
    }

    // --- ACCIÓN: GUARDAR (Alta de categoría) ---
    else {
        $nombre = $_POST['nombre'] ?? '';
        if (!empty($nombre)) {
            $objCategorias->setNombre($nombre);
            $objCategorias->setUsuarioId($usuario_id); 
            if ($objCategorias->guardar()) {
                echo "<script>alert('Categoría guardada'); window.location.href='../views/lista_categorias.php';</script>";
            } else {
                echo "<script>alert('Error al guardar'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('El nombre está vacío'); window.history.back();</script>";
        }
    }
}
?>