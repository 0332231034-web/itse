<?php
include "conexion.php";

$ruc           = trim(strtoupper($_POST['txtruc']));
$razonsocial   = trim(strtoupper($_POST['txtrazonsocial']));
$representante = trim(strtoupper($_POST['txtrepresentante']));
$celular       = trim($_POST['txtcelular']);
$correo        = trim($_POST['txtcorreo']);
$direccion     = trim(strtoupper($_POST['txtdireccion']));
$iddistrito    = $_POST['lstdistrito'];
$idgiro        = $_POST['lstgiro'];
$idfuncionario = $_POST['lstfuncionario'];

// Validar RUC + dirección duplicados
$check = mysqli_query($cn, "SELECT idempresa FROM empresa WHERE rucempresa='$ruc' AND direccionfiscalempresa='$direccion'");
if (mysqli_num_rows($check) > 0) {
    header("location:index.php?error=duplicado");
    exit;
}

// Insertar empresa
$sqlEmp = "INSERT INTO empresa (rucempresa, razonsocialempresa, representantelegalempresa,
            celularempresa, correoempresa, direccionfiscalempresa, iddistrito, idgiro)
           VALUES ('$ruc','$razonsocial','$representante','$celular','$correo','$direccion','$iddistrito','$idgiro')";
mysqli_query($cn, $sqlEmp);
$idempresa = mysqli_insert_id($cn);

$correlativo   = trim(strtoupper($_POST['txtcorrelativo']));
$expediente    = trim(strtoupper($_POST['txtexpediente']));
$resolucion    = trim(strtoupper($_POST['txtresolucion']));
$fechaExpedicion = date('Y-m-d');
$fechaRenovacion = date('Y-m-d', strtotime('+23 months', strtotime($fechaExpedicion)));

$sqlCert = "INSERT INTO certificado (nrocorrelativocertificado, nroexpedientecertificado,
                nroresolucioncertificado, fechaexpedicioncertificado,
                fechasolicitudrenovacioncertificado, fechacaducidadcertificado,
                idempresa, idfuncionario)
            VALUES ('$correlativo','$expediente','$resolucion','$fechaExpedicion',
                '$fechaRenovacion', DATE_ADD('$fechaExpedicion', INTERVAL 2 YEAR),
                '$idempresa','$idfuncionario')";
mysqli_query($cn, $sqlCert);
$idcertificado = mysqli_insert_id($cn);

include_once 'generarqr.php';
generarQR($idcertificado);

mysqli_close($cn);
header("location:panel.php");
?>
