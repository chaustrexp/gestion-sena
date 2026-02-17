<?php
require_once __DIR__ . '/../conexion.php';

class InstructorModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT i.*, cf.cent_nombre 
            FROM INSTRUCTOR i
            LEFT JOIN CENTRO_FORMACION cf ON i.CENTRO_FORMACION_cent_id = cf.cent_id
            ORDER BY i.inst_apellidos, i.inst_nombres
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT i.*, cf.cent_nombre 
            FROM INSTRUCTOR i
            LEFT JOIN CENTRO_FORMACION cf ON i.CENTRO_FORMACION_cent_id = cf.cent_id
            WHERE i.inst_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO INSTRUCTOR (inst_nombres, inst_apellidos, inst_correo, inst_telefono, CENTRO_FORMACION_cent_id, inst_password) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['inst_nombres'],
            $data['inst_apellidos'],
            $data['inst_correo'],
            $data['inst_telefono'],
            $data['CENTRO_FORMACION_cent_id'],
            isset($data['inst_password']) ? password_hash($data['inst_password'], PASSWORD_DEFAULT) : password_hash('123456', PASSWORD_DEFAULT)
        ]);
    }
    
    public function update($id, $data) {
        $sql = "UPDATE INSTRUCTOR SET inst_nombres = ?, inst_apellidos = ?, inst_correo = ?, inst_telefono = ?, CENTRO_FORMACION_cent_id = ?";
        $params = [
            $data['inst_nombres'],
            $data['inst_apellidos'],
            $data['inst_correo'],
            $data['inst_telefono'],
            $data['CENTRO_FORMACION_cent_id']
        ];
        
        if (isset($data['inst_password']) && !empty($data['inst_password'])) {
            $sql .= ", inst_password = ?";
            $params[] = password_hash($data['inst_password'], PASSWORD_DEFAULT);
        }
        
        $sql .= " WHERE inst_id = ?";
        $params[] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM INSTRUCTOR WHERE inst_id = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM INSTRUCTOR");
        $result = $stmt->fetch();
        return $result['total'];
    }
}
?>
