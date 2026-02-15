<?php
require_once __DIR__ . '/../conexion.php';

class TituloProgramaModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM titulo_programa ORDER BY id DESC");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM titulo_programa WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO titulo_programa (nombre, nivel) 
            VALUES (?, ?)
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['nivel']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE titulo_programa 
            SET nombre = ?, nivel = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['nivel'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM titulo_programa WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
