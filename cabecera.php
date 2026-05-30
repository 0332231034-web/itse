<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabecera</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<center>

<table class="tabla-cabecera" style="width:100%;">
    <tr align="center">
        <td style="width:16%; padding: 15px 0;">
            <a href="index.php" target="_parent" class="nav-link">
                <img src="img/index.png" alt="Index"><br>
                Index
            </a>
        </td>
        <td style="width:16%; padding: 15px 0;">
            <a href="giro-negocio.php" target="_parent" class="nav-link">
                <img src="img/giro-negocio.png" alt="Giro Negocio"><br>
                Giro Negocio
            </a>
        </td>
        <td style="width:16%; padding: 15px 0;">
            <a href="distrito.php" target="_parent" class="nav-link">
                <img src="img/distrito.png" alt="Distrito"><br>
                Distrito
            </a>
        </td>
        <td style="width:16%; padding: 15px 0;">
            <a href="funcionario.php" target="_parent" class="nav-link">
                <img src="img/funcionario.png" alt="Funcionario"><br>
                Funcionario
            </a>
        </td>
        <td style="width:16%; padding: 15px 0;">
            <a href="panel.php" target="_parent" class="nav-link">
                <img src="img/panel-l.png" alt="Panel"><br>
                Panel
            </a>
        </td>
        <td style="width:16%; padding: 15px 0;">
            <a href="cerrar-sesion.php" target="_parent" class="nav-link" style="color:#e74c3c;">
                <img src="img/funcionario.png" alt="Salir" style="filter:hue-rotate(300deg);"><br>
                <span style="color:#e74c3c;">Cerrar Sesión</span>
            </a>
        </td>
    </tr>
</table>

</center>

</body>
</html>
