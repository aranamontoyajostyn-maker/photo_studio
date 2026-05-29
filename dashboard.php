<?php
/**
 * Archivo: dashboard.php
 * Descripcion: Panel principal del sistema. 
 * Solo accesible para usuarios autenticados.
 */
session_start();

// Verificacion de seguridad: si no hay sesion, redirigir al login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Bienvenido al Panel de Control</h2>
        <p>Has iniciado sesión correctamente en el sistema de reservas de Photo Studio.</p>
        
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Acciones rápidas</h5>
                <p>Desde aquí podrás gestionar tus citas y clientes próximamente.</p>
                <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>