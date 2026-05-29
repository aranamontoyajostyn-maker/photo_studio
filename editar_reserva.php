<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
require_once 'config/conexion.php';

// Obtenemos el ID de la reserva a editar
if (!isset($_GET['id'])) { header("Location: lista_reservas.php"); exit(); }

$stmt = $conexion->prepare("SELECT * FROM reservas WHERE id = :id");
$stmt->execute(['id' => $_GET['id']]);
$reserva = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reserva) { header("Location: lista_reservas.php"); exit(); }

include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <h2>Editar Reserva</h2>
        <form action="actualizar_reserva.php" method="POST" class="card p-4 shadow-sm">
            <input type="hidden" name="id" value="<?php echo $reserva['id']; ?>">
            
            <div class="mb-3">
                <label>Nombre del Cliente</label>
                <input type="text" name="cliente_nombre" class="form-control" value="<?php echo htmlspecialchars($reserva['cliente_nombre']); ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="cliente_email" class="form-control" value="<?php echo htmlspecialchars($reserva['cliente_email']); ?>" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Fecha</label>
                    <input type="date" name="fecha_reserva" class="form-control" value="<?php echo $reserva['fecha_reserva']; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Hora</label>
                    <input type="time" name="hora_reserva" class="form-control" value="<?php echo $reserva['hora_reserva']; ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label>Estado</label>
                <select name="estado" class="form-control">
                    <option value="pendiente" <?php echo ($reserva['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                    <option value="confirmada" <?php echo ($reserva['estado'] == 'confirmada') ? 'selected' : ''; ?>>Confirmada</option>
                    <option value="cancelada" <?php echo ($reserva['estado'] == 'cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="lista_reservas.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>