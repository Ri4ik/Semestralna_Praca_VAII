<?php require_once __DIR__ . '/../layout/header.php'; ?>
<main>
    <h2>Naše služby</h2>

    <table border="1">
        <tr>
            <th>Názov služby</th>
            <th>Popis</th>
            <th>Cena (€)</th>
            <th>Trvanie (min.)</th>
        </tr>
        <?php foreach ($services as $service): ?>
            <tr>
                <td data-label="Názov služby"><?= htmlspecialchars($service['name']); ?></td>
                <td data-label="Popis"><?= isset($service['description']) ? htmlspecialchars($service['description']) : 'Žiadny popis'; ?></td>
                <td data-label="Cena"><?= htmlspecialchars(number_format($service['price'], 2)); ?> €</td>
                <td data-label="Trvanie"><?= htmlspecialchars($service['duration']); ?> min.</td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
