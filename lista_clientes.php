<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
require_once 'config/conexion.php';

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

<?php include 'includes/footer.php'; ?>