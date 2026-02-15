<?php
require_once __DIR__ . '/../conexion.php';

class CoordinacionModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->conn->query("
            SELECT co.*, c.nombre as centro_nombre 
            FROM coordinacion co 
            LEFT JOIN centro_formacion c ON co.centro_formacion_id = c.id 
            ORDER BY co.id DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT co.*, c.nombre as centro_nombre 
            FROM coordinacion co 
            LEFT JOIN centro_formacion c ON co.centro_formacion_id = c.id 
            WHERE co.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO coordinacion (nombre, centro_formacion_id, responsable) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['centro_formacion_id'],
            $data['responsable']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE coordinacion 
            SET nombre = ?, centro_formacion_id = ?, responsable = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['centro_formacion_id'],
            $data['responsable'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM coordinacion WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
