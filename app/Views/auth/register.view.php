<?php require_once __DIR__ . '/../layout/header.php'; ?>
<h2>Registrácia</h2>
<form method="POST">
    <input type="text" name="name" placeholder="Meno" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Telefón" required>
    <input type="password" name="password" placeholder="Heslo" required>
    <button type="submit">Registrovať</button>
</form>
<p><?= $message ?? ''; ?></p>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
