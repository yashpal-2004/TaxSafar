<?php 
declare(strict_types=1);
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin();


$stats = ['total' => 0, 'new' => 0, 'contacted' => 0, 'closed' => 0];

$query = "SELECT status, COUNT(*) as count FROM inquiries GROUP BY status";
$res = $mysqli->query($query);
while($row = $res->fetch_assoc()) {
    $stats[$row['status']] = (int)$row['count'];
}
$stats['total'] = array_sum($stats);


$recent_stmt = $mysqli->prepare("SELECT id, full_name, email, service, status, created_at FROM inquiries ORDER BY created_at DESC LIMIT 5");
$recent_stmt->execute();
$recent_result = $recent_stmt->get_result();
$recent_stmt->close();

require_once __DIR__ . '/../includes/header.php';
?>

<h1 style="margin-bottom: 30px;">Dashboard Overview</h1>

<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px;">
    <div style="background: #fff; padding: 25px; border-radius: 12px; border-left: 5px solid #3b82f6; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
        <div style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Total Inquiries</div>
        <div style="font-size: 1.8rem; font-weight: 700; margin-top: 5px;"><?php echo $stats['total']; ?></div>
    </div>
    <div style="background: #fff; padding: 25px; border-radius: 12px; border-left: 5px solid #f97316; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
        <div style="color: #64748b; font-size: 0.9rem; font-weight: 500;">New</div>
        <div style="font-size: 1.8rem; font-weight: 700; margin-top: 5px;"><?php echo $stats['new']; ?></div>
    </div>
    <div style="background: #fff; padding: 25px; border-radius: 12px; border-left: 5px solid #8b5cf6; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
        <div style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Contacted</div>
        <div style="font-size: 1.8rem; font-weight: 700; margin-top: 5px;"><?php echo $stats['contacted']; ?></div>
    </div>
    <div style="background: #fff; padding: 25px; border-radius: 12px; border-left: 5px solid #22c55e; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
        <div style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Closed</div>
        <div style="font-size: 1.8rem; font-weight: 700; margin-top: 5px;"><?php echo $stats['closed']; ?></div>
    </div>
</div>

<div class="table-card">
    <div style="padding: 20px; border-bottom: 1px solid #f1f5f9; font-weight: 600;">Recent 5 Inquiries</div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client Name</th>
                <th>Email</th>
                <th>Service</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if($recent_result->num_rows > 0): while($row = $recent_result->fetch_assoc()): ?>
            <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td><?php echo sanitize($row['full_name']); ?></td>
                <td><?php echo sanitize($row['email']); ?></td>
                <td><?php echo sanitize($row['service']); ?></td>
                <td><?php echo getStatusBadge($row['status']); ?></td>
                <td style="font-size: 0.85rem; color: #64748b;"><?php echo formatDate($row['created_at']); ?></td>
                <td>
                    <a href="edit_inquiry.php?id=<?php echo $row['id']; ?>" class="btn btn-primary" style="padding: 4px 10px;"><i class="fas fa-edit"></i></a>
                </td>
            </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="7" style="text-align:center">No records found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
