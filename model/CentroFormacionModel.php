<?php
require_once __DIR__ . '/../conexion.php';

class CentroFormacionModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM centro_formacion ORDER BY id DESC");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM centro_formacion WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO centro_formacion (nombre, codigo, direccion, telefono) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['codigo'],
            $data['direccion'],
            $data['telefono']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE centro_formacion 
            SET nombre = ?, codigo = ?, direccion = ?, telefono = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['codigo'],
            $data['direccion'],
            $data['telefono'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM centro_formacion WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
