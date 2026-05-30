<?php
include 'sesion.php';
include 'conexion.php';
include 'cabecera.php';

$idempresa = $_GET['id'];
$hoy = date('Y-m-d');

// Datos de la empresa
$sqlEmp = "SELECT e.rucempresa, e.razonsocialempresa, e.representantelegalempresa,
                  d.nombredistrito, g.nombregironegocio
           FROM empresa e
           INNER JOIN distrito d ON e.iddistrito = d.iddistrito
           INNER JOIN gironegocio g ON e.idgiro = g.idgiro
           WHERE e.idempresa = '$idempresa'";
$emp = mysqli_fetch_assoc(mysqli_query($cn, $sqlEmp));

// Todos los certificados de esa empresa
$sqlCert = "SELECT c.*, CONCAT(f.nombresfuncionario,' ',f.apellidosfuncionario) AS funcionario, f.cargofuncionario
            FROM certificado c
            INNER JOIN funcionario f ON c.idfuncionario = f.idfuncionario
            WHERE c.idempresa = '$idempresa'
            ORDER BY c.fechaexpedicioncertificado DESC";
$certs = mysqli_query($cn, $sqlCert);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Certificados</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .info-empresa {
            background:#eaf4fb; border:1px solid #2471a3;
            border-radius:8px; padding:16px 24px;
            margin:15px auto; width:92%; box-sizing:border-box;
            font-size:13px; color:#2c3e50;
        }
        .info-empresa h3 { margin:0 0 10px 0; color:#2471a3; font-size:15px; }
        .info-fila { display:flex; gap:10px; margin-bottom:5px; }
        .info-fila span:first-child { font-weight:bold; width:160px; min-width:160px; }
        .badge { padding:4px 10px; border-radius:12px; font-size:11px; font-weight:bold; display:inline-block; }
        .badge-vigente { background:#27ae60; color:white; }
        .badge-renovar { background:#e67e22; color:white; }
        .badge-vencido { background:#e74c3c; color:white; }
        .cronometro { font-size:11px; color:#555; margin-top:3px; }
        .btn-volver {
            display:inline-block; margin:15px 0 0 4%;
            background:#2c3e50; color:white;
            padding:8px 20px; border-radius:6px;
            text-decoration:none; font-size:13px; font-weight:bold;
        }
    </style>
</head>
<body>

<a class="btn-volver" href="panel.php">← Volver al Panel</a>

<h1>Historial de Certificados</h1>

<div class="info-empresa">
    <h3>📋 Empresa</h3>
    <div class="info-fila"><span>RUC:</span><span><?php echo $emp['rucempresa']; ?></span></div>
    <div class="info-fila"><span>Razón Social:</span><span><?php echo $emp['razonsocialempresa']; ?></span></div>
    <div class="info-fila"><span>Representante:</span><span><?php echo $emp['representantelegalempresa']; ?></span></div>
    <div class="info-fila"><span>Distrito:</span><span><?php echo $emp['nombredistrito']; ?></span></div>
    <div class="info-fila"><span>Giro de Negocio:</span><span><?php echo $emp['nombregironegocio']; ?></span></div>
</div>

<div class="tabla-container">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>N. Correlativo</th>
                <th>N. Expediente</th>
                <th>N. Resolución</th>
                <th>Fecha Expedición</th>
                <th>Fecha Caducidad</th>
                <th>Funcionario</th>
                <th>Estado</th>
                <th>Certificado</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $num = 1;
        while ($c = mysqli_fetch_assoc($certs)):
            $cadTs  = strtotime($c['fechacaducidadcertificado']);
            $renTs  = strtotime($c['fechasolicitudrenovacioncertificado']);
            $hoyTs  = strtotime($hoy);
            $diffSeg = $cadTs - $hoyTs;

            if ($diffSeg < 0) {
                $estado = 'vencido'; $label = 'VENCIDO';
                $seg = abs($diffSeg);
                $anos = floor($seg/31536000); $seg %= 31536000;
                $meses = floor($seg/2592000); $seg %= 2592000;
                $semanas = floor($seg/604800); $seg %= 604800;
                $dias = floor($seg/86400);
                if ($anos > 0)      $crono = "Venció hace {$anos} año(s) {$meses} mes(es)";
                elseif ($meses > 0) $crono = "Venció hace {$meses} mes(es) {$semanas} sem.";
                else                $crono = "Venció hace {$semanas} sem. {$dias} día(s)";
            } elseif ($hoyTs >= $renTs) {
                $estado = 'renovar'; $label = 'POR RENOVAR';
                $seg = $diffSeg;
                $semanas = floor($seg/604800); $seg %= 604800;
                $dias = floor($seg/86400);
                $crono = "Vence en {$semanas} sem. {$dias} día(s)";
            } else {
                $estado = 'vigente'; $label = 'VIGENTE';
                $seg = $diffSeg;
                $anos = floor($seg/31536000); $seg %= 31536000;
                $meses = floor($seg/2592000); $seg %= 2592000;
                $semanas = floor($seg/604800);
                if ($anos > 0)      $crono = "Vence en {$anos} año(s) {$meses} mes(es)";
                elseif ($meses > 0) $crono = "Vence en {$meses} mes(es) {$semanas} sem.";
                else                $crono = "Vence en {$semanas} sem.";
            }
        ?>
            <tr>
                <td><?php echo $num++; ?></td>
                <td><?php echo $c['nrocorrelativocertificado']; ?></td>
                <td><?php echo $c['nroexpedientecertificado']; ?></td>
                <td><?php echo $c['nroresolucioncertificado']; ?></td>
                <td><?php echo date('d/m/Y', strtotime($c['fechaexpedicioncertificado'])); ?></td>
                <td><?php echo date('d/m/Y', strtotime($c['fechacaducidadcertificado'])); ?></td>
                <td><?php echo $c['funcionario']; ?><br><small><?php echo $c['cargofuncionario']; ?></small></td>
                <td>
                    <span class="badge badge-<?php echo $estado; ?>"><?php echo $label; ?></span>
                    <div class="cronometro"><?php echo $crono; ?></div>
                </td>
                <td><a class="btn-principal" style="padding:5px 10px;font-size:11px;" href="certificado.php?id=<?php echo $c['idcertificado']; ?>">PDF</a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
