<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('../login.php');
}

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$packages = null;

if ($action == 'list') {
    $packages = $conn->query("SELECT * FROM packages ORDER BY created_at DESC");
}

// Add/Edit Package
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = escape($_POST['name']);
    $description = escape($_POST['description']);
    $price = (float)$_POST['price'];
    $duration = escape($_POST['duration']);
    $features = escape($_POST['features']);
    $status = escape($_POST['status']);
    $package_id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    
    if ($package_id) {
        $conn->query("UPDATE packages SET name='$name', description='$description', price=$price, 
                    duration='$duration', features='$features', status='$status' WHERE id=$package_id");
    } else {
        $conn->query("INSERT INTO packages (name, description, price, duration, features, status) 
                    VALUES ('$name', '$description', $price, '$duration', '$features', '$status')");
    }
    
    header('Location: packages.php');
}

// Delete Package
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM packages WHERE id=$id");
    header('Location: packages.php');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Paket - Admin</title>
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
                <a href="packages.php" class="menu-item active"><i class="fas fa-box"></i> Paket</a>
                <a href="portfolio.php" class="menu-item"><i class="fas fa-images"></i> Portfolio</a>
                <a href="customers.php" class="menu-item"><i class="fas fa-users"></i> Pelanggan</a>
                <a href="testimonials.php" class="menu-item"><i class="fas fa-comments"></i> Testimoni</a>
                <a href="add_admin.php" class="menu-item"><i class="fas fa-user-shield"></i> Tambah Admin</a>
                <a href="settings.php" class="menu-item"><i class="fas fa-cog"></i> Pengaturan</a>
                <a href="../logout.php" class="menu-item logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>

        <main class="admin-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h1>Kelola Paket Layanan</h1>
                <a href="packages.php?action=add" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Paket
                </a>
            </div>

            <?php if ($action == 'list'): ?>
                <div class="admin-card">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nama Paket</th>
                                <th>Harga</th>
                                <th>Durasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($package = $packages->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $package['name']; ?></td>
                                <td><?php echo format_currency($package['price']); ?></td>
                                <td><?php echo $package['duration']; ?></td>
                                <td><span class="status-badge status-<?php echo $package['status']; ?>"><?php echo ucfirst($package['status']); ?></span></td>
                                <td>
                                    <a href="packages.php?action=edit&id=<?php echo $package['id']; ?>" class="btn-edit">Edit</a>
                                    <a href="packages.php?delete=<?php echo $package['id']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="admin-card">
                    <h2><?php echo isset($_GET['id']) ? 'Edit Paket' : 'Tambah Paket Baru'; ?></h2>
                    <form method="POST" class="admin-form">
                        <?php if (isset($_GET['id'])): 
                            $pkg = $conn->query("SELECT * FROM packages WHERE id=" . (int)$_GET['id'])->fetch_assoc();
                        ?>
                            <input type="hidden" name="id" value="<?php echo $pkg['id']; ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="name">Nama Paket</label>
                            <input type="text" id="name" name="name" value="<?php echo isset($pkg) ? $pkg['name'] : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea id="description" name="description" rows="4"><?php echo isset($pkg) ? $pkg['description'] : ''; ?></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="price">Harga (Rp)</label>
                                <input type="number" id="price" name="price" step="1000" value="<?php echo isset($pkg) ? $pkg['price'] : ''; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="duration">Durasi</label>
                                <input type="text" id="duration" name="duration" placeholder="Contoh: 4 jam" value="<?php echo isset($pkg) ? $pkg['duration'] : ''; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="features">Fitur (pisahkan dengan koma)</label>
                            <textarea id="features" name="features" rows="4"><?php echo isset($pkg) ? $pkg['features'] : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status" required>
                                <option value="active" <?php echo isset($pkg) && $pkg['status'] == 'active' ? 'selected' : ''; ?>>Aktif</option>
                                <option value="inactive" <?php echo isset($pkg) && $pkg['status'] == 'inactive' ? 'selected' : ''; ?>>Nonaktif</option>
                            </select>
                        </div>

                        <div style="display: flex; gap: 1rem;">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="packages.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
