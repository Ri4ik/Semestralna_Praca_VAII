<?php
require_once __DIR__ . '/../core/middleware.php';

class HomeController {
    public function index() { //READ
        require_once __DIR__ . '/../Views/pages/home.view.php';
    }
}
?>
