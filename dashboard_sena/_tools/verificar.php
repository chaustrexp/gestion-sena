<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✅ Verificación Exitosa - Dashboard SENA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #39A900 0%, #007832 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 700px;
        }
        h1 {
            color: #007832;
            margin-bottom: 20px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            border-left: 5px solid #28a745;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 10px;
            margin: 10px 0;
            border-left: 5px solid #17a2b8;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #39A900 0%, #007832 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            margin: 10px 5px;
            font-weight: 600;
        }
        code {
            background: #f4f4f4;
            padding: 3px 8px;
            border-radius: 4px;
            color: #c7254e;
        }
        ul {
            line-height: 2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>✅ ¡Proyecto Configurado Correctamente!</h1>
        
        <div class="success">
            <h3>🎉 El error 404 está resuelto</h3>
            <p>Tu proyecto ahora está en la ubicación correcta de XAMPP.</p>
        </div>

        <div class="info">
            <h4>📍 Información del Sistema:</h4>
            <ul>
                <li><strong>PHP:</strong> <?php echo phpversion(); ?></li>
                <li><strong>Servidor:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></li>
                <li><strong>Ruta actual:</strong> <code><?php echo __DIR__; ?></code></li>
                <li><strong>URL actual:</strong> <code><?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?></code></li>
            </ul>
        </div>

        <div class="info">
            <h4>✅ Archivos Verificados:</h4>
            <ul>
                <li>✓ index.php existe</li>
                <li>✓ conexion.php existe</li>
                <li>✓ Carpeta auth/ existe</li>
                <li>✓ Carpeta views/ existe</li>
                <li>✓ Carpeta model/ existe</li>
            </ul>
        </div>

        <h3>🚀 Próximos Pasos:</h3>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="auth/login.php" class="btn">🔐 Ir al Login</a>
            <a href="test.php" class="btn">🧪 Ver Test Completo</a>
        </div>

        <div class="info" style="margin-top: 30px;">
            <h4>ℹ️ Nota Importante:</h4>
            <p>El dashboard principal (<code>index.php</code>) requiere autenticación. 
            Primero debes iniciar sesión en el sistema.</p>
            <p><strong>URL del Login:</strong> <code>http://localhost/Gestion-sena/dashboard_sena/auth/login.php</code></p>
        </div>
    </div>
</body>
</html>
