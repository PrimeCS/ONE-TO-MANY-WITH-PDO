CREATE DATABASE IF NOT EXISTS techsupport_db;
USE techsupport_db;

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  address VARCHAR(255),
  age INT,
  email VARCHAR(100) NOT NULL UNIQUE,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','customer') NOT NULL DEFAULT 'customer',
  date_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE clients (
  client_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL UNIQUE,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  phone VARCHAR(20),
  added_by INT NULL,
  updated_by INT NULL,
  last_updated DATETIME NULL,
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL,
  FOREIGN KEY (added_by) REFERENCES users(user_id) ON DELETE SET NULL,
  FOREIGN KEY (updated_by) REFERENCES users(user_id) ON DELETE SET NULL
);

CREATE TABLE tickets (
  ticket_id INT AUTO_INCREMENT PRIMARY KEY,
  client_id INT NOT NULL,
  type VARCHAR(30) NOT NULL DEFAULT 'Others',
  issue VARCHAR(255) NOT NULL,
  status VARCHAR(20) DEFAULT 'Open',
  date_created DATE,
  added_by INT NULL,
  updated_by INT NULL,
  last_updated DATETIME NULL,
  FOREIGN KEY (client_id) REFERENCES clients(client_id) ON DELETE CASCADE,
  FOREIGN KEY (added_by) REFERENCES users(user_id) ON DELETE SET NULL,
  FOREIGN KEY (updated_by) REFERENCES users(user_id) ON DELETE SET NULL
);

-- DEFAULT ADMIN  (username: admin / password: password)
INSERT INTO users (first_name, last_name, address, age, email, username, password, role)
VALUES ('System', 'Admin', 'Main Office', 30, 'admin@techsupport.com', 'admin',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
