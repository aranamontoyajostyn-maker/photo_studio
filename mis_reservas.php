<?php
session_start();
// --- SEGURIDAD: Solo acceso para clientes ---
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: index.php");
    exit();
}

require_once 'config/conexion.php';

// 1. Obtenemos el nombre del usuario
$stmt_user = $conexion->prepare("SELECT nombre_usuario FROM usuarios WHERE id = :id");
$stmt_user->execute(['id' => $_SESSION['user_id']]);
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);
$nombre_mostrado = ($user) ? htmlspecialchars($user['nombre_usuario']) : "Cliente";

// 2. Obtenemos SOLO las reservas de este cliente usando cliente_id
$stmt = $conexion->prepare("SELECT * FROM reservas WHERE cliente_id = :cliente_id ORDER BY fecha_reserva DESC");
$stmt->execute(['cliente_id' => $_SESSION['cliente_id']]);
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center p-3 mb-4 bg-light border rounded shadow-sm">
        <div><strong>📅 Fecha:</strong> <?php echo date('d/m/Y'); ?></div>
        <div><strong>👤 Cliente:</strong> <?php echo $nombre_mostrado; ?></div>
        <div><span class="badge bg-success">Mis Reservas</span></div>
    </div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="card-title mb-0">Mis Reservas</h2>
            <a href="nueva_reserva.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> + Nueva Reserva
            </a>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Notas</th>
                    <th>Acciones</th> </tr>
            </thead>
            <tbody>
                <?php if (count($reservas) > 0): ?>
                    <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reserva['fecha_reserva']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['hora_reserva']); ?></td>
                        <td>
                            <span class="badge bg-<?php echo ($reserva['estado'] == 'confirmada') ? 'success' : 'warning'; ?>">
                                <?php echo ucfirst($reserva['estado']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($reserva['notas']); ?></td>
                        <td>
                            <a href="eliminar_reserva_cliente.php?id=<?php echo $reserva['id']; ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('¿Seguro que deseas cancelar esta reserva?');">
                               Cancelar
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">No tienes reservas registradas aún.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<?php include 'includes/footer.php'; ?>