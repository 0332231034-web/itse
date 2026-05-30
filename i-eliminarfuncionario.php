<?php
include "conexion.php";
$id = $_GET['id'];

// Verificar si el funcionario está siendo usado
$check = mysqli_query($cn, "SELECT idcertificado FROM certificado WHERE idfuncionario = '$id'");
if (mysqli_num_rows($check) > 0) {
    header("location:funcionario.php?error=enuso");
    exit;
}

$sql = "DELETE FROM funcionario WHERE idfuncionario = '$id'";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:funcionario.php");
?>
