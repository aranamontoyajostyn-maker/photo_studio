<?php
session_start();
require_once 'config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO reservas (cliente_nombre, cliente_email, fecha_reserva, hora_reserva, notas, estado) 
            VALUES (:nombre, :email, :fecha, :hora, :notas, 'pendiente')";
    
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        'nombre' => $_POST['cliente_nombre'],
        'email'  => $_POST['cliente_email'],
        'fecha'  => $_POST['fecha_reserva'],
        'hora'   => $_POST['hora_reserva'],
        'notas'  => $_POST['notas']
    ]);

    header("Location: lista_reservas.php?exito=1");
    exit();
}
?>