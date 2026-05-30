<?php
session_start();
// --- SEGURIDAD: Solo acceso para administradores ---
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    // Si no es admin, lo sacamos de aquí y lo mandamos a la vista de cliente
    header("Location: mis_reservas.php");
    exit();
}
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
require_once 'config/conexion.php';

// Obtener nombre del usuario actual para la barra superior
$stmt_user = $conexion->prepare("SELECT nombre_usuario FROM usuarios WHERE id = :id");
$stmt_user->execute(['id' => $_SESSION['user_id']]);
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

// 1. Si llega un ID, buscamos los datos del cliente
if (isset($_GET['id'])) {
    $stmt = $conexion->prepare("SELECT * FROM clientes WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        header("Location: lista_clientes.php");
        exit();
    }
} else {
    header("Location: lista_clientes.php");
    exit();
}

// 2. Si se envió el formulario, actualizamos la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conexion->prepare("UPDATE clientes SET nombre = :nombre, email = :email, telefono = :telefono WHERE id = :id");
    $stmt->execute([
        'nombre'   => $_POST['nombre'],
        'email'    => $_POST['email'],
        'telefono' => $_POST['telefono'],
        'id'       => $_POST['id']
    ]);
    header("Location: lista_clientes.php?status=actualizado");
    exit();
}

include 'includes/header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center p-3 mb-4 bg-light border rounded shadow-sm">
        <div><strong>📅 Fecha:</strong> <?php echo date('d/m/Y'); ?></div>
        <div><strong>👤 Usuario:</strong> <?php echo htmlspecialchars($user['nombre_usuario']); ?></div>
        <div><span class="badge bg-primary">Edición de Cliente</span></div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title mb-4">Editar Cliente</h2>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Nombre:</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($cliente['email']); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Teléfono:</label>
                            <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($cliente['telefono']); ?>">
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            <a href="lista_clientes.php" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>