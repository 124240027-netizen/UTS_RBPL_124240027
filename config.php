<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'rantaugrafi_db');

// Site Configuration
define('SITE_NAME', 'Rantaugrafi');
define('SITE_URL', 'http://localhost/Rantaugrafi');

// Connect to Database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check Connection
if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8mb4");

// Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ==================== HELPER FUNCTIONS ====================

/**
 * Escape string untuk keamanan database
 */
function escape($string) {
    global $conn;
    return $conn->real_escape_string($string);
}

/**
 * Redirect ke halaman lain
 */
function redirect($location) {
    header('Location: ' . $location);
    exit();
}

/**
 * Check apakah user sudah login
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Check apakah user adalah admin
 */
function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin';
}

/**
 * Format mata uang ke Rupiah
 */
function format_currency($amount) {
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

/**
 * Format tanggal ke bahasa Indonesia
 */
function format_date($date) {
    $months = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];
    if (empty($date) || $date == '0000-00-00') {
        return '-';
    }
    $parts = explode('-', $date);
    return $parts[2] . ' ' . $months[$parts[1]] . ' ' . $parts[0];
}

/**
 * Get user data by ID
 */
function get_user($user_id) {
    global $conn;
    $user_id = escape($user_id);
    $result = $conn->query("SELECT * FROM users WHERE id = '$user_id'");
    return $result->fetch_assoc();
}

/**
 * Check apakah email sudah terdaftar
 */
function email_exists($email) {
    global $conn;
    $email = escape($email);
    $result = $conn->query("SELECT id FROM users WHERE email = '$email'");
    return $result->num_rows > 0;
}

/**
 * Sanitize input
 */
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

?>
