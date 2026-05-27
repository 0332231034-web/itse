<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - Empresas Registradas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            padding: 30px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 24px;
        }

        .tabla-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background-color: #2c3e50;
            color: white;
        }

        thead th {
            padding: 12px 15px;
            text-align: center;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid #e0e0e0;
        }

        tbody tr:hover {
            background-color: #f5f8ff;
        }

        tbody td {
            padding: 11px 15px;
            text-align: center;
            font-size: 13px;
            color: #333;
        }

        .btn-editar {
            background-color: #f39c12;
            color: white;
            padding: 6px 14px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
        }

        .btn-editar:hover {
            background-color: #d68910;
        }

        .btn-certificado {
            background-color: #27ae60;
            color: white;
            padding: 6px 14px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
        }

        .btn-certificado:hover {
            background-color: #1e8449;
        }

        .sin-registros {
            text-align: center;
            padding: 30px;
            color: #999;
            font-size: 15px;
        }
    </style>
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

            $resultado = mysqli_query($conn, $sql);

            if (mysqli_num_rows($resultado) > 0) {
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
                        <a class="btn-editar" href="editar.php?id=<?php echo $fila['idempresa']; ?>">Editar</a>
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
</html>
