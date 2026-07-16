<?php
/*autor Marcos Savid*/
/*archivo de class->categorias.php*/
require_once 'data_base.php';

if (!class_exists('Categorias')) {
class Categorias {
    private $id;
    private $nombre;
    private $usuario_id; // 🎯 NUEVO: Para identificar al dueño
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

    public function setUsuarioId($usuario_id) { 
        $this->usuario_id = $usuario_id; 
    }

    // --- Método guardar (seguro) ---
    public function guardar() { 
        $sql = "INSERT INTO categorias (nombre, usuario_id) VALUES (?, ?)";
        $params = [$this->nombre, $this->usuario_id];
        return $this->db->insert($sql, $params);
    }

    // --- Método eliminar (seguro) ---
    public function eliminarPorUsuario($id, $usuario_id) {
        // Borra solo si el id de la categoría pertenece al usuario
        $sql = "DELETE FROM categorias WHERE id = ? AND usuario_id = ?";
        $params = [$id, $usuario_id];
        return $this->db->delete($sql, $params);
    }

    // --- Método para traer solo las categorías del usuario logueado ---
    public function listarPorUsuario($usuario_id) {
        $sql = "SELECT id, nombre FROM categorias WHERE usuario_id = ? ORDER BY nombre ASC";
        return $this->db->select($sql, [$usuario_id]);
    }
}}
?>