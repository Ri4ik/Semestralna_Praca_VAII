<?php
require_once __DIR__ . '/../core/database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Создать нового пользователя
    public function createUser($name, $email, $phone, $password, $role = 'client') {
        // Хешируем пароль перед сохранением
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);  ///////////////////////////PASSWORD_BCRYPT////////////////////////////

        // Используем подготовленное выражение
        $sql = "INSERT INTO users (name, email, phone, password, role) 
                VALUES (:name, :email, :phone, :password, :role)";
        $stmt = $this->db->prepare($sql);

        // Привязываем параметры с безопасной обработкой
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);

        // Выполняем запрос и возвращаем результат
        return $stmt->execute();
    }

    // Получить всех пользователей
    public function getAllUsers() {
        $stmt = $this->db->query("SELECT id, name, email FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить пользователя по email
    public function getUserByEmail($email) {
        // Используем подготовленное выражение для защиты от SQL Injection
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);

        // Привязываем параметр email
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();
    }

    // Проверить пароль
    public function verifyPassword($email, $password) {
        // Получаем пользователя по email
        $user = $this->getUserByEmail($email);

        // Если пользователь найден и пароль совпадает, возвращаем пользователя, иначе false
        return ($user && password_verify($password, $user['password'])) ? $user : false;   ////////////////////password_verify///////////////////
    }
}
?>
