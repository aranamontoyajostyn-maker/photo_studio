<?php
session_start();
require_once 'config/conexion.php';

// --- SEGURIDAD: Solo acceso para clientes ---
// El administrador no debería usar este archivo de inserción directa
if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin') {
    die("Los administradores no pueden hacer reservas desde aquí. <a href='lista_reservas.php'>Volver</a>");
}

// 1. Verificación de seguridad: ¿Está logueado el cliente?
if (!isset($_SESSION['cliente_id'])) {
    header("Location: index.php");
    exit();
}

// 2. Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // AQUÍ ESTÁ EL CAMBIO: Usamos cliente_id de la sesión
    $cliente_id = $_SESSION['cliente_id'];
    $fecha      = $_POST['fecha'];
    $hora       = $_POST['hora'];
    $notas      = $_POST['notas'];

    // 3. Verificación: ¿Existe este cliente en la base de datos?
    $check_stmt = $conexion->prepare("SELECT id FROM clientes WHERE id = :id");
    $check_stmt->execute(['id' => $cliente_id]);
    
    if (!$check_stmt->fetch()) {
        session_destroy();
        die("Error: Tu sesión es inválida o el cliente no existe. Por favor, <a href='index.php'>inicia sesión nuevamente</a>.");
    }

    // 4. Insertar la reserva
    $stmt = $conexion->prepare("INSERT INTO reservas (cliente_id, fecha_reserva, hora_reserva, estado, notas) 
                                VALUES (:cliente_id, :fecha, :hora, 'pendiente', :notas)");
    
    $stmt->execute([
        'cliente_id' => $cliente_id, 
        'fecha'      => $fecha,
        'hora'       => $hora,
        'notas'      => $notas
    ]);

    // 5. Redirección final
    header("Location: mis_reservas.php?status=creado");
    exit();
}
?>