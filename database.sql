-- CATATAN: Untuk hosting/shared hosting, buat database terlebih dahulu via control panel.
-- Hapus atau komentari baris CREATE DATABASE dan USE jika database sudah ada.
-- CREATE DATABASE IF NOT EXISTS rantaugrafi_db;
-- USE rantaugrafi_db;

SET FOREIGN_KEY_CHECKS = 0;

-- Hapus tabel jika sudah ada (agar bisa di-import ulang)
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS testimonials;
DROP TABLE IF EXISTS settings;
DROP TABLE IF EXISTS portfolio;
DROP TABLE IF EXISTS packages;
DROP TABLE IF EXISTS users;

-- Tabel Users (Admin & Customer)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('admin', 'customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Portfolio (Galeri Fotografi)
CREATE TABLE portfolio (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    image_path VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Packages (Paket Layanan)
CREATE TABLE packages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    duration VARCHAR(50),
    features TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Bookings (Pemesanan)
CREATE TABLE bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    package_id INT NOT NULL,
    event_date DATE NOT NULL,
    event_type VARCHAR(100) NOT NULL,
    location VARCHAR(255) NOT NULL,
    notes TEXT,
    status ENUM('pending', 'confirmed', 'rejected', 'completed', 'cancelled') DEFAULT 'pending',
    total_price DECIMAL(10, 2) NOT NULL,
    payment_status ENUM('unpaid', 'paid', 'partial') DEFAULT 'unpaid',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (package_id) REFERENCES packages(id)
);

-- Tabel Reviews (Ulasan)
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    booking_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Tabel Payment (Pembayaran)
CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    booking_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    payment_method VARCHAR(50),
    transaction_id VARCHAR(100),
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id)
);

-- Tabel Testimonials (Testimoni)
CREATE TABLE testimonials (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    message TEXT NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Settings (Pengaturan Website)
CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value LONGTEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert Admin User
INSERT INTO users (name, email, password, phone, role) VALUES 
('Admin Rantaugrafi', 'admin@rantaugrafi.com', '$2y$10$f0dxDZkKNaJuNikkBpO0iubM79FsLmIvKdbus3c0uU0Ic1ADbqMaq', '08123456789', 'admin');

-- Insert Sample Packages (Fokus ke Wisuda)
INSERT INTO packages (name, description, price, duration, features) VALUES 
('Paket Wisuda Standar', 'Dokumentasi wisuda dengan 1 fotografer profesional', 500000, '4 jam', 'Foto upacara wisuda, foto dengan keluarga, 100+ foto teredit, soft copy'),
('Paket Wisuda Premium', 'Paket wisuda lengkap dengan 2 fotografer dan cinematic video', 1500000, '6 jam', 'Dokumentasi lengkap, video cinematic, album eksklusif, drone shot, 300+ foto teredit'),
('Paket Wisuda Deluxe', 'Paket terlengkap dengan layanan pre-dan post wisuda', 2500000, '10 jam', 'Pre-wisuda photoshoot, dokumentasi upacara lengkap, video 4K, album premium, soft copy 4K, digital gallery');

SET FOREIGN_KEY_CHECKS = 1;

