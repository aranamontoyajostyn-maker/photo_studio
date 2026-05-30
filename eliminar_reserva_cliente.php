<?php
session_start();
require_once 'config/conexion.php';

// Seguridad básica
if (!isset($_SESSION['cliente_id']) || !isset($_GET['id'])) {
    header("Location: mis_reservas.php");
    exit();
}

// Borramos SOLO si la reserva pertenece al cliente logueado
$stmt = $conexion->prepare("DELETE FROM reservas WHERE id = :id AND cliente_id = :cliente_id");
$stmt->execute([
    'id' => $_GET['id'],
    'cliente_id' => $_SESSION['cliente_id']
]);

header("Location: mis_reservas.php?status=eliminado");
exit();
?>