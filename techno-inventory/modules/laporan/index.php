<?php
$pageTitle = "Laporan";
include '../../includes/header.php';

// Default date range (bulan ini)
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-01');
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-t');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-file-alt"></i> Laporan</h2>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-filter"></i> Filter Laporan
    </div>
    <div class="card-body">
        <form method="GET" action="" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" class="form-control" value="<?= $tanggal_awal ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control" value="<?= $tanggal_akhir ?>">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Laporan Stok Barang -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-box"></i> Laporan Stok Barang
    </div>
    <div class="card-body">
        <?php
        $query = "SELECT b.*, k.nama_kategori FROM barang b LEFT JOIN kategori k ON b.id_kategori = k.id ORDER BY b.nama_barang";
        $result = mysqli_query($conn, $query);
        $total_nilai_stok = 0;
        ?>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga Jual</th>
                        <th>Nilai Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result)): 
                        $nilai_stok = $row['stok'] * $row['harga_jual'];
                        $total_nilai_stok += $nilai_stok;
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['kode_barang'] ?></td>
                        <td><?= $row['nama_barang'] ?></td>
                        <td><?= $row['nama_kategori'] ?? '-' ?></td>
                        <td><strong><?= $row['stok'] ?></strong></td>
                        <td><?= formatRupiah($row['harga_jual']) ?></td>
                        <td><?= formatRupiah($nilai_stok) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="6">Total Nilai Stok</th>
                        <th><strong><?= formatRupiah($total_nilai_stok) ?></strong></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Laporan Transaksi -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-exchange-alt"></i> Laporan Transaksi
    </div>
    <div class="card-body">
        <?php
        $query_transaksi = "SELECT t.*, b.nama_barang, u.nama_lengkap 
                           FROM transaksi t 
                           JOIN barang b ON t.id_barang = b.id 
                           LEFT JOIN users u ON t.id_user = u.id 
                           WHERE t.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                           ORDER BY t.tanggal DESC";
        $result_transaksi = mysqli_query($conn, $query_transaksi);
        
        $total_masuk = 0;
        $total_keluar = 0;
        ?>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>No Transaksi</th>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result_transaksi)): 
                        if ($row['jenis_transaksi'] == 'masuk') {
                            $total_masuk += $row['total'];
                        } else {
                            $total_keluar += $row['total'];
                        }
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['no_transaksi'] ?></td>
                        <td><?= formatDate($row['tanggal']) ?></td>
                        <td><?= $row['nama_barang'] ?></td>
                        <td>
                            <span class="badge bg-<?= $row['jenis_transaksi'] == 'masuk' ? 'success' : 'warning' ?>">
                                <?= ucfirst($row['jenis_transaksi']) ?>
                            </span>
                        </td>
                        <td><?= $row['jumlah'] ?></td>
                        <td><?= formatRupiah($row['total']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="5">Total Barang Masuk</th>
                        <th colspan="2" class="text-success"><strong><?= formatRupiah($total_masuk) ?></strong></th>
                    </tr>
                    <tr>
                        <th colspan="5">Total Barang Keluar</th>
                        <th colspan="2" class="text-warning"><strong><?= formatRupiah($total_keluar) ?></strong></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>