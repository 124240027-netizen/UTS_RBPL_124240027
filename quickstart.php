<?php
/**
 * Rantaugrafi - Photography Vendor System
 * Quick Start & Project Info
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rantaugrafi - Quick Start</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 900px;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        .content {
            padding: 2rem;
        }
        .section {
            margin-bottom: 2rem;
        }
        .section h2 {
            color: #667eea;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            border-bottom: 2px solid #667eea;
            padding-bottom: 0.5rem;
        }
        .links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .link-card {
            background: #f9f9f9;
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            text-decoration: none;
            color: #333;
            transition: all 0.3s;
        }
        .link-card:hover {
            border-color: #667eea;
            background: #f5f5ff;
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
        }
        .link-card i {
            font-size: 2rem;
            color: #667eea;
            margin-bottom: 0.5rem;
            display: block;
        }
        .link-card strong {
            display: block;
            margin-bottom: 0.25rem;
        }
        .features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .feature-item {
            display: flex;
            gap: 1rem;
        }
        .feature-item i {
            color: #667eea;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }
        .stat {
            background: #f9f9f9;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
        }
        .stat-number {
            font-size: 2rem;
            color: #667eea;
            font-weight: bold;
        }
        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }
        .alert {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 4px;
        }
        .code {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 1rem;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
            margin: 1rem 0;
        }
        .footer {
            background: #f5f5f5;
            padding: 1.5rem;
            text-align: center;
            color: #666;
            border-top: 1px solid #ddd;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
            margin-top: 0.5rem;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <i class="fas fa-camera"></i>
                Rantaugrafi
            </h1>
            <p>Photography Vendor Sistem Pemesanan Online</p>
        </div>

        <div class="content">
            <!-- Quick Access -->
            <div class="section">
                <h2><i class="fas fa-rocket"></i> Akses Cepat</h2>
                <div class="links-grid">
                    <a href="./" class="link-card">
                        <i class="fas fa-home"></i>
                        <strong>Homepage</strong>
                        <small>Halaman Utama</small>
                    </a>
                    <a href="login.php" class="link-card">
                        <i class="fas fa-sign-in-alt"></i>
                        <strong>Login</strong>
                        <small>Masuk ke Akun</small>
                    </a>
                    <a href="register.php" class="link-card">
                        <i class="fas fa-user-plus"></i>
                        <strong>Registrasi</strong>
                        <small>Buat Akun Baru</small>
                    </a>
                    <a href="admin/dashboard.php" class="link-card">
                        <i class="fas fa-chart-line"></i>
                        <strong>Admin Panel</strong>
                        <small>Panel Administrasi</small>
                    </a>
                    <a href="SETUP.php" class="link-card">
                        <i class="fas fa-book"></i>
                        <strong>Panduan Setup</strong>
                        <small>Instalasi & Konfigurasi</small>
                    </a>
                    <a href="README.md" class="link-card">
                        <i class="fas fa-file-alt"></i>
                        <strong>Dokumentasi</strong>
                        <small>Panduan Lengkap</small>
                    </a>
                </div>
            </div>

            <!-- Key Features -->
            <div class="section">
                <h2><i class="fas fa-star"></i> Fitur Utama</h2>
                <div class="features">
                    <div class="feature-item">
                        <i class="fas fa-users"></i>
                        <div>
                            <strong>Multi-User System</strong>
                            <p>Admin & Customer dengan role berbeda</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-calendar-check"></i>
                        <div>
                            <strong>Sistem Pemesanan</strong>
                            <p>Booking online dengan validasi tanggal</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-credit-card"></i>
                        <div>
                            <strong>Payment Management</strong>
                            <p>Tracking pembayaran dan invoice</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-images"></i>
                        <div>
                            <strong>Portfolio Gallery</strong>
                            <p>Galeri foto hasil pekerjaan</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-comments"></i>
                        <div>
                            <strong>Review System</strong>
                            <p>Rating dan ulasan dari pelanggan</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-cog"></i>
                        <div>
                            <strong>Admin Dashboard</strong>
                            <p>Manajemen lengkap semua aspek</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="section">
                <h2><i class="fas fa-bar-chart"></i> Statistik Sistem</h2>
                <div class="stats">
                    <div class="stat">
                        <div class="stat-number">8</div>
                        <div class="stat-label">Database Tables</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">15+</div>
                        <div class="stat-label">PHP Pages</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Responsive</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">Ready</div>
                        <div class="stat-label">Production</div>
                    </div>
                </div>
            </div>

            <!-- Getting Started -->
            <div class="section">
                <h2><i class="fas fa-play-circle"></i> Memulai</h2>
                
                <h3 style="color: #764ba2; margin: 1rem 0 0.5rem 0;">1. Setup Database</h3>
                <ol style="margin-left: 20px; line-height: 1.8;">
                    <li>Buka phpMyAdmin: <code>http://localhost/phpmyadmin</code></li>
                    <li>Buat database: <code>rantaugrafi_db</code></li>
                    <li>Import file: <code>database.sql</code></li>
                </ol>

                <h3 style="color: #764ba2; margin: 1rem 0 0.5rem 0;">2. Jalankan Website</h3>
                <div class="code">
http://localhost/Rantaugrafi/
                </div>

                <h3 style="color: #764ba2; margin: 1rem 0 0.5rem 0;">3. Login Admin</h3>
                <div class="code">
Email: admin@rantaugrafi.com
Password: password123
                </div>

                <div class="alert">
                    <strong>⚠️ Penting:</strong> Ubah password admin setelah login pertama kali!
                </div>
            </div>

            <!-- Tech Stack -->
            <div class="section">
                <h2><i class="fas fa-code"></i> Teknologi</h2>
                <div class="features">
                    <div class="feature-item">
                        <i class="fab fa-php"></i>
                        <div>
                            <strong>PHP 7.4+</strong>
                            <p>Backend Framework</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fab fa-node-js"></i>
                        <div>
                            <strong>MySQL 5.7+</strong>
                            <p>Database Management</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fab fa-html5"></i>
                        <div>
                            <strong>HTML5 / CSS3</strong>
                            <p>Frontend Design</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fab fa-js"></i>
                        <div>
                            <strong>JavaScript</strong>
                            <p>Client-side Logic</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documentation -->
            <div class="section">
                <h2><i class="fas fa-question-circle"></i> Bantuan & Dukungan</h2>
                <p style="margin-bottom: 1rem;">Untuk informasi lebih lengkap, silakan baca dokumentasi:</p>
                <ul style="margin-left: 20px; line-height: 1.8;">
                    <li><a href="SETUP.php" style="color: #667eea;">📖 Panduan Setup Lengkap</a></li>
                    <li><a href="README.md" style="color: #667eea;">📚 File README</a></li>
                    <li><a href="#" style="color: #667eea;">💬 Hubungi Support (dev@rantaugrafi.com)</a></li>
                </ul>
            </div>
        </div>

        <div class="footer">
            <strong>Rantaugrafi v1.0</strong> | Photography Vendor System<br>
            Dibuat dengan ❤️ untuk fotografer profesional Indonesia<br>
            © 2026 - Semua hak cipta dilindungi
        </div>
    </div>
</body>
</html>
