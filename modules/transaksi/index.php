<?php
$pageTitle = "Transaksi";
include '../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-exchange-alt"></i> Transaksi Stok</h2>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card border-success mb-3">
            <div class="card-header bg-success text-white">
                <i class="fas fa-arrow-down"></i> Barang Masuk
            </div>
            <div class="card-body text-center">
                <i class="fas fa-box-open fa-5x text-success mb-3"></i>
                <h5>Input Barang Masuk</h5>
                <p class="text-muted">Tambah stok barang dari pembelian atau produksi</p>
                <a href="masuk.php" class="btn btn-success">
                    <i class="fas fa-plus"></i> Barang Masuk
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card border-warning mb-3">
            <div class="card-header bg-warning text-dark">
                <i class="fas fa-arrow-up"></i> Barang Keluar
            </div>
            <div class="card-body text-center">
                <i class="fas fa-shopping-cart fa-5x text-warning mb-3"></i>
                <h5>Input Barang Keluar</h5>
                <p class="text-muted">Kurangi stok barang dari penjualan atau penggunaan</p>
                <a href="keluar.php" class="btn btn-warning">
                    <i class="fas fa-minus"></i> Barang Keluar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <i class="fas fa-history"></i> Riwayat Transaksi
    </div>
    <div class="card-body">
        <?php
        $query = "SELECT t.*, b.nama_barang, b.kode_barang, u.nama_lengkap 
                  FROM transaksi t 
                  JOIN barang b ON t.id_barang = b.id 
                  LEFT JOIN users u ON t.id_user = u.id 
                  ORDER BY t.created_at DESC LIMIT 10";
        $result = mysqli_query($conn, $query);
        ?>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Transaksi</th>
                        <th>Barang</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result)): 
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['no_transaksi'] ?></td>
                        <td><?= $row['nama_barang'] ?> (<?= $row['kode_barang'] ?>)</td>
                        <td>
                            <span class="badge bg-<?= $row['jenis_transaksi'] == 'masuk' ? 'success' : 'warning' ?>">
                                <?= ucfirst($row['jenis_transaksi']) ?>
                            </span>
                        </td>
                        <td><?= $row['jumlah'] ?></td>
                        <td><?= formatRupiah($row['harga']) ?></td>
                        <td><strong><?= formatRupiah($row['total']) ?></strong></td>
                        <td><?= formatDate($row['tanggal']) ?></td>
                        <td><?= $row['nama_lengkap'] ?? '-' ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>