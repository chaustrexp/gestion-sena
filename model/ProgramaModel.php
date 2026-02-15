<?php
require_once __DIR__ . '/../conexion.php';

class ProgramaModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->conn->query("
            SELECT p.*, t.nombre as titulo_nombre 
            FROM programa p 
            LEFT JOIN titulo_programa t ON p.titulo_programa_id = t.id 
            ORDER BY p.id DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT p.*, t.nombre as titulo_nombre 
            FROM programa p 
            LEFT JOIN titulo_programa t ON p.titulo_programa_id = t.id 
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO programa (nombre, codigo, duracion_meses, titulo_programa_id) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['codigo'],
            $data['duracion_meses'],
            $data['titulo_programa_id']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE programa 
            SET nombre = ?, codigo = ?, duracion_meses = ?, titulo_programa_id = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['codigo'],
            $data['duracion_meses'],
            $data['titulo_programa_id'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM programa WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM programa");
        return $stmt->fetch()['total'];
    }
}
?>
