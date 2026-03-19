CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user'
);

INSERT INTO users (username, password, role) VALUES
('admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin'),
('alice', '5f4dcc3b5aa765d61d8327deb882cf99', 'user'),
('bob', '5e18c50c766bd71221b65e9447470678', 'user');
