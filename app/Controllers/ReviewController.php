<?php
require_once __DIR__ . '/../core/middleware.php';
require_once __DIR__ . '/../Models/Review.php';

class ReviewController {
    private $reviewModel;

    public function __construct() {
        $this->reviewModel = new Review();
    }

    public function index() {
        $userRole = $_SESSION['user']['role'] ?? null;
        $reviews = $this->reviewModel->getAllReviews();
        require_once __DIR__ . '/../Views/reviews/reviews.view.php';
    }

    public function addReview() {
        requireLogin(); // Только авторизованные пользователи могут оставлять отзывы
        $message = ""; // Инициализация переменной для сообщения

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['id']; // Получаем ID текущего пользователя
            $comment = trim($_POST['comment']); // Очищаем комментарий от лишних пробелов

            if (!empty($comment)) {
                if ($this->reviewModel->addReview($user_id, $comment)) {
                    $message = "✅ Váš názor bol pridaný!"; // Успешное добавление
                } else {
                    $message = "❌ Chyba pri pridávaní recenzie!"; // Ошибка добавления
                }
            } else {
                $message = "❌ Nemôžete odoslať prázdny komentár!"; // Пустой комментарий
            }
        }

        // Передаем сообщение в представление
        require_once __DIR__ . '/../Views/reviews/add_review.view.php';
    }


    public function deleteReview() {
        requireAdmin(); // Только админ может удалять отзывы

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_id'])) {
            $review_id = $_POST['review_id'];

            if ($this->reviewModel->deleteReview($review_id)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
        exit;
    }

    public function editReview() {
        requireAdmin();
        $message = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_id'], $_POST['comment'])) {
            $review_id = $_POST['review_id'];
            $comment = trim($_POST['comment']);

            if (!empty($comment)) {
                if ($this->reviewModel->updateReview($review_id, $comment)) {
                    $message = "✅ Recenzia bola upravená!";
                } else {
                    $message = "❌ Chyba pri upravovaní recenzie!";
                }
            } else {
                $message = "❌ Komentár nemôže byť prázdny!";
            }
        }

        // Получаем текущий отзыв для редактирования
        $review = $this->reviewModel->getReviewById($_GET['id']);
        require_once __DIR__ . '/../Views/reviews/edit_review.view.php';
    }
    public function searchReviews() {
        $author = $_POST['author'] ?? null;
        $date = $_POST['date'] ?? null;

        $reviews = $this->reviewModel->searchReviews($author, $date);

        echo json_encode(['reviews' => $reviews]);
        exit;
    }
}
?>
