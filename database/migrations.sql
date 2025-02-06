-- Создание базы данных
CREATE DATABASE IF NOT EXISTS lash_reservation CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE lash_reservation;

-- Таблица пользователей
CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       name VARCHAR(50) NOT NULL,
                       email VARCHAR(100) UNIQUE NOT NULL,
                       phone VARCHAR(20) NOT NULL,
                       password VARCHAR(255) NOT NULL, -- Захешированный пароль
                       role ENUM('admin', 'client') DEFAULT 'client'
);

-- Таблица услуг
CREATE TABLE services (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          name VARCHAR(100) NOT NULL,
                          category ENUM('predĺženie', 'oprava', 'odstránenie') NOT NULL,
                          description TEXT,
                          price DECIMAL(10, 2) NOT NULL,
                          duration INT NOT NULL
);

-- Таблица бронирований (M:N users ↔ services)
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

-- Таблица отзывов
CREATE TABLE reviews (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         user_id INT NOT NULL,
                         service_id INT NOT NULL,
                         review_text TEXT NOT NULL,
                         rating INT CHECK (rating BETWEEN 1 AND 5), -- Оценка от 1 до 5
                         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                         FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                         FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE
);

-- Таблица приглашений
CREATE TABLE invitations (
                             id INT AUTO_INCREMENT PRIMARY KEY,
                             inviter_id INT NOT NULL,
                             invitee_email VARCHAR(255) NOT NULL,
                             token VARCHAR(64) NOT NULL UNIQUE,
                             created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                             FOREIGN KEY (inviter_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Заполнение таблицы пользователей (пароли должны быть захешированы)
INSERT INTO users (name, email, phone, password, role) VALUES
                                                           ('Admin', 'admin@example.com', '+421900123456', '$2y$10$adminpasswordhash', 'admin'),
                                                           ('Client', 'client@example.com', '+421900654321', '$2y$10$clientpasswordhash', 'client');

-- Заполнение таблицы услуг
INSERT INTO services (name, category, description, price, duration) VALUES
                                                                        ('Odstránenie mihalníc', 'odstránenie', 'Odstránenie mihalníc po inom špecialistovi', 5.00, 15),
                                                                        ('Oprava mihalníc', 'oprava', 'Oprava poškodených mihalníc', 20.00, 60),
                                                                        ('2D Efekt', 'predĺženie', 'Predĺženie mihalníc s 2D efektom', 35.00, 150),
                                                                        ('3D Efekt', 'predĺženie', 'Predĺženie mihalníc s 3D efektom', 40.00, 180),
                                                                        ('L Efekt', 'predĺženie', 'Predĺženie mihalníc s efektom L', 30.00, 170),
                                                                        ('C Efekt', 'predĺženie', 'Predĺženie mihalníc s efektom C', 30.00, 160);

-- Заполнение таблицы бронирований
INSERT INTO reservations (user_id, service_id, reservation_date, reservation_time, status) VALUES
                                                                                               (2, 1, '2024-12-10', '14:00:00', 'confirmed'),
                                                                                               (2, 2, '2024-12-11', '16:00:00', 'pending');

-- Заполнение таблицы отзывов
INSERT INTO reviews (user_id, service_id, review_text, rating) VALUES
                                                                   (2, 1, 'Skvelá práca! Mihalnice vyzerajú úžasne.', 5),
                                                                   (2, 2, 'Dobre urobené, ale trochu drahé.', 4);

-- Заполнение таблицы приглашений
INSERT INTO invitations (inviter_id, invitee_email, token) VALUES
    (1, 'newuser@example.com', 'random_generated_token_here');
