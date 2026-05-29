<?php
/**
 * Archivo: login_proceso.php
 * Descripcion: Valida las credenciales del usuario contra la base de datos.
 */

// 1. Incluimos la conexion
require_once 'config/conexion.php';

// 2. Recibimos los datos del formulario (index.php)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // 3. Preparamos la consulta (usamos prepare para evitar inyecciones SQL)
    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = :usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(['usuario' => $usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 4. Verificamos si existe y si la contraseña coincide
    if ($user && password_verify($password, $user['password'])) {
        // Inicio de sesion exitoso
        session_start();
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php"); // Redirigimos al panel
    } else {
        // Error de acceso
        echo "Usuario o contraseña incorrectos. <a href='index.php'>Volver</a>";
    }
}
?>