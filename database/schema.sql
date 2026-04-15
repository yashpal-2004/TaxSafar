CREATE DATABASE IF NOT EXISTS ca_firm;
USE ca_firm;

-- Table for Admin authentication
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table for Client Inquiries
CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    city VARCHAR(100) NOT NULL,
    service ENUM('Tax Filing', 'GST Registration', 'Audit', 'Company Registration', 'Accounting', 'Other') NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'contacted', 'closed') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Default Admin: email=admin@cafirm.com, password=Admin@123
INSERT INTO admins (name, email, password) VALUES 
('System Admin', 'admin@cafirm.com', '$2y$10$W23a5q17UfDozD0n.vG/oeC/F.0o0T1/8oI1.Rz9mZ8E9Hk3M4x2q'); 
-- Hashed value for Admin@123

-- Sample Data for Inquiries
INSERT INTO inquiries (full_name, email, mobile, city, service, message, status) VALUES
('Rahul Sharma', 'rahul@example.com', '9876543210', 'Mumbai', 'Tax Filing', 'I need help with my annual income tax return.', 'new'),
('Priya Patel', 'priya@example.com', '9123456789', 'Ahmedabad', 'GST Registration', 'Starting a new business, need GST number.', 'contacted'),
('Amit Verma', 'amit@example.com', '9988776655', 'Delhi', 'Audit', 'Looking for statutory audit services for my Pvt Ltd.', 'closed'),
('Sneha Reddy', 'sneha@example.com', '8877665544', 'Bangalore', 'Company Registration', 'Want to register a trademark and company.', 'new'),
('Vikram Singh', 'vikram@example.com', '7766554433', 'Jaipur', 'Accounting', 'Need monthly bookkeeping services.', 'contacted'),
('Anjali Gupta', 'anjali@example.com', '9000011111', 'Pune', 'Other', 'Inquiry regarding startup funding compliance.', 'new');
