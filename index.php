<?php
include("cabecera.php");
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Certificado</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body background="img/fondo.png">

<br>

<div class="form-wrapper">
    <center>
        <form action="i-certificado.php" method="post">
            
            <div class="tarjeta">
                <h2>Ingreso de la Información de la empresa</h2>
                
                <label style="font-weight: bold; color: #555; display:block; margin-bottom:5px;">Seleccione la Empresa:</label>
                <select name="lstempresa" class="lista-moderna" required>
                    <option value="" disabled selected>-- Elija una empresa --</option>
                    <?php
                        $sql="select * from empresa";
                        $f=mysqli_query($cn,$sql);
                        while ($r=mysqli_fetch_assoc($f)) {
                    ?>
                    <option value="<?php echo $r["idempresa"]; ?>"><?php echo $r["razonsocialempresa"]?></option>
                    <?php } ?>
                </select>

                <label style="font-weight: bold; color: #555; display:block; margin-bottom:5px;">Funcionario a Cargo:</label>
                <select name="lstfuncionario" class="lista-moderna" required>
                    <option value="" disabled selected>-- Elija un funcionario --</option>
                    <?php
                        $sql="select * from funcionario";
                        $f=mysqli_query($cn,$sql);
                        while ($r=mysqli_fetch_assoc($f)) {
                    ?>
                    <option value="<?php echo $r["idfuncionario"]; ?>"><?php echo $r["nombresfuncionario"]?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="tarjeta">
                <h2>Datos del Certificado</h2>
                
                <input type="text" name="txtcorrelativo" class="caja-moderna" autocomplete="off" placeholder="N. Correlativo (Ej: 001-2026)" required>
                
                <input type="text" name="txtexpediente" class="caja-moderna" autocomplete="off" placeholder="N. Expediente" required>
                
                <input type="text" name="txtresolucion" class="caja-moderna" autocomplete="off" placeholder="N. Resolución" required>
            </div>
            
            <input type="submit" value="Registrar Certificado" class="btn-principal">
            <br><br><br>
        </form>
    </center>
</div>

</body>
</html>