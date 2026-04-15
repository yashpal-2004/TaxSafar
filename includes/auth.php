<?php declare(strict_types=1);

/**
 * Check if the user is logged in, redirect if not
 */
function requireLogin(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isLoggedIn()) {
        header("Location: ../admin/login.php");
        exit();
    }
}

/**
 * Return login status
 */
function isLoggedIn(): bool {
    return isset($_SESSION['admin_id']);
}

/**
 * Attempt to login an admin
 */
function loginAdmin(mysqli $mysqli, string $email, string $password): bool {
    $stmt = $mysqli->prepare("SELECT id, name, password FROM admins WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($admin = $result->fetch_assoc()) {
        if (password_verify($password, $admin['password'])) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            $stmt->close();
            return true;
        }
    }
    $stmt->close();
    return false;
}

/**
 * Destroy admin session
 */
function logoutAdmin(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
    session_unset();
    session_destroy();
}
