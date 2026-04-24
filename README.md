# Rantaugrafi - Web Vendor Fotografi dengan Sistem Pemesanan

Website vendor fotografi profesional dengan sistem pemesanan online dan panel admin yang lengkap.

## Fitur Utama

### Untuk Pelanggan
- ✅ Registrasi dan login
- ✅ Lihat galeri portfolio
- ✅ Pesan paket layanan fotografi
- ✅ Sistem pembayaran online
- ✅ Track status pemesanan
- ✅ Memberikan ulasan dan rating
- ✅ Melihat testimoni pelanggan lain

### Untuk Admin
- ✅ Dashboard dengan statistik lengkap
- ✅ Manajemen pemesanan (approve/reject/complete)
- ✅ Manajemen paket layanan
- ✅ Manajemen portfolio
- ✅ Melihat daftar pelanggan
- ✅ Moderasi testimoni
- ✅ Pengaturan website

## Teknologi yang Digunakan

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework CSS**: Custom CSS (responsive design)

## Struktur Database

### Tabel Utama
1. **users** - Data pengguna (admin & customer)
2. **packages** - Paket layanan fotografi
3. **bookings** - Pemesanan dari pelanggan
4. **portfolio** - Galeri foto
5. **reviews** - Ulasan dari pemesanan
6. **payments** - Riwayat pembayaran
7. **testimonials** - Testimoni pelanggan
8. **settings** - Pengaturan website

## Instalasi & Setup

### 1. Persiapan
- Pastikan XAMPP sudah terinstal
- Buat folder di `C:\xampp\htdocs\Rantaugrafi\`

### 2. Setup Database
1. Buka phpMyAdmin: `http://localhost/phpmyadmin`
2. Buat database baru: `rantaugrafi_db`
3. Import file `database.sql`:
   - Buka database `rantaugrafi_db`
   - Klik tab "Import"
   - Pilih file `database.sql`
   - Klik "Go"

### 3. Konfigurasi
Edit file `includes/config.php` jika perlu menyesuaikan:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'rantaugrafi_db');
```

### 4. Akses Website
- **Frontend**: http://localhost/Rantaugrafi/
- **Admin Panel**: http://localhost/Rantaugrafi/admin/dashboard.php

## Akun Default

### Admin
- **Email**: admin@rantaugrafi.com
- **Password**: password123 (ubah setelah login)

*Note: Hash password menggunakan bcrypt. Untuk mengganti password, daftar akun baru atau hash manual.*

## File & Folder Structure

```
Rantaugrafi/
├── index.php                 # Homepage
├── login.php                # Halaman login
├── register.php             # Halaman registrasi
├── booking.php              # Halaman pemesanan
├── booking-detail.php       # Detail pemesanan
├── dashboard.php            # Dashboard pelanggan
├── payment.php              # Halaman pembayaran
├── logout.php               # Logout
├── send_message.php         # Proses pesan kontak
├── database.sql             # File SQL database
│
├── admin/
│   ├── dashboard.php        # Dashboard admin
│   ├── bookings.php         # Kelola pemesanan
│   ├── packages.php         # Kelola paket
│   ├── portfolio.php        # Kelola galeri
│   ├── customers.php        # Kelola pelanggan
│   ├── testimonials.php     # Kelola testimoni
│   └── settings.php         # Pengaturan
│
├── includes/
│   └── config.php           # Konfigurasi & database
│
├── assets/
│   ├── css/
│   │   ├── style.css        # Stylesheet utama
│   │   └── admin.css        # Stylesheet admin
│   ├── js/
│   │   └── script.js        # JavaScript
│   ├── images/              # Folder gambar
│   └── fonts/               # Folder font
│
└── uploads/                 # Folder untuk upload gambar

```

## Panduan Penggunaan

### Untuk Pelanggan

1. **Registrasi**
   - Klik "Daftar" di navbar
   - Isi form dengan data lengkap
   - Klik "Daftar"

2. **Pemesanan**
   - Klik "Pesan Sekarang" pada paket
   - Pilih paket dan isi detail acara
   - Lanjut ke pembayaran
   - Konfirmasi pembayaran

3. **Lihat Status**
   - Login ke dashboard
   - Lihat daftar pemesanan
   - Klik "Detail" untuk info lengkap

### Untuk Admin

1. **Login Admin**
   - Akses: http://localhost/Rantaugrafi/admin/dashboard.php
   - Email: admin@rantaugrafi.com
   - Password: password123

2. **Kelola Pemesanan**
   - Buka menu "Pemesanan"
   - Lihat status pemesanan
   - Update status sesuai kebutuhan

3. **Kelola Paket**
   - Buka menu "Paket"
   - Tambah, edit, atau hapus paket
   - Atur harga dan fitur

## Fitur Pembayaran

Saat ini sistem pembayaran mendukung:
- Transfer Bank
- GoPay
- OVO
- DANA
- Kartu Kredit

*Catatan: Implementasi gateway pembayaran (Midtrans, Xendit, dll) dapat ditambahkan sesuai kebutuhan*

## Keamanan

- Password dienkripsi menggunakan bcrypt
- Input validation dan SQL escape untuk mencegah SQL Injection
- Session management untuk autentikasi
- Role-based access control (Admin/Customer)

## Customization

### Mengubah Warna Tema
Edit file `assets/css/style.css`:
```css
/* Ubah gradient utama */
.navbar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
```

### Menambah Paket Baru
1. Login ke admin
2. Buka menu "Paket"
3. Klik "Tambah Paket"
4. Isi form dan klik "Simpan"

## Support & Kontak

- **Email**: dev@rantaugrafi.com
- **WhatsApp**: +62 812-3456-789
- **Instagram**: @rantaugrafi

## Lisensi

Proyek ini dilisensikan di bawah MIT License.

## Changelog

### v1.0 (2026-02-25)
- Initial release
- Core features: booking, payment, admin panel
- Database setup dengan 8 tabel utama

---

**Dibuat dengan ❤️ untuk fotografer profesional Indonesia**
