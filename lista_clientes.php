<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
require_once 'config/conexion.php';
include 'includes/header.php';

$query = $conexion->query("SELECT * FROM clientes ORDER BY nombre ASC");
$clientes = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Gestión de Clientes</h2>
<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clientes as $cliente): ?>
        <tr>
            <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
            <td><?php echo htmlspecialchars($cliente['email']); ?></td>
            <td><?php echo htmlspecialchars($cliente['telefono']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'includes/footer.php'; ?>