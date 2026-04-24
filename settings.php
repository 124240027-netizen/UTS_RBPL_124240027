<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('../login.php');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Admin</title>
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
                <a href="customers.php" class="menu-item"><i class="fas fa-users"></i> Pelanggan</a>
                <a href="testimonials.php" class="menu-item"><i class="fas fa-comments"></i> Testimoni</a>
                <a href="add_admin.php" class="menu-item"><i class="fas fa-user-shield"></i> Tambah Admin</a>
                <a href="settings.php" class="menu-item active"><i class="fas fa-cog"></i> Pengaturan</a>
                <a href="../logout.php" class="menu-item logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>

        <main class="admin-content">
            <h1>Pengaturan Website</h1>

            <div class="admin-card">
                <h2>Informasi Kontak</h2>
                <form method="POST" class="admin-form">
                    <div class="form-group">
                        <label for="phone">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone" value="+62 812-3456-789">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="info@rantaugrafi.com">
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea id="address" name="address" rows="3">Jl. Merdeka No. 123, Jakarta</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
