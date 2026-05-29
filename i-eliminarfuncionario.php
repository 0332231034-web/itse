<?php
include "conexion.php";
$id = $_GET['id'];
$sql = "DELETE FROM funcionario WHERE idfuncionario = '$id'";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:funcionario.php");
?>
