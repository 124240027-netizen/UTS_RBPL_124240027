<?php
require_once 'includes/config.php';

if (is_logged_in()) {
    redirect('dashboard.php');
}

$error = '';
$admin_code = 'RANTAUGRAFI2024'; // Admin registration code

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = escape($_POST['name']);
    $email = escape($_POST['email']);
    $phone = escape($_POST['phone']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $role = isset($_POST['role']) ? escape($_POST['role']) : 'customer';
    
    // Validasi dasar
    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        $error = 'Semua field harus diisi!';
    } elseif ($password !== $password_confirm) {
        $error = 'Password tidak cocok!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        // Validasi admin registration
        if ($role == 'admin') {
            $admin_code_input = isset($_POST['admin_code']) ? $_POST['admin_code'] : '';
            if ($admin_code_input !== $admin_code) {
                $error = 'Admin code salah! Hubungi administrator untuk mendapatkan kode.';
                $role = 'customer'; // Reset role ke customer jika kode salah
            }
        }
        
        if (!$error) {
            // Cek apakah email sudah terdaftar
            $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
            
            if ($check->num_rows > 0) {
                $error = 'Email sudah terdaftar!';
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                
                $insert = $conn->query("INSERT INTO users (name, email, phone, password, role) 
                                       VALUES ('$name', '$email', '$phone', '$hashed_password', '$role')");
                
                if ($insert) {
                    redirect('login.php?success=1');
                } else {
                    $error = 'Gagal mendaftar, silakan coba lagi!';
                }
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
    <title>Daftar - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <h1><i class="fas fa-camera"></i> Rantaugrafi</h1>
            <h2>Buat Akun Baru</h2>
            
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">Pendaftaran berhasil! Silakan login.</div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="register.php">
                <div class="form-group">
                    <label>Daftar Sebagai:</label>
                    <div class="role-selector">
                        <label class="radio-label">
                            <input type="radio" name="role" value="customer" checked onchange="toggleAdminCode()">
                            <i class="fas fa-user"></i> Customer / Pelanggan
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="role" value="admin" onchange="toggleAdminCode()">
                            <i class="fas fa-user-shield"></i> Admin
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" required value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
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
                
                <div class="form-group" id="admin_code_field" style="display: none;">
                    <label for="admin_code">Admin Code</label>
                    <input type="password" id="admin_code" name="admin_code" placeholder="Masukkan kode admin">
                    <small>Hubungi administrator untuk mendapatkan kode admin</small>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Daftar</button>
            </form>
            
            <p class="auth-link">Sudah memiliki akun? <a href="login.php">Masuk di sini</a></p>
        </div>
    </div>

    <style>
        .role-selector {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: all 0.3s;
        }

        .radio-label:hover {
            border-color: #007bff;
            background: #f8f9fa;
        }

        .radio-label input[type="radio"] {
            cursor: pointer;
            width: 16px;
            height: 16px;
        }

        .radio-label input[type="radio"]:checked {
            accent-color: #007bff;
        }

        .radio-label i {
            color: #007bff;
        }

        .form-group small {
            display: block;
            margin-top: 5px;
            color: #666;
            font-size: 12px;
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
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
    </style>

    <script>
        function toggleAdminCode() {
            const role = document.querySelector('input[name="role"]:checked').value;
            const adminCodeField = document.getElementById('admin_code_field');
            
            if (role === 'admin') {
                adminCodeField.style.display = 'block';
            } else {
                adminCodeField.style.display = 'none';
                document.getElementById('admin_code').value = ''; // Clear field jika pilih customer
            }
        }
    </script>
</body>
</html>
