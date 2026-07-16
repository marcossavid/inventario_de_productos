<?php
require_once __DIR__ . '/../backend/auth.php'; 
?>
<!DOCTYPE html>
<!--archivo categorias.html-->
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Categorías</title>
     <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <header>
            <nav class="navbar">

                <ul class="nav-links">
                    <li><a href="home.php">Home</a></li>
                    
                     <li><a href="lista_categorias.html">Lista Categorias</a></li>
                      
                    
                
                </ul>
            </nav>
        </header>
    
    
    <div class="container mt-4">
        
        
        <form id="form-categoria" action="../backend/categorias.php" method="POST">
            <h3>Alta de Categorías</h3>
            <label for="nombre">Nombre de la Categoría</label><br>
            <input type="text" id="nombre" name="nombre"><br><br>
            
            <button type="submit" name="submit">Guardar</button>
            <button type="reset">Cancelar</button>
        </form>
        
        <br>
        <div>Autor Marcos Savid</div>
    </div>
    
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
      <script src= "../assets/js/validaciones.js" type = "text/javascript"> </script>

</body>
</html>