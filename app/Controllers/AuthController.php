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
    public function register() { //Create
        $message = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') { //CREATE
            // Získavame hodnoty z POST požiadavky
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $password = trim($_POST['password']);

            // Kontrola na prázdne polia
            if (empty($name) || empty($email) || empty($phone) || empty($password)) {
                $message = "❌ Všetky polia musia byť vyplnené!";
            } else {
                // Validácia emailu (kontrola formátu)
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $message = "❌ Nesprávny formát emailu!";
                } else {
                    // Validácia telefónneho čísla (môže byť upravené podľa požadovaného formátu)
                    // Napríklad telefón musí obsahovať 10 číslic
                    if (!preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
                        $message = "❌ Nesprávny formát telefónneho čísla!";
                    } else {
                        // Kontrola, či už email existuje
                        if ($this->userModel->getUserByEmail($email)) {
                            $message = "❌ Tento email je už zaregistrovaný!";
                        } else {
                            // Vytvorenie používateľa
                            if ($this->userModel->createUser($name, $email, $phone, $password)) {
                                $message = "✅ Registrácia bola úspešná!";
                            } else {
                                $message = "❌ Chyba pri registrácii!";
                            }
                        }
                    }
                }
            }
        }

        // Pripojenie pohľadu pre registráciu
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
