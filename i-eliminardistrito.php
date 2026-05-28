<?php
include "conexion.php";
$id = $_GET['id'];
$sql = "DELETE FROM distrito WHERE iddistrito = '$id'";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:distrito.php");
?>
