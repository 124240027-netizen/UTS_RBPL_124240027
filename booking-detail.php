<?php
require_once 'includes/config.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$booking_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = $_SESSION['user_id'];

$booking = $conn->query("SELECT b.*, p.name as package_name, p.description as package_desc, p.features 
                        FROM bookings b 
                        JOIN packages p ON b.package_id = p.id 
                        WHERE b.id = $booking_id AND b.user_id = $user_id");

if ($booking->num_rows == 0) {
    redirect('dashboard.php');
}

$booking = $booking->fetch_assoc();

// Ambil review jika ada
$review = $conn->query("SELECT * FROM reviews WHERE booking_id = $booking_id");
$review_data = $review->num_rows > 0 ? $review->fetch_assoc() : null;

// Process review submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $booking['status'] == 'completed') {
    $rating = (int)$_POST['rating'];
    $comment = escape($_POST['comment']);
    
    if ($review_data) {
        $conn->query("UPDATE reviews SET rating = $rating, comment = '$comment' WHERE booking_id = $booking_id");
    } else {
        $conn->query("INSERT INTO reviews (booking_id, user_id, rating, comment) 
                    VALUES ($booking_id, $user_id, $rating, '$comment')");
    }
    
    header('Refresh:0');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemesanan - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <h1><i class="fas fa-camera"></i> Rantaugrafi</h1>
            </div>
            <ul class="navbar-menu">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="padding: 40px 0;">
        <a href="dashboard.php" class="btn btn-secondary" style="margin-bottom: 20px;">← Kembali</a>
        
        <h1>Detail Pemesanan #<?php echo $booking['id']; ?></h1>

        <div class="detail-grid">
            <div class="detail-card">
                <h2>Informasi Pemesanan</h2>
                <table class="detail-table">
                    <tr>
                        <td>Paket</td>
                        <td><?php echo $booking['package_name']; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Acara</td>
                        <td><?php echo format_date($booking['event_date']); ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Acara</td>
                        <td><?php echo $booking['event_type']; ?></td>
                    </tr>
                    <tr>
                        <td>Lokasi</td>
                        <td><?php echo $booking['location']; ?></td>
                    </tr>
                    <tr>
                        <td>Catatan</td>
                        <td><?php echo $booking['notes'] ?: '-'; ?></td>
                    </tr>
                    <tr>
                        <td>Total Harga</td>
                        <td class="price"><?php echo format_currency($booking['total_price']); ?></td>
                    </tr>
                </table>
            </div>

            <div class="detail-card">
                <h2>Status Pemesanan</h2>
                <div class="status-info">
                    <p class="status-large status-<?php echo $booking['status']; ?>">
                        <?php echo ucfirst($booking['status']); ?>
                    </p>
                    <p>Status Pembayaran: <strong><?php echo ucfirst($booking['payment_status']); ?></strong></p>
                    <p>Diperbarui: <?php echo date('d M Y H:i', strtotime($booking['updated_at'])); ?></p>
                    
                    <?php if ($booking['payment_status'] == 'unpaid'): ?>
                        <a href="payment.php?booking_id=<?php echo $booking['id']; ?>" class="btn btn-primary" style="margin-top: 10px;">
                            Bayar Sekarang
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if ($booking['status'] == 'completed' && !$review_data): ?>
        <div class="detail-card">
            <h2>Berikan Ulasan</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <select id="rating" name="rating" required>
                        <option value="">Pilih rating</option>
                        <option value="5">⭐⭐⭐⭐⭐ Sangat Puas</option>
                        <option value="4">⭐⭐⭐⭐ Puas</option>
                        <option value="3">⭐⭐⭐ Cukup</option>
                        <option value="2">⭐⭐ Kurang</option>
                        <option value="1">⭐ Sangat Kurang</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comment">Komentar</label>
                    <textarea id="comment" name="comment" rows="5" placeholder="Bagikan pengalaman Anda..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
            </form>
        </div>
        <?php elseif ($review_data): ?>
        <div class="detail-card">
            <h2>Ulasan Anda</h2>
            <div class="rating">
                <?php for($i = 0; $i < $review_data['rating']; $i++): ?>
                    <i class="fas fa-star"></i>
                <?php endfor; ?>
            </div>
            <p><?php echo $review_data['comment']; ?></p>
        </div>
        <?php endif; ?>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
