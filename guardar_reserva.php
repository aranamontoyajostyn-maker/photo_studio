<?php
require_once 'config/conexion.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $fecha = $_POST['fecha'];

    // 1. Buscar si el cliente existe
    $stmt = $conexion->prepare("SELECT id FROM clientes WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $cliente = $stmt->fetch();

    if ($cliente) {
        $cliente_id = $cliente['id'];
    } else {
        // 2. Si no existe, crearlo
        $stmt = $conexion->prepare("INSERT INTO clientes (nombre, email) VALUES (:nombre, :email)");
        $stmt->execute(['nombre' => $nombre, 'email' => $email]);
        $cliente_id = $conexion->lastInsertId();
    }

    // 3. Insertar la reserva con el cliente_id
    $stmt = $conexion->prepare("INSERT INTO reservas (cliente_id, fecha) VALUES (:cliente_id, :fecha)");
    $stmt->execute(['cliente_id' => $cliente_id, 'fecha' => $fecha]);

    header("Location: lista_reservas.php?status=creado");
    exit();
}
?>