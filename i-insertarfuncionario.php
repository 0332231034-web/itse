<?php
include "conexion.php";
$nombres   = trim(strtoupper($_POST['txtnombres']));
$apellidos = trim(strtoupper($_POST['txtapellidos']));
$cargo     = trim(strtoupper($_POST['txtcargo']));
$sql = "INSERT INTO funcionario (nombresfuncionario, apellidosfuncionario, cargofuncionario) VALUES ('$nombres', '$apellidos', '$cargo')";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:funcionario.php");
?>
