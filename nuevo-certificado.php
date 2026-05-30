<?php
include 'sesion.php';
include 'conexion.php';
include 'cabecera.php';

$idempresa = $_GET['id'];
$sql = "SELECT e.rucempresa, e.razonsocialempresa, e.representantelegalempresa,
               d.nombredistrito, g.nombregironegocio
        FROM empresa e
        INNER JOIN distrito d ON e.iddistrito = d.iddistrito
        INNER JOIN gironegocio g ON e.idgiro = g.idgiro
        WHERE e.idempresa = '$idempresa'";
$resultado = mysqli_query($cn, $sql);
$emp = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Certificado</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .info-empresa {
            background: #eaf4fb;
            border: 1px solid #2471a3;
            border-radius: 8px;
            padding: 16px 24px;
            margin-bottom: 20px;
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #2c3e50;
        }
        .info-empresa h3 {
            margin: 0 0 10px 0;
            color: #2471a3;
            font-size: 15px;
        }
        .info-fila {
            display: flex;
            gap: 10px;
            margin-bottom: 6px;
        }
        .info-fila span:first-child {
            font-weight: bold;
            width: 160px;
            min-width: 160px;
        }
        fieldset {
            border: 2px solid #2471a3;
            border-radius: 8px;
            padding: 20px 25px;
            background: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }
        legend {
            font-family: Arial, sans-serif;
            font-size: 15px;
            font-weight: bold;
            color: #fff;
            background: #2471a3;
            padding: 6px 16px;
            border-radius: 5px;
        }
        .fila-campo {
            display: flex;
            align-items: center;
            margin-bottom: 14px;
            gap: 10px;
        }
        .fila-campo label {
            width: 160px;
            min-width: 160px;
            font-weight: bold;
            color: #555;
            font-size: 13px;
            font-family: Arial, sans-serif;
        }
        .fila-campo input, .fila-campo select {
            flex: 1;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 13px;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
            background: #f9fbfd;
        }
        .fila-campo input:focus, .fila-campo select:focus {
            outline: none;
            border-color: #2471a3;
            background: #fff;
        }
    </style>
</head>
<body background="img/fondo.png">
<br>
<div style="width:55%;margin:0 auto;">
    <form action="i-nuevo-certificado.php" method="post">
        <input type="hidden" name="txtidempresa" value="<?php echo $idempresa; ?>">

        <!-- Info de la empresa (solo lectura) -->
        <div class="info-empresa">
            <h3>📋 Empresa Seleccionada</h3>
            <div class="info-fila"><span>RUC:</span><span><?php echo $emp['rucempresa']; ?></span></div>
            <div class="info-fila"><span>Razón Social:</span><span><?php echo $emp['razonsocialempresa']; ?></span></div>
            <div class="info-fila"><span>Representante:</span><span><?php echo $emp['representantelegalempresa']; ?></span></div>
            <div class="info-fila"><span>Distrito:</span><span><?php echo $emp['nombredistrito']; ?></span></div>
            <div class="info-fila"><span>Giro de Negocio:</span><span><?php echo $emp['nombregironegocio']; ?></span></div>
        </div>

        <!-- Datos del nuevo certificado -->
        <fieldset>
            <legend>Datos del Nuevo Certificado</legend>

            <div class="fila-campo">
                <label>N. Correlativo:</label>
                <input type="text" name="txtcorrelativo" autocomplete="off" placeholder="Ej: 003-2026" required>
            </div>
            <div class="fila-campo">
                <label>N. Expediente:</label>
                <input type="text" name="txtexpediente" autocomplete="off" placeholder="N. Expediente" required>
            </div>
            <div class="fila-campo">
                <label>N. Resolución:</label>
                <input type="text" name="txtresolucion" autocomplete="off" placeholder="N. Resolución" required>
            </div>
            <div class="fila-campo">
                <label>Funcionario a Cargo:</label>
                <select name="lstfuncionario" required>
                    <option value="" disabled selected>-- Seleccione --</option>
                    <?php
                    $sqlF = "SELECT * FROM funcionario ORDER BY apellidosfuncionario ASC";
                    $fF = mysqli_query($cn, $sqlF);
                    while ($rF = mysqli_fetch_assoc($fF)) {
                        echo "<option value='{$rF['idfuncionario']}'>{$rF['nombresfuncionario']} {$rF['apellidosfuncionario']}</option>";
                    }
                    ?>
                </select>
            </div>
        </fieldset>

        <div style="text-align:center;margin:25px 0 40px 0;">
            <input type="submit" value="Registrar Certificado" class="btn-principal">
            <a href="empresa.php" class="btn-eliminar" style="padding:12px 30px;font-size:15px;margin-left:10px;display:inline-block;">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>
