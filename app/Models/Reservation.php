<?php
require_once __DIR__ . '/../core/database.php';

class Reservation {
    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function getAllReservations() {
        $stmt = $this->pdo->query("SELECT reservations.*, users.name AS user_name, services.name AS service_name 
                                   FROM reservations 
                                   JOIN users ON reservations.user_id = users.id 
                                   JOIN services ON reservations.service_id = services.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReservationById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM reservations WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addReservation($user_id, $service_id, $reservation_date, $reservation_time) {
        $stmt = $this->pdo->prepare("INSERT INTO reservations (user_id, service_id, reservation_date, reservation_time) 
                                     VALUES (?, ?, ?, ?)");
        return $stmt->execute([$user_id, $service_id, $reservation_date, $reservation_time]);
    }

    public function updateReservation($id, $service_id, $reservation_date, $reservation_time) {
        $stmt = $this->pdo->prepare("UPDATE reservations SET service_id = ?, reservation_date = ?, reservation_time = ? 
                                     WHERE id = ?");
        return $stmt->execute([$service_id, $reservation_date, $reservation_time, $id]);
    }

    public function deleteReservation($id) {
        $stmt = $this->pdo->prepare("DELETE FROM reservations WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
