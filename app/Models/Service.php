<?php
require_once __DIR__ . '/../core/database.php';

class Service {
    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnection();
    }

    // Получить все услуги
    public function getAllServices() {
        $stmt = $this->pdo->query("SELECT id, name, description, price, duration FROM services");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить услугу по ID
    public function getServiceById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Создать новую услугу
    public function createService($name, $description, $price, $duration) {
        $stmt = $this->pdo->prepare("INSERT INTO services (name, description, price, duration) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $description, $price, $duration]);
    }

    // Обновить услугу
    public function updateService($id, $name, $description, $price, $duration) {
        $stmt = $this->pdo->prepare("UPDATE services SET name = ?, description = ?, price = ?, duration = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $price, $duration, $id]);
    }

    // Удалить услугу
    public function deleteService($id) {
        $stmt = $this->pdo->prepare("DELETE FROM services WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
