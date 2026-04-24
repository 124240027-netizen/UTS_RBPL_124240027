<?php
require_once 'includes/config.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$package_id = isset($_GET['package_id']) ? (int)$_GET['package_id'] : null;
$package = null;

if ($package_id) {
    $result = $conn->query("SELECT * FROM packages WHERE id = $package_id");
    if ($result->num_rows > 0) {
        $package = $result->fetch_assoc();
    }
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $package_id = (int)$_POST['package_id'];
    $event_date = escape($_POST['event_date']);
    $event_type = escape($_POST['event_type']);
    $location = escape($_POST['location']);
    $notes = escape($_POST['notes']);
    
    // Validasi tanggal
    if (strtotime($event_date) < strtotime(date('Y-m-d'))) {
        $error = 'Tanggal acara harus di masa depan!';
    } else {
        // Ambil harga paket
        $pkg = $conn->query("SELECT price FROM packages WHERE id = $package_id");
        $pkg_data = $pkg->fetch_assoc();
        $total_price = $pkg_data['price'];
        
        // Insert booking
        $insert = $conn->query("INSERT INTO bookings 
                              (user_id, package_id, event_date, event_type, location, notes, total_price) 
                              VALUES ($user_id, $package_id, '$event_date', '$event_type', '$location', '$notes', $total_price)");
        
        if ($insert) {
            $booking_id = $conn->insert_id;
            redirect('payment.php?booking_id=' . $booking_id);
        } else {
            $error = 'Gagal membuat pemesanan, silakan coba lagi!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Layanan - <?php echo SITE_NAME; ?></title>
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
        <h1>Form Pemesanan Layanan</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="booking-container">
            <form method="POST" action="" class="booking-form">
                <div class="form-section">
                    <h2>Pilih Paket</h2>
                    <div class="packages-select">
                        <?php 
                        $packages = $conn->query("SELECT * FROM packages WHERE status = 'active'");
                        while($pkg = $packages->fetch_assoc()):
                        ?>
                        <label class="package-radio">
                            <input type="radio" name="package_id" value="<?php echo $pkg['id']; ?>" 
                                   <?php if ($package && $package['id'] == $pkg['id']) echo 'checked'; ?> required>
                            <div class="package-info">
                                <h3><?php echo $pkg['name']; ?></h3>
                                <p><?php echo $pkg['description']; ?></p>
                                <p class="price"><?php echo format_currency($pkg['price']); ?></p>
                            </div>
                        </label>
                        <?php endwhile; ?>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Detail Acara</h2>
                    
                    <div class="form-group">
                        <label for="event_date">Tanggal Acara</label>
                        <input type="date" id="event_date" name="event_date" required>
                    </div>

                    <div class="form-group">
                        <label for="event_type">Jenis Acara</label>
                        <select id="event_type" name="event_type" required>
                            <option value="">Pilih jenis acara</option>
                            <option value="Pernikahan">Pernikahan</option>
                            <option value="Pre-wedding">Pre-wedding</option>
                            <option value="Ulang Tahun">Ulang Tahun</option>
                            <option value="Corporate">Corporate/Event</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="location">Lokasi Acara</label>
                        <input type="text" id="location" name="location" placeholder="Alamat lengkap acara" required>
                    </div>

                    <div class="form-group">
                        <label for="notes">Catatan Tambahan</label>
                        <textarea id="notes" name="notes" rows="4" placeholder="Catatan khusus untuk fotografer..."></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-large">Lanjutkan ke Pembayaran</button>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
