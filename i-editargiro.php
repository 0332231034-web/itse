<?php
include "conexion.php";
$id = $_POST['txtid'];
$nombre = trim(strtoupper($_POST['txtgiro']));
$sql = "UPDATE gironegocio SET nombregironegocio = '$nombre' WHERE idgiro = '$id'";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:giro-negocio.php");
?>
