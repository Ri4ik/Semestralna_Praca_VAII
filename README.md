# Inštrukcia na inštaláciu projektu "Lash Reservation"

Pre správne fungovanie vášho projektu "Lash Reservation" postupujte podľa nasledujúcich krokov. Tento návod predpokladá použitie lokálneho servera (napr. XAMPP) a databázy MySQL.

---

## 1. Inštalácia XAMPP
1. **Stiahnite XAMPP** z oficiálnej stránky: [https://www.apachefriends.org/](https://www.apachefriends.org/).
2. **Nainštalujte XAMPP** na váš počítač a spustite aplikáciu.
3. **Spustite Apache a MySQL** cez ovládací panel XAMPP.

---

## 2. Nastavenie a konfigurácia databázy
1. **Otvorenie PHPMyAdmin**: Otvorte prehliadač a navštívte adresu [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/).
2. **Vytvorenie databázy**:
    - Kliknite na **Nová** vľavo hore a zadajte názov databázy, napríklad `Lash_reservation`.
    - Kliknite na **Vytvoriť**.
3. **Importovanie migrácií**:
    - Prejdite na kartu **Importovať**.
    - Vyberte súbor `migrations.sql` z vášho projektu a kliknite na **Spustiť**.
4. **Skontrolujte, či boli tabuľky úspešne vytvorené**: Uistite sa, že tabuľky ako `users`, `services`, `reservations` a `reviews` boli úspešne importované.

---

## 3. Nastavenie konfigurácie projektu
1. **Nastavenie pripojenia k databáze**:
    - Otvorte súbor `config/config.php`.
    - Uistite sa, že údaje o databáze (host, názov, používateľ, heslo) sú správne.
   ```php
   return [
       'db_host' => 'localhost',
       'db_name' => 'Lash_reservation',
       'db_user' => 'root',
       'db_pass' => '1234',  // Zmeňte heslo podľa potreby
       'db_charset' => 'utf8mb4'
   ];
## 4. Nastavenie databázy

1. Vytvorte databázu a požadované tabuľky pomocou priloženého SQL skriptu. Použite nástroj ako phpMyAdmin alebo príkazový riadok:
    ```sql
    -- Vytvorenie databázy
    CREATE DATABASE IF NOT EXISTS lash_reservation CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
    USE lash_reservation;

    -- Tabuľka používateľov
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        phone VARCHAR(20) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'client') DEFAULT 'client'
    );

    -- Tabuľka služieb
    CREATE TABLE services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        category ENUM('predĺženie', 'oprava', 'odstránenie') NOT NULL,
        description TEXT,
        price DECIMAL(10, 2) NOT NULL,
        duration INT NOT NULL
    );

    -- Tabuľka rezervácií (M:N users ↔ services)
    CREATE TABLE reservations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        service_id INT NOT NULL,
        reservation_date DATE NOT NULL,
        reservation_time TIME NOT NULL,
        status ENUM('pending', 'confirmed', 'canceled') DEFAULT 'pending',
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE
    );

    -- Tabuľka recenzií
    CREATE TABLE reviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        service_id INT NOT NULL,
        review_text TEXT NOT NULL,
        rating INT CHECK (rating BETWEEN 1 AND 5),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE
    );

    -- Počiatočné údaje
    INSERT INTO users (name, email, phone, password, role) VALUES
        ('Admin', 'admin@example.com', '+421900123456', '$2y$10$adminpasswordhash', 'admin'),
        ('Client', 'client@example.com', '+421900654321', '$2y$10$clientpasswordhash', 'client');

    INSERT INTO services (name, category, description, price, duration) VALUES
        ('Odstránenie mihalníc', 'odstránenie', 'Odstránenie mihalníc po inom špecialistovi', 5.00, 15),
        ('Oprava mihalníc', 'oprava', 'Oprava poškodených mihalníc', 20.00, 60),
        ('2D Efekt', 'predĺženie', 'Predĺženie mihalníc s 2D efektom', 35.00, 150),
        ('3D Efekt', 'predĺženie', 'Predĺženie mihalníc s 3D efektom', 40.00, 180),
        ('L Efekt', 'predĺženie', 'Predĺženie mihalníc s efektom L', 30.00, 170),
        ('C Efekt', 'predĺženie', 'Predĺženie mihalníc s efektom C', 30.00, 160);

    INSERT INTO reservations (user_id, service_id, reservation_date, reservation_time, status) VALUES
        (2, 1, '2024-12-10', '14:00:00', 'confirmed'),
        (2, 2, '2024-12-11', '16:00:00', 'pending');

    INSERT INTO reviews (user_id, service_id, review_text, rating) VALUES
        (2, 1, 'Skvelá práca! Mihalnice vyzerajú úžasne.', 5),
        (2, 2, 'Dobre urobené, ale trochu drahé.', 4);
    ```

3. Ak používate XAMPP, uistite sa, že MySQL server beží.

## 5. Spustenie aplikácie

1. Prejdite do adresára, kde ste uložiť projekt, a spustite webový server pomocou PHP. Môžete použiť vstavaný server PHP príkazom:

    ```bash
    php -S localhost:8000 -t public/
    ```

2. Otvorte svoj webový prehliadač a navštívte adresu:
    ```
    http://localhost:8000
    ```

3. Ak ste správne nastavili všetky konfigurácie a databázu, aplikácia by mala byť dostupná.

## 6. Testovanie aplikácie

1. Po prihlásení môžete otestovať rôzne funkcie aplikácie:
    - Prihlásenie a registrácia používateľa.
    - Tvorba a správa rezervácií.
    - Zanechávanie recenzií na služby.
    - Exportovanie rezervácií do CSV formátu (iba pre admina).

2. Uistite sa, že všetky funkcie fungujú správne:
    - Testujte rôzne scenáre, ako je zadanie nesprávnych údajov alebo pokusy o zmazanie/úpravu údajov.

## 7. Ďalšie informácie

- Aplikácia využíva technológie ako PHP, MySQL a HTML/CSS pre front-end.
- Na spracovanie dát používame PDO (PHP Data Objects) pre bezpečné pripojenie k databáze.
- Taktiež sme implementovali AJAX pre niektoré interaktívne funkcie, ako je vyhľadávanie recenzií.


