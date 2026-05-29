<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
require_once 'config/conexion.php';
include 'includes/header.php';

// Obtener datos actuales del usuario
$stmt = $conexion->prepare("SELECT username, email FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$usuario = $stmt->fetch();
?>

<div class="row">
    <div class="col-md-6 offset-md-3">
        <h2>Mi Perfil</h2>
        <form action="actualizar_perfil.php" method="POST" class="card p-4">
            <div class="mb-3">
                <label>Nombre de Usuario</label>
                <input type="text" class="form-control" value="<?php echo $usuario['username']; ?>" disabled>
            </div>
            <div class="mb-3">
                <label>Nueva Contraseña (dejar en blanco para no cambiar)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>