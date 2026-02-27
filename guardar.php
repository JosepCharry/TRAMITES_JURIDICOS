<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];
    $radicado = $_POST['radicado'];
    $fecha_recepcion = $_POST['fecha_recepcion'];
    $solicitante = $_POST['solicitante'];
    $dependencia = $_POST['dependencia'];
    $asunto = $_POST['asunto'];

    // Lógica de términos legales: 10 días para Tutela, 15 para Petición
    $dias = ($tipo == 'Tutela') ? 10 : 15;

    // Calculamos la fecha límite sumando los días a la fecha de recepción
    $fecha_limite = date('Y-m-d', strtotime($fecha_recepcion. " + $dias days"));

    $sql = "INSERT INTO solicitudes (tipo, radicado, fecha_recepcion, solicitante, dependencia, asunto, fecha_limite) 
            VALUES ('$tipo', '$radicado', '$fecha_recepcion', '$solicitante', '$dependencia', '$asunto', '$fecha_limite')";

    if (mysqli_query($con, $sql)) {
        header("Location: index.php?status=success");
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>