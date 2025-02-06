<?php
require_once __DIR__ . '/../core/middleware.php';

class AdminController {
    public function index() {
        requireAdmin(); // Проверяем, что пользователь – администратор
        require_once __DIR__ . '/../Views/admin_panel.view.php';
    }
}
?>
