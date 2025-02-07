<?php require_once __DIR__ . '/../layout/header.php'; ?>
<main>
<h2>Upraviť rezerváciu</h2>

<?php if (!empty($error)) : ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form action="" method="POST">
    <label for="service_id">Služba:</label>
    <select name="service_id" id="service_id" required>
        <?php foreach ($services as $service) : ?>
            <option value="<?= $service['id'] ?>" <?= $service['id'] == $reservation['service_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($service['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="reservation_date">Dátum rezervácie:</label>
    <input type="date" name="reservation_date" id="reservation_date" required value="<?= htmlspecialchars($reservation['reservation_date']) ?>">

    <label for="reservation_time">Čas rezervácie:</label>
    <input type="time" name="reservation_time" id="reservation_time" required value="<?= htmlspecialchars($reservation['reservation_time']) ?>">

    <button type="submit">Uložiť zmeny</button>
</form>

<a href="/Lash_reservation/public/reservations.php">⏪ Späť na zoznam rezervácií</a>
</main>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
