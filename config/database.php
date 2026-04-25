<?php
// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'techno_db');

// Buat Koneksi
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Cek Koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8mb4");

// Base URL (Sesuaikan dengan domain/hosting Anda)
define('BASE_URL', 'http://localhost/techno-inventory/');

// Session Start
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fungsi Helper
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit;
}

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        redirect('modules/login/');
    }
}

function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}

function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function generateNoTransaksi($jenis) {
    $prefix = $jenis == 'masuk' ? 'BM' : 'BK';
    $tanggal = date('Ymd');
    $random = rand(1000, 9999);
    return $prefix . '/' . $tanggal . '/' . $random;
}
?>