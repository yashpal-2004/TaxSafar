<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TaxPro CA Firm</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1a2e4a;
            --accent: #c9a84c;
            --sidebar-width: 260px;
            --topbar-height: 60px;
            --bg: #f4f7fa;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); display: flex; }
        
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--primary);
            color: #fff;
            position: fixed;
            left: 0; top: 0;
            padding: 2rem 1rem;
        }
        .sidebar .logo { font-size: 1.5rem; font-weight: 700; color: var(--accent); margin-bottom: 2rem; display: block; text-decoration: none; }
        .sidebar nav a { 
            display: flex; align-items: center; gap: 10px; 
            padding: 12px 15px; color: #cbd5e1; text-decoration: none; border-radius: 8px; margin-bottom: 5px; transition: 0.3s;
        }
        .sidebar nav a:hover, .sidebar nav a.active { background: rgba(255,255,255,0.1); color: #fff; }
        
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
        }
        .topbar {
            height: var(--topbar-height);
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex; align-items: center; justify-content: flex-end; padding: 0 2rem;
        }
        .admin-info { display: flex; align-items: center; gap: 10px; font-weight: 500; }
        
        .content-area { padding: 2rem; }
        
        /* Table styles */
        .table-card { background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px 20px; text-align: left; border-bottom: 1px solid #f1f5f9; }
        th { background: #f8fafc; font-weight: 600; color: #64748b; font-size: 0.85rem; text-transform: uppercase; }
        
        /* Buttons */
        .btn { padding: 8px 16px; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 0.85rem; border: none; font-weight: 500; transition: 0.2s; display: inline-flex; align-items: center; gap: 5px; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-accent { background: var(--accent); color: #fff; }
        .btn-danger { background: #ef4444; color: #fff; }
        .btn:hover { opacity: 0.9; }

        /* Flash messages */
        .alert { padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; }
        .alert-success { background: #dcfce7; color: #166534; border-left: 5px solid #22c55e; }
        .alert-error { background: #fee2e2; color: #991b1b; border-left: 5px solid #ef4444; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <a href="dashboard.php" class="logo">TaxPro <span style="color:#fff">Admin</span></a>
        <nav>
            <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="inquiries.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'inquiries.php' ? 'active' : ''; ?>">
                <i class="fas fa-envelope-open-text"></i> Inquiries
            </a>
            <a href="logout.php" style="margin-top: 50px; color: #fca5a5;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div class="admin-info">
                <i class="fas fa-user-circle fa-lg"></i>
                <span>Hello, <?php echo sanitize($_SESSION['admin_name'] ?? 'Admin'); ?></span>
            </div>
        </header>
        <div class="content-area">
            <?php if ($flash = getFlash()): ?>
                <div class="alert alert-<?php echo $flash['type']; ?>">
                    <?php echo $flash['message']; ?>
                </div>
            <?php endif; ?>
