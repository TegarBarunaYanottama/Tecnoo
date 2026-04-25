<?php
$pageTitle = "Dashboard";
include '../../includes/header.php';

// Statistik
$total_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM barang"))['total'];
$total_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi"))['total'];
$stok_menipis = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM stok_menipis"))['total'];

// Barang Stok Menipis
$query_menipis = "SELECT * FROM stok_menipis LIMIT 5";
$result_menipis = mysqli_query($conn, $query_menipis);

// Transaksi Terbaru
$query_transaksi = "SELECT t.*, b.nama_barang, u.nama_lengkap 
                    FROM transaksi t 
                    JOIN barang b ON t.id_barang = b.id 
                    LEFT JOIN users u ON t.id_user = u.id 
                    ORDER BY t.created_at DESC LIMIT 5";
$result_transaksi = mysqli_query($conn, $query_transaksi);
?>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Barang</h6>
                        <h2 class="mb-0 mt-2"><?= $total_barang ?></h2>
                    </div>
                    <i class="fas fa-box fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Transaksi</h6>
                        <h2 class="mb-0 mt-2"><?= $total_transaksi ?></h2>
                    </div>
                    <i class="fas fa-exchange-alt fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Stok Menipis</h6>
                        <h2 class="mb-0 mt-2"><?= $stok_menipis ?></h2>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Tanggal Hari Ini</h6>
                        <h5 class="mb-0 mt-2"><?= date('d/m/Y') ?></h5>
                    </div>
                    <i class="fas fa-calendar fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <i class="fas fa-exclamation-triangle"></i> Stok Menipis
            </div>
            <div class="card-body">
                <?php if (mysqli_num_rows($result_menipis) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                                <th>Min</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result_menipis)): ?>
                            <tr>
                                <td><?= $row['kode_barang'] ?></td>
                                <td><?= $row['nama_barang'] ?></td>
                                <td><span class="badge bg-danger"><?= $row['stok'] ?></span></td>
                                <td><?= $row['min_stok'] ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-center text-muted">Tidak ada stok menipis</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-history"></i> Transaksi Terbaru
            </div>
            <div class="card-body">
                <?php if (mysqli_num_rows($result_transaksi) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Jenis</th>
                                <th>Jml</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while($row = mysqli_fetch_assoc($result_transaksi)): 
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama_barang'] ?></td>
                                <td>
                                    <span class="badge bg-<?= $row['jenis_transaksi'] == 'masuk' ? 'success' : 'warning' ?>">
                                        <?= ucfirst($row['jenis_transaksi']) ?>
                                    </span>
                                </td>
                                <td><?= $row['jumlah'] ?></td>
                                <td><?= formatDate($row['tanggal']) ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-center text-muted">Belum ada transaksi</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>