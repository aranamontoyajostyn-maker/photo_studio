<?php
require_once 'config/conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_input = $_POST['usuario'];
    $password_input = $_POST['password'];

    // Consulta incluyendo 'id' (de usuarios) y 'cliente_id'
    $sql = "SELECT id, password, rol, cliente_id, nombre_usuario FROM usuarios WHERE nombre_usuario = :usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(['usuario' => $usuario_input]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Comparación simple
    if ($user && $password_input === $user['password']) {
        session_regenerate_id(true); 
        
        // --- CAMBIOS AQUÍ ---
        $_SESSION['user_id']    = $user['id'];         // ID de la tabla 'usuarios' (Para Dashboard)
        $_SESSION['cliente_id'] = $user['cliente_id']; // ID de la tabla 'clientes' (Para Reservas)
        $_SESSION['rol']        = $user['rol'];
        $_SESSION['user_name']  = $user['nombre_usuario'];

        // Redirección
        if ($user['rol'] == 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: mis_reservas.php");
        }
        exit();
    } else {
        echo "Error: Usuario o contraseña incorrecta.";
        echo "<br><a href='index.php'>Volver al inicio</a>";
    }
} else {
    header("Location: index.php");
    exit();
}
?>