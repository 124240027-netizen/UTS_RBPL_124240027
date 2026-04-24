<?php
require_once 'includes/config.php';

// Ambil data untuk homepage
$packages = $conn->query("SELECT * FROM packages WHERE status = 'active' LIMIT 3");
$portfolios = $conn->query("SELECT * FROM portfolio LIMIT 6");
$testimonials = $conn->query("SELECT * FROM testimonials WHERE status = 'approved' LIMIT 5");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Vendor Fotografi Profesional</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <h1><i class="fas fa-camera"></i> Rantaugrafi</h1>
            </div>
            <ul class="navbar-menu">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#portfolio">Portfolio</a></li>
                <li><a href="#packages">Paket</a></li>
                <li><a href="#testimonials">Testimoni</a></li>
                <li><a href="#contact">Kontak</a></li>
                <?php if (is_logged_in()): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="btn-login">Masuk</a></li>
                    <li><a href="register.php" class="btn-register">Daftar</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Abadikan Momen Wisuda Anda</h1>
            <p>Dokumentasi Fotografi Profesional untuk Hari Kelulusan yang Berkesan</p>
            <a href="#packages" class="btn btn-primary">Lihat Paket Wisuda</a>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio">
        <div class="container">
            <h2>Portfolio Wisuda Kami</h2>
            <p style="text-align: center; color: #666; margin-bottom: 40px;">Lihat koleksi foto wisuda profesional dari acara-acara sebelumnya</p>
            <div class="gallery-grid">
                <?php while($portfolio = $portfolios->fetch_assoc()): ?>
                <div class="gallery-item">
                    <img src="<?php echo $portfolio['image_path']; ?>" alt="<?php echo $portfolio['title']; ?>" onerror="this.src='assets/images/placeholder.jpg'">
                    <div class="overlay">
                        <h3><?php echo $portfolio['title']; ?></h3>
                        <p><?php echo $portfolio['category']; ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>  
        </div>
    </section>

    <!-- Packages Section -->
    <section id="packages" class="packages">
        <div class="container">
            <h2>Paket Layanan Fotografi Wisuda</h2>
            <p class="section-subtitle">Pilih paket yang sesuai untuk mengabadikan momen spesial wisuda Anda</p>
            <div class="packages-grid">
                <?php while($package = $packages->fetch_assoc()): ?>
                <div class="package-card">
                    <div class="package-image">
                        <div class="package-icon">
                            <?php if(stripos($package['name'], 'Dokumentasi') !== false): ?>
                                <i class="fas fa-video"></i>
                            <?php elseif(stripos($package['name'], 'Studio') !== false): ?>
                                <i class="fas fa-studio"></i>
                            <?php else: ?>
                                <i class="fas fa-camera"></i>
                            <?php endif; ?>
                        </div>
                        <p class="photo-label">Paket Wisuda</p>
                    </div>
                    <h3><?php echo $package['name']; ?></h3>
                    <div class="price"><?php echo format_currency($package['price']); ?></div>
                    <p class="duration"><i class="fas fa-clock"></i> <?php echo $package['duration']; ?></p>
                    <div class="description">
                        <?php echo $package['description']; ?>
                    </div>
                    <ul class="features">
                        <?php 
                        $features = explode(',', $package['features']);
                        foreach($features as $feature):
                        ?>
                        <li><i class="fas fa-check"></i> <?php echo trim($feature); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php if (is_logged_in()): ?>
                        <a href="booking.php?package_id=<?php echo $package['id']; ?>" class="btn btn-primary">Pesan Paket Ini</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-secondary">Masuk untuk Pesan</a>
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials">
        <div class="container">
            <h2>Apa Kata Klien Kami</h2>
            <div class="testimonials-grid">
                <?php while($testimonial = $testimonials->fetch_assoc()): ?>
                <div class="testimonial-card">
                    <div class="rating">
                        <?php for($i = 0; $i < $testimonial['rating']; $i++): ?>
                            <i class="fas fa-star"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="message"><?php echo $testimonial['message']; ?></p>
                    <p class="name">- <?php echo $testimonial['name']; ?></p>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <h2>Hubungi Kami</h2>
            <div class="contact-content">
                <div class="contact-info">
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h4>Telepon</h4>
                            <p>+62 812-3456-789</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>Email</h4>
                            <p>info@rantaugrafi.com</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>Alamat</h4>
                            <p>Jl. Merdeka No. 123, Jakarta</p>
                        </div>
                    </div>
                </div>
                <form class="contact-form" action="send_message.php" method="POST">
                    <input type="text" placeholder="Nama Anda" name="name" required>
                    <input type="email" placeholder="Email Anda" name="email" required>
                    <textarea placeholder="Pesan Anda" name="message" rows="5" required></textarea>
                    <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 Rantaugrafi. Semua hak cipta dilindungi.</p>
            <div class="social-media">
                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="#" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>

    <style>
        .section-subtitle {
            text-align: center;
            color: #666;
            font-size: 18px;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .packages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .package-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .package-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .package-image {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
            position: relative;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .package-image:nth-child(2) {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .package-card:nth-child(2) .package-image {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .package-card:nth-child(3) .package-image {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .package-icon {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.9;
            animation: float 3s ease-in-out infinite;
        }

        .photo-label {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .package-card h3 {
            padding: 20px 20px 10px;
            margin: 0;
            font-size: 22px;
            color: #333;
        }

        .package-card .price {
            padding: 0 20px;
            font-size: 28px;
            font-weight: bold;
            color: #667eea;
            margin: 10px 0;
        }

        .package-card:nth-child(2) .price {
            color: #f5576c;
        }

        .package-card:nth-child(3) .price {
            color: #43e97b;
        }

        .package-card .duration {
            padding: 0 20px;
            color: #999;
            font-size: 14px;
            margin: 0 0 15px;
        }

        .package-card .description {
            padding: 0 20px;
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .package-card .features {
            padding: 20px;
            background: #f9f9f9;
            list-style: none;
            margin: 0 auto;
            flex-grow: 1;
        }

        .package-card .features li {
            padding: 8px 0;
            color: #555;
            font-size: 14px;
            border-bottom: 1px solid #eee;
        }

        .package-card .features li:last-child {
            border-bottom: none;
        }

        .package-card .features i {
            color: #667eea;
            margin-right: 8px;
            width: 16px;
        }

        .package-card:nth-child(2) .features i {
            color: #f5576c;
        }

        .package-card:nth-child(3) .features i {
            color: #43e97b;
        }

        .package-card .btn {
            margin: 20px;
            width: calc(100% - 40px);
            padding: 12px;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .package-card .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .package-card:nth-child(2) .btn-primary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .package-card:nth-child(3) .btn-primary {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .package-card .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .package-card .btn-secondary {
            background: #ccc;
            color: #333;
        }

        .package-card .btn-secondary:hover {
            background: #aaa;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @media (max-width: 768px) {
            .packages-grid {
                grid-template-columns: 1fr;
            }

            .package-card h3 {
                font-size: 20px;
            }

            .package-icon {
                font-size: 36px;
            }
        }
    </style>
</body>
</html>
