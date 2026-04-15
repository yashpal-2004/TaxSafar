# TaxPro CA Firm - Inquiry Management System

A professional, modular web application for Chartered Accountants to showcase services and manage client inquiries efficiently. Built with pure PHP, MySQL, and Modern Vanilla CSS.

## Features
- **Modern Landing Page**: Fully responsive, single-page layout with smooth scrolling.
- **Service Showcase**: Highlighting 6 core CA services with FontAwesome icons.
- **Inquiry Management**: AJAX-enabled feel form with server-side validation.
- **Admin Dashboard**: 
  - Statistics overview (Total, New, Contacted, Closed).
  - Search and filter inquiries by name/email or status.
  - Full CRUD for inquiries (Read, Edit, Delete).
  - Secure Login/Logout system with hashed passwords.
- **Modular Code**: Clean separation of concerns (Config, Includes, Admin, Public).

## Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web Server (Apache/Nginx) - Compatible with XAMPP, WAMP, or LAMP.

## Setup Instructions
1. **Clone/Unzip**: Copy the `ca-firm` folder into your web server's root directory (e.g., `C:\xampp\htdocs\ca-firm`).
2. **Database Setup**:
   - Open PHPMyAdmin or your preferred SQL tool.
   - Run the contents of `database/schema.sql`. This will create the `ca_firm` database and tables with sample data.
3. **Configuration**:
   - Open `config/db.php`.
   - Update `DB_USER` and `DB_PASS` if they differ from your local environment defaults.
4. **Access the Application**:
   - **Frontend**: `http://localhost:8000/public/`
   - **Admin Panel**: `http://localhost:8000/admin/login.php`

## Admin Credentials
- **Email**: `admin@cafirm.com`
- **Password**: `Admin@123`

## Folder Structure
- `admin/`: Back-end management pages (Dashboard, Inquiry handling).
- `config/`: Database connection using Singleton Pattern.
- `database/`: SQL schema and sample data.
- `includes/`: Shared logic, authentication helpers, and UI partials.
- `public/`: Frontend assets, landing page, and form submission handler.

## Security
- Prepared Statements (MySQLi) to prevent SQL Injection.
- CSRF protection concepts through POST-only mutations.
- Password hashing using `PASSWORD_BCRYPT`.
- Input/Output sanitization via `htmlspecialchars`.