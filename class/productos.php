<?php
/*autor Marcos Savid*/
/*archivo de class->productos.php*/
require_once 'data_base.php';

class Productos {
    private $id;
    private $nombre;
    private $sku;
    private $imagen;
    private $cantidad; // 🎯 CAMBIO: De $descripcion a $cantidad
    private $categoria;
    private $precio;
    private $db;

    public function __construct() {
        $this->db = new DataBase();
    }

    // --- Setters ---
    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setSku($sku) { $this->sku = $sku; }
    public function setImagen($imagen) { $this->imagen = $imagen; }
    public function setCantidad($cantidad) { $this->cantidad = $cantidad; } // 🎯 NUEVO SETTER
    public function setCategoria($categoria) { $this->categoria = $categoria; }
    public function setPrecio($precio) { $this->precio = $precio; }

    // --- Guardar producto ---
    public function guardar() {
        // 🎯 CAMBIO: Mapeamos 'cantidad' en vez de 'descripcion'
        $sql = "INSERT INTO productos (nombre, sku, imagen, cantidad, categoria_id, precio)
                VALUES (?, ?, ?, ?, ?, ?)";

        $params = [$this->nombre, $this->sku, $this->imagen, $this->cantidad, $this->categoria, $this->precio];
        return $this->db->insert($sql, $params);
    }

    // --- Actualizar producto ---
    public function actualizar() {
        if ($this->imagen !== NULL) {
            // 🎯 CAMBIO: Agregamos 'cantidad' en el UPDATE con imagen
            $sql = "UPDATE productos 
                    SET nombre = ?, sku = ?, imagen = ?, cantidad = ?, categoria_id = ?, precio = ? 
                    WHERE id = ?";
            $params = [$this->nombre, $this->sku, $this->imagen, $this->cantidad, $this->categoria, $this->precio, $this->id];
            return $this->db->update($sql, $params);
        } else {
            // 🎯 CAMBIO: Agregamos 'cantidad' en el UPDATE sin imagen
            $sql = "UPDATE productos 
                    SET nombre = ?, sku = ?, cantidad = ?, categoria_id = ?, precio = ? 
                    WHERE id = ?";
            $params = [$this->nombre, $this->sku, $this->cantidad, $this->categoria, $this->precio, $this->id];
            return $this->db->update($sql, $params);
        }
    }

    // --- Eliminar producto ---
    public function eliminar($id) {
        $sql = "DELETE FROM productos WHERE id = ?";
        $params = [$id];
        return $this->db->delete($sql, $params);
    }

    // api: join entre la tabla productos y categoria
    public function listarConCategorias() {
        // 🎯 CAMBIO: Traemos la columna 'p.cantidad' de la base de datos
        $sql = "SELECT p.id, p.sku, p.nombre, p.precio, p.cantidad, p.imagen, 
                c.nombre AS categoria
                FROM productos p
                INNER JOIN categorias c
                ON p.categoria_id = c.id";
                
        return $this->db->select($sql);
    }
}
?>