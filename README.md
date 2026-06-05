# courier_manage_final

A lightweight **Courier Management System** built with PHP.  
It provides an intuitive interface for managing couriers, tracking shipments, and sending automated email notifications using **PHPMailer**.

---

## Overview

`courier_manage_final` is a web‑based application that helps logistics teams:

* Register and maintain courier profiles.  
* Create, update, and monitor shipment records.  
* Send status updates and alerts to customers via email.  

The project ships with a ready‑to‑import MySQL schema (`Database/courier_db.sql`) and integrates the popular **PHPMailer** library for reliable SMTP mailing.

---

## Features

| ✅ | Feature |
|---|---|
| 📦 | **CRUD** operations for couriers and shipments |
| 📧 | Automated email notifications (order placed, dispatched, delivered) |
| 🗂️ | MySQL database schema with indexes for fast queries |
| 🔐 | Basic authentication & role‑based access control |
| 📂 | Modular code structure – easy to extend or customize |
| 🌐 | Works on any LAMP/LEMP stack (PHP 7.4+ recommended) |

---

## Tech Stack

| Layer | Technology |
|-------|------------|
| **Backend** | PHP (>=7.4) |
| **Database** | MySQL / MariaDB |
| **Mail** | PHPMailer (bundled) |
| **Web Server** | Apache / Nginx |
| **Version Control** | Git |

---

## Installation

> **Prerequisites**  
> - PHP 7.4 or newer with the `mysqli` extension enabled  
> - MySQL server (or MariaDB)  
> - Composer (for PHPMailer dependencies)  
> - A web server capable of serving PHP applications

1. **Clone the repository**

   ```bash
   git clone https://github.com/yourusername/courier_manage_final.git
   cd courier_manage_final
   ```

2. **Set up the database**

   ```bash
   # Create a new database (replace `courier_db` with your preferred name)
   mysql -u root -p -e "CREATE DATABASE courier_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   # Import the schema
   mysql -u root -p courier_db < Database/courier_db.sql
   ```

3. **Configure the application**

   Copy the example config file and edit the credentials:

   ```bash
   cp config.example.php config.php
   ```

   Edit `config.php` and replace the placeholders with your own values:

   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'courier_db');
   define('DB_USER', 'YOUR_DB_USERNAME');
   define('DB_PASS', 'YOUR_DB_PASSWORD');

   // SMTP settings for PHPMailer
   define('SMTP_HOST', 'smtp.example.com');
   define('SMTP_PORT', 587);
   define('SMTP_USER', 'YOUR_SMTP_USERNAME');
   define('SMTP_PASS', 'YOUR_SMTP_PASSWORD');
   define