# TaxPro - CA Firm Inquiry Management System

A professional, modular web application designed for Chartered Accountants to showcase their services and manage client inquiries efficiently. This system features a high-performance landing page and a robust admin dashboard for inquiry tracking.

---

## Quick Start (Local Development)

If you have PHP installed, you can run the project without a full web server:

1.  **Clone the project** and navigate to the directory.
2.  **Database Setup**: 
    - Create a database named `ca_firm` in MySQL.
    - Import `database/schema.sql`.
3.  **Config**: Update `config/db.php` with your database credentials.
4.  **Run Server**:
    ```bash
    php -S localhost:8000
    ```
5.  **Access**:
    - **User Panel**: [http://localhost:8000/public/](http://localhost:8000/public/)
    - **Admin Panel**: [http://localhost:8000/admin/login.php](http://localhost:8000/admin/login.php)
    - **Credentials**: `admin@cafirm.com` / `Admin@123`

---

## Features

### Frontend (Client-Facing)
- **Responsive Landing Page**: Sleek, modern design using Vanilla CSS.
- **Service Showcase**: Grid layout highlighting 6 core CA services.
- **AJAX Inquiry Form**: Instant inquiry submission with server-side validation.
- **FontAwesome Integration**: Beautiful icons for a professional look.

### Admin Dashboard (Internal)
- **Inquiry Management**: Complete CRUD operations for client requests.
- **Smart Search & Filter**: 
    - **Real-time Search**: Search by name, email, or mobile with debounce (500ms).
    - **Status Filtering**: Filter by New, Contacted, or Closed statuses.
- **Statistics Overview**: Dashboard cards showing inquiry volume and status distribution.
- **Secure Authentication**: Session-based login with hashed password protection (`BCRYPT`).
- **Activity Feedback**: Visual badges and success/error notifications.

---

## Tech Stack

- **Backend**: PHP 7.4+ (Modular Architecture)
- **Database**: MySQL (Singleton Connection Pattern)
- **Frontend**: HTML5, Vanilla CSS3, JavaScript (AJAX/Fetch)
- **Icons**: FontAwesome 6.x
- **Fonts**: Google Fonts (Inter/Outfit)
- **Architecture**: Separated Concerns (Config/Admin/Public/Includes)

---

## Project Structure

```text
ca-firm/
├── admin/            # Backend management pages (Dashboard, Inquiries)
├── config/           # Database configuration (Singleton Pattern)
├── database/         # SQL Schema and dummy data
├── includes/         # Shared logic, auth helpers, and UI partials
├── public/           # Frontend assets, landing page, and submission handlers
└── README.md         # Project documentation
```

---

## Security Measurements

1.  **SQLi Protection**: All queries use **Prepared Statements** via MySQLi.
2.  **Password Safety**: Passwords stored using `password_hash()` with `PASSWORD_BCRYPT`.
3.  **XSS Prevention**: Output sanitization using `htmlspecialchars()` via a custom `sanitize()` helper.
4.  **Session Security**: Server-side session validation for all admin routes.