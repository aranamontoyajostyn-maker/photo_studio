<?php
session_start();
// Blindaje de seguridad
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require_once 'config/conexion.php';

// Verificamos que venga un ID y sea numérico
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Preparamos la eliminación
    // Como configuramos ON DELETE CASCADE, esto borrará al cliente y sus reservas automáticamente
    $stmt = $conexion->prepare("DELETE FROM clientes WHERE id = :id");
    $stmt->execute(['id' => $id]);

    // Redirigimos con mensaje de éxito
    header("Location: lista_clientes.php?status=eliminado");
    exit();
} else {
    // Si algo falla, volvemos a la lista
    header("Location: lista_clientes.php");
    exit();
}
?>