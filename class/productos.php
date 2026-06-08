<?php
/*autor Marcos Savid*/
/*archivo de class->productos.php*/
require_once 'data_base.php';

class Productos {
    private $id;
    private $nombre;
    private $imagen;
    private $descripcion;
    private $categoria;
    private $precio;
    private $db;

    public function __construct() {
        $this->db = new DataBase;
    }

    // --- Setters ---
    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setImagen($imagen) { $this->imagen = $imagen; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    public function setCategoria($categoria) { $this->categoria = $categoria; }
    public function setPrecio($precio) { $this->precio = $precio; }

    // --- Guardar producto ---
    public function guardar() {
        $sql = "INSERT INTO productos (nombre, imagen, descripcion, categoria_id, precio)
                VALUES (?, ?, ?, ?, ?)";

        $params = [$this->nombre, $this->imagen, $this->descripcion, $this->categoria, $this->precio];
        return $this->db->insert($sql, $params);
    }

    // --- Eliminar producto ---
    public function eliminar($id) {
        $sql = "DELETE FROM productos WHERE id = ?";
        $params = [$id];
        return $this->db->delete($sql, $params);
    }

    // api: join entre la tabla productos y categoria
public function listarConCategorias() {
    $db = new Database();
    $sql = "SELECT p.id, p.nombre, p.precio, p.descripcion, p.imagen, 
            c.nombre AS categoria
            FROM productos p
            INNER JOIN categorias c
            ON p.categoria_id = c.id";
            
    return $db->select($sql);
}

}
?>