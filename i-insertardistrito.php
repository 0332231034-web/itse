<?php
include "conexion.php";
$nombre = trim(strtoupper($_POST['txtnombre']));

// Verificar si ya existe
$check = mysqli_query($cn, "SELECT iddistrito FROM distrito WHERE UPPER(nombredistrito) = '$nombre'");
if (mysqli_num_rows($check) > 0) {
    header("location:distrito.php?error=duplicado");
    exit;
}

$sql = "INSERT INTO distrito (nombredistrito) VALUES ('$nombre')";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:distrito.php");
?>
