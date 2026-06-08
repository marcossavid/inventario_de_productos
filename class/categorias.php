<?php
/*autor Marcos Savid*/
require_once 'data_base.php';

class Categorias {
    private $id;
    private $nombre;
    private $db;

    public function __construct() {
        $this->db = new DataBase();
    }

    // --- Setters ---
    public function setId($id) { 
        $this->id = $id; 
    }

    public function setNombre($nombre) { 
        $this->nombre = $nombre; 
    }

    // --- Método guardar ---
    public function guardar() { 
        $sql = "INSERT INTO categorias (nombre) VALUES (?)";
        $params = [$this->nombre];
        return $this->db->insert($sql, $params);
    }

    // --- Método eliminar ---
    public function eliminar($id) {
        $sql = "DELETE FROM categorias WHERE id = ?";
        $params = [$id];
        return $this->db->delete($sql, $params);
    }
}
?>
