<?php
require_once __DIR__ . '/../app/Controllers/ExportController.php';
$controller = new ExportController();
$controller->exportReservations();
?>
