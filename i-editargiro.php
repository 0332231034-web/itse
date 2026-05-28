<?php
include "conexion.php";

// Capturamos el ID (usualmente desde un <input type="hidden">) y el nuevo nombre
$id = $_POST['txtid'];
$nombreGiro = trim(strtoupper($_POST['txtgiro']));

// Sentencia SQL para actualizar (UPDATE)
$sql = "UPDATE gironegocio SET nombregironegocio = '$nombreGiro' WHERE idgiro = '$id'";

mysqli_query($cn, $sql);
mysqli_close($cn);

// Redirige de vuelta a la lista
header("location:giro-negocio.php");
?>