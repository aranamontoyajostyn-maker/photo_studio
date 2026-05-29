<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require_once 'config/conexion.php';

// 1. Si llega un ID, buscamos los datos del cliente
if (isset($_GET['id'])) {
    $stmt = $conexion->prepare("SELECT * FROM clientes WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        header("Location: lista_clientes.php"); // Si no existe, vuelve atrás
        exit();
    }
}

// 2. Si se envió el formulario, actualizamos la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conexion->prepare("UPDATE clientes SET nombre = :nombre, email = :email, telefono = :telefono WHERE id = :id");
    $stmt->execute([
        'nombre' => $_POST['nombre'],
        'email'  => $_POST['email'],
        'telefono' => $_POST['telefono'],
        'id'     => $_POST['id']
    ]);
    header("Location: lista_clientes.php?status=actualizado");
    exit();
}
?>

<form method="POST">
    <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
    
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
    
    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($cliente['email']); ?>">
    
    <label>Teléfono:</label>
    <input type="text" name="telefono" value="<?php echo htmlspecialchars($cliente['telefono']); ?>">
    
    <button type="submit">Guardar Cambios</button>
    <a href="lista_clientes.php">Cancelar</a>
</form>