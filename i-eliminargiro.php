<?php
include "conexion.php";

// Capturamos el ID que viene por la URL (método GET)
$id = $_GET['id'];

// Sentencia SQL para eliminar
$sql = "DELETE FROM gironegocio WHERE idgiro = '$id'";

mysqli_query($cn, $sql);
mysqli_close($cn);

// Redirige de vuelta a la lista
header("location:giro-negocio.php");
?>