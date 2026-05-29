<?php
/**
 * Archivo: conexion.php
 * Descripcion: Gestiona la conexion a la base de datos MySQL mediante PDO.
 * Este archivo se incluye en todos los modulos que requieren acceso a datos.
 */

// Configuracion de parametros de conexion
$host = 'localhost';
$dbname = 'photo_studio';
$usuario = 'root';
$password = '';

try {
    // Inicializacion del objeto PDO para la gestion de la base de datos
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $password);
    
    // Configuracion del modo de error para capturar excepciones
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // Notificacion de error en caso de fallo en la comunicacion con el servidor
    error_log("Error de conexion a la base de datos: " . $e->getMessage());
    die("Lo sentimos, no se pudo establecer la conexion con el servidor.");
}
?>