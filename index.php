<?php
// Redirigir al home / aautor marcos savid
if (isset($_POST['action'])) {
    header('Location: views/home.html');
    exit();
}

require_once 'class/autoload.php';

$productos = new Productos();
$listado = $productos->listarConCategorias();

if (isset($_POST['action']) && $_POST['action'] === 'listarHome') {

    foreach ($listado as $prod) {
        // SOLUCIÓN: Se usa la concatenación de cadenas (.) para inyectar las variables.
        // También se corrige el path de la imagen que faltaba el punto (./) si se ejecuta desde la raíz.
        echo '
        <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="product-card">
                <img src="./assets/img/' . $prod['imagen'] . '" class="product-image">
                <h5><strong>' . $prod['nombre'] . '</strong></h5>
                <p class="text-muted">' . $prod['categoria'] . '</p>
                <p>' . $prod['descripcion'] . '</p>
                <p><strong>$' . $prod['precio'] . '</strong></p>
            </div>
        </div>';
    }

    exit;
}
?>