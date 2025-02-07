<?php
require_once __DIR__ . '/../core/middleware.php';

class ExamplesController {
    public function index() {
        require_once __DIR__ . '/../Views/pages/example.view.php';
    }
}
?>
