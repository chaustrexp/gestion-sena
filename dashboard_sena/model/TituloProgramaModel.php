<?php
require_once __DIR__ . '/../conexion.php';

class TituloProgramaModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM TITULO_PROGRAMA ORDER BY titpro_nombre");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM TITULO_PROGRAMA WHERE titpro_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO TITULO_PROGRAMA (titpro_nombre) VALUES (?)");
        return $stmt->execute([
            $data['titpro_nombre']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE TITULO_PROGRAMA SET titpro_nombre = ? WHERE titpro_id = ?");
        return $stmt->execute([
            $data['titpro_nombre'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM TITULO_PROGRAMA WHERE titpro_id = ?");
        return $stmt->execute([$id]);
    }
}
?>
