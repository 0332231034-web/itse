<?php
include("cabecera.php");
include("conexion.php");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - Empresas Registradas</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<h1>Reporte de Empresas Registradas</h1>

<div class="tabla-container">
    <table>
        <thead>
            <tr>
                <th>RUC</th>
                <th>Razón Social</th>
                <th>Representante Legal</th>
                <th>Celular</th>
                <th>Giro de Negocio</th>
                <th>Fecha de Emisión</th>
                <th>Editar</th>
                <th>Obtener Certificado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT e.idempresa, e.rucempresa, e.razonsocialempresa, 
                           e.representantelegalempresa, e.celularempresa,
                           g.nombregironegocio, c.fechaexpedicioncertificado, c.idcertificado
                    FROM empresa e
                    INNER JOIN gironegocio g ON e.idgiro = g.idgiro
                    LEFT JOIN certificado c ON e.idempresa = c.idempresa
                    ORDER BY e.idempresa DESC";

            $resultado = mysqli_query($cn, $sql);

            if (mysqli_num_rows($resultado) > 0) { //verifica si hay empresas registradas
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    $fechaEmision = $fila['fechaexpedicioncertificado'] 
                        ? date('d/m/Y', strtotime($fila['fechaexpedicioncertificado'])) 
                        : 'Sin certificado';
            ?>
                <tr>
                    <td><?php echo $fila['rucempresa']; ?></td>
                    <td><?php echo $fila['razonsocialempresa']; ?></td>
                    <td><?php echo $fila['representantelegalempresa']; ?></td>
                    <td><?php echo $fila['celularempresa']; ?></td>
                    <td><?php echo $fila['nombregironegocio']; ?></td>
                    <td><?php echo $fechaEmision; ?></td>
                    <td>
                        <a class="btn-editar" href="editar-empresa.php?id=<?php echo $fila['idempresa']; ?>">Editar</a>
                    </td>
                    <td>
                        <?php if ($fila['idcertificado']): ?>
                            <a class="btn-certificado" href="certificado.php?id=<?php echo $fila['idcertificado']; ?>">Obtener Certificado</a>
                        <?php else: ?>
                            Sin certificado
                        <?php endif; ?>
                    </td>
                </tr>
            <?php
                }
            } else {
                echo '<tr><td colspan="8" class="sin-registros">No hay empresas registradas.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</body>
>>>>>>> cb0406f493028ea9303831df3091f17586768578
</html>