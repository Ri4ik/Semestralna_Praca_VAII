<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php
$userRole = $_SESSION['user']['role'] ?? null; // Получаем роль пользователя (если авторизован)
?>

<h2>Recenzie</h2>

<!-- Форма поиска -->
<form id="search-form" action="" method="GET">
    <input type="text" id="search-author" name="search-author" placeholder="Hľadať podľa autora" />
    <input type="date" id="search-date" name="search-date" />
    <button type="submit">Hľadať</button>
</form>

<!-- Кнопка оставить отзыв (доступна всем, но редиректит неавторизованных на вход) -->
<a href="<?= isset($_SESSION['user']) ? '/Lash_reservation/public/add_review.php' : '/Lash_reservation/public/login.php'; ?>" class="btn-add-review">
    ➕ Pridať recenziu
</a>

<!-- Отображение всех отзывов -->
<div class="reviews" id="reviews-list">
    <?php foreach ($reviews as $review): ?>
        <div class="review-item" id="review-<?= $review['id']; ?>">
            <p><?= htmlspecialchars($review['comment'] ?? 'Bez textu'); ?></p>
            <p class="review-author"><?= htmlspecialchars($review['name']); ?></p>
            <p class="review-time"><?= htmlspecialchars($review['created_at']); ?></p>

            <!-- Показывать кнопки редактирования и удаления только админам -->
            <?php if ($userRole === 'admin'): ?>
                <div class="review-actions">
                    <!-- Форма для удаления -->
                    <form class="delete-form" action="" method="POST" onsubmit="deleteReview(event, <?= $review['id']; ?>)">
                        <input type="hidden" name="review_id" value="<?= $review['id']; ?>">
                        <button type="submit" class="delete-review">❌ Odstrániť</button>
                    </form>

                    <!-- Ссылка на редактирование -->
                    <a href="/Lash_reservation/public/edit_review.php?id=<?= $review['id']; ?>">✏️ Upraviť</a>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

<!-- Подключаем JavaScript файлы -->
<script src="/Lash_reservation/public/assets/js/ajax_search.js"></script>
<script src="/Lash_reservation/public/assets/js/ajax_delete.js"></script>

