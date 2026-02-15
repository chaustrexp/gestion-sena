<?php
require_once __DIR__ . '/../conexion.php';

class AsignacionModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->conn->query("
            SELECT a.*, 
                   f.numero as ficha_numero,
                   i.nombre as instructor_nombre,
                   am.nombre as ambiente_nombre,
                   c.nombre as competencia_nombre
            FROM asignacion a
            LEFT JOIN ficha f ON a.ficha_id = f.id
            LEFT JOIN instructor i ON a.instructor_id = i.id
            LEFT JOIN ambiente am ON a.ambiente_id = am.id
            LEFT JOIN competencia c ON a.competencia_id = c.id
            ORDER BY a.id DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT a.*, 
                   f.numero as ficha_numero,
                   i.nombre as instructor_nombre,
                   am.nombre as ambiente_nombre,
                   c.nombre as competencia_nombre
            FROM asignacion a
            LEFT JOIN ficha f ON a.ficha_id = f.id
            LEFT JOIN instructor i ON a.instructor_id = i.id
            LEFT JOIN ambiente am ON a.ambiente_id = am.id
            LEFT JOIN competencia c ON a.competencia_id = c.id
            WHERE a.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO asignacion (ficha_id, instructor_id, ambiente_id, competencia_id, fecha_inicio, fecha_fin) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['ficha_id'],
            $data['instructor_id'],
            $data['ambiente_id'],
            $data['competencia_id'],
            $data['fecha_inicio'],
            $data['fecha_fin']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE asignacion 
            SET ficha_id = ?, instructor_id = ?, ambiente_id = ?, competencia_id = ?, fecha_inicio = ?, fecha_fin = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['ficha_id'],
            $data['instructor_id'],
            $data['ambiente_id'],
            $data['competencia_id'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM asignacion WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM asignacion");
        return $stmt->fetch()['total'];
    }
    
    public function getRecent($limit = 5) {
        $stmt = $this->conn->prepare("
            SELECT a.*, 
                   f.numero as ficha_numero,
                   i.nombre as instructor_nombre,
                   am.nombre as ambiente_nombre
            FROM asignacion a
            LEFT JOIN ficha f ON a.ficha_id = f.id
            LEFT JOIN instructor i ON a.instructor_id = i.id
            LEFT JOIN ambiente am ON a.ambiente_id = am.id
            ORDER BY a.created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}
?>
