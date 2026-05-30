<?php
session_start();
// --- SEGURIDAD: Solo acceso para administradores ---
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: mis_reservas.php");
    exit();
}
if (!isset($_SESSION['user_id'])) { 
    header("Location: index.php"); 
    exit(); 
}
require_once 'config/conexion.php';

// Obtener nombre del usuario actual para la barra superior
$stmt = $conexion->prepare("SELECT nombre_usuario FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Definimos el nombre de forma segura para evitar el Warning
$nombre_mostrado = ($user && isset($user['nombre_usuario'])) ? htmlspecialchars($user['nombre_usuario']) : "Usuario";

// 1. Lógica del buscador
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

if ($busqueda != '') {
    $stmt = $conexion->prepare("SELECT * FROM clientes WHERE nombre LIKE :nombre OR email LIKE :email ORDER BY nombre ASC");
    $stmt->execute(['nombre' => '%' . $busqueda . '%', 'email' => '%' . $busqueda . '%']);
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $query = $conexion->query("SELECT * FROM clientes ORDER BY nombre ASC");
    $clientes = $query->fetchAll(PDO::FETCH_ASSOC);
}

include 'includes/header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center p-3 mb-4 bg-light border rounded shadow-sm">
        <div><strong>📅 Fecha:</strong> <?php echo date('d/m/Y'); ?></div>
        <div><strong>👤 Usuario:</strong> <?php echo $nombre_mostrado; ?></div>
        <div><span class="badge bg-success">Gestión de Clientes</span></div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-4">
                <h2>Gestión de Clientes</h2>
                <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
            </div>

            <form method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="buscar" class="form-control" 
                           placeholder="Buscar por nombre o email..." 
                           value="<?php echo htmlspecialchars($busqueda); ?>">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <a href="lista_clientes.php" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </form>

            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($clientes) > 0): ?>
                        <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['telefono']); ?></td>
                            <td>
                                <a href="editar_cliente.php?id=<?php echo $cliente['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="eliminar_cliente.php?id=<?php echo $cliente['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('¿Seguro? Se eliminarán todas sus reservas asociadas.');">Eliminar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center">No se encontraron clientes.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>