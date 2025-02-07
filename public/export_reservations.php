<?php
require_once __DIR__ . '/../app/Controllers/ExportController.php';
// Создаем экземпляр контроллера и вызываем метод для экспорта
$controller = new ExportController();
$controller->exportReservations();
?>
