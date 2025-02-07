<?php require_once __DIR__ . '/../layout/header.php'; ?>
<main>
<h2>Upraviť recenziu</h2>

<!-- Выводим сообщение об успешном/неуспешном редактировании -->
<?php if (!empty($message)): ?>
    <p><?= htmlspecialchars($message); ?></p>
<?php endif; ?>

<!-- Форма редактирования отзыва -->
<form action="/Lash_reservation/public/edit_review.php?id=<?= $review['id']; ?>" method="POST">
    <input type="hidden" name="review_id" value="<?= $review['id']; ?>">
    <textarea name="comment" rows="4" required><?= htmlspecialchars($review['comment']); ?></textarea>
    <button type="submit">Upraviť</button>
</form>

<a href="/Lash_reservation/public/reviews.php">⏪ Späť na recenzie</a>
</main>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
