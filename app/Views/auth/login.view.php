<?php require_once __DIR__ . '/../layout/header.php'; ?>
<main>
<h2>Prihlásenie</h2>

<?php if (!empty($message)) : ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form action="" method="POST">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Heslo:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Prihlásiť sa</button>
</form>

<p>Nemáte účet? <a href="/Lash_reservation/public/register.php" class="register-link">Zaregistrovať sa</a></p>
</main>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
