<?php 
include 'sesion.php';
include 'conexion.php';
include 'cabecera.php';

$hoy = date('Y-m-d');

// Contadores para dashboard
$totalEmpresas  = mysqli_fetch_assoc(mysqli_query($cn, "SELECT COUNT(DISTINCT idempresa) AS total FROM empresa"))['total'];
$totalVigentes  = mysqli_fetch_assoc(mysqli_query($cn, "SELECT COUNT(*) AS total FROM certificado WHERE fechacaducidadcertificado >= '$hoy' AND fechasolicitudrenovacioncertificado > '$hoy'"))['total'];
$totalRenovar   = mysqli_fetch_assoc(mysqli_query($cn, "SELECT COUNT(*) AS total FROM certificado WHERE fechasolicitudrenovacioncertificado <= '$hoy' AND fechacaducidadcertificado >= '$hoy'"))['total'];
$totalVencidos  = mysqli_fetch_assoc(mysqli_query($cn, "SELECT COUNT(*) AS total FROM certificado WHERE fechacaducidadcertificado < '$hoy'"))['total'];
$totalSinCert   = mysqli_fetch_assoc(mysqli_query($cn, "SELECT COUNT(*) AS total FROM empresa e LEFT JOIN certificado c ON c.idempresa = e.idempresa WHERE c.idcertificado IS NULL"))['total'];

// Datos para la tabla
$sql = "SELECT e.idempresa, e.rucempresa, e.razonsocialempresa, e.representantelegalempresa,
               e.celularempresa, e.direccionfiscalempresa, g.nombregironegocio,
               c.idcertificado, c.fechaexpedicioncertificado, c.fechacaducidadcertificado,
               c.fechasolicitudrenovacioncertificado
        FROM empresa e
        INNER JOIN gironegocio g ON e.idgiro = g.idgiro
        LEFT JOIN certificado c ON c.idempresa = e.idempresa
        ORDER BY e.razonsocialempresa ASC";
$resultado = mysqli_query($cn, $sql);
$filas = [];
while ($f = mysqli_fetch_assoc($resultado)) {
    $filas[] = $f;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        body { font-family: Arial, sans-serif; }

        /* Alerta */
        .alerta-renovar {
            background: #e67e22;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            width: 92%;
            margin: 10px auto;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alerta-renovar a {
            color: white;
            font-weight: bold;
            text-decoration: underline;
            cursor: pointer;
        }

        /* Dashboard */
        .dashboard {
            display: flex;
            gap: 12px;
            width: 92%;
            margin: 12px auto;
        }
        .card {
            flex: 1;
            border-radius: 10px;
            padding: 14px 10px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.15s;
        }
        .card:hover { transform: scale(1.04); }
        .card .num {
            font-size: 28px;
            font-weight: bold;
            display: block;
        }
        .card .lbl {
            font-size: 12px;
            display: block;
            margin-top: 4px;
        }
        .card-total    { background:#2c3e50; color:white; }
        .card-vigente  { background:#27ae60; color:white; }
        .card-renovar  { background:#e67e22; color:white; }
        .card-vencido  { background:#e74c3c; color:white; }
        .card-sincert  { background:#95a5a6; color:white; }

        /* Barra filtro */
        .barra-filtro {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 92%;
            margin: 10px auto;
        }
        .barra-filtro select,
        .barra-filtro input {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 13px;
            background: #f9fbfd;
        }
        .barra-filtro select { width: 180px; }
        .barra-filtro input  { flex: 1; }
        .btn-excel {
            background: #1e7e34;
            color: white;
            padding: 8px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            white-space: nowrap;
        }
        .btn-excel:hover { background:#155724; }

        /* Badges */
        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            white-space: nowrap;
            display: inline-block;
        }
        .badge-vigente  { background:#27ae60; color:white; }
        .badge-renovar  { background:#e67e22; color:white; }
        .badge-vencido  { background:#e74c3c; color:white; }
        .badge-sincert  { background:#95a5a6; color:white; }

        .cronometro {
            font-size: 11px;
            color: #555;
            margin-top: 3px;
        }

        .btn-nuevo-cert {
            background:#2471a3; color:white;
            padding:5px 10px; border-radius:6px;
            text-decoration:none; font-size:11px; font-weight:bold;
        }
        .btn-historial {
            background:#8e44ad; color:white;
            padding:5px 10px; border-radius:6px;
            text-decoration:none; font-size:11px; font-weight:bold;
        }
    </style>
</head>
<body>

<h1>Reporte de Empresas Registradas</h1>

<?php if ($totalRenovar > 0): ?>
<div class="alerta-renovar">
    ⚠ <strong><?php echo $totalRenovar; ?> empresa(s)</strong> tienen certificados próximos a vencer.
    <a onclick="filtrarEstado('renovar')">Ver ahora</a>
</div>
<?php endif; ?>

<!-- Dashboard -->
<div class="dashboard">
    <div class="card card-total" onclick="filtrarEstado('todos')">
        <span class="num"><?php echo $totalEmpresas; ?></span>
        <span class="lbl">🏢 Total Empresas</span>
    </div>
    <div class="card card-vigente" onclick="filtrarEstado('vigente')">
        <span class="num"><?php echo $totalVigentes; ?></span>
        <span class="lbl">✅ Vigentes</span>
    </div>
    <div class="card card-renovar" onclick="filtrarEstado('renovar')">
        <span class="num"><?php echo $totalRenovar; ?></span>
        <span class="lbl">🟠 Por Renovar</span>
    </div>
    <div class="card card-vencido" onclick="filtrarEstado('vencido')">
        <span class="num"><?php echo $totalVencidos; ?></span>
        <span class="lbl">🔴 Vencidos</span>
    </div>
    <div class="card card-sincert" onclick="filtrarEstado('sincert')">
        <span class="num"><?php echo $totalSinCert; ?></span>
        <span class="lbl">📄 Sin Certificado</span>
    </div>
</div>

<!-- Filtro -->
<div class="barra-filtro">
    <select id="criterio">
        <option value="razon">Razón Social</option>
        <option value="ruc">RUC</option>
        <option value="representante">Representante</option>
        <option value="negocio">Negocio</option>
    </select>
    <input type="text" id="busqueda" placeholder="Escriba para filtrar..." oninput="filtrarTabla()">
    <a class="btn-excel" href="exportar-excel.php">⬇ Exportar a Excel</a>
</div>

<!-- Tabla -->
<div class="tabla-container">
    <table id="tablaPrincipal">
        <thead>
            <tr>
                <th>RUC</th>
                <th>Razón Social</th>
                <th>Representante</th>
                <th>Negocio</th>
                <th>Dirección</th>
                <th>Fecha Emisión</th>
                <th>Estado</th>
                <th>Editar</th>
                <th>+ Certificado</th>
                <th>Historial</th>
                <th>Obtener Certificado</th>
            </tr>
        </thead>
        <tbody id="cuerpoTabla">
        <?php foreach ($filas as $f):
            $tieneCert = !empty($f['idcertificado']);
            $estado = 'sincert';
            $estadoLabel = 'Sin certificado';
            $cronometro = '';
            $fechaEmision = '---';
            $btnCert = '<span style="color:#aaa;font-size:11px;">Sin certificado</span>';

            if ($tieneCert) {
                $fechaEmision = date('d/m/Y', strtotime($f['fechaexpedicioncertificado']));
                $btnCert = '<a class="btn-principal" style="padding:5px 10px;font-size:11px;" href="certificado.php?id='.$f['idcertificado'].'">PDF</a>';

                $hoyTs   = strtotime($hoy);
                $cadTs   = strtotime($f['fechacaducidadcertificado']);
                $renTs   = strtotime($f['fechasolicitudrenovacioncertificado']);
                $diffSeg = $cadTs - $hoyTs;

                if ($diffSeg < 0) {
                    // VENCIDO
                    $estado = 'vencido';
                    $estadoLabel = 'VENCIDO';
                    $seg = abs($diffSeg);
                    $anos = floor($seg / 31536000); $seg %= 31536000;
                    $meses = floor($seg / 2592000); $seg %= 2592000;
                    $semanas = floor($seg / 604800); $seg %= 604800;
                    $dias = floor($seg / 86400);
                    if ($anos > 0)       $cronometro = "Venció hace {$anos} año(s) {$meses} mes(es)";
                    elseif ($meses > 0)  $cronometro = "Venció hace {$meses} mes(es) {$semanas} sem.";
                    else                 $cronometro = "Venció hace {$semanas} sem. {$dias} día(s)";

                } elseif ($hoyTs >= $renTs) {
                    // POR RENOVAR
                    $estado = 'renovar';
                    $estadoLabel = 'POR RENOVAR';
                    $seg = $diffSeg;
                    $semanas = floor($seg / 604800); $seg %= 604800;
                    $dias = floor($seg / 86400);
                    $cronometro = "Vence en {$semanas} sem. {$dias} día(s)";

                } else {
                    // VIGENTE
                    $estado = 'vigente';
                    $estadoLabel = 'VIGENTE';
                    $seg = $diffSeg;
                    $anos = floor($seg / 31536000); $seg %= 31536000;
                    $meses = floor($seg / 2592000); $seg %= 2592000;
                    $semanas = floor($seg / 604800);
                    if ($anos > 0)      $cronometro = "Vence en {$anos} año(s) {$meses} mes(es)";
                    elseif ($meses > 0) $cronometro = "Vence en {$meses} mes(es) {$semanas} sem.";
                    else                $cronometro = "Vence en {$semanas} sem.";
                }
            }
        ?>
            <tr data-estado="<?php echo $estado; ?>"
                data-razon="<?php echo strtolower($f['razonsocialempresa']); ?>"
                data-ruc="<?php echo $f['rucempresa']; ?>"
                data-representante="<?php echo strtolower($f['representantelegalempresa']); ?>"
                data-negocio="<?php echo strtolower($f['nombregironegocio']); ?>">
                <td><?php echo $f['rucempresa']; ?></td>
                <td><?php echo $f['razonsocialempresa']; ?></td>
                <td><?php echo $f['representantelegalempresa']; ?></td>
                <td><?php echo $f['nombregironegocio']; ?></td>
                <td><?php echo $f['direccionfiscalempresa']; ?></td>
                <td><?php echo $fechaEmision; ?></td>
                <td>
                    <span class="badge badge-<?php echo $estado; ?>"><?php echo $estadoLabel; ?></span>
                    <?php if ($cronometro): ?>
                        <div class="cronometro"><?php echo $cronometro; ?></div>
                    <?php endif; ?>
                </td>
                <td><a class="btn-editar" href="editar.php?id=<?php echo $f['idempresa']; ?>">Editar</a></td>
                <td><a class="btn-nuevo-cert" href="nuevo-certificado.php?id=<?php echo $f['idempresa']; ?>">+ Cert.</a></td>
                <td><a class="btn-historial" href="historial.php?id=<?php echo $f['idempresa']; ?>">Historial</a></td>
                <td><?php echo $btnCert; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function filtrarTabla() {
    const criterio  = document.getElementById('criterio').value;
    const busqueda  = document.getElementById('busqueda').value.toLowerCase();
    const filas     = document.querySelectorAll('#cuerpoTabla tr');
    filas.forEach(function(fila) {
        const valor = fila.getAttribute('data-' + criterio) || '';
        fila.style.display = valor.includes(busqueda) ? '' : 'none';
    });
}

function filtrarEstado(estado) {
    document.getElementById('busqueda').value = '';
    const filas = document.querySelectorAll('#cuerpoTabla tr');
    filas.forEach(function(fila) {
        if (estado === 'todos') {
            fila.style.display = '';
        } else {
            fila.style.display = fila.getAttribute('data-estado') === estado ? '' : 'none';
        }
    });
}
</script>

</body>
</html>
