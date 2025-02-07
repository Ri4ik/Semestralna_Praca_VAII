<?php require_once __DIR__ . '/layout/header.php'; ?>
<main>
<h2>Vitaj, <?= htmlspecialchars($user['name']); ?>!</h2>
<p>Email: <?= htmlspecialchars($user['email']); ?></p>
<p>Rola: <?= htmlspecialchars($user['role']); ?></p>

<?php if ($user['role'] === 'admin'): ?>
    <p><a href="/Lash_reservation/public/admin_panel.php">➡ Administrátorský panel</a></p>
<?php endif; ?>

<p><a href="/Lash_reservation/public/logout.php">🚪 Odhlásiť sa</a></p>
</main>
<?php require_once __DIR__ . '/layout/footer.php'; ?>
