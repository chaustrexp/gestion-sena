<?php
require_once __DIR__ . '/../conexion.php';

class AmbienteModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->conn->query("
            SELECT a.*, s.nombre as sede_nombre 
            FROM ambiente a 
            LEFT JOIN sede s ON a.sede_id = s.id 
            ORDER BY a.id DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT a.*, s.nombre as sede_nombre 
            FROM ambiente a 
            LEFT JOIN sede s ON a.sede_id = s.id 
            WHERE a.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO ambiente (nombre, codigo, capacidad, tipo, sede_id) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['codigo'],
            $data['capacidad'],
            $data['tipo'],
            $data['sede_id']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE ambiente 
            SET nombre = ?, codigo = ?, capacidad = ?, tipo = ?, sede_id = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['codigo'],
            $data['capacidad'],
            $data['tipo'],
            $data['sede_id'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM ambiente WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM ambiente");
        return $stmt->fetch()['total'];
    }
}
?>
