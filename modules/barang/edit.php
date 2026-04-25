<?php
$pageTitle = "Edit Barang";
include '../../includes/header.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM barang WHERE id = $id");
$barang = mysqli_fetch_assoc($query);

$kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-edit"></i> Edit Barang</h2>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="proses.php" method="POST">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $barang['id'] ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Barang *</label>
                    <input type="text" name="kode_barang" class="form-control" required 
                           value="<?= $barang['kode_barang'] ?>">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Barang *</label>
                    <input type="text" name="nama_barang" class="form-control" required 
                           value="<?= $barang['nama_barang'] ?>">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="id_kategori" class="form-select">
                        <option value="">Pilih Kategori</option>
                        <?php while($kat = mysqli_fetch_assoc($kategori)): ?>
                        <option value="<?= $kat['id'] ?>" <?= $kat['id'] == $barang['id_kategori'] ? 'selected' : '' ?>>
                            <?= $kat['nama_kategori'] ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" required 
                           value="<?= $barang['satuan'] ?>">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Harga Beli *</label>
                    <input type="number" name="harga_beli" class="form-control" required min="0"
                           value="<?= $barang['harga_beli'] ?>">
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Harga Jual *</label>
                    <input type="number" name="harga_jual" class="form-control" required min="0"
                           value="<?= $barang['harga_jual'] ?>">
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Stok Saat Ini</label>
                    <input type="text" class="form-control" value="<?= $barang['stok'] ?>" disabled>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Minimum Stok</label>
                    <input type="number" name="min_stok" class="form-control" min="0"
                           value="<?= $barang['min_stok'] ?>">
                </div>
            </div>
            
            <hr>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>