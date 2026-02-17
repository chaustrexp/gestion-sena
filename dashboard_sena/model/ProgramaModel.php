<?php
require_once __DIR__ . '/../conexion.php';

class ProgramaModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT p.*, tp.titpro_nombre 
            FROM PROGRAMA p
            LEFT JOIN TITULO_PROGRAMA tp ON p.TIT_PROGRAMA_titpro_id = tp.titpro_id
            ORDER BY p.prog_denominacion
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT p.*, tp.titpro_nombre 
            FROM PROGRAMA p
            LEFT JOIN TITULO_PROGRAMA tp ON p.TIT_PROGRAMA_titpro_id = tp.titpro_id
            WHERE p.prog_codigo = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO PROGRAMA (prog_denominacion, TIT_PROGRAMA_titpro_id, prog_tipo) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['prog_denominacion'],
            $data['TIT_PROGRAMA_titpro_id'],
            $data['prog_tipo'] ?? null
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE PROGRAMA 
            SET prog_denominacion = ?, TIT_PROGRAMA_titpro_id = ?, prog_tipo = ?
            WHERE prog_codigo = ?
        ");
        return $stmt->execute([
            $data['prog_denominacion'],
            $data['TIT_PROGRAMA_titpro_id'],
            $data['prog_tipo'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM PROGRAMA WHERE prog_codigo = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM PROGRAMA");
        $result = $stmt->fetch();
        return $result['total'];
    }
}
?>
