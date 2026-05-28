<?php
include("cabecera.php");
include("conexion.php");

$id = $_GET['id'];
$sql = "SELECT * FROM funcionario WHERE idfuncionario = '$id'";
$resultado = mysqli_query($cn, $sql);
$f = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Funcionario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body background="img/fondo.png">
<br><br>
<div class="form-wrapper" style="width:45%;">
    <center>
        <form action="i-editarfuncionario.php" method="post">
            <div class="tarjeta">
                <h2>Editar Funcionario</h2>
                <input type="hidden" name="txtid" value="<?php echo $f['idfuncionario']; ?>">
                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">Nombres:</label>
                <input type="text" name="txtnombres" class="caja-moderna" autocomplete="off" value="<?php echo $f['nombresfuncionario']; ?>" required>
                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">Apellidos:</label>
                <input type="text" name="txtapellidos" class="caja-moderna" autocomplete="off" value="<?php echo $f['apellidosfuncionario']; ?>" required>
                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">Cargo:</label>
                <input type="text" name="txtcargo" class="caja-moderna" autocomplete="off" value="<?php echo $f['cargofuncionario']; ?>">
            </div>
            <input type="submit" value="Actualizar Cambios" class="btn-principal" style="background-color:#f39c12;">
            <a href="funcionario.php" class="btn-eliminar" style="padding:12px 30px;font-size:16px;margin-left:10px;display:inline-block;">Cancelar</a>
        </form>
    </center>
</div>
</body>
</html>
