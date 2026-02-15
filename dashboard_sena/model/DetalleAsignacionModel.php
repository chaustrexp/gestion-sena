<?php
require_once __DIR__ . '/../conexion.php';

class DetalleAsignacionModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->conn->query("
            SELECT da.*, 
                   a.id as asignacion_id,
                   f.numero as ficha_numero,
                   i.nombre as instructor_nombre
            FROM detalle_asignacion da
            LEFT JOIN asignacion a ON da.asignacion_id = a.id
            LEFT JOIN ficha f ON a.ficha_id = f.id
            LEFT JOIN instructor i ON a.instructor_id = i.id
            ORDER BY da.id DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT da.*, 
                   a.id as asignacion_id,
                   f.numero as ficha_numero,
                   i.nombre as instructor_nombre
            FROM detalle_asignacion da
            LEFT JOIN asignacion a ON da.asignacion_id = a.id
            LEFT JOIN ficha f ON a.ficha_id = f.id
            LEFT JOIN instructor i ON a.instructor_id = i.id
            WHERE da.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO detalle_asignacion (asignacion_id, fecha, hora_inicio, hora_fin, observaciones) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['asignacion_id'],
            $data['fecha'],
            $data['hora_inicio'],
            $data['hora_fin'],
            $data['observaciones']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE detalle_asignacion 
            SET asignacion_id = ?, fecha = ?, hora_inicio = ?, hora_fin = ?, observaciones = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['asignacion_id'],
            $data['fecha'],
            $data['hora_inicio'],
            $data['hora_fin'],
            $data['observaciones'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM detalle_asignacion WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
