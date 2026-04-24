<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('../login.php');
}

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$error = '';
$success = '';

// List bookings
if ($action == 'list') {
    $status_filter = isset($_GET['status']) ? escape($_GET['status']) : '';
    $query = "SELECT b.*, u.name, p.name as package_name 
              FROM bookings b 
              JOIN users u ON b.user_id = u.id 
              JOIN packages p ON b.package_id = p.id";
    
    if ($status_filter) {
        $query .= " WHERE b.status = '$status_filter'";
    }
    
    $query .= " ORDER BY b.created_at DESC";
    $bookings = $conn->query($query);
}

// Update booking status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['booking_id'])) {
    $booking_id = (int)$_POST['booking_id'];
    $new_status = escape($_POST['status']);
    
    $update = $conn->query("UPDATE bookings SET status = '$new_status' WHERE id = $booking_id");
    
    if ($update) {
        $success = 'Status pemesanan telah diperbarui!';
    } else {
        $error = 'Gagal memperbarui status!';
    }
    
    $bookings = $conn->query($query);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pemesanan - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-page">
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <h2><i class="fas fa-camera"></i> Admin Panel</h2>
            </div>
            <nav class="sidebar-menu">
                <a href="dashboard.php" class="menu-item">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="bookings.php" class="menu-item active">
                    <i class="fas fa-calendar"></i> Pemesanan
                </a>
                <a href="packages.php" class="menu-item">
                    <i class="fas fa-box"></i> Paket
                </a>
                <a href="portfolio.php" class="menu-item">
                    <i class="fas fa-images"></i> Portfolio
                </a>
                <a href="customers.php" class="menu-item">
                    <i class="fas fa-users"></i> Pelanggan
                </a>
                <a href="testimonials.php" class="menu-item">
                    <i class="fas fa-comments"></i> Testimoni
                </a>
                <a href="add_admin.php" class="menu-item">
                    <i class="fas fa-user-shield"></i> Tambah Admin
                </a>
                <a href="settings.php" class="menu-item">
                    <i class="fas fa-cog"></i> Pengaturan
                </a>
                <a href="../logout.php" class="menu-item logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-content">
            <h1>Kelola Pemesanan</h1>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <!-- Filter -->
            <div class="filter-buttons">
                <a href="bookings.php" class="btn <?php echo !isset($_GET['status']) ? 'btn-primary' : 'btn-secondary'; ?>">Semua</a>
                <a href="bookings.php?status=pending" class="btn <?php echo isset($_GET['status']) && $_GET['status'] == 'pending' ? 'btn-primary' : 'btn-secondary'; ?>">Pending</a>
                <a href="bookings.php?status=confirmed" class="btn <?php echo isset($_GET['status']) && $_GET['status'] == 'confirmed' ? 'btn-primary' : 'btn-secondary'; ?>">Dikonfirmasi</a>
                <a href="bookings.php?status=completed" class="btn <?php echo isset($_GET['status']) && $_GET['status'] == 'completed' ? 'btn-primary' : 'btn-secondary'; ?>">Selesai</a>
            </div>

            <div class="admin-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Paket</th>
                            <th>Tanggal Acara</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($booking = $bookings->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $booking['id']; ?></td>
                            <td><?php echo $booking['name']; ?></td>
                            <td><?php echo $booking['package_name']; ?></td>
                            <td><?php echo format_date($booking['event_date']); ?></td>
                            <td><?php echo substr($booking['location'], 0, 20) . '...'; ?></td>
                            <td><span class="status-badge status-<?php echo $booking['status']; ?>"><?php echo ucfirst($booking['status']); ?></span></td>
                            <td><?php echo format_currency($booking['total_price']); ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="pending" <?php echo $booking['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="confirmed" <?php echo $booking['status'] == 'confirmed' ? 'selected' : ''; ?>>Dikonfirmasi</option>
                                        <option value="rejected" <?php echo $booking['status'] == 'rejected' ? 'selected' : ''; ?>>Ditolak</option>
                                        <option value="completed" <?php echo $booking['status'] == 'completed' ? 'selected' : ''; ?>>Selesai</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>
