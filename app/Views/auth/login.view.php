<?php require_once __DIR__ . '/../layout/header.php'; ?>
<h2>Prihlásenie</h2>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Heslo" required>
    <button type="submit">Prihlásiť sa</button>
</form>
<p><?= $message ?? ''; ?></p>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
