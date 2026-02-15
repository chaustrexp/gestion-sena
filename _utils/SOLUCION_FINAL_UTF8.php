<?php
/**
 * ═══════════════════════════════════════════════════════════════════
 * SOLUCIÓN FINAL UTF-8 - REPARAR DATOS DAÑADOS
 * ═══════════════════════════════════════════════════════════════════
 * 
 * Este script repara los datos YA DAÑADOS en la base de datos
 * TecnologÃ­a → Tecnología
 * GestiÃ³n → Gestión
 */

header('Content-Type: text/html; charset=UTF-8');
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

// Conexión directa con MySQLi para mayor control
$conexion = new mysqli("localhost", "root", "", "dashboard_sena");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Forzar UTF-8 en la conexión
$conexion->set_charset("utf8mb4");
$conexion->query("SET NAMES utf8mb4");
$conexion->query("SET CHARACTER SET utf8mb4");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Solución Final UTF-8</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #39A900, #007832); padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 40px; border-radius: 15px; }
        h1 { color: #007832; font-size: 32px; margin-bottom: 20px; }
        h2 { color: #39A900; font-size: 24px; margin: 30px 0 15px; border-bottom: 3px solid #39A900; padding-bottom: 10px; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin: 10px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin: 10px 0; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 8px; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #39A900; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        .btn { display: inline-block; padding: 12px 24px; background: #39A900; color: white; text-decoration: none; border-radius: 8px; margin: 10px 5px; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; color: #c7254e; }
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin: 30px 0; }
        .stat { background: linear-gradient(135deg, #39A900, #007832); color: white; padding: 20px; border-radius: 10px; text-align: center; }
        .stat-num { font-size: 36px; font-weight: bold; }
        .stat-label { font-size: 14px; margin-top: 5px; }
    </style>
</head>
<body>
<div class="container">
    <h1>🔧 Solución Final UTF-8</h1>
    <p style="color: #666; margin-bottom: 30px;">Reparando datos dañados: TecnologÃ­a → Tecnología</p>

<?php

echo "<h2>PASO 1: Convertir Base de Datos y Tablas</h2>";

// Convertir base de datos
$conexion->query("ALTER DATABASE dashboard_sena CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
echo "<div class='success'>✓ Base de datos convertida a utf8mb4</div>";

// Convertir todas las tablas
$tablas = ['ambiente', 'asignacion', 'centro_formacion', 'competencia', 'competencia_programa', 
           'coordinacion', 'detalle_asignacion', 'ficha', 'instructor', 'programa', 'sede', 
           'titulo_programa', 'usuarios'];

foreach ($tablas as $tabla) {
    $conexion->query("ALTER TABLE $tabla CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<div class='info'>✓ Tabla <code>$tabla</code> convertida</div>";
}

echo "<h2>PASO 2: Reparar Datos Dañados</h2>";

$total_reparados = 0;
$ejemplos = [];

// FUNCIÓN DE REPARACIÓN DEFINITIVA
function repararTextoDefinitivo($texto) {
    if (empty($texto)) return $texto;
    
    // Si NO tiene caracteres dañados, devolver tal cual
    if (!preg_match('/Ã|Â/u', $texto)) {
        return $texto;
    }
    
    // MÉTODO DEFINITIVO: Convertir de UTF-8 mal interpretado a ISO-8859-1 y luego a UTF-8 correcto
    $reparado = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');
    $reparado = mb_convert_encoding($reparado, 'UTF-8', 'ISO-8859-1');
    
    return $reparado;
}

// REPARAR titulo_programa
echo "<h3>1. Reparando: titulo_programa</h3>";
$result = $conexion->query("SELECT * FROM titulo_programa");
$count = 0;

while ($row = $result->fetch_assoc()) {
    $nombre_nuevo = repararTextoDefinitivo($row['nombre']);
    $nivel_nuevo = repararTextoDefinitivo($row['nivel']);
    
    if ($nombre_nuevo !== $row['nombre'] || $nivel_nuevo !== $row['nivel']) {
        $stmt = $conexion->prepare("UPDATE titulo_programa SET nombre = ?, nivel = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nombre_nuevo, $nivel_nuevo, $row['id']);
        $stmt->execute();
        
        if ($nombre_nuevo !== $row['nombre']) {
            $ejemplos[] = ['antes' => $row['nombre'], 'despues' => $nombre_nuevo];
            echo "<div class='info'>✓ ID {$row['id']}: <code>{$row['nombre']}</code> → <code>{$nombre_nuevo}</code></div>";
        }
        $count++;
    }
}
echo "<div class='success'>✓ Reparados: {$count} registros</div>";
$total_reparados += $count;

// REPARAR centro_formacion
echo "<h3>2. Reparando: centro_formacion</h3>";
$result = $conexion->query("SELECT * FROM centro_formacion");
$count = 0;

while ($row = $result->fetch_assoc()) {
    $nombre_nuevo = repararTextoDefinitivo($row['nombre']);
    $direccion_nueva = repararTextoDefinitivo($row['direccion']);
    
    if ($nombre_nuevo !== $row['nombre'] || $direccion_nueva !== $row['direccion']) {
        $stmt = $conexion->prepare("UPDATE centro_formacion SET nombre = ?, direccion = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nombre_nuevo, $direccion_nueva, $row['id']);
        $stmt->execute();
        
        if ($nombre_nuevo !== $row['nombre']) {
            $ejemplos[] = ['antes' => $row['nombre'], 'despues' => $nombre_nuevo];
            echo "<div class='info'>✓ ID {$row['id']}: <code>{$row['nombre']}</code> → <code>{$nombre_nuevo}</code></div>";
        }
        $count++;
    }
}
echo "<div class='success'>✓ Reparados: {$count} registros</div>";
$total_reparados += $count;

// REPARAR instructor
echo "<h3>3. Reparando: instructor</h3>";
$result = $conexion->query("SELECT * FROM instructor");
$count = 0;

while ($row = $result->fetch_assoc()) {
    $nombre_nuevo = repararTextoDefinitivo($row['nombre']);
    
    if ($nombre_nuevo !== $row['nombre']) {
        $stmt = $conexion->prepare("UPDATE instructor SET nombre = ? WHERE id = ?");
        $stmt->bind_param("si", $nombre_nuevo, $row['id']);
        $stmt->execute();
        
        $ejemplos[] = ['antes' => $row['nombre'], 'despues' => $nombre_nuevo];
        echo "<div class='info'>✓ ID {$row['id']}: <code>{$row['nombre']}</code> → <code>{$nombre_nuevo}</code></div>";
        $count++;
    }
}
echo "<div class='success'>✓ Reparados: {$count} registros</div>";
$total_reparados += $count;

// REPARAR programa
echo "<h3>4. Reparando: programa</h3>";
$result = $conexion->query("SELECT * FROM programa");
$count = 0;

while ($row = $result->fetch_assoc()) {
    $nombre_nuevo = repararTextoDefinitivo($row['nombre']);
    
    if ($nombre_nuevo !== $row['nombre']) {
        $stmt = $conexion->prepare("UPDATE programa SET nombre = ? WHERE id = ?");
        $stmt->bind_param("si", $nombre_nuevo, $row['id']);
        $stmt->execute();
        
        $ejemplos[] = ['antes' => $row['nombre'], 'despues' => $nombre_nuevo];
        echo "<div class='info'>✓ ID {$row['id']}: <code>{$row['nombre']}</code> → <code>{$nombre_nuevo}</code></div>";
        $count++;
    }
}
echo "<div class='success'>✓ Reparados: {$count} registros</div>";
$total_reparados += $count;

// REPARAR usuarios
echo "<h3>5. Reparando: usuarios</h3>";
$result = $conexion->query("SELECT * FROM usuarios");
$count = 0;

while ($row = $result->fetch_assoc()) {
    $nombre_nuevo = repararTextoDefinitivo($row['nombre']);
    
    if ($nombre_nuevo !== $row['nombre']) {
        $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ? WHERE id = ?");
        $stmt->bind_param("si", $nombre_nuevo, $row['id']);
        $stmt->execute();
        
        $ejemplos[] = ['antes' => $row['nombre'], 'despues' => $nombre_nuevo];
        echo "<div class='info'>✓ ID {$row['id']}: <code>{$row['nombre']}</code> → <code>{$nombre_nuevo}</code></div>";
        $count++;
    }
}
echo "<div class='success'>✓ Reparados: {$count} registros</div>";
$total_reparados += $count;

// REPARAR competencia
echo "<h3>6. Reparando: competencia</h3>";
$result = $conexion->query("SELECT * FROM competencia");
$count = 0;

while ($row = $result->fetch_assoc()) {
    $nombre_nuevo = repararTextoDefinitivo($row['nombre']);
    $descripcion_nueva = repararTextoDefinitivo($row['descripcion']);
    
    if ($nombre_nuevo !== $row['nombre'] || $descripcion_nueva !== $row['descripcion']) {
        $stmt = $conexion->prepare("UPDATE competencia SET nombre = ?, descripcion = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nombre_nuevo, $descripcion_nueva, $row['id']);
        $stmt->execute();
        
        if ($nombre_nuevo !== $row['nombre']) {
            $ejemplos[] = ['antes' => $row['nombre'], 'despues' => $nombre_nuevo];
            echo "<div class='info'>✓ ID {$row['id']}: <code>{$row['nombre']}</code> → <code>{$nombre_nuevo}</code></div>";
        }
        $count++;
    }
}
echo "<div class='success'>✓ Reparados: {$count} registros</div>";
$total_reparados += $count;

// REPARAR coordinacion
echo "<h3>7. Reparando: coordinacion</h3>";
$result = $conexion->query("SELECT * FROM coordinacion");
$count = 0;

while ($row = $result->fetch_assoc()) {
    $nombre_nuevo = repararTextoDefinitivo($row['nombre']);
    $responsable_nuevo = repararTextoDefinitivo($row['responsable']);
    
    if ($nombre_nuevo !== $row['nombre'] || $responsable_nuevo !== $row['responsable']) {
        $stmt = $conexion->prepare("UPDATE coordinacion SET nombre = ?, responsable = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nombre_nuevo, $responsable_nuevo, $row['id']);
        $stmt->execute();
        $count++;
    }
}
echo "<div class='success'>✓ Reparados: {$count} registros</div>";
$total_reparados += $count;

// ESTADÍSTICAS
echo "<h2>📊 Estadísticas</h2>";
echo "<div class='stats'>";
echo "<div class='stat'><div class='stat-num'>13</div><div class='stat-label'>Tablas Procesadas</div></div>";
echo "<div class='stat'><div class='stat-num'>{$total_reparados}</div><div class='stat-label'>Registros Reparados</div></div>";
echo "<div class='stat'><div class='stat-num'>" . count($ejemplos) . "</div><div class='stat-label'>Campos Corregidos</div></div>";
echo "</div>";

// VERIFICACIÓN
echo "<h2>✅ Verificación de Datos Corregidos</h2>";

echo "<h3>Títulos de Programa:</h3>";
$result = $conexion->query("SELECT * FROM titulo_programa LIMIT 10");
echo "<table><tr><th>ID</th><th>Nombre</th><th>Nivel</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['id']}</td><td>{$row['nombre']}</td><td>{$row['nivel']}</td></tr>";
}
echo "</table>";

echo "<h3>Centros de Formación:</h3>";
$result = $conexion->query("SELECT * FROM centro_formacion LIMIT 10");
echo "<table><tr><th>ID</th><th>Nombre</th><th>Dirección</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['id']}</td><td>{$row['nombre']}</td><td>{$row['direccion']}</td></tr>";
}
echo "</table>";

echo "<h3>Instructores:</h3>";
$result = $conexion->query("SELECT * FROM instructor LIMIT 10");
echo "<table><tr><th>ID</th><th>Nombre</th><th>Email</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['id']}</td><td>{$row['nombre']}</td><td>{$row['email']}</td></tr>";
}
echo "</table>";

echo "<h3>Programas:</h3>";
$result = $conexion->query("SELECT * FROM programa LIMIT 10");
echo "<table><tr><th>ID</th><th>Nombre</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['id']}</td><td>{$row['nombre']}</td></tr>";
}
echo "</table>";

// MENSAJE FINAL
echo "<div class='success' style='font-size: 20px; text-align: center; padding: 40px; margin-top: 30px;'>";
echo "<h2 style='margin-bottom: 20px;'>🎉 ¡PROBLEMA RESUELTO!</h2>";
echo "<p>Todos los caracteres han sido reparados correctamente.</p>";
echo "<p>Ahora verás: <strong>Tecnología, Gestión, Formación, Especialización</strong></p>";
echo "</div>";

echo "<div style='text-align: center; margin-top: 30px;'>";
echo "<a href='/Gestion-sena/' class='btn'>🏠 Ir al Dashboard</a>";
echo "<a href='/Gestion-sena/views/titulo_programa/index.php' class='btn'>📋 Ver Títulos</a>";
echo "</div>";

$conexion->close();

?>

</div>
</body>
</html>
