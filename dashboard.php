<?php
require_once 'includes/config.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];
$bookings = $conn->query("SELECT b.*, p.name as package_name 
                         FROM bookings b 
                         JOIN packages p ON b.package_id = p.id 
                         WHERE b.user_id = $user_id 
                         ORDER BY b.created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <h1><i class="fas fa-camera"></i> Rantaugrafi</h1>
            </div>
            <ul class="navbar-menu">
                <li><a href="index.php">Beranda</a></li>
                <?php if (is_admin()): ?>
                    <li><a href="admin/dashboard.php">Admin Panel</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="padding: 40px 0;">
        <h1>Dashboard Saya</h1>
        
        <div class="user-info">
            <p>Selamat datang, <strong><?php echo $_SESSION['user_name']; ?></strong></p>
        </div>

        <div class="dashboard-actions">
            <a href="booking.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Pesan Layanan
            </a>
        </div>

        <h2>Pemesanan Saya</h2>

        <?php if ($bookings->num_rows > 0): ?>
            <div class="bookings-table">
                <table>
                    <thead>
                        <tr>
                            <th>No. Pesanan</th>
                            <th>Paket</th>
                            <th>Tanggal Acara</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($booking = $bookings->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $booking['id']; ?></td>
                            <td><?php echo $booking['package_name']; ?></td>
                            <td><?php echo format_date($booking['event_date']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $booking['status']; ?>">
                                    <?php echo ucfirst($booking['status']); ?>
                                </span>
                            </td>
                            <td><?php echo format_currency($booking['total_price']); ?></td>
                            <td>
                                <a href="booking-detail.php?id=<?php echo $booking['id']; ?>" class="btn btn-small">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                Belum ada pemesanan. <a href="booking.php">Pesan layanan sekarang</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
