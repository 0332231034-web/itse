<?php
include "conexion.php";
$id = $_POST['txtid'];
$nombre = trim(strtoupper($_POST['txtnombre']));

// Verificamos si ya existe otro distrito con el mismo nombre (excluyendo el actual)
$check = mysqli_query($cn, "SELECT iddistrito FROM distrito WHERE UPPER(nombredistrito) = '$nombre' AND iddistrito != '$id'");
if (mysqli_num_rows($check) > 0) {
    header("location:distrito.php?error=duplicado");
    exit;
}

$sql = "UPDATE distrito SET nombredistrito = '$nombre' WHERE iddistrito = '$id'";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:distrito.php");
?>
