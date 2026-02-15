<?php
require_once __DIR__ . '/../conexion.php';

class SedeModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM sede ORDER BY id DESC");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM sede WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO sede (nombre, direccion, ciudad) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['direccion'],
            $data['ciudad']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE sede 
            SET nombre = ?, direccion = ?, ciudad = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['direccion'],
            $data['ciudad'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM sede WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
