<?php
include "conexion.php";
$id = $_POST['txtid'];
$nombre = trim(strtoupper($_POST['txtnombre']));
$sql = "UPDATE distrito SET nombredistrito = '$nombre' WHERE iddistrito = '$id'";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:distrito.php");
?>
