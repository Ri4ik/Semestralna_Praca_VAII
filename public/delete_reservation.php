<?php
require_once __DIR__ . '/../app/Controllers/ReservationController.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $controller = new ReservationController();
    $controller->delete($id);
} else {
    header("Location: /Lash_reservation/public/reservations.php");
}
?>
