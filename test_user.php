<?php
require_once 'app/Models/User.php';

$userModel = new User();

// Тест: создаём нового пользователя
$userModel->createUser("Test User", "test@example.com", "+421900123456", "password123");

// Тест: получаем пользователя
$user = $userModel->getUserByEmail("test@example.com");
echo "<pre>";
print_r($user);
echo "</pre>";

// Тест: проверка пароля
if ($userModel->verifyPassword("test@example.com", "password123")) {
    echo "✅ Пароль верный!";
} else {
    echo "❌ Неверный пароль!";
}
?>
