<?php
include 'sesion.php';
include 'conexion.php';

// Cabeceras para descarga Excel
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Reporte_Empresas_" . date('d-m-Y') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

$hoy = date('Y-m-d');

$sql = "SELECT 
            e.rucempresa AS 'RUC',
            e.razonsocialempresa AS 'Razon Social',
            e.representantelegalempresa AS 'Representante Legal',
            e.celularempresa AS 'Celular',
            e.correoempresa AS 'Correo',
            e.direccionfiscalempresa AS 'Direccion Fiscal',
            d.nombredistrito AS 'Distrito',
            g.nombregironegocio AS 'Giro de Negocio',
            c.nrocorrelativocertificado AS 'N. Correlativo',
            c.nroexpedientecertificado AS 'N. Expediente',
            c.nroresolucioncertificado AS 'N. Resolucion',
            c.fechaexpedicioncertificado AS 'Fecha Expedicion',
            c.fechacaducidadcertificado AS 'Fecha Caducidad',
            CONCAT(f.nombresfuncionario, ' ', f.apellidosfuncionario) AS 'Funcionario',
            f.cargofuncionario AS 'Cargo'
        FROM empresa e
        INNER JOIN gironegocio g ON e.idgiro = g.idgiro
        INNER JOIN distrito d ON e.iddistrito = d.iddistrito
        LEFT JOIN certificado c ON c.idempresa = e.idempresa
        LEFT JOIN funcionario f ON c.idfuncionario = f.idfuncionario
        ORDER BY e.razonsocialempresa ASC";

$resultado = mysqli_query($cn, $sql);

// Encabezado de tabla
echo '<table border="1">';
echo '<thead><tr style="background-color:#2c3e50;color:white;font-weight:bold;">';
$campos = ['RUC','Razón Social','Representante Legal','Celular','Correo','Dirección Fiscal',
           'Distrito','Giro de Negocio','N. Correlativo','N. Expediente','N. Resolución',
           'Fecha Expedición','Fecha Caducidad','Funcionario','Cargo','Estado'];
foreach ($campos as $c) {
    echo "<th>$c</th>";
}
echo '</tr></thead><tbody>';

while ($fila = mysqli_fetch_assoc($resultado)) {
    // Estado
    if (!empty($fila['Fecha Caducidad'])) {
        $estado = ($fila['Fecha Caducidad'] >= $hoy) ? 'VIGENTE' : 'VENCIDO';
    } else {
        $estado = 'Sin certificado';
    }
    echo '<tr>';
    foreach ($fila as $valor) {
        echo "<td>" . ($valor ?? '---') . "</td>";
    }
    echo "<td>$estado</td>";
    echo '</tr>';
}

echo '</tbody></table>';
mysqli_close($cn);
?>
