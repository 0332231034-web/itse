<?php
include "conexion.php";
require('fpdf/fpdf.php');

$id = $_GET['id'];

// Traer todos los datos del certificado
$sql = "SELECT 
            c.idcertificado,
            c.nrocorrelativocertificado,
            c.nroexpedientecertificado,
            c.nroresolucioncertificado,
            c.fechaexpedicioncertificado,
            c.fechasolicitudrenovacioncertificado,
            c.fechacaducidadcertificado,
            e.rucempresa,
            e.razonsocialempresa,
            e.representantelegalempresa,
            e.celularempresa,
            e.correoempresa,
            e.direccionfiscalempresa,
            g.nombregironegocio,
            d.nombredistrito,
            f.nombresfuncionario,
            f.apellidosfuncionario,
            f.cargofuncionario
        FROM certificado c
        INNER JOIN empresa e ON c.idempresa = e.idempresa
        INNER JOIN gironegocio g ON e.idgiro = g.idgiro
        INNER JOIN distrito d ON e.iddistrito = d.iddistrito
        INNER JOIN funcionario f ON c.idfuncionario = f.idfuncionario
        WHERE c.idcertificado = '$id'";

$resultado = mysqli_query($cn, $sql);
$r = mysqli_fetch_assoc($resultado);

if (!$r) {
    die("Certificado no encontrado.");
}

// Ruta del QR
$qrPath = "qrcertificado/" . $r['rucempresa'] . "_" . $r['idcertificado'] . ".png";

// Formatear fechas
function fecha($f) {
    if (!$f) return '---';
    $d = explode('-', $f);
    return $d[2] . '/' . $d[1] . '/' . $d[0];
}

// ---- GENERAR PDF ----
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetMargins(20, 20, 20);
$pdf->SetAutoPageBreak(false);

// Fondo gris claro del encabezado
$pdf->SetFillColor(44, 62, 80);
$pdf->Rect(0, 0, 210, 40, 'F');

// Logo (si existe)
if (file_exists('img/logo unjfsc.png')) {
    $pdf->Image('img/logo unjfsc.png', 8, 5, 30);
}

// Título principal
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetXY(0, 10);
$pdf->Cell(210, 8, 'MUNICIPALIDAD - CERTIFICADO DE FUNCIONAMIENTO', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(0, 20);
$pdf->Cell(210, 6, 'Licencia de Funcionamiento Empresarial', 0, 1, 'C');
$pdf->SetXY(0, 28);
$pdf->Cell(210, 6, utf8_decode('Válido en todo el territorio nacional'), 0, 1, 'C');

// Resetear color de texto
$pdf->SetTextColor(0, 0, 0);

// ---- Sección: Datos del certificado ----
$pdf->SetXY(20, 48);
$pdf->SetFillColor(36, 113, 163);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(170, 8, 'DATOS DEL CERTIFICADO', 0, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);

$y = 60;
$col1 = 20; $col2 = 85; $w1 = 60; $w2 = 105;

// Helper para fila
function fila($pdf, &$y, $col1, $w1, $col2, $w2, $label, $valor) {
    $pdf->SetXY($col1, $y);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($w1, 7, $label, 0);
    $pdf->SetXY($col2, $y);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell($w2, 7, utf8_decode($valor), 0);
    $y += 8;
}

fila($pdf, $y, $col1, $w1, $col2, $w2, 'N. Correlativo:', $r['nrocorrelativocertificado']);
fila($pdf, $y, $col1, $w1, $col2, $w2, 'N. Expediente:', $r['nroexpedientecertificado']);
fila($pdf, $y, $col1, $w1, $col2, $w2, 'N. Resolucion:', $r['nroresolucioncertificado']);
fila($pdf, $y, $col1, $w1, $col2, $w2, 'Fecha de Expedicion:', fecha($r['fechaexpedicioncertificado']));
fila($pdf, $y, $col1, $w1, $col2, $w2, 'Fecha de Caducidad:', fecha($r['fechacaducidadcertificado']));
fila($pdf, $y, $col1, $w1, $col2, $w2, 'Fecha de Renovacion:', fecha($r['fechasolicitudrenovacioncertificado']));

// ---- Sección: Datos de la empresa ----
$y += 4;
$pdf->SetXY(20, $y);
$pdf->SetFillColor(36, 113, 163);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(170, 8, 'DATOS DE LA EMPRESA', 0, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0);
$y += 10;

fila($pdf, $y, $col1, $w1, $col2, $w2, 'RUC:', $r['rucempresa']);
fila($pdf, $y, $col1, $w1, $col2, $w2, 'Razon Social:', $r['razonsocialempresa']);
fila($pdf, $y, $col1, $w1, $col2, $w2, 'Representante Legal:', $r['representantelegalempresa']);
fila($pdf, $y, $col1, $w1, $col2, $w2, 'Celular:', $r['celularempresa']);
fila($pdf, $y, $col1, $w1, $col2, $w2, 'Correo:', $r['correoempresa']);
fila($pdf, $y, $col1, $w1, $col2, $w2, 'Direccion Fiscal:', $r['direccionfiscalempresa']);
fila($pdf, $y, $col1, $w1, $col2, $w2, 'Distrito:', $r['nombredistrito']);
fila($pdf, $y, $col1, $w1, $col2, $w2, 'Giro de Negocio:', $r['nombregironegocio']);

// ---- Sección: Funcionario ----
$y += 4;
$pdf->SetXY(20, $y);
$pdf->SetFillColor(36, 113, 163);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(170, 8, 'FUNCIONARIO A CARGO', 0, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0);
$y += 10;

$nomFuncionario = $r['nombresfuncionario'] . ' ' . $r['apellidosfuncionario'];
fila($pdf, $y, $col1, $w1, $col2, $w2, 'Nombres:', $nomFuncionario);
fila($pdf, $y, $col1, $w1, $col2, $w2, 'Cargo:', $r['cargofuncionario']);

// ---- QR ----
if (file_exists($qrPath)) {
    $pdf->SetXY(20, $y + 6);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(170, 6, utf8_decode('Código QR de Verificación'), 0, 1, 'C');
    $pdf->Image($qrPath, 85, $y + 14, 40, 40);
    $y += 58;
}

// ---- Firma ----
$y += 8;
$pdf->SetXY(20, $y);
$pdf->SetDrawColor(44, 62, 80);
$pdf->SetLineWidth(0.5);
$pdf->Line(60, $y + 15, 150, $y + 15);
$pdf->SetXY(20, $y + 17);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(170, 6, strtoupper($nomFuncionario), 0, 1, 'C');
$pdf->SetXY(20, $y + 24);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(170, 6, utf8_decode($r['cargofuncionario']), 0, 1, 'C');

// ---- Pie de página ----
$pdf->SetFillColor(44, 62, 80);
$pdf->Rect(0, 282, 210, 15, 'F');
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'I', 8);
$pdf->SetXY(0, 285);
$pdf->Cell(210, 6, utf8_decode('Documento generado electrónicamente - Sistema ITSE'), 0, 0, 'C');

// Salida
$pdf->Output('I', 'Certificado_' . $r['rucempresa'] . '.pdf');
?>
