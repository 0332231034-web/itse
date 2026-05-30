<?php
include "conexion.php";

$idempresa     = $_POST['txtidempresa'];
$correlativo   = trim(strtoupper($_POST['txtcorrelativo']));
$expediente    = trim(strtoupper($_POST['txtexpediente']));
$resolucion    = trim(strtoupper($_POST['txtresolucion']));
$idfuncionario = $_POST['lstfuncionario'];

$fechaExpedicion = date('Y-m-d');
$fechaRenovacion = date('Y-m-d', strtotime('+23 months', strtotime($fechaExpedicion)));

$sql = "INSERT INTO certificado (
            nrocorrelativocertificado,
            nroexpedientecertificado,
            nroresolucioncertificado,
            fechaexpedicioncertificado,
            fechasolicitudrenovacioncertificado,
            fechacaducidadcertificado,
            idempresa,
            idfuncionario
        ) VALUES (
            '$correlativo',
            '$expediente',
            '$resolucion',
            '$fechaExpedicion',
            '$fechaRenovacion',
            DATE_ADD('$fechaExpedicion', INTERVAL 2 YEAR),
            '$idempresa',
            '$idfuncionario'
        )";

mysqli_query($cn, $sql);
$idcertificado = mysqli_insert_id($cn);

// Regenerar QR
include_once 'generarqr.php';
generarQR($idcertificado);

mysqli_close($cn);
header("location:panel.php");
?>
