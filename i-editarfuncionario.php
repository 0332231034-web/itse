<?php
include "conexion.php";
$id        = $_POST['txtid'];
$nombres   = trim(strtoupper($_POST['txtnombres']));
$apellidos = trim(strtoupper($_POST['txtapellidos']));
$cargo     = trim(strtoupper($_POST['txtcargo']));
$sql = "UPDATE funcionario SET nombresfuncionario='$nombres', apellidosfuncionario='$apellidos', cargofuncionario='$cargo' WHERE idfuncionario='$id'";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:funcionario.php");
?>
