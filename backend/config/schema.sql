DROP TABLE IF EXISTS user_post_contact;
DROP TABLE IF EXISTS post_feedback;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS cities;
DROP TABLE IF EXISTS provinces;

-- Crear la base de datos con codificación utf8mb4
CREATE DATABASE IF NOT EXISTS manita CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE manita;

-- Crear la tabla de provincias
CREATE TABLE provinces (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear la tabla de ciudades
CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    province_id INT,
    FOREIGN KEY (province_id) REFERENCES provinces(id) ON DELETE SET NULL ON UPDATE CASCADE
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








-- Insertar todas las provincias de España en la tabla 'province'
INSERT INTO provinces (id, name) VALUES
(1, 'Álava'),
(2, 'Albacete'),
(3, 'Alicante'),
(4, 'Almería'),
(5, 'Asturias'),
(6, 'Ávila'),
(7, 'Badajoz'),
(8, 'Baleares'),
(9, 'Barcelona'),
(10, 'Burgos'),
(11, 'Cáceres'),
(12, 'Cádiz'),
(13, 'Cantabria'),
(14, 'Castellón'),
(15, 'Ciudad Real'),
(16, 'Córdoba'),
(17, 'La Coruña'),
(18, 'Cuenca'),
(19, 'Gerona'),
(20, 'Granada'),
(21, 'Guadalajara'),
(22, 'Guipúzcoa'),
(23, 'Huelva'),
(24, 'Huesca'),
(25, 'Jaén'),
(26, 'León'),
(27, 'Lérida'),
(28, 'Lugo'),
(29, 'Madrid'),
(30, 'Málaga'),
(31, 'Murcia'),
(32, 'Navarra'),
(33, 'Orense'),
(34, 'Palencia'),
(35, 'Las Palmas'),
(36, 'Pontevedra'),
(37, 'La Rioja'),
(38, 'Salamanca'),
(39, 'Segovia'),
(40, 'Sevilla'),
(41, 'Soria'),
(42, 'Tarragona'),
(43, 'Santa Cruz de Tenerife'),
(44, 'Teruel'),
(45, 'Toledo'),
(46, 'Valencia'),
(47, 'Valladolid'),
(48, 'Vizcaya'),
(49, 'Zamora'),
(50, 'Zaragoza');


-- Insertar las ciudades principales de España enlazadas con sus provincias
INSERT INTO cities (id, name, province_id) VALUES
(1, 'Vitoria-Gasteiz', 1),  -- Álava
(2, 'Albacete', 2),         -- Albacete
(3, 'Alicante', 3),         -- Alicante
(4, 'Elche', 3),            -- Alicante
(5, 'Almería', 4),          -- Almería
(6, 'Oviedo', 5),           -- Asturias
(7, 'Gijón', 5),            -- Asturias
(8, 'Ávila', 6),            -- Ávila
(9, 'Badajoz', 7),          -- Badajoz
(10, 'Mérida', 7),          -- Badajoz
(11, 'Palma de Mallorca', 8),-- Baleares
(12, 'Barcelona', 9),       -- Barcelona
(13, 'LHospitalet de Llobregat', 9), -- Barcelona
(14, 'Burgos', 10),         -- Burgos
(15, 'Cáceres', 11),        -- Cáceres
(16, 'Cádiz', 12),          -- Cádiz
(17, 'Jerez de la Frontera', 12), -- Cádiz
(18, 'Santander', 13),      -- Cantabria
(19, 'Castellón de la Plana', 14), -- Castellón
(20, 'Ciudad Real', 15),    -- Ciudad Real
(21, 'Córdoba', 16),        -- Córdoba
(22, 'A Coruña', 17),       -- La Coruña
(23, 'Santiago de Compostela', 17), -- La Coruña
(24, 'Cuenca', 18),         -- Cuenca
(25, 'Girona', 19),         -- Gerona
(26, 'Granada', 20),        -- Granada
(27, 'Guadalajara', 21),    -- Guadalajara
(28, 'San Sebastián', 22),  -- Guipúzcoa
(29, 'Huelva', 23),         -- Huelva
(30, 'Huesca', 24),         -- Huesca
(31, 'Jaén', 25),           -- Jaén
(32, 'León', 26),           -- León
(33, 'Lleida', 27),         -- Lérida
(34, 'Lugo', 28),           -- Lugo
(35, 'Madrid', 29),         -- Madrid
(36, 'Málaga', 30),         -- Málaga
(37, 'Murcia', 31),         -- Murcia
(38, 'Pamplona', 32),       -- Navarra
(39, 'Ourense', 33),        -- Orense
(40, 'Palencia', 34),       -- Palencia
(41, 'Las Palmas de Gran Canaria', 35), -- Las Palmas
(42, 'Pontevedra', 36),     -- Pontevedra
(43, 'Vigo', 36),           -- Pontevedra
(44, 'Logroño', 37),        -- La Rioja
(45, 'Salamanca', 38),      -- Salamanca
(46, 'Segovia', 39),        -- Segovia
(47, 'Sevilla', 40),        -- Sevilla
(48, 'Soria', 41),          -- Soria
(49, 'Tarragona', 42),      -- Tarragona
(50, 'Santa Cruz de Tenerife', 43), -- Santa Cruz de Tenerife
(51, 'Teruel', 44),         -- Teruel
(52, 'Toledo', 45),         -- Toledo
(53, 'Valencia', 46),       -- Valencia
(54, 'Valladolid', 47),     -- Valladolid
(55, 'Bilbao', 48),         -- Vizcaya
(56, 'Zamora', 49),         -- Zamora
(57, 'Zaragoza', 50);       -- Zaragoza