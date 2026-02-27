<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM solicitudes WHERE id = $id";

    if (mysqli_query($con, $sql)) {
        header("Location: index.php?status=deleted");
    } else {
        echo "Error al eliminar: " . mysqli_error($con);
    }
}
?>