<?php
/**
 * VERIFICADOR UTF-8
 * Comprueba la configuración UTF-8 del sistema
 */

header('Content-Type: text/html; charset=UTF-8');
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificador UTF-8 - Dashboard SENA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #39A900 0%, #007832 100%);
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #007832;
            font-size: 32px;
            margin-bottom: 30px;
            text-align: center;
        }
        .check-item {
            background: #f8f9fa;
            padding: 20px;
            margin: 15px 0;
            border-radius: 10px;
            border-left: 5px solid #6c757d;
        }
        .check-item.success {
            background: #d4edda;
            border-left-color: #28a745;
        }
        .check-item.error {
            background: #f8d7da;
            border-left-color: #dc3545;
        }
        .check-item.warning {
            background: #fff3cd;
            border-left-color: #ffc107;
        }
        .check-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .check-detail {
            font-size: 14px;
            color: #666;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        .test-text {
            background: #e8f5e9;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border: 2px solid #39A900;
        }
        .test-text h3 {
            color: #007832;
            margin-bottom: 15px;
        }
        .test-text p {
            font-size: 18px;
            line-height: 1.8;
            color: #333;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #39A900 0%, #2d8700 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 10px 5px;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #39A900;
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🔍 Verificador de Configuración UTF-8</h1>

    <?php
    $checks = [];
    $total_ok = 0;
    $total_checks = 0;

    // CHECK 1: PHP Charset
    $total_checks++;
    $php_charset = ini_get('default_charset');
    if (strtolower($php_charset) === 'utf-8') {
        $checks[] = [
            'status' => 'success',
            'title' => '✅ PHP Charset',
            'detail' => "Configurado correctamente: <code>{$php_charset}</code>"
        ];
        $total_ok++;
    } else {
        $checks[] = [
            'status' => 'warning',
            'title' => '⚠️ PHP Charset',
            'detail' => "Actual: <code>{$php_charset}</code> (debería ser UTF-8)"
        ];
    }

    // CHECK 2: MB String
    $total_checks++;
    if (function_exists('mb_internal_encoding')) {
        $mb_encoding = mb_internal_encoding();
        if (strtolower($mb_encoding) === 'utf-8') {
            $checks[] = [
                'status' => 'success',
                'title' => '✅ MB String Encoding',
                'detail' => "Configurado correctamente: <code>{$mb_encoding}</code>"
            ];
            $total_ok++;
        } else {
            $checks[] = [
                'status' => 'warning',
                'title' => '⚠️ MB String Encoding',
                'detail' => "Actual: <code>{$mb_encoding}</code>"
            ];
        }
    } else {
        $checks[] = [
            'status' => 'error',
            'title' => '❌ MB String',
            'detail' => 'Extensión mbstring no disponible'
        ];
    }

    // CHECK 3: Conexión a Base de Datos
    $total_checks++;
    try {
        $conn = new mysqli("localhost", "root", "", "dashboard_sena");
        
        if ($conn->connect_error) {
            $checks[] = [
                'status' => 'error',
                'title' => '❌ Conexión MySQL',
                'detail' => "Error: " . $conn->connect_error
            ];
        } else {
            $checks[] = [
                'status' => 'success',
                'title' => '✅ Conexión MySQL',
                'detail' => 'Conectado correctamente a dashboard_sena'
            ];
            $total_ok++;

            // CHECK 4: Charset de la Base de Datos
            $total_checks++;
            $result = $conn->query("SELECT DEFAULT_CHARACTER_SET_NAME, DEFAULT_COLLATION_NAME 
                                   FROM information_schema.SCHEMATA 
                                   WHERE SCHEMA_NAME = 'dashboard_sena'");
            
            if ($result && $row = $result->fetch_assoc()) {
                $db_charset = $row['DEFAULT_CHARACTER_SET_NAME'];
                $db_collation = $row['DEFAULT_COLLATION_NAME'];
                
                if (strpos($db_charset, 'utf8') !== false) {
                    $checks[] = [
                        'status' => 'success',
                        'title' => '✅ Charset Base de Datos',
                        'detail' => "Charset: <code>{$db_charset}</code>, Collation: <code>{$db_collation}</code>"
                    ];
                    $total_ok++;
                } else {
                    $checks[] = [
                        'status' => 'warning',
                        'title' => '⚠️ Charset Base de Datos',
                        'detail' => "Charset: <code>{$db_charset}</code> (debería ser utf8mb4)"
                    ];
                }
            }

            // CHECK 5: Charset de las Tablas
            $total_checks++;
            $result = $conn->query("SELECT TABLE_NAME, TABLE_COLLATION 
                                   FROM information_schema.TABLES 
                                   WHERE TABLE_SCHEMA = 'dashboard_sena' 
                                   AND TABLE_TYPE = 'BASE TABLE'");
            
            $tablas_utf8 = 0;
            $total_tablas = 0;
            $tablas_info = [];
            
            while ($row = $result->fetch_assoc()) {
                $total_tablas++;
                if (strpos($row['TABLE_COLLATION'], 'utf8') !== false) {
                    $tablas_utf8++;
                }
                $tablas_info[] = $row;
            }
            
            if ($tablas_utf8 === $total_tablas && $total_tablas > 0) {
                $checks[] = [
                    'status' => 'success',
                    'title' => '✅ Charset de Tablas',
                    'detail' => "Todas las tablas ({$total_tablas}) están en UTF-8"
                ];
                $total_ok++;
            } else {
                $checks[] = [
                    'status' => 'warning',
                    'title' => '⚠️ Charset de Tablas',
                    'detail' => "Solo {$tablas_utf8} de {$total_tablas} tablas están en UTF-8"
                ];
            }

            // CHECK 6: Datos de Prueba
            $total_checks++;
            $result = $conn->query("SELECT nombre FROM titulo_programa LIMIT 1");
            if ($result && $row = $result->fetch_assoc()) {
                $texto_prueba = $row['nombre'];
                
                // Detectar si tiene caracteres dañados
                if (preg_match('/Ã|Â/u', $texto_prueba)) {
                    $checks[] = [
                        'status' => 'error',
                        'title' => '❌ Datos con Problemas',
                        'detail' => "Se detectaron caracteres dañados en los datos. Ejemplo: <code>{$texto_prueba}</code><br>
                                   <strong>Solución:</strong> Ejecutar <a href='REPARAR_UTF8_AHORA.php'>REPARAR_UTF8_AHORA.php</a>"
                    ];
                } else {
                    $checks[] = [
                        'status' => 'success',
                        'title' => '✅ Datos Correctos',
                        'detail' => "Los datos se ven correctamente. Ejemplo: <code>{$texto_prueba}</code>"
                    ];
                    $total_ok++;
                }
            }

            $conn->close();
        }
    } catch (Exception $e) {
        $checks[] = [
            'status' => 'error',
            'title' => '❌ Error de Conexión',
            'detail' => $e->getMessage()
        ];
    }

    // Mostrar resultados
    foreach ($checks as $check) {
        echo "<div class='check-item {$check['status']}'>";
        echo "<div class='check-title'>{$check['title']}</div>";
        echo "<div class='check-detail'>{$check['detail']}</div>";
        echo "</div>";
    }

    // Resumen
    $porcentaje = ($total_ok / $total_checks) * 100;
    $color = $porcentaje >= 80 ? 'success' : ($porcentaje >= 50 ? 'warning' : 'error');
    
    echo "<div class='check-item {$color}' style='margin-top: 30px;'>";
    echo "<div class='check-title'>📊 Resumen</div>";
    echo "<div class='check-detail'>";
    echo "Verificaciones exitosas: <strong>{$total_ok} de {$total_checks}</strong> (" . round($porcentaje) . "%)";
    echo "</div>";
    echo "</div>";
    ?>

    <div class="test-text">
        <h3>🧪 Texto de Prueba UTF-8</h3>
        <p>
            Si ves estos textos correctamente, UTF-8 está funcionando:<br><br>
            ✓ Configuración<br>
            ✓ Tecnología<br>
            ✓ Gestión<br>
            ✓ Formación<br>
            ✓ Especialización<br>
            ✓ Bogotá, Medellín, Cali<br>
            ✓ Año, señor, niño<br>
            ✓ Caracteres especiales: á é í ó ú ñ ü ¿ ¡
        </p>
    </div>

    <?php if ($porcentaje < 100): ?>
    <div style="text-align: center; margin-top: 30px;">
        <a href="REPARAR_UTF8_AHORA.php" class="btn">🔧 Reparar Problemas UTF-8</a>
    </div>
    <?php else: ?>
    <div style="text-align: center; margin-top: 30px;">
        <a href="index.php" class="btn">🏠 Ir al Dashboard</a>
    </div>
    <?php endif; ?>

</div>
</body>
</html>
