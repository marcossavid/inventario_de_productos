<?php
//archivo class->autoload autor Marco Savid
spl_autoload_register(function($clase) {
    $ruta = __DIR__ . '/' . $clase . '.php';
    if (file_exists($ruta)) {
        require_once $ruta;
    }
});

if (isset($_POST['action'])) {

    include_once 'data_base.php';
    include_once 'categorias.php';
    include_once 'productos.php';

    $db = new DataBase();

    switch ($_POST['action']) {

        case 'listarCategorias':
            $categorias = $db->select("SELECT * FROM categorias");
            foreach ($categorias as $cat) {
                echo "<tr id='fila-categoria-".$cat['id']."'>";
                echo "<td>".$cat['id']."</td>";
                echo "<td>".$cat['nombre']."</td>";
                echo "<td class='text-center'>
                        <button class='btn btn-danger btn-sm btn-eliminar' data-id='".$cat['id']."'>Eliminar</button>
                    </td>";
                echo "</tr>";
            }
        break;

        // 🎯 NUEVO CASE INDEPENDIENTE: Para procesar la eliminación por AJAX
        case 'eliminarCategoria':
            $id = intval($_POST['id']); // Validamos el ID
            
            $query = "DELETE FROM categorias WHERE id = $id";
            
            // Usamos ->select() que ya sabemos que existe en tu archivo data_base.php
            $db->select($query); 

            // Devolvemos la respuesta limpia
            echo json_encode([
                'success' => true, 
                'message' => 'Categoría eliminada con éxito.'
            ]);
            exit;
        break;

        case 'listarProductos':
            $productos = $db->select("SELECT * FROM productos");

            foreach ($productos as $prod) {
                // Ruta de imágenes
                $rutaImagen = "../../assets/img/" . $prod['imagen'];

                echo "<tr>
                        <td>{$prod['id']}</td>
                        <td><img src='$rutaImagen' width='80'></td>
                        <td>{$prod['nombre']}</td>
                        <td>{$prod['descripcion']}</td>
                        <td>{$prod['categoria_id']}</td>
                        <td>{$prod['precio']}</td>
                      </tr>";
            }
        break;
    }
}
?>