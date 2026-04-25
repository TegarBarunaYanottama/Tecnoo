<?php
require_once '../../config/database.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action == 'tambah') {
        $kode_barang = mysqli_real_escape_string($conn, $_POST['kode_barang']);
        $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
        $id_kategori = $_POST['id_kategori'] ?: 'NULL';
        $harga_beli = $_POST['harga_beli'];
        $harga_jual = $_POST['harga_jual'];
        $stok = $_POST['stok'];
        $min_stok = $_POST['min_stok'];
        $satuan = mysqli_real_escape_string($conn, $_POST['satuan']);
        
        $query = "INSERT INTO barang (kode_barang, nama_barang, id_kategori, harga_beli, harga_jual, 
                  stok, min_stok, satuan) VALUES 
                  ('$kode_barang', '$nama_barang', $id_kategori, $harga_beli, $harga_jual, 
                  $stok, $min_stok, '$satuan')";
        
        if (mysqli_query($conn, $query)) {
            redirect('modules/barang/?msg=Data berhasil ditambahkan&status=success');
        } else {
            redirect('modules/barang/tambah.php?msg=Gagal menambah data&status=error');
        }
    }
    
    elseif ($action == 'edit') {
        $id = $_POST['id'];
        $kode_barang = mysqli_real_escape_string($conn, $_POST['kode_barang']);
        $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
        $id_kategori = $_POST['id_kategori'] ?: 'NULL';
        $harga_beli = $_POST['harga_beli'];
        $harga_jual = $_POST['harga_jual'];
        $min_stok = $_POST['min_stok'];
        $satuan = mysqli_real_escape_string($conn, $_POST['satuan']);
        
        $query = "UPDATE barang SET 
                  kode_barang = '$kode_barang',
                  nama_barang = '$nama_barang',
                  id_kategori = $id_kategori,
                  harga_beli = $harga_beli,
                  harga_jual = $harga_jual,
                  min_stok = $min_stok,
                  satuan = '$satuan'
                  WHERE id = $id";
        
        if (mysqli_query($conn, $query)) {
            redirect('modules/barang/?msg=Data berhasil diupdate&status=success');
        } else {
            redirect('modules/barang/edit.php?id='.$id.'&msg=Gagal update data&status=error');
        }
    }
}
?>