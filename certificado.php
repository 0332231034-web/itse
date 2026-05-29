<?php
include "conexion.php";
require('fpdf/fpdf.php');

$id = $_GET['id'];

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

if (!$r) { die("Certificado no encontrado."); }

// Ruta QR: solo RUC.png
$qrPath = "qrcertificado/" . $r['rucempresa'] . ".png";

function fecha($f) {
    if (!$f) return '---';
    $d = explode('-', $f);
    return $d[2] . '/' . $d[1] . '/' . $d[0];
}

function fila($pdf, &$y, $col1, $w1, $col2, $w2, $label, $valor) {
    $pdf->SetXY($col1, $y);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($w1, 7, $label, 0);
    $pdf->SetXY($col2, $y);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell($w2, 7, utf8_decode($valor), 0);
    $y += 8;
}

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

//img de fondo

$pdf->Image('img/fondocertificado.png', 0, 0, 210, 297);


$pdf->SetMargins(20, 20, 20);
$pdf->SetAutoPageBreak(false);




// Encabezado
$pdf->SetFillColor(44, 62, 80);
$pdf->Rect(0, 0, 210, 40, 'F');
if (file_exists('img/logo unjfsc.png')) {
    $pdf->Image('img/logo unjfsc.png', 8, 5, 30);
}
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetXY(0, 10);
$pdf->Cell(210, 8, 'MUNICIPALIDAD - CERTIFICADO DE FUNCIONAMIENTO', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(0, 20);
$pdf->Cell(210, 6, 'Licencia de Funcionamiento Empresarial', 0, 1, 'C');
$pdf->SetXY(0, 28);
$pdf->Cell(210, 6, utf8_decode('Válido en todo el territorio nacional'), 0, 1, 'C');
$pdf->SetTextColor(0, 0, 0);

$col1 = 20; $col2 = 85; $w1 = 60; $w2 = 105;

// Sección certificado
$pdf->SetXY(20, 48);
$pdf->SetFillColor(36, 113, 163);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(170, 8, 'DATOS DEL CERTIFICADO', 0, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0);
$y = 60;
fila($pdf, $y, $col1, $w1, $col2, $w2, 'N. Correlativo:', $r['nrocorrelativocertificado']);
fila($pdf, $y, $col1, $w1, $col2, $w2, 'N. Expediente:', $r['nroexpedientecertificado']);
fila($pdf, $y, $col1, $w1, $col2, $w2, 'N. Resolucion:', $r['nroresolucioncertificado']);
fila($pdf, $y, $col1, $w1, $col2, $w2, 'Fecha de Expedicion:', fecha($r['fechaexpedicioncertificado']));
fila($pdf, $y, $col1, $w1, $col2, $w2, 'Fecha de Caducidad:', fecha($r['fechacaducidadcertificado']));
fila($pdf, $y, $col1, $w1, $col2, $w2, 'Fecha de Renovacion:', fecha($r['fechasolicitudrenovacioncertificado']));

// Sección empresa
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

// Sección funcionario
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

// QR + datos a la derecha
$y += 6;
$pdf->SetXY(20, $y);
$pdf->SetFillColor(36, 113, 163);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(170, 8, utf8_decode('CÓDIGO QR DE VERIFICACIÓN'), 0, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0);
$y += 12;

if (file_exists($qrPath)) {
    // QR a la izquierda
    $pdf->Image($qrPath, 30, $y, 45, 45);
    // Datos del QR a la derecha
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetXY(85, $y + 4);
    $pdf->Cell(100, 6, 'Contenido del QR:', 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetXY(85, $y + 12);
    $pdf->Cell(100, 6, 'RUC: ' . $r['rucempresa'], 0);
    $pdf->SetXY(85, $y + 19);
    $pdf->Cell(100, 6, utf8_decode('Razón Social: ') . utf8_decode($r['razonsocialempresa']), 0);
    $pdf->SetXY(85, $y + 26);
    $pdf->Cell(100, 6, 'Giro: ' . utf8_decode($r['nombregironegocio']), 0);
    $pdf->SetXY(85, $y + 33);
    $pdf->Cell(100, 6, utf8_decode('Expedición: ') . fecha($r['fechaexpedicioncertificado']), 0);
    $y += 50;
} else {
    $pdf->SetXY(20, $y);
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Cell(170, 8, 'QR no disponible', 0, 0, 'C');
    $y += 14;
}

// Firma
$y += 6;
$pdf->SetDrawColor(44, 62, 80);
$pdf->SetLineWidth(0.5);
$pdf->Line(60, $y + 15, 150, $y + 15);
$pdf->SetXY(20, $y + 17);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(170, 6, strtoupper($nomFuncionario), 0, 1, 'C');
$pdf->SetXY(20, $y + 24);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(170, 6, utf8_decode($r['cargofuncionario']), 0, 1, 'C');

// Pie
$pdf->SetFillColor(44, 62, 80);
$pdf->Rect(0, 282, 210, 15, 'F');
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'I', 8);
$pdf->SetXY(0, 285);
$pdf->Cell(210, 6, utf8_decode('Documento generado electrónicamente - Sistema ITSE'), 0, 0, 'C');

$pdf->Output('I', 'Certificado_' . $r['rucempresa'] . '.pdf');
?>
