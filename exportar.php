<?php
include 'conexion.php';

// Nombre del archivo con la fecha de hoy
$filename = "Reporte_Tramites_" . date('Y-m-d') . ".xls";

// Cabeceras para forzar la descarga en formato Excel
header("Content-Type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-Disposition: attachment; filename=$filename");

// Consulta de los datos
$query = mysqli_query($con, "SELECT * FROM solicitudes ORDER BY fecha_limite ASC");
?>

<table border="1">
    <thead>
        <tr style="background-color: #00468b; color: white;">
            <th>ID</th>
            <th>Tipo</th>
            <th>Radicado</th>
            <th>Fecha Recepcion</th>
            <th>Solicitante</th>
            <th>Dependencia</th>
            <th>Asunto</th>
            <th>Fecha Limite</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_array($query)): 
            $hoy = date('Y-m-d');
            $estado = ($hoy > $row['fecha_limite']) ? 'VENCIDO' : 'En Tramite';
        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['tipo']; ?></td>
            <td><?php echo $row['radicado']; ?></td>
            <td><?php echo $row['fecha_recepcion']; ?></td>
            <td><?php echo $row['solicitante']; ?></td>
            <td><?php echo $row['dependencia']; ?></td>
            <td><?php echo $row['asunto']; ?></td>
            <td><?php echo $row['fecha_limite']; ?></td>
            <td><?php echo $estado; ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>