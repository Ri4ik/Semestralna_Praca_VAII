<?php require_once __DIR__ . '/../layout/header.php'; ?>
<main>
<h2>Registrácia</h2>

<?php if (!empty($message)) : ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form action="" method="POST">
    <label for="name">Meno:</label>
    <input type="text" name="name" id="name" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="phone">Telefón:</label>
    <input type="text" name="phone" id="phone" required>

    <label for="password">Heslo:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Zaregistrovať sa</button>
</form>

<p>Máte už účet? <a href="/Lash_reservation/public/login.php" class="login-link">Prihlásiť sa</a></p>
</main>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
