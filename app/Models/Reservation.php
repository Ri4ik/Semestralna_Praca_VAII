<?php
require_once __DIR__ . '/../core/database.php';

class Reservation {
    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnection();
    }

    // Получить все бронирования
    public function getAllReservations() {
        $stmt = $this->pdo->query("SELECT 
            r.id, r.reservation_date, r.reservation_time, 
            u.name AS user_name, u.email AS user_email, 
            s.name AS service_name 
        FROM reservations r
        JOIN users u ON r.user_id = u.id
        JOIN services s ON r.service_id = s.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить бронирования пользователя
    public function getUserReservations($user_id) {
        $stmt = $this->pdo->prepare("SELECT r.id, r.reservation_date, r.reservation_time, 
                                        s.name AS service_name, 
                                        u.name AS user_name, u.email AS user_email 
                                 FROM reservations r 
                                 JOIN services s ON r.service_id = s.id 
                                 JOIN users u ON r.user_id = u.id 
                                 WHERE r.user_id = :user_id");
        // Защищаем параметр с помощью привязки
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить бронирование по ID
    public function getReservationById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM reservations WHERE id = :id");
        // Защищаем параметр с помощью привязки
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Добавить бронирование
    public function addReservation($user_id, $service_id, $reservation_date, $reservation_time) {
        $stmt = $this->pdo->prepare("INSERT INTO reservations (user_id, service_id, reservation_date, reservation_time) 
                                     VALUES (:user_id, :service_id, :reservation_date, :reservation_time)");
        // Защищаем параметры с помощью привязки
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
        $stmt->bindParam(':reservation_date', $reservation_date, PDO::PARAM_STR);
        $stmt->bindParam(':reservation_time', $reservation_time, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Обновить бронирование
    public function updateReservation($id, $service_id, $reservation_date, $reservation_time) {
        $stmt = $this->pdo->prepare("UPDATE reservations SET service_id = :service_id, reservation_date = :reservation_date, reservation_time = :reservation_time 
                                     WHERE id = :id");
        // Защищаем параметры с помощью привязки
        $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
        $stmt->bindParam(':reservation_date', $reservation_date, PDO::PARAM_STR);
        $stmt->bindParam(':reservation_time', $reservation_time, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Удалить бронирование
    public function deleteReservation($id) {
        $stmt = $this->pdo->prepare("DELETE FROM reservations WHERE id = :id");
        // Защищаем параметр с помощью привязки
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
