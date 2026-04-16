<?php 
declare(strict_types=1);
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin();

$id = (int)($_GET['id'] ?? 0);
if (!$id) { header("Location: inquiries.php"); exit(); }


$stmt = $mysqli->prepare("SELECT full_name FROM inquiries WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$inquiry = $res->fetch_assoc();
$stmt->close();

if (!$inquiry) { header("Location: inquiries.php"); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $del = $mysqli->prepare("DELETE FROM inquiries WHERE id = ?");
    $del->bind_param("i", $id);
    if ($del->execute()) {
        setFlash('success', "Inquiry deleted successfully.");
        header("Location: inquiries.php");
        exit();
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div style="max-width: 500px; margin: 50px auto; text-align: center;">
    <div class="table-card" style="padding: 40px;">
        <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #ef4444; margin-bottom: 20px;"></i>
        <h2>Confirm Deletion</h2>
        <p style="margin: 20px 0; color: #64748b;">
            Are you sure you want to delete the inquiry from <br>
            <strong>"<?php echo sanitize($inquiry['full_name']); ?>"</strong>?<br>
            This action cannot be undone.
        </p>
        
        <form method="POST">
            <div style="display: flex; justify-content: center; gap: 10px;">
                <button type="submit" class="btn btn-danger" style="padding: 12px 30px;">Yes, Delete Permanently</button>
                <a href="inquiries.php" class="btn" style="background: #e2e8f0; color: #475569; padding: 12px 30px;">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
