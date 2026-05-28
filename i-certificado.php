<?php
include "conexion.php";

// 1. Recibimos los datos del formulario (Asegúrate de que los 'name' de tu HTML coincidan)
$idempresa = $_POST['lstempresa']; 
$idfuncionario = $_POST['lstfuncionario']; 
$correlativo = $_POST['txtcorrelativo'];
$expediente = $_POST['txtexpediente'];
$resolucion = $_POST['txtresolucion'];

// 2. Limpiamos espacios y pasamos a mayúsculas por orden
$correlativo = trim(strtoupper($correlativo));
$expediente = trim(strtoupper($expediente));
$resolucion = trim(strtoupper($resolucion));

// 3. Fechas: Expedición y Renovación
$fechaExpedicion = date('Y-m-d'); // Captura la fecha actual del servidor automáticamente

// MI PROPUESTA: Calcular la fecha de renovación usando strtotime()
// Como caduca en 2 años, lo ideal es que la empresa inicie el trámite un mes antes.
// Le sumamos 23 meses a la fecha de expedición actual.
$fechaRenovacion = date('Y-m-d', strtotime('+23 months', strtotime($fechaExpedicion))); 

// 4. Inserción a la BD aplicando la lógica del profesor para la caducidad
// Usamos DATE_ADD directamente en el INSERT. Pongo INTERVAL 2 YEAR porque tu requerimiento dice "validez de 2 años".
$sql = "INSERT INTO certificado (
            nrocorrelativocertificado, 
            nroexpedientecertificado, 
            nroresolucioncertificado, 
            fechaexpedicioncertificado, 
            fechasolicitudrenovacioncertificado, 
            fechacaducidadcertificado, 
            idempresa, 
            idfuncionario
        ) VALUES (
            '$correlativo', 
            '$expediente', 
            '$resolucion', 
            '$fechaExpedicion', 
            '$fechaRenovacion', 
            DATE_ADD('$fechaExpedicion', INTERVAL 2 YEAR), 
            '$idempresa', 
            '$idfuncionario'
        )";

mysqli_query($cn, $sql);

// Opcional: Aquí podrías llamar a generarqr.php si quieres que se cree el QR al momento de registrar
 $id_recien_creado = mysqli_insert_id($cn);
 include_once 'generarqr.php';
 generarQR($id_recien_creado);

mysqli_close($cn);

header("location:panel.php");
?>