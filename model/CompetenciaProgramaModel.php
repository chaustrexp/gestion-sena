<?php
require_once __DIR__ . '/../conexion.php';

class CompetenciaProgramaModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->conn->query("
            SELECT cp.*, 
                   c.nombre as competencia_nombre,
                   p.nombre as programa_nombre
            FROM competencia_programa cp
            LEFT JOIN competencia c ON cp.competencia_id = c.id
            LEFT JOIN programa p ON cp.programa_id = p.id
            ORDER BY cp.id DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT cp.*, 
                   c.nombre as competencia_nombre,
                   p.nombre as programa_nombre
            FROM competencia_programa cp
            LEFT JOIN competencia c ON cp.competencia_id = c.id
            LEFT JOIN programa p ON cp.programa_id = p.id
            WHERE cp.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO competencia_programa (competencia_id, programa_id, horas) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['competencia_id'],
            $data['programa_id'],
            $data['horas']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE competencia_programa 
            SET competencia_id = ?, programa_id = ?, horas = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['competencia_id'],
            $data['programa_id'],
            $data['horas'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM competencia_programa WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
