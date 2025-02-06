<?php
//$config = require dirname(__DIR__) . '/Lash_reservation/config/config.php';
$config = require dirname(__DIR__) . '/Lash_reservation/app/core/database.php';

try {
    $db = Database::getInstance()->getConnection();
    echo "✅ Pripojenie k databáze je úspešné!";
} catch (PDOException $e) {
    echo "❌ Chyba pripojenia: " . $e->getMessage();
}
?>
