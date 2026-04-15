<?php 
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$data = [
    'full_name' => $_POST['full_name'] ?? '',
    'email'     => $_POST['email'] ?? '',
    'mobile'    => $_POST['mobile'] ?? '',
    'city'      => $_POST['city'] ?? '',
    'service'   => $_POST['service'] ?? '',
    'message'   => $_POST['message'] ?? ''
];

$errors = validateInquiryForm($data);

if (!empty($errors)) {
    $_SESSION['old'] = $data;
    setFlash('error', implode(' ', $errors));
    header("Location: index.php#inquiry-form");
    exit();
}

try {
    $stmt = $mysqli->prepare("INSERT INTO inquiries (full_name, email, mobile, city, service, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", 
        $data['full_name'], 
        $data['email'], 
        $data['mobile'], 
        $data['city'], 
        $data['service'], 
        $data['message']
    );
    
    if ($stmt->execute()) {
        setFlash('success', "Thank you! Your inquiry has been submitted successfully.");
    } else {
        setFlash('error', "Something went wrong. Please try again later.");
    }
    $stmt->close();
} catch (Exception $e) {
    setFlash('error', "Database error: " . $e->getMessage());
}

header("Location: index.php#inquiry-form");
exit();
