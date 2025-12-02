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
                echo "<tr>
                        <td>{$cat['id']}</td>
                        <td>{$cat['nombre']}</td>
                      </tr>";
            }
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
