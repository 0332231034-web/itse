<?php
include "conexion.php";
$id = $_POST['txtid'];
$nombreGiro = trim(strtoupper($_POST['txtgiro']));

// Verificar si ya existe otro giro con el mismo nombre (excluyendo el actual)
$check = mysqli_query($cn, "SELECT idgiro FROM gironegocio WHERE UPPER(nombregironegocio) = '$nombreGiro' AND idgiro != '$id'");
if (mysqli_num_rows($check) > 0) {
    header("location:giro-negocio.php?error=duplicado");
    exit;
}

$sql = "UPDATE gironegocio SET nombregironegocio = '$nombreGiro' WHERE idgiro = '$id'";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:giro-negocio.php");
?>
