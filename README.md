# Tech Support System
A simple PHP and MySQL web app for managing tech support clients and their support tickets. It demonstrates a **one-to-many relationship**: one client can have many tickets.

## Features
- Add, view, edit, and delete **clients** (parent entity)
- Add, view, edit, and delete **support tickets** (child entity)
- Assign each ticket to a client using a dropdown
- Home page showing the number of clients and open tickets
- Deleting a client also deletes their tickets

## Tech Stack
- PHP (PDO with prepared statements)
- MySQL / MariaDB
- HTML and basic CSS
- XAMPP (Apache + MySQL) for local development


## Folder Structure
```
C:\xampp\htdocs\techsupport
```

## Database Setup
Run this in phpMyAdmin (SQL tab):
```sql
CREATE DATABASE techsupport_db;
USE techsupport_db;

CREATE TABLE clients (
  client_id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  phone VARCHAR(20)
);

CREATE TABLE tickets (
  ticket_id INT AUTO_INCREMENT PRIMARY KEY,
  client_id INT NOT NULL,
  issue VARCHAR(255) NOT NULL,
  status VARCHAR(20) DEFAULT 'Open',
  date_created DATE,
  FOREIGN KEY (client_id) REFERENCES clients(client_id)
    ON DELETE CASCADE
);
```

Optional sample data:
```sql
INSERT INTO clients (full_name, email, phone) VALUES
('Juan Dela Cruz', 'juan@email.com', '09171234567'),
('Maria Santos', 'maria@email.com', '09181234567'),
('Pedro Reyes', 'pedro@email.com', '09191234567');

INSERT INTO tickets (client_id, issue, status, date_created) VALUES
(1, 'Laptop will not turn on', 'Open', CURDATE()),
(1, 'Slow internet connection', 'In Progress', CURDATE()),
(2, 'Cannot log in to email', 'Open', CURDATE()),
(3, 'Windows update stuck', 'Resolved', CURDATE());
```
## How to Run

1. Install [XAMPP](https://www.apachefriends.org/) and start **Apache** and **MySQL**.
2. Clone or download this repository into `xampp/htdocs/` so the folder is named `techsupport`.
3. Create the database using the SQL above.
4. Check `config/db.php`. It uses user `root` with no password by default. Change it if your setup is different.
5. Open `http://localhost/techsupport/` in your browser.

