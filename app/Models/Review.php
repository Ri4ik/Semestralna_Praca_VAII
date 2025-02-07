<?php
require_once __DIR__ . '/../core/database.php';

class Review {
    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnection();
    }

    // Получить все отзывы
    public function getAllReviews() {
        $stmt = $this->pdo->query("SELECT reviews.id, reviews.comment, reviews.created_at, users.name 
                                   FROM reviews 
                                   JOIN users ON reviews.user_id = users.id 
                                   ORDER BY reviews.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Добавить новый отзыв
    public function addReview($user_id, $comment) {
        $stmt = $this->pdo->prepare("INSERT INTO reviews (user_id, comment, created_at) VALUES (:user_id, :comment, NOW())");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Удалить отзыв
    public function deleteReview($id) {
        $stmt = $this->pdo->prepare("DELETE FROM reviews WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Обновить отзыв
    public function updateReview($id, $comment) {
        $stmt = $this->pdo->prepare("UPDATE reviews SET comment = :comment WHERE id = :id");
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Получить отзыв по ID
    public function getReviewById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM reviews WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Поиск отзывов по автору и дате
    public function searchReviews($author, $date) {
        $sql = "SELECT reviews.id, reviews.comment, reviews.created_at, users.name 
                FROM reviews
                JOIN users ON reviews.user_id = users.id
                WHERE 1=1";

        if ($author) {
            $sql .= " AND users.name LIKE :author";
        }

        if ($date) {
            $sql .= " AND DATE(reviews.created_at) = :date";
        }

        $stmt = $this->pdo->prepare($sql);

        $params = [];
        if ($author) {
            $params[':author'] = "%$author%";  // Используем LIKE для поиска по автору
        }
        if ($date) {
            $params[':date'] = $date;  // Устанавливаем параметр для даты
        }

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
