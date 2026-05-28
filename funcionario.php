<?php include 'conexion.php'; ?>
<?php include 'cabecera.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - Funcionarios</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<h1>Reporte de Funcionarios</h1>

<div class="tabla-container">
    <a class="btn-insertar" href="nuevo-funcionario.php">Insertar Nuevo Funcionario</a>
    <br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Cargo</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM funcionario ORDER BY apellidosfuncionario ASC";
            $resultado = mysqli_query($cn, $sql);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
            ?>
                <tr>
                    <td><?php echo $fila['idfuncionario']; ?></td>
                    <td><?php echo $fila['nombresfuncionario']; ?></td>
                    <td><?php echo $fila['apellidosfuncionario']; ?></td>
                    <td><?php echo $fila['cargofuncionario']; ?></td>
                    <td><a class="btn-editar" href="editar-funcionario.php?id=<?php echo $fila['idfuncionario']; ?>">Editar</a></td>
                    <td><a class="btn-eliminar" href="i-eliminarfuncionario.php?id=<?php echo $fila['idfuncionario']; ?>">Eliminar</a></td>
                </tr>
            <?php
                }
            } else {
                echo '<tr><td colspan="6" class="sin-registros">No hay funcionarios registrados.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
