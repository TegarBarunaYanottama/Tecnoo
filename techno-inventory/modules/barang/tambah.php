<?php
$pageTitle = "Tambah Barang";
include '../../includes/header.php';

// Ambil kategori
$kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus"></i> Tambah Barang</h2>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="proses.php" method="POST">
            <input type="hidden" name="action" value="tambah">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Barang *</label>
                    <input type="text" name="kode_barang" class="form-control" required 
                           value="BRG<?= date('YmdHis') ?>" readonly>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Barang *</label>
                    <input type="text" name="nama_barang" class="form-control" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="id_kategori" class="form-select">
                        <option value="">Pilih Kategori</option>
                        <?php while($kat = mysqli_fetch_assoc($kategori)): ?>
                        <option value="<?= $kat['id'] ?>"><?= $kat['nama_kategori'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="pcs" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Harga Beli *</label>
                    <input type="number" name="harga_beli" class="form-control" required min="0">
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Harga Jual *</label>
                    <input type="number" name="harga_jual" class="form-control" required min="0">
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Stok Awal</label>
                    <input type="number" name="stok" class="form-control" value="0" min="0">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Minimum Stok</label>
                    <input type="number" name="min_stok" class="form-control" value="10" min="0">
                </div>
            </div>
            
            <hr>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>