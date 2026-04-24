<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('../login.php');
}

// Ambil data dashboard
$total_bookings = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'];
$pending_bookings = $conn->query("SELECT COUNT(*) as total FROM bookings WHERE status = 'pending'")->fetch_assoc()['total'];
$total_revenue = $conn->query("SELECT SUM(total_price) as total FROM bookings WHERE payment_status = 'paid'")->fetch_assoc()['total'];
$total_customers = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'customer'")->fetch_assoc()['total'];

// Ambil booking terbaru
$recent_bookings = $conn->query("SELECT b.*, u.name, p.name as package_name 
                                FROM bookings b 
                                JOIN users u ON b.user_id = u.id 
                                JOIN packages p ON b.package_id = p.id 
                                ORDER BY b.created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo SITE_NAME; ?></title>
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
                <a href="dashboard.php" class="menu-item active">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="bookings.php" class="menu-item">
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
            <h1>Dashboard Admin</h1>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-calendar"></i>
                    <div>
                        <h3><?php echo $total_bookings; ?></h3>
                        <p>Total Pemesanan</p>
                    </div>
                </div>
                <div class="stat-card warning">
                    <i class="fas fa-clock"></i>
                    <div>
                        <h3><?php echo $pending_bookings; ?></h3>
                        <p>Pemesanan Pending</p>
                    </div>
                </div>
                <div class="stat-card success">
                    <i class="fas fa-money-bill"></i>
                    <div>
                        <h3><?php echo format_currency($total_revenue); ?></h3>
                        <p>Total Pendapatan</p>
                    </div>
                </div>
                <div class="stat-card info">
                    <i class="fas fa-users"></i>
                    <div>
                        <h3><?php echo $total_customers; ?></h3>
                        <p>Total Pelanggan</p>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="admin-card">
                <h2>Pemesanan Terbaru</h2>
                <?php if ($recent_bookings->num_rows > 0): ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Paket</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($booking = $recent_bookings->fetch_assoc()): ?>
                            <tr>
                                <td>#<?php echo $booking['id']; ?></td>
                                <td><?php echo $booking['name']; ?></td>
                                <td><?php echo $booking['package_name']; ?></td>
                                <td><?php echo format_date($booking['event_date']); ?></td>
                                <td><span class="status-badge status-<?php echo $booking['status']; ?>"><?php echo ucfirst($booking['status']); ?></span></td>
                                <td><?php echo format_currency($booking['total_price']); ?></td>
                                <td>
                                    <a href="bookings.php" class="btn btn-small">Lihat</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>
