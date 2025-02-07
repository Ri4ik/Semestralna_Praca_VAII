<?php require_once __DIR__ . '/../layout/header.php'; ?>
<main>
<script src="/Lash_reservation/public/assets/js/validation.js"></script>
<h2>Vytvorenie rezervácie</h2>

<?php if (!empty($message)) : ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form action="" method="POST">
    <?php if ($_SESSION['user']['role'] === 'admin') : ?>
        <label for="user_id">Používateľ:</label>
        <select name="user_id" id="user_id" required>
            <?php foreach ($users as $user) : ?>
                <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['email']) ?></option>
            <?php endforeach; ?>
        </select>
    <?php else : ?>
        <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?>">
    <?php endif; ?>

    <label for="service_id">Služba:</label>
    <select name="service_id" id="service_id" required>
        <?php foreach ($services as $service) : ?>
            <option value="<?= $service['id'] ?>"><?= htmlspecialchars($service['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="reservation_date">Dátum rezervácie:</label>
    <input type="date" name="reservation_date" id="reservation_date" required>

    <label for="reservation_time">Čas rezervácie:</label>
    <input type="time" name="reservation_time" id="reservation_time" required>

    <button type="submit">Vytvoriť rezerváciu</button>
</form>

</main>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
