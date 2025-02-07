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

    // 📌 Метод просмотра резерваций
    public function index() {
        requireLogin();

        if ($_SESSION['user']['role'] === 'admin') {
            $reservations = $this->reservationModel->getAllReservations();
        } else {
            $reservations = $this->reservationModel->getUserReservations($_SESSION['user']['id']);
        }

        require_once __DIR__ . '/../Views/reservations/reservations.view.php';
    }

    // 📌 Метод создания резервации
    public function create() {
        requireLogin();
        $message = "";

        if ($_SESSION['user']['role'] === 'admin') {
            $users = $this->userModel->getAllUsers();
        } else {
            $users = null;
        }

        $services = $this->serviceModel->getAllServices();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//            $user_id = $_SESSION['user']['id']; // ✅ Обычный юзер создаёт резервацию только для себя
            if ($_SESSION['user']['role'] === 'admin') {
                $user_id = $_POST['user_id']; // ✅ Админ выбирает пользователя из формы
            } else {
                $user_id = $_SESSION['user']['id']; // ✅ Обычный пользователь бронирует для себя
            }
            $service_id = $_POST['service_id'] ?? null;
            $reservation_date = $_POST['reservation_date'] ?? null;
            $reservation_time = $_POST['reservation_time'] ?? null;

            // ✅ Проверка, что все поля заполнены
            if (!$service_id || !$reservation_date || !$reservation_time) {
                $message = "❌ Všetky polia musia byť vyplnené!";
            } else {
                // ✅ Проверка, что дата не в прошлом
                $now = new DateTime();
                $reservationDateTime = new DateTime("$reservation_date $reservation_time");

                if ($reservationDateTime < $now) {
                    $message = "❌ Dátum rezervácie musí byť v budúcnosti!";
                } else {
                    // ✅ Вставка в БД, если данные корректны
                    if ($this->reservationModel->addReservation($user_id, $service_id, $reservation_date, $reservation_time)) {
                        $message = "✅ Rezervácia úspešne vytvorená!";
                    } else {
                        $message = "❌ Chyba pri vytváraní rezervácie!";
                    }
                }
            }
        }

        require_once __DIR__ . '/../Views/reservations/create.view.php';
    }

    // 📌 Метод редактирования резервации
    public function edit($id) {
        requireLogin();
        $reservation = $this->reservationModel->getReservationById($id);
        $services = $this->serviceModel->getAllServices();

        // ✅ Проверяем, можно ли редактировать
        if ($_SESSION['user']['role'] !== 'admin' && $_SESSION['user']['id'] !== $reservation['user_id']) {
            die("❌ Nemáte oprávnenie na úpravu tejto rezervácie.");
        }

        // ✅ Проверяем, осталось ли больше 5 часов до услуги
        $reservationTime = new DateTime($reservation['reservation_date'] . ' ' . $reservation['reservation_time']);
        $currentTime = new DateTime();
        $difference = $currentTime->diff($reservationTime);

        if ($_SESSION['user']['role'] !== 'admin' && $difference->h < 5 && $difference->invert === 0) {
            die("❌ Rezerváciu je možné upraviť iba do 5 hodín pred termínom.");
        }

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

    // 📌 Метод удаления резервации
    public function delete($id) {
        requireLogin();
        $reservation = $this->reservationModel->getReservationById($id);

        // ✅ Проверяем, может ли пользователь удалить запись
        if ($_SESSION['user']['role'] !== 'admin' && $_SESSION['user']['id'] !== $reservation['user_id']) {
            die("❌ Nemáte oprávnenie na odstránenie tejto rezervácie.");
        }

        // ✅ Проверяем, осталось ли больше 5 часов до услуги
        // Получаем текущее время
        $now = new DateTime();

        // Формируем дату и время бронирования
        $reservationDateTime = new DateTime($reservation['reservation_date'] . ' ' . $reservation['reservation_time']);

        // Вычисляем разницу во времени
        $difference = $now->diff($reservationDateTime);
        $differenceInHours = ($difference->days * 24) + $difference->h;

        // Проверяем, можно ли удалить
        if ($reservationDateTime > $now && $differenceInHours < 5) {
            echo "❌ Rezerváciu je možné odstrániť iba do 5 hodín pred termínom.";
            return;
        }

        if ($this->reservationModel->deleteReservation($id)) {
            header("Location: /Lash_reservation/public/reservations.php");
            exit;
        } else {
            echo "❌ Chyba pri odstraňovaní rezervácie!";
        }
    }
}
?>
