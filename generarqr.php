<?php

function generarQR(int $id_certificado) {
    include_once('phpqrcode/qrlib.php');
    include("conexion.php");

    $sql = "SELECT e.rucempresa, e.razonsocialempresa, g.nombregironegocio, c.fechaexpedicioncertificado 
            FROM certificado c
            INNER JOIN empresa e ON c.idempresa = e.idempresa
            INNER JOIN gironegocio g ON e.idgiro = g.idgiro
            WHERE c.idcertificado = $id_certificado";
            
    $f = mysqli_query($cn, $sql);
    $r = mysqli_fetch_assoc($f); 

    $data = "RUC: " . $r['rucempresa'] . "\n" .
            "Razon Social: " . $r['razonsocialempresa'] . "\n" .
            "Giro: " . $r['nombregironegocio'] . "\n" .
            "Expedicion: " . $r['fechaexpedicioncertificado'];

    // Nombre del archivo: solo el RUC + .png  (requerimiento de la evaluación)
    $nombre = "qrcertificado/" . $r['rucempresa'] . ".png";
    
    $nivel = QR_ECLEVEL_H;
    $tamanio = 5;

    QRcode::png($data, $nombre, $nivel, $tamanio);
}
?>
