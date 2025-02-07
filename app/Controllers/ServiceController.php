<?php
session_start();
require_once __DIR__ . '/../Models/Service.php';

class ServiceController {
    private $serviceModel;

    public function __construct() {
        $this->serviceModel = new Service();
    }

    public function index() {

        $services = $this->serviceModel->getAllServices();
        require_once __DIR__ . '/../Views/services/services.view.php';
    }
}
?>
