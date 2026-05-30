<?php
include "conexion.php";
$id = $_GET['id'];

// Verificar si el distrito está siendo usado por alguna empresa
$check = mysqli_query($cn, "SELECT idempresa FROM empresa WHERE iddistrito = '$id'");
if (mysqli_num_rows($check) > 0) {
    header("location:distrito.php?error=enuso");
    exit;
}

$sql = "DELETE FROM distrito WHERE iddistrito = '$id'";
mysqli_query($cn, $sql);
mysqli_close($cn);
header("location:distrito.php");
?>
