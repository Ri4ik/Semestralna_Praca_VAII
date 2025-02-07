<?php
session_start();
require_once __DIR__ . '/../Models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        $message = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $message = $this->authenticate($email, $password);
        }

        require_once __DIR__ . '/../Views/auth/login.view.php';
    }
    public function register() {
        $message = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];

            if ($this->userModel->getUserByEmail($email)) {
                $message = "❌ Email už existuje!";
            } else {
                if ($this->userModel->createUser($name, $email, $phone, $password)) {
                    $message = "✅ Registrácia úspešná!";
                } else {
                    $message = "❌ Chyba registrácie!";
                }
            }
        }
//        $viewPath = realpath(__DIR__ . '/../Views/auth/register.view.php');
//        if (!$viewPath) {
//            die("❌ Ошибка: Файл register.view.php не найден. Проверяем путь: " . __DIR__ . '/../Views/auth/register.view.php');
//        }
//        require_once $viewPath;
        require_once realpath(__DIR__ . '/../Views/auth/register.view.php');

    }
    private function authenticate($email, $password) {
        $user = $this->userModel->verifyPassword($email, $password);
        if ($user) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
//            return "✅ Prihlásenie úspešné!";
            header("Location: /Lash_reservation/public/index.php");
            exit;
        }
        return "❌ Nesprávny email alebo heslo!";
    }

    public function logout() {
        session_destroy();
        session_unset();
        header("Location: /Lash_reservation/public/login.php");
        exit;
    }
}
?>
