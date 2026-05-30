<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">
            <h3>Nueva Reserva</h3>
            <form action="guardar_reserva.php" method="POST">
                
                <div class="mb-3">
                    <label>Fecha:</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label>Hora:</label>
                    <input type="time" name="hora" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label>Notas:</label>
                    <textarea name="notas" class="form-control"></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Reservar</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>