<?php
session_start();
require_once 'config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE reservas SET 
            cliente_nombre = :nombre, 
            cliente_email = :email, 
            fecha_reserva = :fecha, 
            hora_reserva = :hora, 
            estado = :estado 
            WHERE id = :id";
            
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        'nombre' => $_POST['cliente_nombre'],
        'email'  => $_POST['cliente_email'],
        'fecha'  => $_POST['fecha_reserva'],
        'hora'   => $_POST['hora_reserva'],
        'estado' => $_POST['estado'],
        'id'     => $_POST['id']
    ]);

    header("Location: lista_reservas.php?status=actualizado");
    exit();
}
?>