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

<form action="i-certificado.php" method="post">
    <div class="dos-columnas">

        <fieldset>
            <legend>Información de la Empresa</legend>

            <div class="fila-campo">
                <label>RUC:</label>
                <input type="text" name="txtruc" autocomplete="off" placeholder="Ej: 20123456789" maxlength="11" required>
            </div>
            <div class="fila-campo">
                <label>Razón Social:</label>
                <input type="text" name="txtrazonsocial" autocomplete="off" placeholder="Nombre de la empresa" required>
            </div>
            <div class="fila-campo">
                <label>Representante Legal:</label>
                <input type="text" name="txtrepresentante" autocomplete="off" placeholder="Nombres y apellidos" required>
            </div>
            <div class="fila-campo">
                <label>Celular:</label>
                <input type="text" name="txtcelular" autocomplete="off" placeholder="Ej: 987654321">
            </div>
            <div class="fila-campo">
                <label>Correo Electrónico:</label>
                <input type="email" name="txtcorreo" autocomplete="off" placeholder="correo@empresa.com">
            </div>
            <div class="fila-campo">
                <label>Dirección Fiscal:</label>
                <input type="text" name="txtdireccion" autocomplete="off" placeholder="Dirección del negocio" required>
            </div>
            <div class="fila-campo">
                <label>Distrito:</label>
                <select name="lstdistrito" required>
                    <option value="" disabled selected>-- Seleccione --</option>
                    <?php
                        $sql = "SELECT * FROM distrito ORDER BY nombredistrito ASC";
                        $f = mysqli_query($cn, $sql);
                        while ($r = mysqli_fetch_assoc($f)) {
                    ?>
                    <option value="<?php echo $r['iddistrito']; ?>"><?php echo $r['nombredistrito']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="fila-campo">
                <label>Giro de Negocio:</label>
                <select name="lstgiro" required>
                    <option value="" disabled selected>-- Seleccione --</option>
                    <?php
                        $sql = "SELECT * FROM gironegocio ORDER BY nombregironegocio ASC";
                        $f = mysqli_query($cn, $sql);
                        while ($r = mysqli_fetch_assoc($f)) {
                    ?>
                    <option value="<?php echo $r['idgiro']; ?>"><?php echo $r['nombregironegocio']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="fila-campo">
                <label>Funcionario a Cargo:</label>
                <select name="lstfuncionario" required>
                    <option value="" disabled selected>-- Seleccione --</option>
                    <?php
                        $sql = "SELECT * FROM funcionario";
                        $f = mysqli_query($cn, $sql);
                        while ($r = mysqli_fetch_assoc($f)) {
                    ?>
                    <option value="<?php echo $r['idfuncionario']; ?>"><?php echo $r['nombresfuncionario']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </fieldset>

        <fieldset>
            <legend>Datos del Certificado</legend>

            <div class="fila-campo">
                <label>N. Correlativo:</label>
                <input type="text" name="txtcorrelativo" autocomplete="off" placeholder="Ej: 001-2026" required>
            </div>
            <div class="fila-campo">
                <label>N. Expediente:</label>
                <input type="text" name="txtexpediente" autocomplete="off" placeholder="N. Expediente" required>
            </div>
            <div class="fila-campo">
                <label>N. Resolución:</label>
                <input type="text" name="txtresolucion" autocomplete="off" placeholder="N. Resolución" required>
            </div>
        </fieldset>

    </div>

    <div class="centro-boton">
        <input type="submit" value="Registrar Certificado" class="btn-principal">
    </div>
</form>

</body>
</html>