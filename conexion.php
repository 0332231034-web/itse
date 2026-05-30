<?php
$cn = mysqli_connect("localhost", "root", "", "bditse");
mysqli_set_charset($cn, "utf8");
if (!$cn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
