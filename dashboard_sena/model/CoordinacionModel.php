<?php
require_once __DIR__ . '/../conexion.php';

class CoordinacionModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT c.*, cf.cent_nombre 
            FROM COORDINACION c
            LEFT JOIN CENTRO_FORMACION cf ON c.CENTRO_FORMACION_cent_id = cf.cent_id
            ORDER BY c.coord_descripcion
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT c.*, cf.cent_nombre 
            FROM COORDINACION c
            LEFT JOIN CENTRO_FORMACION cf ON c.CENTRO_FORMACION_cent_id = cf.cent_id
            WHERE c.coord_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO COORDINACION (coord_descripcion, CENTRO_FORMACION_cent_id, coord_nombre_coordinador, coord_correo, coord_password) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['coord_descripcion'],
            $data['CENTRO_FORMACION_cent_id'],
            $data['coord_nombre_coordinador'],
            $data['coord_correo'],
            isset($data['coord_password']) ? password_hash($data['coord_password'], PASSWORD_DEFAULT) : password_hash('123456', PASSWORD_DEFAULT)
        ]);
    }
    
    public function update($id, $data) {
        $sql = "UPDATE COORDINACION SET coord_descripcion = ?, CENTRO_FORMACION_cent_id = ?, coord_nombre_coordinador = ?, coord_correo = ?";
        $params = [
            $data['coord_descripcion'],
            $data['CENTRO_FORMACION_cent_id'],
            $data['coord_nombre_coordinador'],
            $data['coord_correo']
        ];
        
        if (isset($data['coord_password']) && !empty($data['coord_password'])) {
            $sql .= ", coord_password = ?";
            $params[] = password_hash($data['coord_password'], PASSWORD_DEFAULT);
        }
        
        $sql .= " WHERE coord_id = ?";
        $params[] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM COORDINACION WHERE coord_id = ?");
        return $stmt->execute([$id]);
    }
}
?>
