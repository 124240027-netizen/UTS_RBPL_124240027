<?php
require_once '../includes/config.php';

// Cek apakah user adalah admin
if (!is_logged_in() || !is_admin()) {
    redirect('../login.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = escape($_POST['name']);
    $email = escape($_POST['email']);
    $phone = escape($_POST['phone']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    
    // Validasi
    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        $error = 'Semua field harus diisi!';
    } elseif ($password !== $password_confirm) {
        $error = 'Password tidak cocok!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        // Cek apakah email sudah terdaftar
        $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
        
        if ($check->num_rows > 0) {
            $error = 'Email sudah terdaftar!';
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            // Insert ke database
            $insert = $conn->query("INSERT INTO users (name, email, phone, password, role) 
                                   VALUES ('$name', '$email', '$phone', '$hashed_password', 'admin')");
            
            if ($insert) {
                $success = 'Admin berhasil ditambahkan! Email: ' . $email;
                // Clear form
                $_POST = array();
            } else {
                $error = 'Gagal menambahkan admin: ' . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Admin - <?php echo SITE_NAME; ?></title>
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
                <a href="add_admin.php" class="menu-item active">
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
            <h1><i class="fas fa-user-shield"></i> Tambah Admin Baru</h1>

            <div class="admin-form-container">
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

                <form method="POST" action="" class="admin-form">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" required 
                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        <small>Email akan digunakan untuk login</small>
                    </div>

                    <div class="form-group">
                        <label for="phone">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone" required 
                               value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        <small>Minimal 6 karakter</small>
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Konfirmasi Password</label>
                        <input type="password" id="password_confirm" name="password_confirm" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Tambahkan Admin
                    </button>
                    <a href="dashboard.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </form>

                <!-- Info Box -->
                <div class="info-box" style="margin-top: 30px;">
                    <h3><i class="fas fa-info-circle"></i> Informasi Penting</h3>
                    <ul>
                        <li>Admin yang ditambahkan dapat login ke admin panel</li>
                        <li>Email harus unik dan belum terdaftar sebelumnya</li>
                        <li>Pastikan password kuat untuk keamanan sistem</li>
                        <li>Admin dapat mengelola semua fitur di admin panel</li>
                    </ul>
                </div>
            </div>
        </main>
    </div>

    <style>
        .admin-form-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .admin-form {
            max-width: 500px;
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

        .form-group input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
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
            margin-right: 10px;
            margin-bottom: 10px;
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

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 20px;
            border-radius: 4px;
        }

        .info-box h3 {
            margin-top: 0;
            color: #007bff;
        }

        .info-box ul {
            margin: 10px 0;
            padding-left: 20px;
        }

        .info-box li {
            margin: 8px 0;
            color: #555;
        }
    </style>
</body>
</html>
