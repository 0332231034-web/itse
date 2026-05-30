<?php include 'sesion.php'; ?>
<?php 
include("cabecera.php"); 
include("conexion.php"); 

$id = $_GET['id'];
$sql = "SELECT e.*, d.nombredistrito, g.nombregironegocio 
        FROM empresa e
        INNER JOIN distrito d ON e.iddistrito = d.iddistrito
        INNER JOIN gironegocio g ON e.idgiro = g.idgiro
        WHERE e.idempresa = '$id'";
$resultado = mysqli_query($cn, $sql);
$emp = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empresa</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body background="img/fondo.png">
<br>
<div class="form-wrapper">
    <center>
        <form action="i-editarempresa.php" method="post">
            <input type="hidden" name="txtid" value="<?php echo $emp['idempresa']; ?>">

            <div class="tarjeta">
                <h2>Datos de la Empresa</h2>

                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">RUC:</label>
                <input type="text" name="txtruc" class="caja-moderna" value="<?php echo $emp['rucempresa']; ?>" maxlength="11" required>

                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">Razón Social:</label>
                <input type="text" name="txtrazonsocial" class="caja-moderna" value="<?php echo $emp['razonsocialempresa']; ?>" required>

                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">Representante Legal:</label>
                <input type="text" name="txtrepresentante" class="caja-moderna" value="<?php echo $emp['representantelegalempresa']; ?>" required>

                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">Celular:</label>
                <input type="text" name="txtcelular" class="caja-moderna" value="<?php echo $emp['celularempresa']; ?>">

                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">Correo:</label>
                <input type="email" name="txtcorreo" class="caja-moderna" value="<?php echo $emp['correoempresa']; ?>">

                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">Dirección Fiscal:</label>
                <input type="text" name="txtdireccion" class="caja-moderna" value="<?php echo $emp['direccionfiscalempresa']; ?>" required>
            </div>

            <div class="tarjeta">
                <h2>Clasificación</h2>

                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">Distrito:</label>
                <select name="lstdistrito" class="lista-moderna" required>
                    <?php
                        $sqlD = "SELECT * FROM distrito ORDER BY nombredistrito ASC";
                        $fD = mysqli_query($cn, $sqlD);
                        while ($rD = mysqli_fetch_assoc($fD)) {
                            $sel = ($rD['iddistrito'] == $emp['iddistrito']) ? 'selected' : '';
                            echo "<option value='{$rD['iddistrito']}' $sel>{$rD['nombredistrito']}</option>";
                        }
                    ?>
                </select>

                <label style="font-weight:bold;color:#555;display:block;margin-bottom:5px;">Giro de Negocio:</label>
                <select name="lstgiro" class="lista-moderna" required>
                    <?php
                        $sqlG = "SELECT * FROM gironegocio ORDER BY nombregironegocio ASC";
                        $fG = mysqli_query($cn, $sqlG);
                        while ($rG = mysqli_fetch_assoc($fG)) {
                            $sel = ($rG['idgiro'] == $emp['idgiro']) ? 'selected' : '';
                            echo "<option value='{$rG['idgiro']}' $sel>{$rG['nombregironegocio']}</option>";
                        }
                    ?>
                </select>
            </div>

            <input type="submit" value="Guardar Cambios" class="btn-principal" style="background-color:#f39c12;">
            <a href="panel.php" class="btn-eliminar" style="padding:12px 30px;font-size:16px;margin-left:10px;display:inline-block;">Cancelar</a>
            <br><br><br>
        </form>
    </center>
</div>
</body>
</html>
