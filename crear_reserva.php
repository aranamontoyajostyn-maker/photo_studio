<?php
session_start();
require_once 'config/conexion.php';

// --- SEGURIDAD: Solo acceso para administradores ---
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: mis_reservas.php");
    exit();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Obtener nombre del usuario actual
$stmt = $conexion->prepare("SELECT nombre_usuario FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Definimos el nombre de forma segura
$nombre_mostrado = ($user && isset($user['nombre_usuario'])) ? htmlspecialchars($user['nombre_usuario']) : "Usuario";

include 'includes/header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center p-3 mb-4 bg-light border rounded shadow-sm">
        <div><strong>📅 Fecha:</strong> <?php echo date('d/m/Y'); ?></div>
        <div><strong>👤 Usuario:</strong> <?php echo $nombre_mostrado; ?></div>
        <div><span class="badge bg-warning text-dark">Nueva Reserva</span></div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title mb-4">Nueva Reserva</h2>
                    <form action="guardar_reserva.php" method="POST">
                        <div class="mb-3">
                            <label>Nombre del Cliente</label>
                            <input type="text" name="cliente_nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="cliente_email" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Fecha</label>
                                <input type="date" name="fecha_reserva" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Hora</label>
                                <input type="time" name="hora_reserva" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Notas</label>
                            <textarea name="notas" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Guardar Reserva</button>
                        <a href="lista_reservas.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>