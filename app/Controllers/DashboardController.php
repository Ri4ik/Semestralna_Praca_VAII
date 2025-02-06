<?php
require_once __DIR__ . '/../core/middleware.php';

class DashboardController {
    public function index() {
        requireLogin();
        $user = $_SESSION['user'];
        require_once __DIR__ . '/../Views/dashboard.view.php';
    }
}
?>
