DROP TABLE IF EXISTS user_post_contact;
DROP TABLE IF EXISTS post_feedback;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS cities;

-- Crear la base de datos con codificación utf8mb4
CREATE DATABASE IF NOT EXISTS manita CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE manita;

-- Crear la tabla de ciudades
CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear la tabla de usuarios
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    avatar VARCHAR(255),
    city_id INT,
    login_hash VARCHAR(255) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE SET NULL ON UPDATE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear la tabla de posts
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(60) NOT NULL,
    body VARCHAR(255),
    telephone VARCHAR(15),
    neighborhood VARCHAR(20),
    phone_call BOOLEAN,
    chat_link BOOLEAN, 
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear la tabla de contactos de usuario con post (quien ha pulsado algún botón de contactar en el post)
CREATE TABLE user_post_contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY unique_user_post_contact (user_id, post_id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear la tabla de retroalimentación de posts
CREATE TABLE post_feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    user_role ENUM('helper', 'recipient') NOT NULL,
    valoration ENUM('good', 'bad') NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY unique_user_post_role (user_id, post_id, user_role) -- Un usuario puede dar una valoración por rol (ayudante o receptor)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;



-- Insertar las ciudades principales de España enlazadas con sus provincias
INSERT INTO cities (id, name) VALUES
(1, 'Vitoria-Gasteiz'),          -- Álava
(2, 'Albacete'),                 -- Albacete
(3, 'Alicante'),                 -- Alicante
(4, 'Elche'),                    -- Alicante
(5, 'Almería'),                  -- Almería
(6, 'Oviedo'),                   -- Asturias
(7, 'Gijón'),                    -- Asturias
(8, 'Ávila'),                    -- Ávila
(9, 'Badajoz'),                  -- Badajoz
(10, 'Mérida'),                  -- Badajoz
(11, 'Palma de Mallorca'),       -- Baleares
(12, 'Barcelona'),               -- Barcelona
(13, 'LHospitalet de Llobregat'), -- Barcelona
(14, 'Burgos'),                  -- Burgos
(15, 'Cáceres'),                 -- Cáceres
(16, 'Cádiz'),                   -- Cádiz
(17, 'Jerez de la Frontera'),   -- Cádiz
(18, 'Santander'),               -- Cantabria
(19, 'Castellón de la Plana'),   -- Castellón
(20, 'Ciudad Real'),             -- Ciudad Real
(21, 'Córdoba'),                 -- Córdoba
(22, 'A Coruña'),                -- La Coruña
(23, 'Santiago de Compostela'),   -- La Coruña
(24, 'Cuenca'),                  -- Cuenca
(25, 'Girona'),                  -- Gerona
(26, 'Granada'),                 -- Granada
(27, 'Guadalajara'),             -- Guadalajara
(28, 'San Sebastián'),           -- Guipúzcoa
(29, 'Huelva'),                  -- Huelva
(30, 'Huesca'),                  -- Huesca
(31, 'Jaén'),                    -- Jaén
(32, 'León'),                    -- León
(33, 'Lleida'),                  -- Lérida
(34, 'Lugo'),                    -- Lugo
(35, 'Madrid'),                  -- Madrid
(36, 'Málaga'),                  -- Málaga
(37, 'Murcia'),                  -- Murcia
(38, 'Pamplona'),                -- Navarra
(39, 'Ourense'),                 -- Orense
(40, 'Palencia'),                -- Palencia
(41, 'Las Palmas de Gran Canaria'), -- Las Palmas
(42, 'Pontevedra'),              -- Pontevedra
(43, 'Vigo'),                    -- Pontevedra
(44, 'Logroño'),                 -- La Rioja
(45, 'Salamanca'),               -- Salamanca
(46, 'Segovia'),                 -- Segovia
(47, 'Sevilla'),                 -- Sevilla
(48, 'Soria'),                   -- Soria
(49, 'Tarragona'),               -- Tarragona
(50, 'Santa Cruz de Tenerife'),  -- Santa Cruz de Tenerife
(51, 'Teruel'),                  -- Teruel
(52, 'Toledo'),                  -- Toledo
(53, 'Valencia'),                -- Valencia
(54, 'Valladolid'),              -- Valladolid
(55, 'Bilbao'),                  -- Vizcaya
(56, 'Zamora'),                  -- Zamora
(57, 'Zaragoza');                -- Zaragoza
