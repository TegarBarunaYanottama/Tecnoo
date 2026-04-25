<?php
$pageTitle = "Data Barang";
include '../../includes/header.php';

$query = "SELECT b.*, k.nama_kategori 
          FROM barang b 
          LEFT JOIN kategori k ON b.id_kategori = k.id 
          ORDER BY b.created_at DESC";
$result = mysqli_query($conn, $query);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-box"></i> Data Barang</h2>
    <a href="tambah.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Barang
    </a>
</div>

<?php if (isset($_GET['msg'])): ?>
<div class="alert alert-<?= $_GET['status'] == 'success' ? 'success' : 'danger' ?> alert-dismissible fade show">
    <?= htmlspecialchars($_GET['msg']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result)): 
                        $status = $row['stok'] <= $row['min_stok'] ? 'danger' : 'success';
                        $status_text = $row['stok'] <= $row['min_stok'] ? 'Stok Menipis' : 'Aman';
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['kode_barang'] ?></td>
                        <td><?= $row['nama_barang'] ?></td>
                        <td><?= $row['nama_kategori'] ?? '-' ?></td>
                        <td><?= formatRupiah($row['harga_beli']) ?></td>
                        <td><?= formatRupiah($row['harga_jual']) ?></td>
                        <td><strong><?= $row['stok'] ?> <?= $row['satuan'] ?></strong></td>
                        <td><span class="badge bg-<?= $status ?>"><?= $status_text ?></span></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" 
                               onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>