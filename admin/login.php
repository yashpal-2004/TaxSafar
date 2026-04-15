<?php 
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (loginAdmin($mysqli, $email, $password)) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | TaxPro CA Firm</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #1a2e4a; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .login-card { background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); width: 100%; max-width: 400px; }
        .logo { text-align: center; color: #1a2e4a; font-size: 1.8rem; font-weight: 700; margin-bottom: 30px; }
        .logo span { color: #c9a84c; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.9rem; }
        .form-control { width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        .btn { width: 100%; padding: 12px; background: #1a2e4a; color: #fff; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: 0.3s; }
        .btn:hover { background: #c9a84c; }
        .error { color: #e11d48; background: #fff1f2; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 0.85rem; text-align: center; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">TaxPro <span>Admin</span></div>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" required placeholder="admin@cafirm.com">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn">Sign In</button>
        </form>
    </div>
</body>
</html>
