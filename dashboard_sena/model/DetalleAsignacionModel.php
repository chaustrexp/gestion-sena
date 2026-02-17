<?php
require_once __DIR__ . '/../conexion.php';

class DetalleAsignacionModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT da.*,
                   a.ASIG_ID,
                   f.fich_id as ficha_numero,
                   CONCAT(i.inst_nombres, ' ', i.inst_apellidos) as instructor_nombre
            FROM DETALLExASIGNACION da
            LEFT JOIN ASIGNACION a ON da.ASIGNACION_ASIG_ID = a.ASIG_ID
            LEFT JOIN FICHA f ON a.FICHA_fich_id = f.fich_id
            LEFT JOIN INSTRUCTOR i ON a.INSTRUCTOR_inst_id = i.inst_id
            ORDER BY da.detasig_hora_ini DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getByAsignacion($asignacion_id) {
        $stmt = $this->db->prepare("
            SELECT * FROM DETALLExASIGNACION 
            WHERE ASIGNACION_ASIG_ID = ?
            ORDER BY detasig_hora_ini
        ");
        $stmt->execute([$asignacion_id]);
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM DETALLExASIGNACION WHERE detasig_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO DETALLExASIGNACION (ASIGNACION_ASIG_ID, detasig_hora_ini, detasig_hora_fin) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['ASIGNACION_ASIG_ID'],
            $data['detasig_hora_ini'],
            $data['detasig_hora_fin']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE DETALLExASIGNACION 
            SET ASIGNACION_ASIG_ID = ?, detasig_hora_ini = ?, detasig_hora_fin = ?
            WHERE detasig_id = ?
        ");
        return $stmt->execute([
            $data['ASIGNACION_ASIG_ID'],
            $data['detasig_hora_ini'],
            $data['detasig_hora_fin'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM DETALLExASIGNACION WHERE detasig_id = ?");
        return $stmt->execute([$id]);
    }
}
?>
