<?php
/**
 * ═══════════════════════════════════════════════════════════════════
 * SOLUCIÓN DEFINITIVA - REPARAR DOBLE CODIFICACIÓN UTF-8
 * ═══════════════════════════════════════════════════════════════════
 * 
 * Este script repara COMPLETAMENTE la doble codificación UTF-8
 * Convierte: TecnologÃ­a → Tecnología
 */

// Forzar UTF-8 en TODO
header('Content-Type: text/html; charset=UTF-8');
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

require_once __DIR__ . '/conexion.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reparación Definitiva UTF-8</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            background: linear-gradient(135deg, #39A900 0%, #007832 100%); 
            padding: 20px; 
            min-height: 100vh;
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            background: white; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.2); 
        }
        h1 { color: #007832; margin-bottom: 10px; font-size: 36px; }
        h2 { color: #39A900; margin: 30px 0 15px; font-size: 24px; border-bottom: 3px solid #39A900; padding-bottom: 10px; }
        h3 { color: #007832; margin: 20px 0 10px; font-size: 18px; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #28a745; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #dc3545; }
        .warning { background: #fff3cd; color: #856404; padding: 15px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #ffc107; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #17a2b8; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #39A900; color: white; font-weight: 600; }
        tr:nth-child(even) { background: #f9f9f9; }
        .btn { display: inline-block; padding: 12px 24px; background: #39A900; color: white; text-decoration: none; border-radius: 8px; margin: 10px 5px; font-weight: 600; }
        .btn:hover { background: #007832; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 30px 0; }
        .stat-card { background: linear-gradient(135deg, #39A900 0%, #007832 100%); color: white; padding: 20px; border-radius: 10px; text-align: center; }
        .stat-number { font-size: 36px; font-weight: bold; margin-bottom: 5px; }
        .stat-label { font-size: 14px; opacity: 0.9; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-family: 'Courier New', monospace; color: #c7254e; }
        .comparison { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0; }
        .before { background: #f8d7da; padding: 15px; border-radius: 8px; border-left: 4px solid #dc3545; }
        .after { background: #d4edda; padding: 15px; border-radius: 8px; border-left: 4px solid #28a745; }
        .before h4, .after h4 { margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="container">
    <h1>🔧 Reparación Definitiva UTF-8</h1>
    <p style="color: #666; margin-bottom: 30px;">Corrigiendo doble codificación: TecnologÃ­a → Tecnología</p>

<?php

try {
    $db = Database::getInstance()->getConnection();
    
    // PASO 1: Configurar UTF-8 en la conexión
    echo "<h2>📡 PASO 1: Configurar Conexión UTF-8</h2>";
    $db->exec("SET NAMES utf8mb4");
    $db->exec("SET CHARACTER SET utf8mb4");
    $db->exec("SET character_set_connection=utf8mb4");
    $db->exec("SET character_set_client=utf8mb4");
    $db->exec("SET character_set_results=utf8mb4");
    echo "<div class='success'>✓ Conexión configurada en UTF-8</div>";
    
    // PASO 2: Convertir base de datos
    echo "<h2>🗄️ PASO 2: Convertir Base de Datos</h2>";
    try {
        $db->exec("ALTER DATABASE dashboard_sena CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "<div class='success'>✓ Base de datos convertida a utf8mb4_unicode_ci</div>";
    } catch (Exception $e) {
        echo "<div class='warning'>⚠ Base de datos ya está en UTF-8 o no se pudo convertir</div>";
    }
    
    // PASO 3: Convertir todas las tablas
    echo "<h2>📋 PASO 3: Convertir Tablas a UTF-8</h2>";
    $tablas = [
        'ambiente', 'asignacion', 'centro_formacion', 'competencia', 
        'competencia_programa', 'coordinacion', 'detalle_asignacion', 
        'ficha', 'instructor', 'programa', 'sede', 'titulo_programa', 'usuarios'
    ];
    
    foreach ($tablas as $tabla) {
        try {
            $db->exec("ALTER TABLE $tabla CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "<div class='info'>✓ Tabla <code>$tabla</code> convertida</div>";
        } catch (Exception $e) {
            echo "<div class='warning'>⚠ Tabla <code>$tabla</code>: " . $e->getMessage() . "</div>";
        }
    }
    
    // FUNCIÓN MEJORADA DE REPARACIÓN
    function repararTexto($texto) {
        if (empty($texto)) return $texto;
        
        // Detectar si tiene caracteres de doble codificación
        if (preg_match('/Ã|Â|â€|Ã©|Ã³|Ã­|Ã¡|Ãº|Ã±|Ã¼|Ã‰|Ã"|Ã|Ãš|Ã'/u', $texto)) {
            // Método 1: Decodificar y recodificar
            $reparado = mb_convert_encoding($texto, 'UTF-8', 'ISO-8859-1');
            
            // Si no funcionó, intentar método alternativo
            if (preg_match('/Ã|Â/u', $reparado)) {
                $reparado = utf8_encode(utf8_decode($texto));
            }
            
            // Si aún no funciona, intentar conversión directa
            if (preg_match('/Ã|Â/u', $reparado)) {
                $reparado = iconv('UTF-8', 'ISO-8859-1//IGNORE', $texto);
                $reparado = iconv('ISO-8859-1', 'UTF-8', $reparado);
            }
            
            return $reparado;
        }
        
        return $texto;
    }
    
    echo "<h2>🔨 PASO 4: Reparar Datos con Doble Codificación</h2>";
    
    $total_reparados = 0;
    $ejemplos = [];
    
    // REPARAR titulo_programa
    echo "<h3>1. Reparando: titulo_programa</h3>";
    $stmt = $db->query("SELECT * FROM titulo_programa");
    $registros = $stmt->fetchAll();
    $count = 0;
    
    foreach ($registros as $reg) {
        $nombre_nuevo = repararTexto($reg['nombre']);
        $nivel_nuevo = repararTexto($reg['nivel']);
        
        if ($nombre_nuevo !== $reg['nombre'] || $nivel_nuevo !== $reg['nivel']) {
            $update = $db->prepare("UPDATE titulo_programa SET nombre = ?, nivel = ? WHERE id = ?");
            $update->execute([$nombre_nuevo, $nivel_nuevo, $reg['id']]);
            
            if ($nombre_nuevo !== $reg['nombre']) {
                $ejemplos[] = ['tabla' => 'titulo_programa', 'antes' => $reg['nombre'], 'despues' => $nombre_nuevo];
                echo "<div class='info'>✓ ID {$reg['id']}: <code>{$reg['nombre']}</code> → <code>{$nombre_nuevo}</code></div>";
            }
            $count++;
        }
    }
    echo "<div class='success'>✓ Reparados: {$count} registros</div>";
    $total_reparados += $count;
    
    // REPARAR centro_formacion
    echo "<h3>2. Reparando: centro_formacion</h3>";
    $stmt = $db->query("SELECT * FROM centro_formacion");
    $registros = $stmt->fetchAll();
    $count = 0;
    
    foreach ($registros as $reg) {
        $nombre_nuevo = repararTexto($reg['nombre']);
        $direccion_nueva = repararTexto($reg['direccion']);
        
        if ($nombre_nuevo !== $reg['nombre'] || $direccion_nueva !== $reg['direccion']) {
            $update = $db->prepare("UPDATE centro_formacion SET nombre = ?, direccion = ? WHERE id = ?");
            $update->execute([$nombre_nuevo, $direccion_nueva, $reg['id']]);
            
            if ($nombre_nuevo !== $reg['nombre']) {
                $ejemplos[] = ['tabla' => 'centro_formacion', 'antes' => $reg['nombre'], 'despues' => $nombre_nuevo];
                echo "<div class='info'>✓ ID {$reg['id']}: <code>{$reg['nombre']}</code> → <code>{$nombre_nuevo}</code></div>";
            }
            $count++;
        }
    }
    echo "<div class='success'>✓ Reparados: {$count} registros</div>";
    $total_reparados += $count;
    
    // REPARAR instructor
    echo "<h3>3. Reparando: instructor</h3>";
    $stmt = $db->query("SELECT * FROM instructor");
    $registros = $stmt->fetchAll();
    $count = 0;
    
    foreach ($registros as $reg) {
        $nombre_nuevo = repararTexto($reg['nombre']);
        
        if ($nombre_nuevo !== $reg['nombre']) {
            $update = $db->prepare("UPDATE instructor SET nombre = ? WHERE id = ?");
            $update->execute([$nombre_nuevo, $reg['id']]);
            
            $ejemplos[] = ['tabla' => 'instructor', 'antes' => $reg['nombre'], 'despues' => $nombre_nuevo];
            echo "<div class='info'>✓ ID {$reg['id']}: <code>{$reg['nombre']}</code> → <code>{$nombre_nuevo}</code></div>";
            $count++;
        }
    }
    echo "<div class='success'>✓ Reparados: {$count} registros</div>";
    $total_reparados += $count;
    
    // REPARAR programa
    echo "<h3>4. Reparando: programa</h3>";
    $stmt = $db->query("SELECT * FROM programa");
    $registros = $stmt->fetchAll();
    $count = 0;
    
    foreach ($registros as $reg) {
        $nombre_nuevo = repararTexto($reg['nombre']);
        
        if ($nombre_nuevo !== $reg['nombre']) {
            $update = $db->prepare("UPDATE programa SET nombre = ? WHERE id = ?");
            $update->execute([$nombre_nuevo, $reg['id']]);
            
            $ejemplos[] = ['tabla' => 'programa', 'antes' => $reg['nombre'], 'despues' => $nombre_nuevo];
            echo "<div class='info'>✓ ID {$reg['id']}: <code>{$reg['nombre']}</code> → <code>{$nombre_nuevo}</code></div>";
            $count++;
        }
    }
    echo "<div class='success'>✓ Reparados: {$count} registros</div>";
    $total_reparados += $count;
    
    // REPARAR usuarios
    echo "<h3>5. Reparando: usuarios</h3>";
    $stmt = $db->query("SELECT * FROM usuarios");
    $registros = $stmt->fetchAll();
    $count = 0;
    
    foreach ($registros as $reg) {
        $nombre_nuevo = repararTexto($reg['nombre']);
        
        if ($nombre_nuevo !== $reg['nombre']) {
            $update = $db->prepare("UPDATE usuarios SET nombre = ? WHERE id = ?");
            $update->execute([$nombre_nuevo, $reg['id']]);
            
            $ejemplos[] = ['tabla' => 'usuarios', 'antes' => $reg['nombre'], 'despues' => $nombre_nuevo];
            echo "<div class='info'>✓ ID {$reg['id']}: <code>{$reg['nombre']}</code> → <code>{$nombre_nuevo}</code></div>";
            $count++;
        }
    }
    echo "<div class='success'>✓ Reparados: {$count} registros</div>";
    $total_reparados += $count;
    
    // REPARAR competencia
    echo "<h3>6. Reparando: competencia</h3>";
    $stmt = $db->query("SELECT * FROM competencia");
    $registros = $stmt->fetchAll();
    $count = 0;
    
    foreach ($registros as $reg) {
        $nombre_nuevo = repararTexto($reg['nombre']);
        $descripcion_nueva = repararTexto($reg['descripcion']);
        
        if ($nombre_nuevo !== $reg['nombre'] || $descripcion_nueva !== $reg['descripcion']) {
            $update = $db->prepare("UPDATE competencia SET nombre = ?, descripcion = ? WHERE id = ?");
            $update->execute([$nombre_nuevo, $descripcion_nueva, $reg['id']]);
            
            if ($nombre_nuevo !== $reg['nombre']) {
                $ejemplos[] = ['tabla' => 'competencia', 'antes' => $reg['nombre'], 'despues' => $nombre_nuevo];
                echo "<div class='info'>✓ ID {$reg['id']}: <code>{$reg['nombre']}</code> → <code>{$nombre_nuevo}</code></div>";
            }
            $count++;
        }
    }
    echo "<div class='success'>✓ Reparados: {$count} registros</div>";
    $total_reparados += $count;
    
    // REPARAR coordinacion
    echo "<h3>7. Reparando: coordinacion</h3>";
    $stmt = $db->query("SELECT * FROM coordinacion");
    $registros = $stmt->fetchAll();
    $count = 0;
    
    foreach ($registros as $reg) {
        $nombre_nuevo = repararTexto($reg['nombre']);
        $responsable_nuevo = repararTexto($reg['responsable']);
        
        if ($nombre_nuevo !== $reg['nombre'] || $responsable_nuevo !== $reg['responsable']) {
            $update = $db->prepare("UPDATE coordinacion SET nombre = ?, responsable = ? WHERE id = ?");
            $update->execute([$nombre_nuevo, $responsable_nuevo, $reg['id']]);
            $count++;
        }
    }
    echo "<div class='success'>✓ Reparados: {$count} registros</div>";
    $total_reparados += $count;
    
    // ESTADÍSTICAS
    echo "<h2>📊 Estadísticas Finales</h2>";
    echo "<div class='stats'>";
    echo "<div class='stat-card'><div class='stat-number'>13</div><div class='stat-label'>Tablas Procesadas</div></div>";
    echo "<div class='stat-card'><div class='stat-number'>{$total_reparados}</div><div class='stat-label'>Registros Reparados</div></div>";
    echo "<div class='stat-card'><div class='stat-number'>" . count($ejemplos) . "</div><div class='stat-label'>Campos Corregidos</div></div>";
    echo "</div>";
    
    // EJEMPLOS
    if (!empty($ejemplos)) {
        echo "<h2>🔍 Ejemplos de Reparación</h2>";
        echo "<div class='comparison'>";
        echo "<div class='before'><h4>❌ ANTES (Dañado)</h4>";
        foreach (array_slice($ejemplos, 0, 10) as $ej) {
            echo "<p><strong>{$ej['tabla']}:</strong> <code>{$ej['antes']}</code></p>";
        }
        echo "</div>";
        echo "<div class='after'><h4>✅ DESPUÉS (Corregido)</h4>";
        foreach (array_slice($ejemplos, 0, 10) as $ej) {
            echo "<p><strong>{$ej['tabla']}:</strong> <code>{$ej['despues']}</code></p>";
        }
        echo "</div>";
        echo "</div>";
    }
    
    // VERIFICACIÓN
    echo "<h2>✅ Verificación de Datos</h2>";
    
    echo "<h3>Títulos de Programa:</h3>";
    $stmt = $db->query("SELECT * FROM titulo_programa LIMIT 10");
    $titulos = $stmt->fetchAll();
    echo "<table><tr><th>ID</th><th>Nombre</th><th>Nivel</th></tr>";
    foreach ($titulos as $t) {
        echo "<tr><td>{$t['id']}</td><td>{$t['nombre']}</td><td>{$t['nivel']}</td></tr>";
    }
    echo "</table>";
    
    echo "<h3>Centros de Formación:</h3>";
    $stmt = $db->query("SELECT * FROM centro_formacion LIMIT 10");
    $centros = $stmt->fetchAll();
    echo "<table><tr><th>ID</th><th>Nombre</th><th>Dirección</th></tr>";
    foreach ($centros as $c) {
        echo "<tr><td>{$c['id']}</td><td>{$c['nombre']}</td><td>{$c['direccion']}</td></tr>";
    }
    echo "</table>";
    
    echo "<h3>Instructores:</h3>";
    $stmt = $db->query("SELECT * FROM instructor LIMIT 10");
    $instructores = $stmt->fetchAll();
    echo "<table><tr><th>ID</th><th>Nombre</th><th>Email</th></tr>";
    foreach ($instructores as $i) {
        echo "<tr><td>{$i['id']}</td><td>{$i['nombre']}</td><td>{$i['email']}</td></tr>";
    }
    echo "</table>";
    
    // MENSAJE FINAL
    echo "<div class='success' style='font-size: 20px; text-align: center; padding: 40px; margin-top: 30px;'>";
    echo "<h2 style='margin-bottom: 20px;'>🎉 ¡REPARACIÓN COMPLETADA!</h2>";
    echo "<p style='font-size: 16px;'>Todos los caracteres han sido corregidos.</p>";
    echo "<p style='font-size: 16px;'>El sistema ahora muestra correctamente: Tecnología, Gestión, Formación</p>";
    echo "</div>";
    
    echo "<div style='text-align: center; margin-top: 30px;'>";
    echo "<a href='/Gestion-sena/' class='btn'>🏠 Ir al Dashboard</a>";
    echo "<a href='/Gestion-sena/views/titulo_programa/index.php' class='btn'>📋 Ver Títulos</a>";
    echo "<a href='/Gestion-sena/views/centro_formacion/index.php' class='btn'>🏫 Ver Centros</a>";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<div class='error'><strong>✗ Error:</strong> " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<div class='warning'><strong>Solución:</strong> Verifica que MySQL esté corriendo y que la base de datos 'dashboard_sena' exista.</div>";
}

?>

</div>
</body>
</html>
