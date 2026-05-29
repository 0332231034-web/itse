<?php

include('fpdf.php');


// Extiende la clase FPDF
class PDF extends FPDF {
    // Función para agregar una página con imagen de fondo
    function addPageWithBackground($imgPath, $orientation = 'l', $size = 'A4') {
        $this->AddPage($orientation, $size);
        $this->Image($imgPath, 0, 0, $this->w, $this->h);
    }
}

// Crea una instancia de PDF
$pdf = new PDF();

// Agrega una página con la imagen de fondo
$pdf->addPageWithBackground('img.jpg');

// Establece la fuente y el tamaño de texto
$pdf->SetFont('Arial', 'B', 20);



// Agrega contenido al PDF
$pdf->ln(85);
$pdf->Cell(270, 10, "texto", 0,1,'C');
$pdf->ln(13.5);
$pdf->Cell(100, 10, '', 0,0,'C');
$pdf->Cell(20, 10, 'hola', 0,1);


// Genera el archivo PDF
$pdf->Output();









?>