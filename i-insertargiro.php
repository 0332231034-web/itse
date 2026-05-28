<?php
include "conexion.php";
$nombreGiro = trim(strtoupper($_POST['txtgiro']));

// Verificar si ya existe
$check = mysqli_query($cn, "SELECT idgiro FROM gironegocio WHERE UPPER(nombregironegocio) = '$nombreGiro'");
if (mysqli_num_rows($check) > 0) {
    header("location:giro-negocio.php?error=duplicado");
    exit;
}

$sql = "INSERT INTO gironegocio (nombregironegocio) VALUES ('$nombreGiro')";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:giro-negocio.php");
?>
