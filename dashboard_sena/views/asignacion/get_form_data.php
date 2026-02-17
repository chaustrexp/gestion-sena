<?php
require_once __DIR__ . '/../../auth/check_auth.php';
require_once __DIR__ . '/../../model/FichaModel.php';
require_once __DIR__ . '/../../model/InstructorModel.php';
require_once __DIR__ . '/../../model/AmbienteModel.php';
require_once __DIR__ . '/../../model/CompetenciaModel.php';

header('Content-Type: application/json');

$fichaModel = new FichaModel();
$instructorModel = new InstructorModel();
$ambienteModel = new AmbienteModel();
$competenciaModel = new CompetenciaModel();

// Obtener datos y formatearlos para el modal
$fichas = array_map(function($f) {
    return [
        'id' => $f['fich_id'] ?? '',
        'numero' => 'Ficha ' . ($f['fich_id'] ?? '')
    ];
}, $fichaModel->getAll());

$instructores = array_map(function($i) {
    return [
        'id' => $i['inst_id'] ?? '',
        'nombre' => ($i['inst_nombres'] ?? '') . ' ' . ($i['inst_apellidos'] ?? '')
    ];
}, $instructorModel->getAll());

$ambientes = array_map(function($a) {
    return [
        'id' => $a['amb_id'] ?? '',
        'nombre' => $a['amb_nombre'] ?? ''
    ];
}, $ambienteModel->getAll());

$competencias = array_map(function($c) {
    return [
        'id' => $c['comp_id'] ?? '',
        'nombre' => $c['comp_nombre_corto'] ?? ''
    ];
}, $competenciaModel->getAll());

$data = [
    'fichas' => $fichas,
    'instructores' => $instructores,
    'ambientes' => $ambientes,
    'competencias' => $competencias
];

echo json_encode($data);
?>
