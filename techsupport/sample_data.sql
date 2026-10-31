-- SAMPLE DATA for techsupport_db
-- Run AFTER the tables and the admin account exist. Run it only once.
-- All sample customers log in with the password:  password

USE techsupport_db;

-- 1. Sample customers (role = customer)
INSERT INTO users (first_name, last_name, address, age, email, username, password, role) VALUES
('Juan',  'Dela Cruz', '12 Rizal St., Manila',       21, 'juan@email.com',  'juan',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer'),
('Maria', 'Santos',    '45 Quezon City', 25, 'maria@email.com', 'maria', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer'),
('Pedro', 'Reyes',     '78 Something Highway, Cebu City',      30, 'pedro@email.com', 'pedro', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer');

-- 2. Remember the ids so we do not have to type them
SET @admin = (SELECT user_id FROM users WHERE username = 'admin');
SET @juan  = (SELECT user_id FROM users WHERE username = 'juan');
SET @maria = (SELECT user_id FROM users WHERE username = 'maria');
SET @pedro = (SELECT user_id FROM users WHERE username = 'pedro');

-- 3. Each customer gets a client record (same thing the Register page does)
INSERT INTO clients (user_id, full_name, email, added_by, updated_by, last_updated)
SELECT user_id, CONCAT(first_name, ' ', last_name), email, user_id, user_id, NOW()
FROM users WHERE role = 'customer';

-- 4. One walk-in client added by the admin
INSERT INTO clients (full_name, email, phone, added_by, updated_by, last_updated)
VALUES ('Ana Lopez', 'ana@email.com', '09171234567', @admin, @admin, NOW());

SET @c_juan  = (SELECT client_id FROM clients WHERE user_id = @juan);
SET @c_maria = (SELECT client_id FROM clients WHERE user_id = @maria);
SET @c_pedro = (SELECT client_id FROM clients WHERE user_id = @pedro);
SET @c_ana   = (SELECT client_id FROM clients WHERE email = 'ana@email.com');

-- 5. Tickets 
INSERT INTO tickets (client_id, type, issue, status, date_created, added_by, updated_by, last_updated) VALUES
(@c_juan,  'Hardware Failures',   'Laptop will not turn on',               'Open',        CURDATE() - INTERVAL 1 DAY, @juan,  @juan,  NOW() - INTERVAL 1 DAY),
(@c_juan,  'Connectivity Issues', 'Wi-Fi keeps disconnecting every hour',  'In Progress', CURDATE() - INTERVAL 3 DAY, @juan,  @admin, NOW() - INTERVAL 2 HOUR),
(@c_juan,  'Software Crashes',    'Word closes when I open a large file',  'Resolved',    CURDATE() - INTERVAL 7 DAY, @juan,  @admin, NOW() - INTERVAL 5 DAY),
(@c_maria, 'Connectivity Issues', 'No internet connection since yesterday','Open',        CURDATE(),                  @maria, @maria, NOW()),
(@c_maria, 'Complaint',           'The technician arrived two hours late', 'In Progress', CURDATE() - INTERVAL 2 DAY, @maria, @admin, NOW() - INTERVAL 1 DAY),
(@c_pedro, 'Others',              'Need help setting up a new printer',    'Open',        CURDATE() - INTERVAL 1 DAY, @pedro, @pedro, NOW() - INTERVAL 1 DAY),
(@c_ana,   'Software Crashes',    'Windows update stuck at 40 percent',    'Resolved',    CURDATE() - INTERVAL 4 DAY, @admin, @admin, NOW() - INTERVAL 3 DAY);
