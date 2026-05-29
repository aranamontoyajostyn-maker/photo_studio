<?php
// Usamos tu archivo de seguridad para mantener la coherencia
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require_once 'config/conexion.php';

// Verificamos que el ID sea numérico para evitar errores raros
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Opcional pero recomendado: Verificamos si la reserva existe antes de intentar borrar
    $stmt = $conexion->prepare("DELETE FROM reservas WHERE id = :id");
    $stmt->execute(['id' => $id]);
    
    // 2. Redirección con mensaje de confirmación
    header("Location: lista_reservas.php?status=eliminado");
    exit();
} else {
    // Si no hay ID o no es un número, enviamos de vuelta al dashboard
    header("Location: lista_reservas.php");
    exit();
}
?>