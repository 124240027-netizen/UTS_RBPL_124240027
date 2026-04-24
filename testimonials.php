<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('../login.php');
}

$testimonials = $conn->query("SELECT * FROM testimonials ORDER BY created_at DESC");

// Update status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $status = escape($_POST['status']);
    $conn->query("UPDATE testimonials SET status='$status' WHERE id=$id");
    header('Location: testimonials.php');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Testimoni - Admin</title>
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
                <a href="testimonials.php" class="menu-item active"><i class="fas fa-comments"></i> Testimoni</a>
                <a href="add_admin.php" class="menu-item"><i class="fas fa-user-shield"></i> Tambah Admin</a>
                <a href="settings.php" class="menu-item"><i class="fas fa-cog"></i> Pengaturan</a>
                <a href="../logout.php" class="menu-item logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>

        <main class="admin-content">
            <h1>Kelola Testimoni</h1>

            <div class="admin-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Rating</th>
                            <th>Pesan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($testimonial = $testimonials->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $testimonial['name']; ?></td>
                            <td>
                                <?php for($i = 0; $i < $testimonial['rating']; $i++): ?>
                                    <i class="fas fa-star" style="color: #ffc107;"></i>
                                <?php endfor; ?>
                            </td>
                            <td><?php echo substr($testimonial['message'], 0, 50) . '...'; ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo $testimonial['id']; ?>">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="pending" <?php echo $testimonial['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="approved" <?php echo $testimonial['status'] == 'approved' ? 'selected' : ''; ?>>Disetujui</option>
                                        <option value="rejected" <?php echo $testimonial['status'] == 'rejected' ? 'selected' : ''; ?>>Ditolak</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="#" class="btn btn-small" onclick="return false;">Lihat</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
