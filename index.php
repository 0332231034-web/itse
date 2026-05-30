<?php
include("sesion.php");
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
    <style>
        .dos-columnas {
            display: flex;
            gap: 30px;
            width: 90%;
            margin: 20px auto 0 auto;
            align-items: flex-start;
        }
        .dos-columnas fieldset {
            flex: 1;
            border: 2px solid #2471a3;
            border-radius: 8px;
            padding: 20px 25px;
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }
        legend {
            font-family: Arial, sans-serif;
            font-size: 15px;
            font-weight: bold;
            color: #ffffff;
            background-color: #2471a3;
            padding: 6px 16px;
            border-radius: 5px;
        }
        .fila-campo {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            gap: 10px;
        }
        .fila-campo label {
            width: 160px;
            min-width: 160px;
            font-weight: bold;
            color: #555;
            font-size: 13px;
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .fila-campo input,
        .fila-campo select {
            flex: 1;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 13px;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
            background-color: #f9fbfd;
        }
        .fila-campo input:focus,
        .fila-campo select:focus {
            outline: none;
            border-color: #2471a3;
            background-color: #fff;
        }
        .centro-boton {
            text-align: center;
            margin: 25px 0 40px 0;
        }
    </style>
</head>

<body background="img/fondo.png">
<br>

<form action="i-certificado.php" method="post">
    <div class="dos-columnas">

        <!-- FIELDSET IZQUIERDA: Datos de la Empresa -->
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

        <!-- FIELDSET DERECHA: Datos del Certificado -->
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
