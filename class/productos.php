<?php
/*autor Marcos Savid*/
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
}
