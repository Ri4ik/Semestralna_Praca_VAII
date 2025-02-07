<?php require_once __DIR__ . '/../layout/header.php'; ?>
<main>
<h2>Pridať recenziu</h2>

<!-- Выводим сообщение, если оно есть -->
<?php if (!empty($message)): ?>
    <p class="message"><?= htmlspecialchars($message); ?></p>
<?php endif; ?>

<!-- Форма для отзыва -->
<form action="" method="POST">
    <label for="comment">Vaša recenzia:</label>
    <textarea name="comment" id="comment" rows="4" required></textarea>

    <button type="submit">Odoslať recenziu</button>
</form>

<a href="/Lash_reservation/public/reviews.php">⏪ Späť na recenzie</a>
</main>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
