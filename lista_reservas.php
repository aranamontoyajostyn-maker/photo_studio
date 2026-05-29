<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/conexion.php';

// 1. Lógica del Buscador
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

if ($busqueda != '') {
    // Si hay búsqueda, filtramos por nombre del cliente usando LIKE
    $sql = "SELECT reservas.*, clientes.nombre AS nombre_cliente 
            FROM reservas 
            JOIN clientes ON reservas.cliente_id = clientes.id 
            WHERE clientes.nombre LIKE :nombre 
            ORDER BY reservas.fecha_reserva ASC";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(['nombre' => '%' . $busqueda . '%']);
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Si no hay búsqueda, traemos todas (tu código original)
    $sql = "SELECT reservas.*, clientes.nombre AS nombre_cliente 
            FROM reservas 
            JOIN clientes ON reservas.cliente_id = clientes.id 
            ORDER BY reservas.fecha_reserva ASC";
    $query = $conexion->query($sql);
    $reservas = $query->fetchAll(PDO::FETCH_ASSOC);
}

include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between mb-4">
            <h2>Gestión de Reservas</h2>
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>

        <form method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="buscar" class="form-control" 
                       placeholder="Buscar por nombre de cliente..." 
                       value="<?php echo htmlspecialchars($busqueda); ?>">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="lista_reservas.php" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th> 
                </tr>
            </thead>
            <tbody>
                <?php if (count($reservas) > 0): ?>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reserva['nombre_cliente']); ?></td>
                            <td><?php echo htmlspecialchars($reserva['fecha_reserva']); ?></td>
                            <td><?php echo htmlspecialchars($reserva['hora_reserva']); ?></td>
                            <td><span class="badge bg-info"><?php echo $reserva['estado']; ?></span></td>
                            <td>
                                <a href="editar_reserva.php?id=<?php echo $reserva['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="eliminar_reserva.php?id=<?php echo $reserva['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('¿Estás seguro de eliminar esta reserva?');">
                                   Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">No se encontraron reservas con ese nombre.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>