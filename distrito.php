<?php include 'sesion.php'; ?>
<?php include 'conexion.php'; ?>
<?php include 'cabecera.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - Distritos</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<h1>Reporte de Distritos</h1>

<?php if (isset($_GET['error']) && $_GET['error'] == 'duplicado'): ?>
<div style="background:#e74c3c;color:white;padding:10px 20px;border-radius:6px;width:90%;margin:0 auto 10px auto;font-family:Arial;font-size:14px;">
    ⚠ El distrito ya existe. No se puede registrar duplicados.
</div>
<?php endif; ?>
<?php if (isset($_GET['error']) && $_GET['error'] == 'enuso'): ?>
<div style="background:#e67e22;color:white;padding:10px 20px;border-radius:6px;width:90%;margin:0 auto 10px auto;font-family:Arial;font-size:14px;">
    ⚠ No se puede eliminar este distrito porque está asignado a una empresa registrada.
</div>
<?php endif; ?>

<div class="tabla-container">
    <a class="btn-insertar" href="nuevo-distrito.php">Insertar Nuevo Distrito</a>
    <br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Distrito</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT iddistrito, nombredistrito FROM distrito ORDER BY iddistrito ASC";
            $resultado = mysqli_query($cn, $sql);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
            ?>
                <tr>
                    <td><?php echo $fila['iddistrito']; ?></td>
                    <td><?php echo $fila['nombredistrito']; ?></td>
                    <td><a class="btn-editar" href="editar-distrito.php?id=<?php echo $fila['iddistrito']; ?>">Editar</a></td>
                    <td><a class="btn-eliminar" href="i-eliminardistrito.php?id=<?php echo $fila['iddistrito']; ?>">Eliminar</a></td>
                </tr>
            <?php
                }
            } else {
                echo '<tr><td colspan="4" class="sin-registros">No hay distritos registrados.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
