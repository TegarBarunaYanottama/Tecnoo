-- Buat Database
CREATE DATABASE IF NOT EXISTS techno_db;
USE techno_db;

-- Tabel Users
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    role ENUM('admin', 'staff') DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert User Default
INSERT INTO users (username, password, nama_lengkap, email, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@techno.com', 'admin');

-- Tabel Kategori
CREATE TABLE IF NOT EXISTS kategori (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO kategori (nama_kategori) VALUES 
('Elektronik'), ('Pakaian'), ('Makanan'), ('Minuman'), ('Alat Tulis');

-- Tabel Barang
CREATE TABLE IF NOT EXISTS barang (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(50) UNIQUE NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    id_kategori INT(11),
    harga_beli DECIMAL(10,2) NOT NULL,
    harga_jual DECIMAL(10,2) NOT NULL,
    stok INT(11) DEFAULT 0,
    min_stok INT(11) DEFAULT 10,
    satuan VARCHAR(20) DEFAULT 'pcs',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id) ON DELETE SET NULL
);

-- Tabel Transaksi
CREATE TABLE IF NOT EXISTS transaksi (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    no_transaksi VARCHAR(50) UNIQUE NOT NULL,
    id_barang INT(11) NOT NULL,
    jenis_transaksi ENUM('masuk', 'keluar') NOT NULL,
    jumlah INT(11) NOT NULL,
    harga DECIMAL(10,2),
    total DECIMAL(10,2),
    tanggal DATE NOT NULL,
    keterangan TEXT,
    id_user INT(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_barang) REFERENCES barang(id) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE SET NULL
);

-- View stok menipis
CREATE OR REPLACE VIEW stok_menipis AS
SELECT b.*, k.nama_kategori
FROM barang b
LEFT JOIN kategori k ON b.id_kategori = k.id
WHERE b.stok <= b.min_stok;