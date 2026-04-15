<?php 
declare(strict_types=1);
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin();

$id = (int)($_GET['id'] ?? 0);
if (!$id) { header("Location: inquiries.php"); exit(); }

// Fetch current data
$stmt = $mysqli->prepare("SELECT * FROM inquiries WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$inquiry = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$inquiry) { header("Location: inquiries.php"); exit(); }

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? $inquiry['status'];
    $city = $_POST['city'] ?? $inquiry['city'];
    $service = $_POST['service'] ?? $inquiry['service'];
    $message = $_POST['message'] ?? $inquiry['message'];
    
    $upd = $mysqli->prepare("UPDATE inquiries SET status=?, city=?, service=?, message=? WHERE id=?");
    $upd->bind_param("ssssi", $status, $city, $service, $message, $id);
    
    if ($upd->execute()) {
        setFlash('success', "Inquiry updated successfully!");
        header("Location: inquiries.php");
        exit();
    }
    $upd->close();
}

require_once __DIR__ . '/../includes/header.php';
?>

<div style="max-width: 600px;">
    <h1 style="margin-bottom: 25px;">Edit Inquiry</h1>
    
    <div class="table-card" style="padding: 30px;">
        <form method="POST">
            <div style="display: flex; gap: 20px; margin-bottom: 20px; padding: 15px; background: #f8fafc; border-radius: 8px;">
                <div style="flex:1">
                    <label style="color: #64748b; font-size: 0.8rem; text-transform: uppercase;">Client Name</label>
                    <div style="font-weight: 600;"><?php echo sanitize($inquiry['full_name']); ?></div>
                </div>
                <div style="flex:1">
                    <label style="color: #64748b; font-size: 0.8rem; text-transform: uppercase;">Email</label>
                    <div style="font-weight: 600;"><?php echo sanitize($inquiry['email']); ?></div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label>Inquiry Status</label>
                <select name="status" class="btn" style="width: 100%; border: 1px solid #ddd; background: #fff; padding: 10px;">
                    <option value="new" <?php echo $inquiry['status'] == 'new' ? 'selected' : ''; ?>>New</option>
                    <option value="contacted" <?php echo $inquiry['status'] == 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                    <option value="closed" <?php echo $inquiry['status'] == 'closed' ? 'selected' : ''; ?>>Closed</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label>City</label>
                <input type="text" name="city" value="<?php echo sanitize($inquiry['city']); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label>Service</label>
                <select name="service" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    <?php 
                    $services = ['Tax Filing', 'GST Registration', 'Audit', 'Company Registration', 'Accounting', 'Other'];
                    foreach($services as $s): ?>
                        <option value="<?php echo $s; ?>" <?php echo $inquiry['service'] == $s ? 'selected' : ''; ?>><?php echo $s; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label>Full Message</label>
                <textarea name="message" rows="5" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"><?php echo sanitize($inquiry['message']); ?></textarea>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 25px;">Update Changes</button>
                <a href="inquiries.php" class="btn" style="background: #e2e8f0; color: #475569; padding: 12px 25px;">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
