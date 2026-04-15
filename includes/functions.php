<?php declare(strict_types=1);

/**
 * Sanitize input to prevent XSS
 */
function sanitize($input) {
    return htmlspecialchars(trim((string)$input), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate Inquiry Form Data
 */
function validateInquiryForm(array $data): array {
    $errors = [];
    
    if (empty($data['full_name'])) $errors[] = "Full name is required.";
    if (!validateEmail($data['email'])) $errors[] = "A valid email is required.";
    if (!validateMobile($data['mobile'])) $errors[] = "Enter a valid 10-digit mobile number.";
    if (empty($data['city'])) $errors[] = "City is required.";
    
    $allowed_services = ['Tax Filing', 'GST Registration', 'Audit', 'Company Registration', 'Accounting', 'Other'];
    if (!in_array($data['service'], $allowed_services)) $errors[] = "Invalid service selected.";
    
    if (empty($data['message'])) $errors[] = "Message cannot be empty.";
    
    return $errors;
}

/**
 * Validate Email Format
 */
function validateEmail(string $email): bool {
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validate 10-digit Indian Mobile Number
 */
function validateMobile(string $mobile): bool {
    return (bool) preg_match('/^[6-9]\d{9}$/', $mobile);
}

/**
 * Set Flash Message
 */
function setFlash(string $type, string $message): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Get and Unset Flash Message
 */
function getFlash(): ?array {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Format Date to "15 Apr 2025, 10:30 AM"
 */
function formatDate(string $datetime): string {
    return date("d M Y, h:i A", strtotime($datetime));
}

/**
 * Get Status Badge HTML
 */
function getStatusBadge(string $status): string {
    $colors = [
        'new' => ['bg' => '#fde6d2', 'text' => '#9a3412', 'label' => 'New'],
        'contacted' => ['bg' => '#dbeafe', 'text' => '#1e40af', 'label' => 'Contacted'],
        'closed' => ['bg' => '#dcfce7', 'text' => '#166534', 'label' => 'Closed'],
    ];
    
    $style = isset($colors[$status]) ? $colors[$status] : $colors['new'];
    
    return sprintf(
        '<span style="background: %s; color: %s; padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: 600; text-transform: capitalize;">%s</span>',
        $style['bg'], $style['text'], $style['label']
    );
}
