<?php 
include 'sesion.php';
include 'conexion.php';
include 'cabecera.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - Empresas</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .badge-vigente {
            background: #27ae60;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
        .badge-vencido {
            background: #e74c3c;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
        .badge-sincert {
            background: #95a5a6;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-family: Arial, sans-serif;
        }
        .btn-excel {
            background: #1e7e34;
            color: white;
            padding: 8px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-size: 13px;
            font-weight: bold;
            margin-left: 10px;
        }
        .btn-excel:hover { background: #155724; }
        .barra-superior {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 92%;
            margin: 0 auto 10px auto;
        }
    </style>
</head>
<body>

<h1>Reporte de Empresas Registradas</h1>

<div class="barra-superior">
    <span style="font-family:Arial;font-size:13px;color:#fff;">
        <?php
        $total = mysqli_num_rows(mysqli_query($cn, "SELECT idempresa FROM empresa"));
        echo "Total registradas: <strong>$total</strong>";
        ?>
    </span>
    <a class="btn-excel" href="exportar-excel.php">⬇ Exportar a Excel</a>
</div>

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
                <th>Estado</th>
                <th>Editar</th>
                <th>Obtener Certificado</th>
            </tr>
        </thead>
        <tbody>
<<<<<<< Updated upstream
            <?php
            $sql = "SELECT e.idempresa, e.rucempresa, e.razonsocialempresa, 
                           e.representantelegalempresa, e.celularempresa,
                           g.nombregironegocio, c.fechaexpedicioncertificado, c.idcertificado
                    FROM empresa e
                    INNER JOIN gironegocio g ON e.idgiro = g.idgiro
                    LEFT JOIN certificado c ON e.idempresa = c.idempresa
                    ORDER BY e.razonsocialempresa ASC";
=======
        <?php
        $sql = "SELECT e.idempresa, e.rucempresa, e.razonsocialempresa, e.representantelegalempresa,
                       e.celularempresa, g.nombregironegocio,
                       c.idcertificado, c.fechaexpedicioncertificado, c.fechacaducidadcertificado
                FROM empresa e
                INNER JOIN gironegocio g ON e.idgiro = g.idgiro
                LEFT JOIN certificado c ON c.idempresa = e.idempresa";
        $resultado = mysqli_query($cn, $sql);
        $hoy = date('Y-m-d');
>>>>>>> Stashed changes

        while ($f = mysqli_fetch_assoc($resultado)):
            $tieneCert = !empty($f['idcertificado']);
            if ($tieneCert) {
                $vigente = ($f['fechacaducidadcertificado'] >= $hoy);
                $estadoHtml = $vigente
                    ? '<span class="badge-vigente">VIGENTE</span>'
                    : '<span class="badge-vencido">VENCIDO</span>';
                $fechaEmision = date('d/m/Y', strtotime($f['fechaexpedicioncertificado']));
                $btnCert = '<a class="btn-principal" style="padding:6px 14px;font-size:12px;" href="certificado.php?id='.$f['idcertificado'].'">Obtener Certificado</a>';
            } else {
                $estadoHtml = '<span class="badge-sincert">Sin certificado</span>';
                $fechaEmision = 'Sin certificado';
                $btnCert = '<span style="color:#aaa;font-size:12px;font-family:Arial;">Sin certificado</span>';
            }
        ?>
            <tr>
                <td><?php echo $f['rucempresa']; ?></td>
                <td><?php echo $f['razonsocialempresa']; ?></td>
                <td><?php echo $f['representantelegalempresa']; ?></td>
                <td><?php echo $f['celularempresa']; ?></td>
                <td><?php echo $f['nombregironegocio']; ?></td>
                <td><?php echo $fechaEmision; ?></td>
                <td><?php echo $estadoHtml; ?></td>
                <td><a class="btn-editar" href="editar.php?id=<?php echo $f['idempresa']; ?>">Editar</a></td>
                <td><?php echo $btnCert; ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
