<?php include("cabecera.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Distrito</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body background="img/fondo.png">
<br><br>
<div class="form-wrapper" style="width:40%;">
    <center>
        <form action="i-insertardistrito.php" method="post">
            <div class="tarjeta">
                <h2>Registrar Nuevo Distrito</h2>
                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">Nombre del Distrito:</label>
                <input type="text" name="txtnombre" class="caja-moderna" autocomplete="off" placeholder="Ej: HUACHO" required>
            </div>
            <input type="submit" value="Guardar Registro" class="btn-principal">
            <a href="distrito.php" class="btn-eliminar" style="padding:12px 30px;font-size:16px;margin-left:10px;display:inline-block;">Cancelar</a>
        </form>
    </center>
</div>
</body>
</html>
