# 🎬 Rantaugrafi - Documentation Lengkap

## 📋 Daftar Isi
1. [Instalasi](#instalasi)
2. [Struktur File](#struktur-file)
3. [Database Schema](#database-schema)
4. [Fitur Pelanggan](#fitur-pelanggan)
5. [Fitur Admin](#fitur-admin)
6. [API & Fungsi](#api--fungsi)
7. [Customization](#customization)
8. [Troubleshooting](#troubleshooting)

---

## Instalasi

### Persyaratan
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- XAMPP/WAMP/LAMP Stack
- Browser modern

### Langkah-Langkah

1. **Clone/Download Project**
   ```bash
   cd C:\xampp\htdocs\
   git clone <repository> Rantaugrafi
   # atau extract folder Rantaugrafi
   ```

2. **Setup Database**
   - Buka phpMyAdmin: `http://localhost/phpmyadmin`
   - Buat database baru: `rantaugrafi_db`
   - Import `database.sql`

3. **Konfigurasi**
   - Edit `includes/config.php` jika diperlukan
   - Sesuaikan `DB_HOST`, `DB_USER`, `DB_PASS`

4. **Jalankan**
   - Buka `http://localhost/Rantaugrafi/`

---

## Struktur File

```
Rantaugrafi/
│
├── 📄 index.php                 # Homepage
├── 📄 login.php                 # Login page
├── 📄 register.php              # Registrasi
├── 📄 booking.php               # Form pemesanan
├── 📄 booking-detail.php        # Detail pesanan
├── 📄 dashboard.php             # Dashboard customer
├── 📄 payment.php               # Payment page
├── 📄 logout.php                # Logout
├── 📄 send_message.php          # Contact form handler
├── 📄 quickstart.php            # Quick start guide
├── 📄 SETUP.php                 # Setup guide
├── 📄 README.md                 # Readme
├── 📄 database.sql              # Database schema
│
├── 📁 admin/
│   ├── dashboard.php            # Admin dashboard
│   ├── bookings.php             # Kelola pesanan
│   ├── packages.php             # Kelola paket
│   ├── portfolio.php            # Kelola galeri
│   ├── customers.php            # Daftar customer
│   ├── testimonials.php         # Moderasi testimoni
│   └── settings.php             # Pengaturan
│
├── 📁 includes/
│   └── config.php               # Konfigurasi & DB connection
│
├── 📁 assets/
│   ├── css/
│   │   ├── style.css            # Stylesheet utama
│   │   └── admin.css            # Stylesheet admin
│   └── js/
│       └── script.js            # JavaScript
│
├── 📁 uploads/                  # Folder untuk upload
│
└── 📄 .htaccess                 # URL rewriting rules
```

---

## Database Schema

### Tabel: users
Menyimpan data pengguna (admin & customer)

```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    phone VARCHAR(20),
    role ENUM('admin', 'customer'),
    created_at TIMESTAMP
);
```

**Fields:**
- `id`: ID unik user
- `name`: Nama lengkap
- `email`: Email (unik)
- `password`: Password di-hash bcrypt
- `phone`: Nomor telepon
- `role`: admin atau customer
- `created_at`: Waktu registrasi

### Tabel: packages
Paket layanan fotografi

```sql
CREATE TABLE packages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10, 2),
    duration VARCHAR(50),
    features TEXT,
    status ENUM('active', 'inactive'),
    created_at TIMESTAMP
);
```

### Tabel: bookings
Pesanan dari pelanggan

```sql
CREATE TABLE bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    package_id INT,
    event_date DATE,
    event_type VARCHAR(100),
    location VARCHAR(255),
    notes TEXT,
    status ENUM('pending', 'confirmed', 'rejected', 'completed', 'cancelled'),
    total_price DECIMAL(10, 2),
    payment_status ENUM('unpaid', 'paid', 'partial'),
    created_at TIMESTAMP
);
```

**Status Booking:**
- `pending`: Menunggu konfirmasi admin
- `confirmed`: Sudah dikonfirmasi
- `rejected`: Ditolak oleh admin
- `completed`: Acara sudah selesai
- `cancelled`: Dibatalkan

### Tabel: reviews
Ulasan dari pelanggan

```sql
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    booking_id INT,
    user_id INT,
    rating INT (1-5),
    comment TEXT,
    created_at TIMESTAMP
);
```

### Tabel: payments
Riwayat pembayaran

```sql
CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    booking_id INT,
    amount DECIMAL(10, 2),
    payment_method VARCHAR(50),
    transaction_id VARCHAR(100),
    status ENUM('pending', 'completed', 'failed'),
    created_at TIMESTAMP
);
```

### Tabel: portfolio
Galeri foto pekerjaan

```sql
CREATE TABLE portfolio (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100),
    description TEXT,
    image_path VARCHAR(255),
    category VARCHAR(50),
    created_at TIMESTAMP
);
```

### Tabel: testimonials
Testimoni & feedback pelanggan

```sql
CREATE TABLE testimonials (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    email VARCHAR(100),
    message TEXT,
    rating INT (1-5),
    status ENUM('pending', 'approved', 'rejected'),
    created_at TIMESTAMP
);
```

---

## Fitur Pelanggan

### 1. Registrasi & Login
- Halaman: `register.php`, `login.php`
- Password di-hash menggunakan bcrypt
- Session management untuk autentikasi

```php
// Login check
if (!is_logged_in()) {
    redirect('login.php');
}
```

### 2. Browse Paket
- Lihat semua paket aktif di homepage
- Detail paket: harga, durasi, fitur
- Filter berdasarkan kategori

### 3. Pemesanan
- Halaman: `booking.php`
- Pilih paket dan isi detail acara
- Validasi tanggal (harus di masa depan)
- Automatic price calculation

```php
// Validasi tanggal
if (strtotime($event_date) < strtotime(date('Y-m-d'))) {
    $error = 'Tanggal harus di masa depan!';
}
```

### 4. Pembayaran
- Halaman: `payment.php`
- Pilih metode pembayaran
- Konfirmasi transaksi
- Update status pembayaran

### 5. Dashboard Pelanggan
- Halaman: `dashboard.php`
- Lihat riwayat pemesanan
- Track status pemesanan
- Lihat detail pemesanan

### 6. Review & Rating
- Berikan rating 1-5 bintang
- Tulis komentar
- Hanya bisa review setelah acara selesai

### 7. Gallery Portfolio
- Lihat hasil pekerjaan fotografer
- Filter berdasarkan kategori
- Galeri responsif dengan hover effect

---

## Fitur Admin

### 1. Dashboard
- Halaman: `admin/dashboard.php`
- Statistik: total pemesanan, revenue, customer
- Grafik pemesanan terbaru
- Quick access ke fitur lain

### 2. Manajemen Pemesanan
- Halaman: `admin/bookings.php`
- Lihat semua pemesanan
- Filter berdasarkan status
- Update status pemesanan
- Lihat detail pelanggan

**Status yang dapat diupdate:**
- Pending → Confirmed / Rejected
- Confirmed → Completed / Cancelled
- Completed → (tidak bisa diubah)

### 3. Manajemen Paket
- Halaman: `admin/packages.php`
- Tambah paket baru
- Edit paket
- Hapus paket
- Set harga dan fitur
- Aktif/nonaktifkan paket

```php
// Tambah paket
INSERT INTO packages (name, description, price, duration, features)
VALUES ('Paket Baru', 'Deskripsi', 1000000, '4 jam', 'fitur1, fitur2');
```

### 4. Manajemen Portfolio
- Halaman: `admin/portfolio.php`
- Upload foto
- Kategorisasi
- Edit judul & deskripsi
- Hapus foto

### 5. Daftar Pelanggan
- Halaman: `admin/customers.php`
- Lihat semua pelanggan
- Informasi: nama, email, telepon
- Filter & search

### 6. Moderasi Testimoni
- Halaman: `admin/testimonials.php`
- Approve/reject testimoni
- Moderasi untuk menghindari spam
- Tampilkan di homepage setelah approval

### 7. Pengaturan
- Halaman: `admin/settings.php`
- Edit informasi kontak
- Email, telepon, alamat
- Pengaturan lainnya

---

## API & Fungsi

### Fungsi Helper (config.php)

#### escape($string)
Escape string untuk mencegah SQL injection
```php
$name = escape($_POST['name']);
```

#### redirect($location)
Redirect ke halaman lain
```php
redirect('dashboard.php');
```

#### is_logged_in()
Check apakah user sudah login
```php
if (!is_logged_in()) {
    redirect('login.php');
}
```

#### is_admin()
Check apakah user adalah admin
```php
if (!is_admin()) {
    redirect('login.php');
}
```

#### format_currency($amount)
Format angka menjadi format Rupiah
```php
echo format_currency(1500000); // Rp 1.500.000
```

#### format_date($date)
Format tanggal Indonesia
```php
echo format_date('2026-02-25'); // 25 Februari 2026
```

### JavaScript Functions (script.js)

#### formatCurrency(amount)
Format currency di JavaScript
```js
formatCurrency(1500000); // Rp 1.500.000
```

#### showNotification(message, type, duration)
Tampilkan notifikasi
```js
showNotification('Berhasil!', 'success', 3000);
showNotification('Error!', 'error', 3000);
```

#### validateForm(formId)
Validasi form
```js
if (validateForm('myForm')) {
    // Form valid
}
```

---

## Customization

### 1. Mengubah Tema Warna

Edit `assets/css/style.css`:

```css
/* Ubah warna utama */
.navbar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
```

### 2. Menambah Paket Baru

**Via Admin Panel:**
1. Login ke admin
2. Buka "Kelola Paket"
3. Klik "Tambah Paket"
4. Isi form dan submit

**Via Database:**
```sql
INSERT INTO packages (name, description, price, duration, features, status)
VALUES (
    'Paket Premium',
    'Paket lengkap dengan editan professional',
    3000000,
    '8 jam',
    'Dokumentasi full, video cinematic, drone, album deluxe',
    'active'
);
```

### 3. Mengubah Teks Homepage

Edit `index.php`:
```php
// Ubah hero section
$hero_title = 'Judul Baru Anda';
$hero_subtitle = 'Subtitle baru Anda';
```

### 4. Integrasi Payment Gateway

Untuk Midtrans:
```php
// Di payment.php
require_once 'vendor/autoload.php';

\Midtrans\Config::$serverKey = 'YOUR_SERVER_KEY';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

$midtrans = \Midtrans\Snap::createTransaction($params);
```

### 5. Menambah Field Baru ke Booking

1. Update database:
```sql
ALTER TABLE bookings ADD COLUMN new_field VARCHAR(255);
```

2. Update form di `booking.php`
3. Update handler di form submission

### 6. Customizing Email Notifications

Buat file `includes/email.php`:
```php
<?php
function sendEmail($to, $subject, $message) {
    $headers = "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: admin@rantaugrafi.com\r\n";
    
    return mail($to, $subject, $message, $headers);
}
?>
```

---

## Troubleshooting

### Error: "Koneksi database gagal"
**Solusi:**
- Pastikan MySQL berjalan
- Cek konfigurasi di `config.php`
- Pastikan database sudah dibuat
- Check user credentials

### Error: "Call to undefined function"
**Solusi:**
- Pastikan `config.php` sudah di-include
- Cek nama fungsi (case-sensitive)
- Include file yang benar

### Upload gambar tidak berfungsi
**Solusi:**
```bash
# Set permission folder
chmod 777 uploads/
```

- Cek ukuran file (max 5MB)
- Format gambar harus JPG/PNG/GIF
- Check `php.ini` untuk `upload_max_filesize`

### Password hash tidak cocok
**Reset password:**
1. Buka phpMyAdmin
2. Edit user di tabel `users`
3. Generate bcrypt hash di: https://www.bcryptgenerator.com
4. Copy hash ke field password

### Database tidak terimport
**Solusi:**
- Cek ukuran file SQL (jika besar, gunakan command line)
- Buka file SQL di text editor, cek syntax
- Coba import dengan phpMyAdmin atau command line:
```bash
mysql -u root -p rantaugrafi_db < database.sql
```

### Session tidak bekerja
**Solusi:**
- Pastikan session folder writable
- Check `session.save_path` di `php.ini`
- Cek `php.ini` setting untuk sessions
- Clear browser cookies & cache

### CSS/JS tidak loading
**Solusi:**
```html
<!-- Pastikan path benar -->
<link rel="stylesheet" href="assets/css/style.css">
<script src="assets/js/script.js"></script>

<!-- Atau gunakan absolute path -->
<link rel="stylesheet" href="/Rantaugrafi/assets/css/style.css">
```

---

## Tips & Best Practices

### Security
- ✅ Always escape user input
- ✅ Use prepared statements untuk complex queries
- ✅ Hash passwords dengan bcrypt
- ✅ Validate input di server & client
- ✅ Use HTTPS untuk production
- ✅ Keep PHP & MySQL updated

### Performance
- ✅ Compress images sebelum upload
- ✅ Use CSS minification
- ✅ Lazy load images
- ✅ Cache database queries jika perlu
- ✅ Optimize database queries

### Maintenance
- ✅ Backup database regularly
- ✅ Monitor error logs
- ✅ Update password admin regularly
- ✅ Remove old uploads
- ✅ Keep changelog update

---

## Support

Untuk bantuan lebih lanjut:
- 📧 Email: dev@rantaugrafi.com
- 📱 WhatsApp: +62 812-3456-789
- 📷 Instagram: @rantaugrafi

---

**© 2026 Rantaugrafi - All Rights Reserved**
