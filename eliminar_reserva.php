<?php
session_start();
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