<!DOCTYPE html>
<html lang="sk">
<link rel="stylesheet" href="/Lash_reservation/public/assets/css/style.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Predlžovanie rias - Domov</title>
</head>
<body>
<header>
    <h1>Predlžovanie mihalníc</h1>
    <nav>
        <ul>
            <li><a href="/Lash_reservation/public/">Domov</a></li>
            <li><a href="/Lash_reservation/public/about.php">Kde nás nájdete</a></li>
            <li><a href="/Lash_reservation/public/examples.php">Príklady prác</a></li>
            <li><a href="/Lash_reservation/public/services.php">Cenník</a></li>
            <li><a href="/Lash_reservation/public/create_reservation.php">Rezervácia</a></li>
            <li><a href="/Lash_reservation/public/reservations.php">Moje Rezervácie</a></li>
            <li><a href="/Lash_reservation/public/reviews.php">Recenzií</a></li>
        </ul>
    </nav>
    <div class="auth-icons">
        <?php if (isset($_SESSION['user'])): ?>
            <!-- Если пользователь авторизован, отображаем кнопку выхода -->
            <a href="/Lash_reservation/public/logout.php" class="auth-icon">
                <img src="/Lash_reservation/public/assets/images/logout_70dp_E6D2DC.svg" alt="Logout" />
            </a>
        <?php else: ?>
            <!-- Если пользователь не авторизован, отображаем кнопку входа -->
            <a href="/Lash_reservation/public/login.php" class="auth-icon">
                <img src="/Lash_reservation/public/assets/images/login_70dp_E6D2DC.svg" alt="Login" />
            </a>
        <?php endif; ?>
    </div>
</header>