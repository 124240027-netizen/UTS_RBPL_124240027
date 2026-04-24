<?php
require_once 'includes/config.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
$user_id = $_SESSION['user_id'];

$booking = $conn->query("SELECT * FROM bookings WHERE id = $booking_id AND user_id = $user_id");

if ($booking->num_rows == 0) {
    redirect('dashboard.php');
}

$booking = $booking->fetch_assoc();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = escape($_POST['payment_method']);
    $transaction_id = escape($_POST['transaction_id']);
    $amount = $booking['total_price'];
    
    // Insert payment record
    $insert = $conn->query("INSERT INTO payments (booking_id, amount, payment_method, transaction_id, status) 
                           VALUES ($booking_id, $amount, '$payment_method', '$transaction_id', 'completed')");
    
    if ($insert) {
        // Update booking payment status
        $conn->query("UPDATE bookings SET payment_status = 'paid' WHERE id = $booking_id");
        $success = 'Pembayaran berhasil! Pemesanan Anda telah dikonfirmasi.';
    } else {
        $error = 'Gagal memproses pembayaran, silakan coba lagi!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - <?php echo SITE_NAME; ?></title>
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
        <h1>Pembayaran Pemesanan</h1>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <a href="dashboard.php" class="btn btn-primary">Kembali ke Dashboard</a>
        <?php else: ?>
            <div class="payment-container">
                <div class="payment-info">
                    <h2>Ringkasan Pembayaran</h2>
                    <table class="detail-table">
                        <tr>
                            <td>No. Pemesanan</td>
                            <td>#<?php echo $booking['id']; ?></td>
                        </tr>
                        <tr>
                            <td>Total Pembayaran</td>
                            <td class="price"><?php echo format_currency($booking['total_price']); ?></td>
                        </tr>
                    </table>
                </div>

                <div class="payment-form">
                    <h2>Metode Pembayaran</h2>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="payment_method">Pilih Metode Pembayaran</label>
                            <select id="payment_method" name="payment_method" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="bank_transfer">Transfer Bank</option>
                                <option value="gopay">GoPay</option>
                                <option value="ovo">OVO</option>
                                <option value="dana">DANA</option>
                                <option value="kartu_kredit">Kartu Kredit</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="transaction_id">No. Transaksi / Bukti Pembayaran</label>
                            <input type="text" id="transaction_id" name="transaction_id" 
                                   placeholder="Masukkan nomor referensi pembayaran Anda" required>
                        </div>

                        <div class="alert alert-info">
                            <h4>Instruksi Pembayaran:</h4>
                            <ul style="margin: 10px 0; padding-left: 20px;">
                                <li>Transfer ke rekening: BCA 1234567890 a.n PT Rantau Grafi</li>
                                <li>Cantumkan nomor pesanan (#<?php echo $booking['id']; ?>) di deskripsi transfer</li>
                                <li>Konfirmasi pembayaran melalui WhatsApp: +62 812-3456-789</li>
                                <li>Tunggu verifikasi dari admin sebelum acara dimulai</li>
                            </ul>
                        </div>

                        <button type="submit" class="btn btn-primary btn-large">Konfirmasi Pembayaran</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
