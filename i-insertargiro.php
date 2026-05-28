<?php
include "conexion.php";

// Capturamos el dato del formulario (Asegúrate de que tu input se llame 'txtgiro')
$nombreGiro = trim(strtoupper($_POST['txtgiro']));

// Sentencia SQL para insertar
$sql = "INSERT INTO gironegocio (nombregironegocio) VALUES ('$nombreGiro')";

mysqli_query($cn, $sql);
mysqli_close($cn);

// Redirige de vuelta al panel principal de giros (cambia 'panel-giros.php' por el nombre de tu archivo)
header("location:giro-negocio.php");
?>