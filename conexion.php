<?php
$host = "localhost";
$user = "root";
$pass = ""; 
$db   = "db_juridica";

// Conexión con reporte de errores detallado
$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {
    die("Fallo la conexión: " . mysqli_connect_error());
}
?>