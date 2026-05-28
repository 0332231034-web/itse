<?php
include "conexion.php";

$id             = $_POST['txtid'];
$ruc            = trim($_POST['txtruc']);
$razonsocial    = trim(strtoupper($_POST['txtrazonsocial']));
$representante  = trim(strtoupper($_POST['txtrepresentante']));
$celular        = trim($_POST['txtcelular']);
$correo         = trim($_POST['txtcorreo']);
$direccion      = trim(strtoupper($_POST['txtdireccion']));
$iddistrito     = $_POST['lstdistrito'];
$idgiro         = $_POST['lstgiro'];

$sql = "UPDATE empresa SET
            rucempresa = '$ruc',
            razonsocialempresa = '$razonsocial',
            representantelegalempresa = '$representante',
            celularempresa = '$celular',
            correoempresa = '$correo',
            direccionfiscalempresa = '$direccion',
            iddistrito = '$iddistrito',
            idgiro = '$idgiro'
        WHERE idempresa = '$id'";

mysqli_query($cn, $sql);
mysqli_close($cn);

header("location:panel.php");
?>
