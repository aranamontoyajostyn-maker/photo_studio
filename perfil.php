<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
require_once 'config/conexion.php';

// Obtener datos actuales del usuario
$stmt = $conexion->prepare("SELECT nombre_usuario, email FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center p-3 mb-4 bg-light border rounded shadow-sm">
        <div><strong>📅 Fecha:</strong> <?php echo date('d/m/Y'); ?></div>
        <div><strong>👤 Usuario:</strong> <?php echo htmlspecialchars($usuario['nombre_usuario']); ?></div>
        <div><span class="badge bg-secondary">Configuración de Perfil</span></div>
    </div>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title mb-4">Mi Perfil</h2>
                    <form action="actualizar_perfil.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre_usuario']); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nueva Contraseña (dejar en blanco para no cambiar)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>