<?php
require_once '../../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM barang WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        redirect('modules/barang/?msg=Data berhasil dihapus&status=success');
    } else {
        redirect('modules/barang/?msg=Gagal menghapus data&status=error');
    }
}
?>