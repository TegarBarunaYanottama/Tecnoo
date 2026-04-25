<?php
require_once '../../config/database.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action == 'masuk' || $action == 'keluar') {
        $no_transaksi = mysqli_real_escape_string($conn, $_POST['no_transaksi']);
        $id_barang = $_POST['id_barang'];
        $jumlah = $_POST['jumlah'];
        $harga = $_POST['harga'];
        $total = $_POST['total'];
        $tanggal = $_POST['tanggal'];
        $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
        $id_user = $_SESSION['user_id'];
        
        // Mulai transaksi
        mysqli_begin_transaction($conn);
        
        try {
            // Insert ke tabel transaksi
            $query_transaksi = "INSERT INTO transaksi (no_transaksi, id_barang, jenis_transaksi, jumlah, harga, total, tanggal, keterangan, id_user) 
                               VALUES ('$no_transaksi', $id_barang, '$action', $jumlah, $harga, $total, '$tanggal', '$keterangan', $id_user)";
            mysqli_query($conn, $query_transaksi);
            
            // Update stok barang
            if ($action == 'masuk') {
                $query_stok = "UPDATE barang SET stok = stok + $jumlah WHERE id = $id_barang";
            } else {
                $query_stok = "UPDATE barang SET stok = stok - $jumlah WHERE id = $id_barang";
            }
            mysqli_query($conn, $query_stok);
            
            // Commit transaksi
            mysqli_commit($conn);
            
            redirect('modules/transaksi/?msg=Transaksi berhasil disimpan&status=success');
            
        } catch (Exception $e) {
            // Rollback jika ada error
            mysqli_rollback($conn);
            redirect('modules/transaksi/?msg=Gagal menyimpan transaksi&status=error');
        }
    }
}
?>