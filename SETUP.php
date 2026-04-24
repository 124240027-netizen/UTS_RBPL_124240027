<?php
/**
 * Rantaugrafi - Photography Vendor System
 * 
 * Panduan Setup & Instalasi
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Setup - Rantaugrafi</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .setup-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .setup-container h2 {
            color: #667eea;
            margin-top: 2rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid #667eea;
            padding-bottom: 0.5rem;
        }
        .setup-container h3 {
            color: #764ba2;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .setup-container ol, .setup-container ul {
            margin: 1rem 0 1rem 2rem;
        }
        .setup-container li {
            margin: 0.5rem 0;
            line-height: 1.6;
        }
        .setup-container code {
            background: #f5f5f5;
            padding: 0.2rem 0.5rem;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        .setup-container pre {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 1rem;
            border-radius: 4px;
            overflow-x: auto;
            margin: 1rem 0;
        }
        .info-box {
            background: #d1ecf1;
            border-left: 4px solid #0c5460;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 4px;
        }
        .success-box {
            background: #d4edda;
            border-left: 4px solid #155724;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 4px;
        }
        .warning-box {
            background: #fff3cd;
            border-left: 4px solid #856404;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <h1><i class="fas fa-camera"></i> Rantaugrafi</h1>
            </div>
        </div>
    </nav>

    <div class="setup-container">
        <h1>📖 Panduan Instalasi & Setup</h1>
        <p>Panduan lengkap untuk menginstall dan mengkonfigurasi Web Vendor Fotografi Rantaugrafi</p>

        <h2>1. Persiapan Awal</h2>
        <h3>Persyaratan Sistem</h3>
        <ul>
            <li>XAMPP atau server lokal dengan PHP 7.4+</li>
            <li>MySQL 5.7 atau lebih baru</li>
            <li>Browser modern (Chrome, Firefox, Edge, Safari)</li>
            <li>Minimal 100 MB ruang penyimpanan</li>
        </ul>

        <h3>Instalasi XAMPP</h3>
        <ol>
            <li>Download XAMPP dari <a href="https://www.apachefriends.org" target="_blank">apachefriends.org</a></li>
            <li>Jalankan installer dan ikuti petunjuk</li>
            <li>Pilih komponen: Apache, MySQL, PHP</li>
            <li>Instalasi di folder default (C:\xampp untuk Windows)</li>
            <li>Setelah instalasi selesai, buka XAMPP Control Panel</li>
        </ol>

        <h2>2. Setup Database</h2>

        <h3>Step 1: Nyalakan MySQL</h3>
        <ol>
            <li>Buka XAMPP Control Panel</li>
            <li>Klik tombol "Start" di samping MySQL</li>
            <li>Tunggu sampai berstatus "Running" (warna hijau)</li>
        </ol>

        <h3>Step 2: Akses phpMyAdmin</h3>
        <ol>
            <li>Buka browser dan akses: <code>http://localhost/phpmyadmin</code></li>
            <li>Jika diminta login, gunakan:
                <ul>
                    <li>Username: <code>root</code></li>
                    <li>Password: <code>(kosong)</code></li>
                </ul>
            </li>
        </ol>

        <h3>Step 3: Import Database</h3>
        <ol>
            <li>Klik menu "Databases" atau "Databases baru"</li>
            <li>Buat database baru dengan nama: <code>rantaugrafi_db</code></li>
            <li>Pilih charset: <code>utf8mb4_unicode_ci</code></li>
            <li>Klik "Create"</li>
            <li>Setelah database dibuat, klik tab "Import"</li>
            <li>Pilih file <code>database.sql</code> dari folder Rantaugrafi</li>
            <li>Klik tombol "Go" atau "Import"</li>
            <li>Tunggu sampai proses selesai (ada pesan sukses)</li>
        </ol>

        <div class="success-box">
            ✅ Database berhasil diimport jika muncul pesan "Import has been successfully finished"
        </div>

        <h2>3. Konfigurasi Aplikasi</h2>

        <h3>File Configuration</h3>
        <p>Buka file <code>includes/config.php</code> dan pastikan konfigurasi sudah sesuai:</p>
        <pre><code>&lt;?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'rantaugrafi_db');
?&gt;</code></pre>

        <h3>Folder Uploads</h3>
        <ol>
            <li>Pastikan folder <code>uploads/</code> sudah ada</li>
            <li>Set permission folder menjadi 777 (read, write, execute)</li>
            <li>Untuk Windows: klik kanan → Properties → Security → Edit permissions</li>
        </ol>

        <h2>4. Akses Website</h2>

        <h3>Jalankan XAMPP</h3>
        <ol>
            <li>Buka XAMPP Control Panel</li>
            <li>Nyalakan Apache (klik Start)</li>
            <li>Pastikan MySQL juga berjalan</li>
        </ol>

        <h3>Buka Website</h3>
        <ol>
            <li>
                <strong>Homepage:</strong> <code>http://localhost/Rantaugrafi/</code>
            </li>
            <li>
                <strong>Login Pelanggan:</strong> <code>http://localhost/Rantaugrafi/login.php</code>
            </li>
            <li>
                <strong>Admin Panel:</strong> <code>http://localhost/Rantaugrafi/admin/dashboard.php</code>
            </li>
        </ol>

        <h2>5. Akun Default</h2>

        <h3>Admin Account</h3>
        <pre><code>Email: admin@rantaugrafi.com
Password: password123</code></pre>

        <div class="warning-box">
            ⚠️ <strong>Penting:</strong> Ubah password admin setelah login pertama kali!
        </div>

        <h3>Buat Akun Pelanggan</h3>
        <ol>
            <li>Klik tombol "Daftar" di homepage</li>
            <li>Isi form dengan data lengkap</li>
            <li>Klik "Daftar"</li>
            <li>Login dengan akun yang baru dibuat</li>
        </ol>

        <h2>6. Testing Fitur</h2>

        <h3>Test Admin Panel</h3>
        <ul>
            <li>Login ke admin dengan akun default</li>
            <li>Lihat dashboard dan statistik</li>
            <li>Cek menu-menu di sidebar</li>
            <li>Tambah paket baru untuk test</li>
        </ul>

        <h3>Test Customer Features</h3>
        <ul>
            <li>Daftar akun customer baru</li>
            <li>Lihat portfolio di homepage</li>
            <li>Klik "Pesan Sekarang" pada paket</li>
            <li>Isi form pemesanan</li>
            <li>Lanjut ke halaman pembayaran</li>
            <li>Cek dashboard untuk melihat pesanan</li>
        </ul>

        <h2>7. Troubleshooting</h2>

        <h3>Error: "Koneksi database gagal"</h3>
        <ul>
            <li>Pastikan MySQL sudah dijalankan di XAMPP Control Panel</li>
            <li>Cek konfigurasi di <code>includes/config.php</code></li>
            <li>Pastikan database <code>rantaugrafi_db</code> sudah dibuat</li>
        </ul>

        <h3>Error: "File not found"</h3>
        <ul>
            <li>Pastikan folder Rantaugrafi ada di <code>C:\xampp\htdocs\</code></li>
            <li>Cek spelling nama folder (case-sensitive di Linux/Mac)</li>
            <li>Restart Apache dari XAMPP Control Panel</li>
        </ul>

        <h3>Upload Gambar Tidak Berfungsi</h3>
        <ul>
            <li>Pastikan folder <code>uploads/</code> ada</li>
            <li>Set permission folder menjadi 777</li>
            <li>Cek ukuran file (max 5MB)</li>
            <li>Format gambar harus: JPG, PNG, GIF</li>
        </ul>

        <h3>Lupa Password Admin</h3>
        <ol>
            <li>Buka phpMyAdmin</li>
            <li>Pilih database <code>rantaugrafi_db</code></li>
            <li>Buka tabel <code>users</code></li>
            <li>Edit row admin</li>
            <li>Generate password baru di: <a href="https://www.bcryptgenerator.com" target="_blank">bcryptgenerator.com</a></li>
            <li>Copy hash password dan simpan</li>
        </ol>

        <h2>8. Fitur Lanjutan</h2>

        <h3>Integrasi Payment Gateway</h3>
        <p>Untuk integrasi pembayaran online (Midtrans, Xendit, dll):</p>
        <ol>
            <li>Daftar akun di platform payment</li>
            <li>Dapatkan API Key</li>
            <li>Modifikasi file <code>payment.php</code></li>
            <li>Integrasikan library payment gateway</li>
        </ol>

        <h3>Backup Database</h3>
        <p>Gunakan phpMyAdmin untuk backup:</p>
        <ol>
            <li>Buka database <code>rantaugrafi_db</code></li>
            <li>Klik tab "Export"</li>
            <li>Pilih "SQL" format</li>
            <li>Klik "Go" untuk download backup</li>
        </ol>

        <h2>9. Maintenance</h2>

        <h3>Regular Checks</h3>
        <ul>
            <li>Cek error log di folder admin</li>
            <li>Update password admin setiap 3 bulan</li>
            <li>Backup database setiap minggu</li>
            <li>Cek folder uploads untuk file yang tidak perlu</li>
        </ul>

        <h2>10. Support & Bantuan</h2>

        <div class="info-box">
            <strong>Butuh bantuan?</strong>
            <ul>
                <li>Email: dev@rantaugrafi.com</li>
                <li>WhatsApp: +62 812-3456-789</li>
                <li>Instagram: @rantaugrafi</li>
            </ul>
        </div>

        <hr style="margin: 2rem 0;">

        <p style="text-align: center; color: #666;">
            <strong>Rantaugrafi v1.0</strong> | Dibuat dengan ❤️ untuk fotografer profesional Indonesia<br>
            © 2026 - Semua hak cipta dilindungi
        </p>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
