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
        // Защита от SQL Injection с использованием подготовленного выражения
        $stmt = $this->pdo->prepare("SELECT id, name, description, price, duration FROM services WHERE id = :id");
        // Привязка параметра :id
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Создать новую услугу
    public function createService($name, $description, $price, $duration) {
        // Используем подготовленное выражение для вставки данных
        $stmt = $this->pdo->prepare("INSERT INTO services (name, description, price, duration) VALUES (:name, :description, :price, :duration)");
        // Привязываем параметры
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Обновить услугу
    public function updateService($id, $name, $description, $price, $duration) {
        // Используем подготовленное выражение для обновления данных
        $stmt = $this->pdo->prepare("UPDATE services SET name = :name, description = :description, price = :price, duration = :duration WHERE id = :id");
        // Привязываем параметры
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Удалить услугу
    public function deleteService($id) {
        // Используем подготовленное выражение для удаления данных
        $stmt = $this->pdo->prepare("DELETE FROM services WHERE id = :id");
        // Привязываем параметр :id
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
