<?php
include("cabecera.php");
include("conexion.php");

$id = $_GET['id'];
$sql = "SELECT nombregironegocio FROM gironegocio WHERE idgiro = '$id'";
$resultado = mysqli_query($cn, $sql);
$fila = mysqli_fetch_assoc($resultado);
$nombreActual = $fila['nombregironegocio'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Giro de Negocio</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body background="img/fondo.png">
<br><br>
<div class="form-wrapper" style="width:40%;">
    <center>
        <form action="i-editargiro.php" method="post">
            <div class="tarjeta">
                <h2>Editar Giro de Negocio</h2>
                <input type="hidden" name="txtid" value="<?php echo $id; ?>">
                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">Nombre del Giro:</label>
                <input type="text" name="txtgiro" class="caja-moderna" autocomplete="off" value="<?php echo $nombreActual; ?>" required>
            </div>
            <input type="submit" value="Actualizar Cambios" class="btn-principal" style="background-color:#f39c12;">
            <a href="giro-negocio.php" class="btn-eliminar" style="padding:12px 30px;font-size:16px;margin-left:10px;display:inline-block;">Cancelar</a>
        </form>
    </center>
</div>
</body>
</html>
