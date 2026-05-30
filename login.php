<?php
session_start();
include "conexion.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['txtusuario']);
    $clave   = trim($_POST['txtclave']);

    // Usuario hardcodeado: admin / admin123
    if ($usuario === 'admin' && $clave === 'admin123') {
        $_SESSION['usuario'] = $usuario;
        header("location:panel.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - ITSE</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('img/fondo.png');
            background-size: cover;
        }
        .login-box {
            background: white;
            border-radius: 12px;
            padding: 40px 50px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            width: 360px;
            text-align: center;
        }
        .login-box h2 {
            font-family: Arial, sans-serif;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 22px;
        }
        .login-box p {
            font-family: Arial, sans-serif;
            color: #888;
            font-size: 13px;
            margin-bottom: 28px;
        }
        .login-box label {
            display: block;
            text-align: left;
            font-family: Arial, sans-serif;
            font-size: 13px;
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }
        .login-box input[type=text],
        .login-box input[type=password] {
            width: 100%;
            padding: 11px 14px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
            background: #f9fbfd;
        }
        .login-box input[type=text]:focus,
        .login-box input[type=password]:focus {
            outline: none;
            border-color: #2471a3;
            background: #fff;
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #1a8a7a, #16a085);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            font-family: Arial, sans-serif;
            margin-top: 5px;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #16a085, #1a8a7a);
        }
        .error-msg {
            background: #e74c3c;
            color: white;
            padding: 10px;
            border-radius: 6px;
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin-bottom: 18px;
        }
        .login-icon {
            font-size: 50px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="login-box">
    <div class="login-icon">🏛️</div>
    <h2>Sistema ITSE</h2>
    <p>Certificados de Funcionamiento</p>

    <?php if ($error): ?>
        <div class="error-msg">⚠ <?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Usuario:</label>
        <input type="text" name="txtusuario" placeholder="Ingrese su usuario" autocomplete="off" required>
        <label>Contraseña:</label>
        <input type="password" name="txtclave" placeholder="Ingrese su contraseña" required>
        <input type="submit" value="Ingresar al Sistema" class="btn-login">
    </form>
</div>
</body>
</html>
