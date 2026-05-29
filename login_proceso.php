<?php
require_once 'config/conexion.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_input = $_POST['usuario'];
    $password_input = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = :usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(['usuario' => $usuario_input]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // CAMBIO: Comparación simple sin encriptación
    if ($user && password_verify($password_input, $user['password'])) {
    session_regenerate_id(true); // Evita ataques de fijación de sesión
    $_SESSION['user_id'] = $user['id'];
    header("Location: dashboard.php");
    exit();
}
    } else {
        echo "Error: Usuario no encontrado o contraseña incorrecta.";
        echo "<br><a href='index.php'>Volver</a>";
    }

?>