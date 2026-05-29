<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <h2>Nueva Reserva</h2>
        <form action="guardar_reserva.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label>Nombre del Cliente</label>
                <input type="text" name="cliente_nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="cliente_email" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Fecha</label>
                    <input type="date" name="fecha_reserva" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Hora</label>
                    <input type="time" name="hora_reserva" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label>Notas</label>
                <textarea name="notas" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Guardar Reserva</button>
            <a href="lista_reservas.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>