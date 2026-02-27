<?php 
include 'conexion.php'; 
$query = mysqli_query($con, "SELECT * FROM solicitudes ORDER BY fecha_limite ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión Jurídica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .navbar-custom { background-color: #00468b; color: white; }
        .card { border: none; border-radius: 12px; }
        .vencido { background-color: #ffdce0 !important; color: #af0808; }
        .a-tiempo { background-color: #e1f7e1 !important; color: #155724; }
    </style>
</head>
<body>

    <nav class="navbar navbar-custom mb-4 shadow-sm">
        <div class="container">
            <span class="navbar-brand mb-0 h1 text-white"><i class="bi bi-gavel"></i> Control de Tutelas y Peticiones</span>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">Nuevo Registro</div>
                    <div class="card-body">
                        <form action="guardar.php" method="POST">
                            <div class="mb-2">
                                <label class="form-label small">Tipo</label>
                                <select name="tipo" class="form-select form-select-sm">
                                    <option value="Derecho de Petición">Derecho de Petición</option>
                                    <option value="Tutela">Tutela</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small">Radicado</label>
                                <input type="text" name="radicado" class="form-control form-control-sm" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small">Fecha Recepción</label>
                                <input type="date" name="fecha_recepcion" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="mb-2">
                                <label class="form-label small">Solicitante</label>
                                <input type="text" name="solicitante" class="form-control form-control-sm" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small">Dependencia</label>
                                <input type="text" name="dependencia" class="form-control form-control-sm" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Asunto</label>
                                <textarea name="asunto" class="form-control form-control-sm" rows="2"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-sm">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <span>Listado de Seguimiento</span>
                        <a href="exportar.php" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Excel</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Radicado</th>
                                    <th>Vence</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_array($query)): 
                                    $hoy = date('Y-m-d');
                                    $es_vencido = ($hoy > $row['fecha_limite']);
                                ?>
                                <tr class="<?php echo $es_vencido ? 'vencido' : 'a-tiempo'; ?>">
                                    <td><strong><?php echo $row['radicado']; ?></strong></td>
                                    <td><?php echo $row['fecha_limite']; ?></td>
                                    <td><span class="badge <?php echo $es_vencido ? 'bg-danger' : 'bg-success'; ?>"><?php echo $es_vencido ? 'VENCIDO' : 'Al día'; ?></span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#ver<?php echo $row['id']; ?>"><i class="bi bi-eye"></i></button>
                                        
                                        <a href="eliminar.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que quieres borrar este registro?')"><i class="bi bi-trash"></i></a>

                                        <div class="modal fade" id="ver<?php echo $row['id']; ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content text-dark">
                                                    <div class="modal-header"><h5>Detalle Radicado <?php echo $row['radicado']; ?></h5></div>
                                                    <div class="modal-body">
                                                        <p><strong>Solicitante:</strong> <?php echo $row['solicitante']; ?></p>
                                                        <p><strong>Asunto:</strong><br><?php echo nl2br($row['asunto']); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>