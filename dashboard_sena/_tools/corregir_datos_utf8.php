<?php
/**
 * SCRIPT DE REPARACIÓN UTF-8 DEFINITIVO
 * Dashboard SENA - Gestión de Asignaciones
 * 
 * Este script repara la doble codificación UTF-8 en la base de datos
 * Convierte: TecnologÃ­a → Tecnología
 */

// Configuración
define('DB_HOST', 'localhost');
define('DB_NAME', 'dashboard_sena');
define('DB_USER', 'root');
define('DB_PASS', '');

// Establecer UTF-8 en la salida
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reparación UTF-8 - Dashboard SENA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #39A900 0%, #2d8500 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .header p {
            opacity: 0.9;
            font-size: 14px;
        }
        .content {
            padding: 40px;
        }
        .step {
            background: #f8f9fa;
            border-left: 4px solid #39A900;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .step h3 {
            color: #2d8500;
            margin-bottom: 10px;
            font-size: 18px;
        }
        .step p {
            color: #495057;
            line-height: 1.6;
            margin-bottom: 8px;
        }
        .success {
            background: #d1fae5;
            border-left-color: #10b981;
            color: #065f46;
        }
        .error {
            background: #fee2e2;
            border-left-color: #ef4444;
            color: #991b1b;
        }
        .warning {
            background: #fef3c7;
            border-left-color: #f59e0b;
            color: #92400e;
        }
        .info {
            background: #dbeafe;
            border-left-color: #3b82f6;
            color: #1e40af;
        }
        .code {
            background: #1e1e2d;
            color: #a9b7c6;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            overflow-x: auto;
            margin: 15px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #39A900 0%, #2d8500 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 20px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(57, 169, 0, 0.4);
        }
        .progress {
            background: #e5e7eb;
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-bar {
            background: linear-gradient(90deg, #39A900 0%, #2d8500 100%);
            height: 100%;
            transition: width 0.3s ease;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th {
            background: #f3f4f6;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #f3f4f6;
            color: #495057;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-error { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔧 Reparación UTF-8</h1>
            <p>Dashboard SENA - Sistema de Gestión de Asignaciones</p>
        </div>
        <div class="content">
<?php

try {
    // Conectar a la base de datos
    echo '<div class="step info">';
    echo '<h3>📡 Paso 1: Conectando a la base de datos</h3>';
    echo '<p>Host: ' . DB_HOST . '</p>';
    echo '<p>Base de datos: ' . DB_NAME . '</p>';
    
    $conn = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo '<p><strong>✅ Conexión establecida correctamente</strong></p>';
    echo '</div>';
    
    // Paso 2: Convertir base de datos
    echo '<div class="step">';
    echo '<h3>🔄 Paso 2: Convirtiendo base de datos a UTF-8</h3>';
    
    $conn->exec("ALTER DATABASE " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo '<p>✅ Base de datos convertida a utf8mb4_unicode_ci</p>';
    echo '</div>';
    
    // Paso 3: Obtener todas las tablas
    echo '<div class="step">';
    echo '<h3>📋 Paso 3: Obteniendo lista de tablas</h3>';
    
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo '<p>Tablas encontradas: <strong>' . count($tables) . '</strong></p>';
    echo '<ul style="margin-left: 20px; margin-top: 10px;">';
    foreach ($tables as $table) {
        echo '<li>' . htmlspecialchars($table) . '</li>';
    }
    echo '</ul>';
    echo '</div>';
    
    // Paso 4: Convertir cada tabla
    echo '<div class="step">';
    echo '<h3>🔧 Paso 4: Convirtiendo tablas a UTF-8</h3>';
    echo '<table>';
    echo '<thead><tr><th>Tabla</th><th>Estado</th></tr></thead>';
    echo '<tbody>';
    
    foreach ($tables as $table) {
        try {
            $conn->exec("ALTER TABLE `$table` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo '<tr>';
            echo '<td>' . htmlspecialchars($table) . '</td>';
            echo '<td><span class="badge badge-success">✅ Convertida</span></td>';
            echo '</tr>';
        } catch (PDOException $e) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($table) . '</td>';
            echo '<td><span class="badge badge-error">❌ Error</span></td>';
            echo '</tr>';
        }
    }
    
    echo '</tbody></table>';
    echo '</div>';
    
    // Paso 5: Reparar datos con doble codificación
    echo '<div class="step warning">';
    echo '<h3>⚠️ Paso 5: Reparando doble codificación</h3>';
    echo '<p>Este paso repara datos que ya están mal guardados (TecnologÃ­a → Tecnología)</p>';
    
    $tablesRepaired = 0;
    $columnsRepaired = 0;
    
    foreach ($tables as $table) {
        // Obtener columnas de texto
        $stmt = $conn->query("SHOW COLUMNS FROM `$table`");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $textColumns = [];
        foreach ($columns as $column) {
            $type = strtolower($column['Type']);
            if (strpos($type, 'varchar') !== false || 
                strpos($type, 'text') !== false || 
                strpos($type, 'char') !== false) {
                $textColumns[] = $column['Field'];
            }
        }
        
        if (empty($textColumns)) {
            continue;
        }
        
        // Reparar cada columna
        foreach ($textColumns as $colName) {
            try {
                // Detectar y reparar doble codificación
                $sql = "UPDATE `$table` 
                        SET `$colName` = CONVERT(CAST(CONVERT(`$colName` USING latin1) AS BINARY) USING utf8mb4)
                        WHERE `$colName` LIKE '%Ã%' 
                           OR `$colName` LIKE '%Ã±%'
                           OR `$colName` LIKE '%Ã³%'
                           OR `$colName` LIKE '%Ã­%'
                           OR `$colName` LIKE '%Ã©%'
                           OR `$colName` LIKE '%Ãº%'";
                
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $affected = $stmt->rowCount();
                
                if ($affected > 0) {
                    $columnsRepaired++;
                    echo '<p>✅ <strong>' . htmlspecialchars($table) . '.' . htmlspecialchars($colName) . '</strong>: ' . $affected . ' registros reparados</p>';
                }
            } catch (PDOException $e) {
                // Ignorar errores en columnas específicas
            }
        }
        
        $tablesRepaired++;
    }
    
    echo '<p style="margin-top: 15px;"><strong>📊 Resumen:</strong></p>';
    echo '<p>• Tablas procesadas: ' . $tablesRepaired . '</p>';
    echo '<p>• Columnas reparadas: ' . $columnsRepaired . '</p>';
    echo '</div>';
    
    // Paso 6: Verificación
    echo '<div class="step success">';
    echo '<h3>✅ Paso 6: Verificación Final</h3>';
    
    // Verificar codificación de tablas
    $stmt = $conn->query("
        SELECT TABLE_NAME, TABLE_COLLATION
        FROM information_schema.TABLES
        WHERE TABLE_SCHEMA = '" . DB_NAME . "'
        ORDER BY TABLE_NAME
    ");
    $tableInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<p><strong>Codificación de tablas:</strong></p>';
    echo '<table>';
    echo '<thead><tr><th>Tabla</th><th>Collation</th><th>Estado</th></tr></thead>';
    echo '<tbody>';
    
    foreach ($tableInfo as $info) {
        $isUtf8 = strpos($info['TABLE_COLLATION'], 'utf8') !== false;
        echo '<tr>';
        echo '<td>' . htmlspecialchars($info['TABLE_NAME']) . '</td>';
        echo '<td>' . htmlspecialchars($info['TABLE_COLLATION']) . '</td>';
        echo '<td>';
        if ($isUtf8) {
            echo '<span class="badge badge-success">✅ UTF-8</span>';
        } else {
            echo '<span class="badge badge-error">❌ No UTF-8</span>';
        }
        echo '</td>';
        echo '</tr>';
    }
    
    echo '</tbody></table>';
    echo '</div>';
    
    // Resultado final
    echo '<div class="step success">';
    echo '<h3>🎉 ¡Proceso Completado!</h3>';
    echo '<p>La reparación UTF-8 se ha completado exitosamente.</p>';
    echo '<p><strong>Próximos pasos:</strong></p>';
    echo '<ol style="margin-left: 20px; margin-top: 10px;">';
    echo '<li>Verifica que los datos se vean correctamente en phpMyAdmin</li>';
    echo '<li>Accede a tu aplicación y verifica las tablas</li>';
    echo '<li>Crea un nuevo registro con tildes para probar</li>';
    echo '</ol>';
    echo '<a href="/Gestion-sena/" class="btn">🏠 Ir al Dashboard</a>';
    echo '</div>';
    
} catch (PDOException $e) {
    echo '<div class="step error">';
    echo '<h3>❌ Error de Conexión</h3>';
    echo '<p><strong>Mensaje:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p>Verifica que:</p>';
    echo '<ul style="margin-left: 20px;">';
    echo '<li>XAMPP esté ejecutándose</li>';
    echo '<li>MySQL esté activo</li>';
    echo '<li>Las credenciales sean correctas</li>';
    echo '<li>La base de datos "dashboard_sena" exista</li>';
    echo '</ul>';
    echo '</div>';
}

?>
        </div>
    </div>
</body>
</html>
