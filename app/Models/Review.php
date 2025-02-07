<?php
require_once __DIR__ . '/../core/database.php';

class Review {
    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function getAllReviews() {
        $stmt = $this->pdo->query("SELECT reviews.id, reviews.comment, reviews.created_at, users.name 
                                   FROM reviews 
                                   JOIN users ON reviews.user_id = users.id 
                                   ORDER BY reviews.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addReview($user_id, $comment) {
        $stmt = $this->pdo->prepare("INSERT INTO reviews (user_id, comment, created_at) VALUES (?, ?, NOW())");
        return $stmt->execute([$user_id, $comment]);
    }

    public function deleteReview($id) {
        $stmt = $this->pdo->prepare("DELETE FROM reviews WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateReview($id, $comment) {
        $stmt = $this->pdo->prepare("UPDATE reviews SET comment = ? WHERE id = ?");
        return $stmt->execute([$comment, $id]);
    }
    public function getReviewById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM reviews WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchReviews($author, $date) {
        $sql = "SELECT reviews.id, reviews.comment, reviews.created_at, users.name 
            FROM reviews
            JOIN users ON reviews.user_id = users.id
            WHERE 1=1";

        if ($author) {
            $sql .= " AND users.name LIKE ?";
        }

        if ($date) {
            $sql .= " AND DATE(reviews.created_at) = ?";
        }

        $stmt = $this->pdo->prepare($sql);

        $params = [];
        if ($author) $params[] = "%$author%";
        if ($date) $params[] = $date;

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
