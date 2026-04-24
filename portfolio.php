<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('../login.php');
}

$error = '';
$success = '';
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Handle upload portfolio baru
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'add') {
    $title = escape($_POST['title']);
    $description = escape($_POST['description']);
    $category = escape($_POST['category']);
    $image_path = 'uploads/placeholder-3.jpg'; // Default
    
    // Handle file upload
    if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = basename($_FILES['image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        
        if (in_array($file_ext, $allowed_ext)) {
            // Generate unique filename
            $new_file_name = 'portfolio_' . time() . '.' . $file_ext;
            $upload_path = '../uploads/' . $new_file_name;
            
            if (move_uploaded_file($file_tmp, $upload_path)) {
                $image_path = 'uploads/' . $new_file_name;
                
                // Insert ke database
                $insert = $conn->query("INSERT INTO portfolio (title, description, image_path, category) 
                                       VALUES ('$title', '$description', '$image_path', '$category')");
                
                if ($insert) {
                    $success = 'Portfolio berhasil ditambahkan!';
                    $action = 'list';
                } else {
                    $error = 'Gagal menyimpan ke database: ' . $conn->error;
                }
            } else {
                $error = 'Gagal upload file!';
            }
        } else {
            $error = 'Format file tidak didukung! (jpg, png, gif)';
        }
    } else {
        $error = 'Silakan pilih file gambar!';
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $portfolio = $conn->query("SELECT image_path FROM portfolio WHERE id=$id")->fetch_assoc();
    
    if ($portfolio) {
        // Hapus file
        $file_path = '../' . $portfolio['image_path'];
        if (file_exists($file_path) && strpos($portfolio['image_path'], 'placeholder') === false) {
            @unlink($file_path);
        }
        
        // Hapus dari database
        $conn->query("DELETE FROM portfolio WHERE id=$id");
        $success = 'Portfolio berhasil dihapus!';
    }
    
    $action = 'list';
}

// Ambil semua portfolio
$portfolios = $conn->query("SELECT * FROM portfolio ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Portfolio - Admin</title>
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
                <a href="portfolio.php" class="menu-item active"><i class="fas fa-images"></i> Portfolio</a>
                <a href="customers.php" class="menu-item"><i class="fas fa-users"></i> Pelanggan</a>
                <a href="testimonials.php" class="menu-item"><i class="fas fa-comments"></i> Testimoni</a>
                <a href="add_admin.php" class="menu-item"><i class="fas fa-user-shield"></i> Tambah Admin</a>
                <a href="settings.php" class="menu-item"><i class="fas fa-cog"></i> Pengaturan</a>
                <a href="../logout.php" class="menu-item logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>

        <main class="admin-content">
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($action == 'add'): ?>
                <!-- Form Tambah Portfolio -->
                <h1>Tambah Portfolio Baru</h1>
                <div class="admin-card">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Judul Portfolio</label>
                            <input type="text" id="title" name="title" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <select id="category" name="category" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Pernikahan">Pernikahan</option>
                                <option value="Pre-wedding">Pre-wedding</option>
                                <option value="Corporate">Corporate</option>
                                <option value="Dokumentasi">Dokumentasi</option>
                                <option value="Product">Product</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea id="description" name="description" rows="4"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="image">Foto Portfolio</label>
                            <input type="file" id="image" name="image" accept="image/*" required>
                            <small>Format: JPG, PNG, GIF | Max: 5MB</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Portfolio
                        </button>
                        <a href="portfolio.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </form>
                </div>

            <?php else: ?>
                <!-- List Portfolio -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h1>Kelola Portfolio</h1>
                    <a href="?action=add" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Portfolio</a>
                </div>

                <div class="admin-card">
                    <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem;">
                        <?php while($portfolio = $portfolios->fetch_assoc()): ?>
                        <div style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <div style="position: relative; overflow: hidden; height: 200px;">
                                <img src="../<?php echo $portfolio['image_path']; ?>" 
                                     style="width: 100%; height: 100%; object-fit: cover;" 
                                     alt="<?php echo $portfolio['title']; ?>"
                                     onerror="this.src='../assets/images/placeholder.jpg'">
                            </div>
                            <div style="padding: 1rem;">
                                <h3 style="margin: 0 0 0.5rem 0; font-size: 0.95rem; color: #333;">
                                    <?php echo $portfolio['title']; ?>
                                </h3>
                                <p style="margin: 0 0 0.5rem 0; font-size: 0.85rem; color: #999;">
                                    <i class="fas fa-folder"></i> <?php echo $portfolio['category']; ?>
                                </p>
                                <p style="margin: 0 0 0.8rem 0; font-size: 0.8rem; color: #666;">
                                    <?php echo substr($portfolio['description'], 0, 60); ?>...
                                </p>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="#" class="btn btn-small" style="flex: 1; text-align: center;">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="?delete=<?php echo $portfolio['id']; ?>" 
                                       class="btn btn-small" 
                                       style="flex: 1; text-align: center; background: #e74c3c; color: white;"
                                       onclick="return confirm('Yakin ingin menghapus?');">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>

                    <?php if ($portfolios->num_rows == 0): ?>
                    <div style="text-align: center; padding: 3rem;">
                        <i class="fas fa-images" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem; display: block;"></i>
                        <p style="color: #999; margin-bottom: 1rem;">Belum ada portfolio</p>
                        <a href="?action=add" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Portfolio Pertama
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <style>
        .alert {
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .form-group small {
            display: block;
            margin-top: 5px;
            color: #666;
            font-size: 12px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #545b62;
        }

        .btn-small {
            padding: 8px 12px;
            font-size: 12px;
            background: #17a2b8;
            color: white;
            display: inline-block;
            text-align: center;
        }

        .btn-small:hover {
            background: #138496;
        }

        .admin-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
    </style>
</body>
</html>
