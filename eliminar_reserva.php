<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require_once 'config/conexion.php';

if (isset($_GET['id'])) {
    $stmt = $conexion->prepare("DELETE FROM reservas WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    
    header("Location: lista_reservas.php?status=eliminado");
    exit();
} else {
    header("Location: lista_reservas.php");
    exit();
}
?>