DROP TABLE IF EXISTS event_participants;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS post_feedback;
DROP TABLE IF EXISTS user_post_chat_state;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS cities;
DROP TABLE IF EXISTS province;

CREATE TABLE province (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    province_id INT,
    FOREIGN KEY (province_id) REFERENCES province(id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    telephone VARCHAR(15) UNIQUE,
    uuid VARCHAR(255) NOT NULL,
    login_hash VARCHAR(255) UNIQUE,
    avatar VARCHAR(255),
    city_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(60) NOT NULL,
    body VARCHAR(255),
    neighborhood VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE user_post_chat_state (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    state ENUM('no_action', 'accepted', 'canceled', 'finished') NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE post_feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_role ENUM('helper', 'recipient') NOT NULL,
    feedback TEXT,
    valoration ENUM('good', 'bad') NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY unique_user_post_role (user_id, post_id, user_role)
);

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(60) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    event_date DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE event_participants (
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY (event_id, user_id),
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);
