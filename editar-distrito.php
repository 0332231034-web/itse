<?php
include("cabecera.php");
include("conexion.php");

$id = $_GET['id'];
$sql = "SELECT nombredistrito FROM distrito WHERE iddistrito = '$id'";
$resultado = mysqli_query($cn, $sql);
$fila = mysqli_fetch_assoc($resultado);
$nombreActual = $fila['nombredistrito'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Distrito</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body background="img/fondo.png">
<br><br>
<div class="form-wrapper wrapper-40">
    <center>
        <form action="i-editardistrito.php" method="post">
            <div class="tarjeta">
                <h2>Editar Distrito</h2>
                <input type="hidden" name="txtid" value="<?php echo $id; ?>">
                
                <label class="label-moderno">Nombre del Distrito:</label>
                <input type="text" name="txtnombre" class="caja-moderna" autocomplete="off" value="<?php echo $nombreActual; ?>" required>
            </div>
            <input type="submit" value="Actualizar Cambios" class="btn-principal btn-naranja">
            <a href="distrito.php" class="btn-eliminar btn-cancelar">Cancelar</a>
        </form>
    </center>
</div>
</body>
</html>