<?php include("cabecera.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Funcionario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body background="img/fondo.png">
<br><br>
<div class="form-wrapper" style="width:45%;">
    <center>
        <form action="i-insertarfuncionario.php" method="post">
            <div class="tarjeta">
                <h2>Registrar Nuevo Funcionario</h2>
                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">Nombres:</label>
                <input type="text" name="txtnombres" class="caja-moderna" autocomplete="off" placeholder="Nombres del funcionario" required>
                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">Apellidos:</label>
                <input type="text" name="txtapellidos" class="caja-moderna" autocomplete="off" placeholder="Apellidos del funcionario" required>
                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">Cargo:</label>
                <input type="text" name="txtcargo" class="caja-moderna" autocomplete="off" placeholder="Ej: JEFE DE DEFENSA CIVIL">
            </div>
            <input type="submit" value="Guardar Registro" class="btn-principal">
            <a href="funcionario.php" class="btn-eliminar" style="padding:12px 30px;font-size:16px;margin-left:10px;display:inline-block;">Cancelar</a>
        </form>
    </center>
</div>
</body>
</html>
