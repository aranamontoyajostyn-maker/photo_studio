<?php
/**
 * Archivo: logout.php
 * Descripcion: Destruye la sesion actual y redirige al login.
 */
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit();
?>