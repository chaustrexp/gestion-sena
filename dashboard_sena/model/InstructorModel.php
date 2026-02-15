<?php
require_once __DIR__ . '/../conexion.php';

class InstructorModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->conn->query("
            SELECT i.*, c.nombre as centro_nombre 
            FROM instructor i 
            LEFT JOIN centro_formacion c ON i.centro_formacion_id = c.id 
            ORDER BY i.id DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT i.*, c.nombre as centro_nombre 
            FROM instructor i 
            LEFT JOIN centro_formacion c ON i.centro_formacion_id = c.id 
            WHERE i.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO instructor (nombre, documento, email, telefono, centro_formacion_id) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['documento'],
            $data['email'],
            $data['telefono'],
            $data['centro_formacion_id']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE instructor 
            SET nombre = ?, documento = ?, email = ?, telefono = ?, centro_formacion_id = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['documento'],
            $data['email'],
            $data['telefono'],
            $data['centro_formacion_id'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM instructor WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM instructor");
        return $stmt->fetch()['total'];
    }
}
?>
