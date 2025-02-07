<?php
require_once __DIR__ . '/../app/Controllers/ReviewController.php';

$controller = new ReviewController();
$controller->deleteReview(); // Контроллер сам проверит, что это POST запрос с правильными данными
?>
?>
