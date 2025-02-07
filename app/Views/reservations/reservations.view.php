<?php require_once __DIR__ . '/../layout/header.php'; ?>
<main>
<h2>Moje rezervácie</h2>
<a href="/Lash_reservation/public/create_reservation.php">➕ Nová rezervácia</a>

<table border="1" style="border-collapse: collapse; width: 100%; text-align: center;">
    <tr>
        <th>Užívateľ</th>
        <th>Email</th>
        <th>Služba</th>
        <th>Dátum</th>
        <th>Čas</th>
        <th>Akcie</th>
    </tr>
    <?php foreach ($reservations as $reservation): ?>
        <tr>
            <td><?= htmlspecialchars($reservation['user_name']); ?></td>
            <td><?= htmlspecialchars($reservation['user_email']); ?></td>
            <td><?= htmlspecialchars($reservation['service_name']); ?></td>
            <td><?= htmlspecialchars($reservation['reservation_date']); ?></td>
            <td><?= htmlspecialchars($reservation['reservation_time']); ?></td>
            <td>
                <a href="/Lash_reservation/public/edit_reservation.php?id=<?= $reservation['id']; ?>">✏️ Upraviť</a>
                <a href="/Lash_reservation/public/delete_reservation.php?id=<?= $reservation['id']; ?>" onclick="return confirm('Naozaj chcete odstrániť túto rezerváciu?')">❌ Odstrániť</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</main>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
