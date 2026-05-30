<?php
include "conexion.php";
$id = $_GET['id'];

// Verificar si el giro está siendo usado
$check = mysqli_query($cn, "SELECT idempresa FROM empresa WHERE idgiro = '$id'");
if (mysqli_num_rows($check) > 0) {
    header("location:giro-negocio.php?error=enuso");
    exit;
}

$sql = "DELETE FROM gironegocio WHERE idgiro = '$id'";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:giro-negocio.php");
?>
