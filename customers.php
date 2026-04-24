<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('../login.php');
}

$customers = $conn->query("SELECT * FROM users WHERE role='customer' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pelanggan - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-page">
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <h2><i class="fas fa-camera"></i> Admin</h2>
            </div>
            <nav class="sidebar-menu">
                <a href="dashboard.php" class="menu-item"><i class="fas fa-home"></i> Dashboard</a>
                <a href="bookings.php" class="menu-item"><i class="fas fa-calendar"></i> Pemesanan</a>
                <a href="packages.php" class="menu-item"><i class="fas fa-box"></i> Paket</a>
                <a href="portfolio.php" class="menu-item"><i class="fas fa-images"></i> Portfolio</a>
                <a href="customers.php" class="menu-item active"><i class="fas fa-users"></i> Pelanggan</a>
                <a href="testimonials.php" class="menu-item"><i class="fas fa-comments"></i> Testimoni</a>
                <a href="add_admin.php" class="menu-item"><i class="fas fa-user-shield"></i> Tambah Admin</a>
                <a href="settings.php" class="menu-item"><i class="fas fa-cog"></i> Pengaturan</a>
                <a href="../logout.php" class="menu-item logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>

        <main class="admin-content">
            <h1>Daftar Pelanggan</h1>

            <div class="admin-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while($customer = $customers->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $customer['name']; ?></td>
                            <td><?php echo $customer['email']; ?></td>
                            <td><?php echo $customer['phone']; ?></td>
                            <td><?php echo date('d M Y', strtotime($customer['created_at'])); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
