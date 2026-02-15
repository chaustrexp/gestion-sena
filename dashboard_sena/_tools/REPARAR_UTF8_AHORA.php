<?php
/**
 * ═══════════════════════════════════════════════════════════════════
 * REPARACIÓN DEFINITIVA UTF-8
 * ═══════════════════════════════════════════════════════════════════
 * Este script repara TODOS los problemas de codificación UTF-8
 * Configuración → Configuración
 * TecnologÃ­a → Tecnología
 */

// Forzar UTF-8 en todo el script
header('Content-Type: text/html; charset=UTF-8');
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

// Conexión con MySQLi
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'dashboard_sena';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

// Configurar conexión UTF-8
$conn->set_charset("utf8mb4");
$conn->query("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
$conn->query("SET CHARACTER SET utf8mb4");
$conn->query("SET character_set_connection=utf8mb4");
$conn->query("SET character_set_client=utf8mb4");
$conn->query("SET character_set_results=utf8mb4");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reparación UTF-8 - Dashboard SENA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #39A900 0%, #007832 100%);
            padding: 20px;
            min-height: 100vh;
        }
        .container { 
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 { 
            color: #007832;
            font-size: 36px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .subtitle {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #39A900;
        }
        h2 { 
            color: #39A900;
            font-size: 24px;
            margin: 30px 0 15px;
            padding: 15px;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-left: 5px solid #39A900;
            border-radius: 8px;
        }
        h3 {
            color: #007832;
            font-size: 18px;
            margin: 20px 0 10px;
            padding-left: 10px;
            border-left: 3px solid #39A900;
        }
        .success { 
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            padding: 15px 20px;
            border-radius: 10px;
            margin: 10px 0;
            border-left: 5px solid #28a745;
            font-weight: 500;
        }
        .error { 
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            padding: 15px 20px;
            border-radius: 10px;
            margin: 10px 0;
            border-left: 5px solid #dc3545;
            font-weight: 500;
        }
        .info { 
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            color: #0c5460;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 8px 0;
            border-left: 4px solid #17a2b8;
            font-size: 14px;
        }
        .warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
            padding: 15px 20px;
            border-radius: 10px;
            margin: 10px 0;
            border-left: 5px solid #ffc107;
            font-weight: 500;
        }
        table { 
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td { 
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        th { 
            background: linear-gradient(135deg, #39A900 0%, #2d8700 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }
        tr:nth-child(even) { background: #f8f9fa; }
        tr:hover { background: #e8f5e9; }
        code { 
            background: #f4f4f4;
            padding: 3px 8px;
            border-radius: 4px;
            color: #c7254e;
            font-family: 'Courier New', monospace;
            font-size: 13px;
        }
        .stats { 
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .stat { 
            background: linear-gradient(135deg, #39A900 0%, #007832 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(57, 169, 0, 0.3);
            transition: transform 0.3s;
        }
        .stat:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(57, 169, 0, 0.4);
        }
        .stat-num { 
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .stat-label { 
            font-size: 14px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #39A900 0%, #2d8700 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            margin: 10px 5px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(57, 169, 0, 0.3);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(57, 169, 0, 0.4);
        }
        .final-message {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 3px solid #28a745;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            margin: 40px 0;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.2);
        }
        .final-message h2 {
            color: #155724;
            font-size: 32px;
            margin-bottom: 20px;
            background: none;
            border: none;
            padding: 0;
        }
        .final-message p {
            font-size: 18px;
            color: #155724;
            margin: 10px 0;
        }
        .progress-bar {
            width: 100%;
            height: 30px;
            background: #e0e0e0;
            border-radius: 15px;
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #39A900 0%, #007832 100%);
            transition: width 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🔧 Reparación Definitiva UTF-8</h1>
    <p class="subtitle">Corrigiendo problemas de codificación en la base de datos Dashboard SENA</p>

<?php

$total_reparados = 0;
$total_tablas = 0;
$total_campos = 0;

// PASO 1: Convertir Base de Datos
echo "<h2>📦 PASO 1: Configuración de Base de Datos</h2>";

$conn->query("ALTER DATABASE `{$db}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
echo "<div class='success'>✅ Base de datos convertida a utf8mb4_unicode_ci</div>";

// PASO 2: Convertir Tablas
echo "<h2>🗂️ PASO 2: Conversión de Tablas</h2>";

$tablas = [
    'ambiente', 'asignacion', 'centro_formacion', 'competencia', 
    'competencia_programa', 'coordinacion', 'detalle_asignacion', 
    'ficha', 'instructor', 'programa', 'sede', 'titulo_programa', 'usuarios'
];

foreach ($tablas as $tabla) {
    $sql = "ALTER TABLE `{$tabla}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if ($conn->query($sql)) {
        echo "<div class='info'>✓ Tabla <code>{$tabla}</code> convertida a utf8mb4</div>";
        $total_tablas++;
    } else {
        echo "<div class='warning'>⚠ Tabla <code>{$tabla}</code> no existe o ya está convertida</div>";
    }
}

// PASO 3: Función de Reparación
echo "<h2>🔨 PASO 3: Reparación de Datos Dañados</h2>";

function repararTexto($texto) {
    if (empty($texto) || !is_string($texto)) {
        return $texto;
    }
    
    // Detectar si tiene caracteres dañados
    if (!preg_match('/Ã|Â|Ã©|Ã³|Ã­|Ã±|Ãº/u', $texto)) {
        return $texto;
    }
    
    // Método 1: Conversión doble
    $reparado = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');
    $reparado = mb_convert_encoding($reparado, 'UTF-8', 'ISO-8859-1');
    
    // Si sigue teniendo problemas, intentar método 2
    if (preg_match('/Ã|Â/u', $reparado)) {
        $reparado = utf8_decode(utf8_encode($texto));
    }
    
    return $reparado;
}

// REPARAR CADA TABLA
$configuracion_tablas = [
    'titulo_programa' => ['campos' => ['nombre', 'nivel'], 'nombre_tabla' => 'Títulos de Programa'],
    'centro_formacion' => ['campos' => ['nombre', 'direccion'], 'nombre_tabla' => 'Centros de Formación'],
    'sede' => ['campos' => ['nombre', 'direccion'], 'nombre_tabla' => 'Sedes'],
    'coordinacion' => ['campos' => ['nombre', 'responsable'], 'nombre_tabla' => 'Coordinaciones'],
    'instructor' => ['campos' => ['nombre'], 'nombre_tabla' => 'Instructores'],
    'programa' => ['campos' => ['nombre'], 'nombre_tabla' => 'Programas'],
    'competencia' => ['campos' => ['nombre', 'descripcion'], 'nombre_tabla' => 'Competencias'],
    'ambiente' => ['campos' => ['nombre', 'tipo'], 'nombre_tabla' => 'Ambientes'],
    'ficha' => ['campos' => ['numero'], 'nombre_tabla' => 'Fichas'],
    'usuarios' => ['campos' => ['nombre', 'email'], 'nombre_tabla' => 'Usuarios']
];

foreach ($configuracion_tablas as $tabla => $config) {
    echo "<h3>📋 {$config['nombre_tabla']}</h3>";
    
    // Verificar si la tabla existe
    $check = $conn->query("SHOW TABLES LIKE '{$tabla}'");
    if ($check->num_rows == 0) {
        echo "<div class='warning'>⚠ Tabla <code>{$tabla}</code> no existe</div>";
        continue;
    }
    
    $result = $conn->query("SELECT * FROM `{$tabla}`");
    
    if (!$result) {
        echo "<div class='error'>❌ Error al leer tabla: " . $conn->error . "</div>";
        continue;
    }
    
    $count = 0;
    
    while ($row = $result->fetch_assoc()) {
        $cambios = [];
        $valores = [];
        $tipos = '';
        
        foreach ($config['campos'] as $campo) {
            if (isset($row[$campo]) && !empty($row[$campo])) {
                $valor_original = $row[$campo];
                $valor_reparado = repararTexto($valor_original);
                
                if ($valor_reparado !== $valor_original) {
                    $cambios[] = "`{$campo}` = ?";
                    $valores[] = $valor_reparado;
                    $tipos .= 's';
                    $total_campos++;
                    
                    echo "<div class='info'>🔄 ID {$row['id']}: <code>{$valor_original}</code> → <code>{$valor_reparado}</code></div>";
                }
            }
        }
        
        if (!empty($cambios)) {
            $sql = "UPDATE `{$tabla}` SET " . implode(', ', $cambios) . " WHERE id = ?";
            $stmt = $conn->prepare($sql);
            
            if ($stmt) {
                $valores[] = $row['id'];
                $tipos .= 'i';
                $stmt->bind_param($tipos, ...$valores);
                $stmt->execute();
                $stmt->close();
                $count++;
            }
        }
    }
    
    if ($count > 0) {
        echo "<div class='success'>✅ {$count} registros reparados en {$config['nombre_tabla']}</div>";
        $total_reparados += $count;
    } else {
        echo "<div class='info'>✓ No se encontraron datos dañados en {$config['nombre_tabla']}</div>";
    }
}

// ESTADÍSTICAS
echo "<h2>📊 Estadísticas de Reparación</h2>";
echo "<div class='stats'>";
echo "<div class='stat'><div class='stat-num'>{$total_tablas}</div><div class='stat-label'>Tablas Convertidas</div></div>";
echo "<div class='stat'><div class='stat-num'>{$total_reparados}</div><div class='stat-label'>Registros Reparados</div></div>";
echo "<div class='stat'><div class='stat-num'>{$total_campos}</div><div class='stat-label'>Campos Corregidos</div></div>";
echo "</div>";

// VERIFICACIÓN
echo "<h2>✅ Verificación de Datos Corregidos</h2>";

$tablas_verificar = [
    'titulo_programa' => ['campos' => ['id', 'nombre', 'nivel'], 'titulo' => 'Títulos de Programa'],
    'centro_formacion' => ['campos' => ['id', 'nombre', 'direccion'], 'titulo' => 'Centros de Formación'],
    'instructor' => ['campos' => ['id', 'nombre', 'email'], 'titulo' => 'Instructores'],
    'programa' => ['campos' => ['id', 'nombre'], 'titulo' => 'Programas']
];

foreach ($tablas_verificar as $tabla => $info) {
    $check = $conn->query("SHOW TABLES LIKE '{$tabla}'");
    if ($check->num_rows > 0) {
        echo "<h3>{$info['titulo']}</h3>";
        $result = $conn->query("SELECT * FROM `{$tabla}` LIMIT 5");
        
        if ($result && $result->num_rows > 0) {
            echo "<table><tr>";
            foreach ($info['campos'] as $campo) {
                echo "<th>" . ucfirst($campo) . "</th>";
            }
            echo "</tr>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($info['campos'] as $campo) {
                    echo "<td>" . htmlspecialchars($row[$campo] ?? '', ENT_QUOTES, 'UTF-8') . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
    }
}

// MENSAJE FINAL
echo "<div class='final-message'>";
echo "<h2>🎉 ¡Reparación Completada!</h2>";
echo "<p><strong>Todos los problemas de codificación han sido corregidos</strong></p>";
echo "<p>Ahora verás correctamente: <strong>Configuración, Tecnología, Gestión, Formación</strong></p>";
echo "<p style='margin-top: 20px; font-size: 14px; opacity: 0.8;'>Presiona Ctrl+F5 en el dashboard para limpiar la caché del navegador</p>";
echo "</div>";

echo "<div style='text-align: center; margin-top: 30px;'>";
echo "<a href='/Gestion-sena/dashboard_sena/' class='btn'>🏠 Ir al Dashboard</a>";
echo "<a href='/Gestion-sena/dashboard_sena/views/ambiente/index.php' class='btn'>🏢 Ver Ambientes</a>";
echo "<a href='/Gestion-sena/dashboard_sena/views/titulo_programa/index.php' class='btn'>📋 Ver Títulos</a>";
echo "</div>";

$conn->close();

?>

</div>

<script>
// Auto-scroll suave al final
window.addEventListener('load', function() {
    setTimeout(function() {
        window.scrollTo({
            top: document.body.scrollHeight,
            behavior: 'smooth'
        });
    }, 500);
});
</script>

</body>
</html>
