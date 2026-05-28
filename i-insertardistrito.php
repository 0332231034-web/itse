<?php
include "conexion.php";
$nombre = trim(strtoupper($_POST['txtnombre']));
$sql = "INSERT INTO distrito (nombredistrito) VALUES ('$nombre')";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:distrito.php");
?>
