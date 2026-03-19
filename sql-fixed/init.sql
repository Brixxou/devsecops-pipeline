CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user'
);

-- FIX: bcrypt hashes instead of MD5
INSERT INTO users (username, password, role) VALUES
('admin', '$2y$10$abcdefghijklmnopqrstuuABCDEFGHIJKLMNOPQRSTUVWXYZ012', 'admin'),
('alice', '$2y$10$xyzxyzxyzxyzxyzxyzxyzuuABCDEFGHIJKLMNOPQRSTUVWXYZ012', 'user'),
('bob', '$2y$10$123456789012345678901uuABCDEFGHIJKLMNOPQRSTUVWXYZ012', 'user');
