<?php
require_once __DIR__ . '/../conexion.php';

class CompetenciaModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM competencia ORDER BY id DESC");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM competencia WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO competencia (codigo, nombre, descripcion) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['codigo'],
            $data['nombre'],
            $data['descripcion']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE competencia 
            SET codigo = ?, nombre = ?, descripcion = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['codigo'],
            $data['nombre'],
            $data['descripcion'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM competencia WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
