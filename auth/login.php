<?php
session_start();

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['usuario_id'])) {
    header('Location: /Gestion-sena/index.php');
    exit;
}

require_once __DIR__ . '/../conexion.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($email) && !empty($password)) {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ? AND estado = 'Activo'");
            $stmt->execute([$email]);
            $usuario = $stmt->fetch();
            
            if ($usuario && password_verify($password, $usuario['password'])) {
                // Login exitoso
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_rol'] = $usuario['rol'];
                
                // Actualizar último acceso
                $stmt = $db->prepare("UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = ?");
                $stmt->execute([$usuario['id']]);
                
                header('Location: /Gestion-sena/index.php');
                exit;
            } else {
                $error = 'Credenciales incorrectas o usuario inactivo';
            }
        } catch (PDOException $e) {
            $error = 'Error de conexión. Intente nuevamente.';
        }
    } else {
        $error = 'Por favor complete todos los campos';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard SENA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: url('/Gestion-sena/assets/images/ImagenFachada111124SENA.jpg') center/cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }
        
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 950px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            position: relative;
            z-index: 10;
        }
        
        .login-left {
            background: linear-gradient(135deg, #39A900 0%, #007832 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        
        .logo-circle {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .logo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .login-left h1 {
            font-size: 48px;
            margin-bottom: 12px;
            font-weight: 800;
            letter-spacing: 2px;
        }
        
        .login-left p {
            font-size: 15px;
            opacity: 0.95;
            line-height: 1.6;
        }
        
        .login-right {
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-header {
            margin-bottom: 35px;
        }
        
        .login-header h2 {
            color: #007832;
            font-size: 28px;
            margin-bottom: 8px;
            font-weight: 700;
        }
        
        .login-header p {
            color: #666;
            font-size: 14px;
        }
        
        .alert-error {
            background: #ff4757;
            color: white;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
        }
        
        .alert-error::before {
            content: '⚠';
            margin-right: 10px;
            font-size: 18px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            color: #007832;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e8e8e8;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #39A900;
            box-shadow: 0 0 0 4px rgba(57, 169, 0, 0.1);
        }
        
        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 13px;
        }
        
        .options label {
            display: flex;
            align-items: center;
            color: #666;
            cursor: pointer;
        }
        
        .options input[type="checkbox"] {
            margin-right: 8px;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }
        
        .options a {
            color: #39A900;
            text-decoration: none;
            font-weight: 600;
        }
        
        .options a:hover {
            color: #007832;
        }
        
        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #39A900 0%, #007832 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            box-shadow: 0 4px 15px rgba(57, 169, 0, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(57, 169, 0, 0.4);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #999;
            font-size: 12px;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e8e8e8;
        }
        
        .divider::before {
            margin-right: 12px;
        }
        
        .divider::after {
            margin-left: 12px;
        }
        
        .demo-box {
            background: #f8f9fa;
            padding: 16px;
            border-radius: 10px;
            font-size: 12px;
            color: #495057;
        }
        
        .demo-box strong {
            color: #007832;
            display: block;
            margin-bottom: 10px;
            font-weight: 700;
            font-size: 13px;
        }
        
        .demo-item {
            display: flex;
            justify-content: space-between;
            margin: 6px 0;
            padding: 8px;
            background: white;
            border-radius: 6px;
        }
        
        .demo-item span:first-child {
            font-weight: 600;
            color: #6c757d;
        }
        
        .demo-item span:last-child {
            font-family: 'Courier New', monospace;
            color: #007832;
            font-size: 11px;
        }
        
        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
                max-width: 450px;
            }
            
            .login-left {
                padding: 40px 30px;
            }
            
            .login-left h1 {
                font-size: 36px;
            }
            
            .logo-circle {
                width: 90px;
                height: 90px;
            }
            
            .login-right {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <div class="logo-circle">
                <img src="/Gestion-sena/assets/images/sena-logo.png" alt="Logo SENA">
            </div>
            <h1>SENA</h1>
            <p>Sistema de Gestión Académica<br>Servicio Nacional de Aprendizaje</p>
        </div>
        
        <div class="login-right">
            <div class="login-header">
                <h2>Bienvenido</h2>
                <p>Ingrese sus credenciales para continuar</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <div class="input-wrapper">
                        <span class="input-icon">📧</span>
                        <input type="email" id="email" name="email" placeholder="usuario@sena.edu.co" required autofocus>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="input-wrapper">
                        <span class="input-icon">🔒</span>
                        <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
                    </div>
                </div>
                
                <div class="options">
                    <label>
                        <input type="checkbox" name="remember">
                        Recordarme
                    </label>
                    <a href="#">¿Olvidó su contraseña?</a>
                </div>
                
                <button type="submit" class="btn-login">Iniciar Sesión</button>
            </form>
            
            <div class="divider">Credenciales de Prueba</div>
            
            <div class="demo-box">
                <strong>Acceso de Demostración</strong>
                <div class="demo-item">
                    <span>Email:</span>
                    <span>admin@sena.edu.co</span>
                </div>
                <div class="demo-item">
                    <span>Contraseña:</span>
                    <span>admin123</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
