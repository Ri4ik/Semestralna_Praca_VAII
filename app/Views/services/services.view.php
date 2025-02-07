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
                <td><?= htmlspecialchars($service['name']); ?></td>
                <td><?= isset($service['description']) ? htmlspecialchars($service['description']) : 'Žiadny popis'; ?></td>
                <td><?= htmlspecialchars(number_format($service['price'], 2)); ?> €</td>
                <td><?= htmlspecialchars($service['duration']); ?> min.</td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
