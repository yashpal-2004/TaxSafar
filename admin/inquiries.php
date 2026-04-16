<?php 
declare(strict_types=1);
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin();

$search = $_GET['search'] ?? '';
$status_filter = $_GET['status'] ?? 'all';
$page = (int)($_GET['page'] ?? 1);
$limit = 10;
$offset = ($page - 1) * $limit;


$where = " WHERE 1=1";
$params = [];
$types = "";

if (!empty($search)) {
    $where .= " AND (full_name LIKE ? OR email LIKE ? OR mobile LIKE ?)";
    $sterm = "%$search%";
    $params[] = $sterm;
    $params[] = $sterm;
    $params[] = $sterm;
    $types .= "sss";
}

if ($status_filter !== 'all') {
    $where .= " AND status = ?";
    $params[] = $status_filter;
    $types .= "s";
}


$count_query = "SELECT COUNT(*) as total FROM inquiries" . $where;
$count_stmt = $mysqli->prepare($count_query);
if (!empty($params)) {
    $count_stmt->bind_param($types, ...$params);
}
$count_stmt->execute();
$total_records = $count_stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_records / $limit);
$count_stmt->close();


$select_query = "SELECT * FROM inquiries" . $where . " ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = $mysqli->prepare($select_query);


$final_params = $params;
$final_params[] = $limit;
$final_params[] = $offset;
$final_types = $types . "ii";

$stmt->bind_param($final_types, ...$final_params);
$stmt->execute();
$result = $stmt->get_result();

require_once __DIR__ . '/../includes/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <h1>Managed Inquiries</h1>
</div>

<div class="table-card" style="padding: 20px; margin-bottom: 20px;">
    <form id="filterForm" method="GET" style="display: flex; gap: 15px;">
        <input type="text" name="search" id="searchInput" placeholder="Search name, email, mobile..." value="<?php echo sanitize($search); ?>" style="flex:1; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
        <select name="status" id="statusSelect" style="padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            <option value="all">All Status</option>
            <option value="new" <?php echo $status_filter == 'new' ? 'selected' : ''; ?>>New</option>
            <option value="contacted" <?php echo $status_filter == 'contacted' ? 'selected' : ''; ?>>Contacted</option>
            <option value="closed" <?php echo $status_filter == 'closed' ? 'selected' : ''; ?>>Closed</option>
        </select>
        <a href="inquiries.php" class="btn" style="background: #e2e8f0; color: #475569;">Clear</a>
    </form>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Client Name</th>
                <th>Contact info</th>
                <th>City</th>
                <th>Service</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if($result->num_rows > 0): while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td style="font-weight: 600;"><?php echo sanitize($row['full_name']); ?></td>
                <td style="font-size: 0.85rem">
                    <i class="fas fa-envelope"></i> <?php echo sanitize($row['email']); ?><br>
                    <i class="fas fa-phone"></i> <?php echo sanitize($row['mobile']); ?>
                </td>
                <td><?php echo sanitize($row['city']); ?></td>
                <td><?php echo sanitize($row['service']); ?></td>
                <td><?php echo getStatusBadge($row['status']); ?></td>
                <td><?php echo formatDate($row['created_at']); ?></td>
                <td>
                    <div style="display: flex; gap: 5px;">
                        <a href="edit_inquiry.php?id=<?php echo $row['id']; ?>" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="delete_inquiry.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="8" style="text-align:center; padding: 40px;">No inquiries found matching your criteria.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<?php if ($total_pages > 1): ?>
<div style="display: flex; justify-content: center; gap: 5px; margin-top: 30px;">
    <?php for($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>" 
           style="padding: 8px 15px; border-radius: 6px; text-decoration: none; <?php echo $page == $i ? 'background:var(--primary); color:#fff;' : 'background:#fff; color:var(--primary);' ?>">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<?php 
$stmt->close();
?>
<script>
    const filterForm = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const statusSelect = document.getElementById('statusSelect');

    let timeout = null;


    searchInput.addEventListener('input', () => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            filterForm.submit();
        }, 500);
    });


    statusSelect.addEventListener('change', () => {
        filterForm.submit();
    });


    if (searchInput.value) {
        searchInput.focus();
        searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
    }
</script>
<?php
require_once __DIR__ . '/../includes/footer.php'; 
?>
