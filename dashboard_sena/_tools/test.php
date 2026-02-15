<?php
// Archivo de prueba para verificar que PHP funciona
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test - Dashboard SENA</title>
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
            max-width: 600px;
        }
        h1 {
            color: #007832;
            margin-bottom: 20px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin: 10px 0;
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
            padding: 12px 24px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>✅ PHP Funciona Correctamente</h1>
        
        <div class="success">
            <strong>✓ Servidor Web:</strong> Apache está funcionando<br>
            <strong>✓ PHP:</strong> Versión <?php echo phpversion(); ?><br>
            <strong>✓ Ruta actual:</strong> <?php echo __DIR__; ?>
        </div>

        <div class="info">
            <strong>📍 URL de acceso:</strong><br>
            <code><?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?></code>
        </div>

        <div class="info">
            <strong>🔍 Información del sistema:</strong><br>
            <strong>Sistema Operativo:</strong> <?php echo PHP_OS; ?><br>
            <strong>Servidor:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?><br>
            <strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT']; ?>
        </div>

        <h2>📋 Próximos Pasos:</h2>
        <div class="info">
            <p><strong>1. Acceder al Login:</strong></p>
            <a href="auth/login.php" class="btn">Ir al Login</a>
            
            <p style="margin-top: 20px;"><strong>2. Verificar UTF-8:</strong></p>
            <a href="VERIFICAR_UTF8.php" class="btn">Verificar UTF-8</a>
            
            <p style="margin-top: 20px;"><strong>3. Reparar UTF-8 (si es necesario):</strong></p>
            <a href="REPARAR_UTF8_AHORA.php" class="btn">Reparar UTF-8</a>
        </div>

        <div class="info" style="margin-top: 20px;">
            <strong>ℹ️ Nota:</strong> El dashboard principal requiere autenticación. 
            Primero debes iniciar sesión en el sistema.
        </div>
    </div>
</body>
</html>
