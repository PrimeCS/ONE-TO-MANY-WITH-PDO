# Tech Support System

A PHP and MySQL web app where customers send tech support tickets and complaints, and an admin manages them. It demonstrates a **one-to-many relationship** (one client has many tickets), user login with roles, and tracking of who added or last updated every record.

## Features

**Customer**
- Register, log in, and log out
- Submit a ticket or complaint by choosing a type (Hardware Failures, Software Crashes, Connectivity Issues, Complaint, Others)
- View their own tickets and follow their status (Open, In Progress, Resolved)
- Home page that explains the website and the ticket (child) entity

**Admin**
- Dashboard with the number of clients, open tickets, and open complaints, plus an explanation of the client (parent) entity
- Add, view, edit, and delete **clients**
- Add, view, edit, and delete **tickets**
- See who added each record, who last updated it, and when

**System**
- Pages are protected: visitors who are not logged in are sent to the login page
- Customers cannot open admin pages
- Passwords are hashed with `password_hash()`
- Deleting a client also deletes their tickets (`ON DELETE CASCADE`)
- Public home page explaining the website and how it works

## Tech Stack

- PHP (PDO with prepared statements, sessions)
- MySQL / MariaDB
- HTML and basic CSS
- XAMPP (Apache + MySQL) for local development

## Database Design

| Table | Purpose | Key columns |
| --- | --- | --- |
| `users` | Accounts for admins and customers | `user_id`, personal info, `username`, `password`, `role` |
| `clients` | **Parent entity** | `client_id`, `user_id`, `added_by`, `updated_by`, `last_updated` |
| `tickets` | **Child entity** | `ticket_id`, `client_id`, `type`, `status`, `added_by`, `updated_by`, `last_updated` |

**Relationships**
- One client has many tickets (`tickets.client_id` points to `clients.client_id`)
- One user account has one client record (`clients.user_id` points to `users.user_id`)
- `added_by` and `updated_by` in `clients` and `tickets` point to `users.user_id`, which is how every change is traced to a person

## Folder Structure

```
techsupport/
├── index.php            public home page
├── login.php
├── register.php
├── logout.php
├── dashboard.php        admin home (login required)
├── database.sql         creates the database, tables, and admin account
├── sample_data.sql      optional sample customers, clients, and tickets
├── config/
│   ├── db.php           database connection
│   ├── auth.php         login and role checks
│   ├── layout.php       shared header, footer, and styling
│   └── types.php        list of ticket types
├── customer/
│   ├── index.php        customer home
│   ├── submit.php       send a ticket or complaint
│   └── tickets.php      the customer's own tickets
├── clients/             admin only (index, create, edit, delete)
└── tickets/             admin only (index, create, edit, delete)
```

## Database Setup

1. Start **Apache** and **MySQL** in XAMPP.
2. Open phpMyAdmin and go to the **SQL** tab.
3. Paste the contents of `database.sql` and click **Go**. This creates `techsupport_db`, all three tables, and the default admin account.
4. Optional: paste the contents of `sample_data.sql` and click **Go** to add sample customers, clients, and tickets.

## How to Run

1. Install [XAMPP](https://www.apachefriends.org/).
2. Clone or download this repository into `C:\xampp\htdocs\` so the folder is named `techsupport`.
3. Set up the database as shown above.
4. Check `config/db.php`. It uses user `root` with no password, which is the XAMPP default. Change it if your setup is different.
5. Open `http://localhost/techsupport/` in your browser.

## Default Accounts

| Role | Username | Password |
| --- | --- | --- |
| Admin | `admin` | `password` |
| Customers (only if you ran `sample_data.sql`) | `juan`, `maria`, `pedro` | `password` |

Change the admin password if you ever use this outside of a local test. New customers register from the website. New admins can only be added directly in the database by copying the admin `INSERT` in `database.sql` and changing the details.

## Usage

- **As a customer:** register, log in, click *Submit*, choose a type, describe the problem, and send it. Open *My Tickets* to see its status.
- **As admin:** log in, open *Manage Tickets* to read requests and change their status, and open *Manage Clients* to add, edit, or delete clients.

## Screenshots

Add your screenshots here (registration, login, insert, update, delete, and logout).

## Author

Your name here
