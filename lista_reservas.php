<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/conexion.php';

// Consultar todas las reservas
$query = $conexion->query("SELECT * FROM reservas ORDER BY fecha_reserva ASC");
$reservas = $query->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between mb-4">
            <h2>Gestión de Reservas</h2>
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($reservas) > 0): ?>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reserva['cliente_nombre']); ?></td>
                            <td><?php echo htmlspecialchars($reserva['fecha_reserva']); ?></td>
                            <td><?php echo htmlspecialchars($reserva['hora_reserva']); ?></td>
                            <td><span class="badge bg-info"><?php echo $reserva['estado']; ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center">No hay reservas registradas aún.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>