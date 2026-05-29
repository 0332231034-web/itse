<?php
include "conexion.php";
$id        = $_POST['txtid'];
$nombres   = trim(strtoupper($_POST['txtnombres']));
$apellidos = trim(strtoupper($_POST['txtapellidos']));
$cargo     = trim(strtoupper($_POST['txtcargo']));

// Verificar si ya existe otro funcionario con el mismo nombre y apellido (excluyendo el actual)
$check = mysqli_query($cn, "SELECT idfuncionario FROM funcionario WHERE UPPER(nombresfuncionario) = '$nombres' AND UPPER(apellidosfuncionario) = '$apellidos' AND idfuncionario != '$id'");
if (mysqli_num_rows($check) > 0) {
    header("location:funcionario.php?error=duplicado");
    exit;
}

$sql = "UPDATE funcionario SET nombresfuncionario='$nombres', apellidosfuncionario='$apellidos', cargofuncionario='$cargo' WHERE idfuncionario='$id'";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:funcionario.php");
?>
