<?php

function generarQR(int $id_certificado) {
    // Usamos include_once para evitar errores si llamas a la función más de una vez
    include_once('phpqrcode/qrlib.php');
    include("conexion.php");

    // Hacemos un JOIN para obtener los datos del certificado, la empresa y su giro de negocio
    $sql = "SELECT e.rucempresa, e.razonsocialempresa, g.nombregironegocio, c.fechaexpedicioncertificado 
            FROM certificado c
            INNER JOIN empresa e ON c.idempresa = e.idempresa
            INNER JOIN gironegocio g ON e.idgiro = g.idgiro
            WHERE c.idcertificado = $id_certificado";
            
    $f = mysqli_query($cn, $sql);
    $r = mysqli_fetch_assoc($f); 

    // 1. Preparamos la data que pide la diapositiva: RUC, RAZON SOCIAL, GIRO DE NEGOCIO, FECHA DE EXPEDICIÓN
    $data = "RUC: " . $r['rucempresa'] . "\n" .
            "Razon Social: " . $r['razonsocialempresa'] . "\n" .
            "Giro: " . $r['nombregironegocio'] . "\n" .
            "Expedicion: " . $r['fechaexpedicioncertificado'];

    // 2. Preparamos el nombre: qrcertificado/20434686098_1.png (RUC + ID del Certificado)
    $nombre = "qrcertificado/" . $r['rucempresa'] . "_" . $id_certificado . ".png";
    
    $nivel = QR_ECLEVEL_H;
    $tamanio = 5;

    // 3. Generamos el QR y lo guardamos
    QRcode::png($data, $nombre, $nivel, $tamanio);
}

?>