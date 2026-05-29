<?php
include "conexion.php";
$nombres   = trim(strtoupper($_POST['txtnombres']));
$apellidos = trim(strtoupper($_POST['txtapellidos']));
$cargo     = trim(strtoupper($_POST['txtcargo']));

// Verificar si ya existe (mismo nombre + apellido)
$check = mysqli_query($cn, "SELECT idfuncionario FROM funcionario WHERE UPPER(nombresfuncionario) = '$nombres' AND UPPER(apellidosfuncionario) = '$apellidos'");
if (mysqli_num_rows($check) > 0) {
    header("location:funcionario.php?error=duplicado");
    exit;
}

$sql = "INSERT INTO funcionario (nombresfuncionario, apellidosfuncionario, cargofuncionario) VALUES ('$nombres', '$apellidos', '$cargo')";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:funcionario.php");
?>
