<?php include 'conexion.php'; ?>
<?php include 'cabecera.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - Giros de Negocio</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<h1>Reporte de Giros de Negocio</h1>

<?php if (isset($_GET['error']) && $_GET['error'] == 'duplicado'): ?>
<div style="background:#e74c3c;color:white;padding:10px 20px;border-radius:6px;width:90%;margin:0 auto 10px auto;font-family:Arial;font-size:14px;">
    ⚠ El giro de negocio ya existe. No se puede registrar duplicados.
</div>
<?php endif; ?>

<div class="tabla-container">
    
   <a class="btn-insertar" href="nuevo-giro.php">Insertar Nuevo Giro</a> 
   
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Giro de Negocio</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT idgiro, nombregironegocio FROM gironegocio ORDER BY idgiro asc";
            $resultado = mysqli_query($cn, $sql);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
            ?>
                <tr>
                    <td><?php echo $fila['idgiro']; ?></td>
                    <td><?php echo $fila['nombregironegocio']; ?></td>
                    <td><a class="btn-editar" href="editar-giro.php?id=<?php echo $fila['idgiro']; ?>">Editar</a></td>
                    <td><a class="btn-eliminar" href="i-eliminargiro.php?id=<?php echo $fila['idgiro']; ?>">Eliminar</a></td>
                </tr>
            <?php
                }
            } else {
                echo '<tr><td colspan="4" class="sin-registros">No hay giros de negocio registrados.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
