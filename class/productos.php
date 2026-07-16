<?php
/*autor Marcos Savid*/
/*archivo de class->productos.php*/
require_once 'data_base.php';

if (!class_exists('Productos')) {
    class Productos {
        private $id;
        private $nombre;
        private $sku;
        private $imagen;
        private $cantidad;
        private $categoria; // Este es el categoria_id
        private $precio;
        private $usuario_id;
        private $db;

        public function __construct() {
            $this->db = new DataBase();
        }

        // --- Setters ---
        public function setId($id) { $this->id = $id; }
        public function setNombre($nombre) { $this->nombre = $nombre; }
        public function setSku($sku) { $this->sku = $sku; }
        public function setImagen($imagen) { $this->imagen = $imagen; }
        public function setCantidad($cantidad) { $this->cantidad = $cantidad; }
        public function setCategoria($categoria) { $this->categoria = $categoria; }
        public function setPrecio($precio) { $this->precio = $precio; }
        public function setUsuarioId($usuario_id) { $this->usuario_id = $usuario_id; }

        // --- Guardar producto ---
        public function guardar() {
            $sql = "INSERT INTO productos (nombre, sku, imagen, cantidad, categoria_id, precio, usuario_id)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $params = [$this->nombre, $this->sku, $this->imagen, $this->cantidad, $this->categoria, $this->precio, $this->usuario_id];
            return $this->db->insert($sql, $params);
        }

        // --- Actualizar producto (seguro) ---
        public function actualizarPorUsuario() {
            if (!empty($this->imagen)) {
                $sql = "UPDATE productos SET nombre = ?, sku = ?, imagen = ?, cantidad = ?, categoria_id = ?, precio = ? 
                        WHERE id = ? AND usuario_id = ?";
                $params = [$this->nombre, $this->sku, $this->imagen, $this->cantidad, $this->categoria, $this->precio, $this->id, $this->usuario_id];
            } else {
                $sql = "UPDATE productos SET nombre = ?, sku = ?, cantidad = ?, categoria_id = ?, precio = ? 
                        WHERE id = ? AND usuario_id = ?";
                $params = [$this->nombre, $this->sku, $this->cantidad, $this->categoria, $this->precio, $this->id, $this->usuario_id];
            }
            return $this->db->update($sql, $params);
        }

        // --- Eliminar producto (seguro) ---
        public function eliminarPorUsuario($id, $usuario_id) {
            $sql = "DELETE FROM productos WHERE id = ? AND usuario_id = ?";
            return $this->db->delete($sql, [$id, $usuario_id]);
        }

        // --- Listar productos (Corregido para evitar duplicados) ---
        public function listarPorUsuario($usuario_id) {
            // Usamos DISTINCT para evitar duplicados y LEFT JOIN por si hay productos sin categoría
            $sql = "SELECT DISTINCT p.id, p.sku, p.nombre, p.precio, p.cantidad, p.imagen, 
                    c.nombre AS categoria
                    FROM productos p
                    LEFT JOIN categorias c ON p.categoria_id = c.id
                    WHERE p.usuario_id = ?
                    ORDER BY p.id DESC";
            return $this->db->select($sql, [$usuario_id]);
        }
    }
}
?>