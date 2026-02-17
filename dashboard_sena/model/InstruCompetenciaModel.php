<?php
require_once __DIR__ . '/../conexion.php';

class InstruCompetenciaModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT ic.*,
                   CONCAT(i.inst_nombres, ' ', i.inst_apellidos) as instructor_nombre,
                   p.prog_denominacion,
                   c.comp_nombre_corto
            FROM INSTRU_COMPETENCIA ic
            LEFT JOIN INSTRUCTOR i ON ic.INSTRUCTOR_inst_id = i.inst_id
            LEFT JOIN COMPETxPROGRAMA cp ON ic.COMPETxPROGRAMA_PROGRAMA_prog_id = cp.PROGRAMA_prog_id 
                AND ic.COMPETxPROGRAMA_COMPETENCIA_comp_id = cp.COMPETENCIA_comp_id
            LEFT JOIN PROGRAMA p ON cp.PROGRAMA_prog_id = p.prog_codigo
            LEFT JOIN COMPETENCIA c ON cp.COMPETENCIA_comp_id = c.comp_id
            ORDER BY ic.inscomp_vigencia DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT ic.*,
                   CONCAT(i.inst_nombres, ' ', i.inst_apellidos) as instructor_nombre,
                   p.prog_denominacion,
                   c.comp_nombre_corto,
                   c.comp_nombre_unidad_competencia
            FROM INSTRU_COMPETENCIA ic
            LEFT JOIN INSTRUCTOR i ON ic.INSTRUCTOR_inst_id = i.inst_id
            LEFT JOIN COMPETxPROGRAMA cp ON ic.COMPETxPROGRAMA_PROGRAMA_prog_id = cp.PROGRAMA_prog_id 
                AND ic.COMPETxPROGRAMA_COMPETENCIA_comp_id = cp.COMPETENCIA_comp_id
            LEFT JOIN PROGRAMA p ON cp.PROGRAMA_prog_id = p.prog_codigo
            LEFT JOIN COMPETENCIA c ON cp.COMPETENCIA_comp_id = c.comp_id
            WHERE ic.inscomp_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getByInstructor($instructor_id) {
        $stmt = $this->db->prepare("
            SELECT ic.*,
                   p.prog_denominacion,
                   c.comp_nombre_corto,
                   c.comp_nombre_unidad_competencia
            FROM INSTRU_COMPETENCIA ic
            LEFT JOIN PROGRAMA p ON ic.COMPETxPROGRAMA_PROGRAMA_prog_id = p.prog_codigo
            LEFT JOIN COMPETENCIA c ON ic.COMPETxPROGRAMA_COMPETENCIA_comp_id = c.comp_id
            WHERE ic.INSTRUCTOR_inst_id = ?
            ORDER BY ic.inscomp_vigencia DESC
        ");
        $stmt->execute([$instructor_id]);
        return $stmt->fetchAll();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO INSTRU_COMPETENCIA (INSTRUCTOR_inst_id, COMPETxPROGRAMA_PROGRAMA_prog_id, COMPETxPROGRAMA_COMPETENCIA_comp_id, inscomp_vigencia) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['INSTRUCTOR_inst_id'],
            $data['COMPETxPROGRAMA_PROGRAMA_prog_id'],
            $data['COMPETxPROGRAMA_COMPETENCIA_comp_id'],
            $data['inscomp_vigencia']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE INSTRU_COMPETENCIA 
            SET INSTRUCTOR_inst_id = ?, COMPETxPROGRAMA_PROGRAMA_prog_id = ?, COMPETxPROGRAMA_COMPETENCIA_comp_id = ?, inscomp_vigencia = ?
            WHERE inscomp_id = ?
        ");
        return $stmt->execute([
            $data['INSTRUCTOR_inst_id'],
            $data['COMPETxPROGRAMA_PROGRAMA_prog_id'],
            $data['COMPETxPROGRAMA_COMPETENCIA_comp_id'],
            $data['inscomp_vigencia'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM INSTRU_COMPETENCIA WHERE inscomp_id = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM INSTRU_COMPETENCIA");
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    public function countVigentes() {
        $hoy = date('Y-m-d');
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM INSTRU_COMPETENCIA WHERE inscomp_vigencia >= ?");
        $stmt->execute([$hoy]);
        $result = $stmt->fetch();
        return $result['total'];
    }
}
?>
