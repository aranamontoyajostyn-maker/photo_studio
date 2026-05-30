<?php
session_start();
require_once 'config/conexion.php';

// --- SEGURIDAD: Solo acceso para administradores ---
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: mis_reservas.php");
    exit();
}

// Verificación de seguridad
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Obtener datos del usuario usando el ID de la tabla 'usuarios'
$stmt = $conexion->prepare("SELECT nombre_usuario FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Definimos un nombre por defecto en caso de que no encuentre al usuario
$nombre_mostrado = ($user) ? htmlspecialchars($user['nombre_usuario']) : "Usuario";

include 'includes/header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center p-3 mb-4 bg-light border rounded shadow-sm">
        <div>
            <strong>📅 Fecha:</strong> <?php echo date('d/m/Y'); ?>
        </div>
        <div>
            <strong>👤 Usuario:</strong> <?php echo $nombre_mostrado; ?>
        </div>
        <div>
            <span class="badge bg-success">Sistema Activo</span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Panel de Control</h2>
                <a href="logout.php" class="btn btn-outline-danger">Cerrar Sesión</a>
            </div>
            
            <div class="alert alert-info">
                Bienvenido, <strong><?php echo $nombre_mostrado; ?></strong>. ¡Qué bueno verte de nuevo!
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Nueva Reserva</h5>
                    <p class="card-text">Agendar un nuevo cliente.</p>
                    <a href="crear_reserva.php" class="btn btn-light">Crear Reserva</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Reservas</h5>
                    <p class="card-text">Gestionar las citas de fotografía.</p>
                    <a href="lista_reservas.php" class="btn btn-light">Ver Reservas</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Clientes</h5>
                    <p class="card-text">Ver catálogo de clientes registrados.</p>
                    <a href="lista_clientes.php" class="btn btn-light">Ver Clientes</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>