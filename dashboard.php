<?php
session_start();

// Verificación de seguridad
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/conexion.php';

// Obtener nombre del usuario actual para saludarlo
$stmt = $conexion->prepare("SELECT nombre_usuario FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Panel de Control</h2>
            <a href="logout.php" class="btn btn-outline-danger">Cerrar Sesión</a>
        </div>
        
        <div class="alert alert-info">
            Bienvenido, <strong><?php echo htmlspecialchars($user['nombre_usuario']); ?></strong>. ¡Qué bueno verte de nuevo!
        </div>
<div class="col-md-4">
    <div class="card text-white bg-warning mb-3">
        <div class="card-body">
            <h5 class="card-title">Nueva Reserva</h5>
            <p class="card-text">Agendar un nuevo cliente.</p>
            <a href="crear_reserva.php" class="btn btn-light">Crear Reserva</a>
        </div>
    </div>
</div>
        <div class="row">
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
                        <a href="#" class="btn btn-light">Ver Clientes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>