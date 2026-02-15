<?php
require_once __DIR__ . '/../conexion.php';

class FichaModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->conn->query("
            SELECT f.*, p.nombre as programa_nombre 
            FROM ficha f 
            LEFT JOIN programa p ON f.programa_id = p.id 
            ORDER BY f.id DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT f.*, p.nombre as programa_nombre 
            FROM ficha f 
            LEFT JOIN programa p ON f.programa_id = p.id 
            WHERE f.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO ficha (numero, programa_id, fecha_inicio, fecha_fin, estado) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['numero'],
            $data['programa_id'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['estado']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE ficha 
            SET numero = ?, programa_id = ?, fecha_inicio = ?, fecha_fin = ?, estado = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['numero'],
            $data['programa_id'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['estado'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM ficha WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM ficha");
        return $stmt->fetch()['total'];
    }
}
?>
