<?php
require_once __DIR__ . '/../core/middleware.php';
require_once __DIR__ . '/../Models/Reservation.php';
require_once __DIR__ . '/../Models/Service.php';
require_once __DIR__ . '/../Models/User.php';
class ReservationController {
    private $db;
    private $userModel;
    private $serviceModel;
    private $reservationModel;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->userModel = new User();
        $this->serviceModel = new Service();
        $this->reservationModel = new Reservation();
    }

    public function index() {
        requireLogin();
        $reservations = $this->reservationModel->getAllReservations();
        require_once __DIR__ . '/../Views/reservations/reservations.view.php';
    }

    public function create() {
        requireLogin();
        // ✅ Проверяем, инициализированы ли переменные
        if (!$this->userModel || !$this->serviceModel) {
            die("❌ Chyba: UserModel alebo ServiceModel nie sú dostupné.");
        }

        $users = $this->userModel->getAllUsers();
        $services = $this->serviceModel->getAllServices();
        $message = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'] ?? null;
            $service_id = $_POST['service_id'] ?? null;
            $reservation_date = $_POST['reservation_date'] ?? null;
            $reservation_time = $_POST['reservation_time'] ?? null;
            $message = "";

            // Проверка, чтобы все поля были заполнены
            if (!$user_id || !$service_id || !$reservation_date || !$reservation_time) {
                $message = "❌ Všetky polia musia byť vyplnené!";
            } else {
                // Проверка, что дата не в прошлом
                $today = new DateTime();
                $selectedDate = new DateTime($reservation_date);
                if ($selectedDate < $today) {
                    $message = "❌ Dátum rezervácie musí byť v budúcnosti!";
                } else {
                    // Вставка в БД, если данные корректны
                    $stmt = $this->db->prepare("INSERT INTO reservations (user_id, service_id, reservation_date, reservation_time) VALUES (?, ?, ?, ?)");
                    if ($stmt->execute([$user_id, $service_id, $reservation_date, $reservation_time])) {
                        $message = "✅ Rezervácia úspešne vytvorená!";
                    } else {
                        $message = "❌ Chyba pri vytváraní rezervácie!";
                    }
                }
            }
        }

        require_once __DIR__ . '/../Views/reservations/create.view.php';
    }

    public function edit($id) {
        requireLogin();
        $reservation = $this->reservationModel->getReservationById($id);
        $services = $this->serviceModel->getAllServices(); // ✅ Добавлено

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service_id = $_POST['service_id'];
            $reservation_date = $_POST['reservation_date'];
            $reservation_time = $_POST['reservation_time'];

            if ($this->reservationModel->updateReservation($id, $service_id, $reservation_date, $reservation_time)) {
                header("Location: /Lash_reservation/public/reservations.php");
                exit;
            } else {
                $error = "❌ Chyba pri aktualizácii rezervácie!";
            }
        }

        require_once __DIR__ . '/../Views/reservations/edit.view.php';
    }


    public function delete($id) {
        requireLogin();
        if ($this->reservationModel->deleteReservation($id)) {
            header("Location: /Lash_reservation/public/reservations.php");
            exit;
        } else {
            echo "❌ Chyba pri odstraňovaní rezervácie!";
        }
    }
}
?>
