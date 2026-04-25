<?php
$pageTitle = "Barang Keluar";
include '../../includes/header.php';

// Ambil semua barang dengan stok > 0
$barang = mysqli_query($conn, "SELECT * FROM barang WHERE stok > 0 ORDER BY nama_barang");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-arrow-up"></i> Barang Keluar</h2>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="proses.php" method="POST">
            <input type="hidden" name="action" value="keluar">
            <input type="hidden" name="no_transaksi" value="<?= generateNoTransaksi('keluar') ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">No Transaksi</label>
                    <input type="text" class="form-control" value="<?= generateNoTransaksi('keluar') ?>" readonly>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal *</label>
                    <input type="date" name="tanggal" class="form-control" required value="<?= date('Y-m-d') ?>">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pilih Barang *</label>
                    <select name="id_barang" class="form-select" id="selectBarang" required>
                        <option value="">-- Pilih Barang --</option>
                        <?php while($brg = mysqli_fetch_assoc($barang)): ?>
                        <option value="<?= $brg['id'] ?>" 
                                data-harga="<?= $brg['harga_jual'] ?>"
                                data-stok="<?= $brg['stok'] ?>">
                            <?= $brg['kode_barang'] ?> - <?= $brg['nama_barang'] ?> (Stok: <?= $brg['stok'] ?>)
                        </option>
                        <?php endwhile; ?>
                    </select>
                    <small class="text-danger" id="stokWarning" style="display:none;">
                        Stok tidak mencukupi!
                    </small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah *</label>
                    <input type="number" name="jumlah" class="form-control" required min="1" id="jumlah">
                    <small class="text-muted">Maksimal: <span id="maxStok">0</span></small>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Jual per Unit</label>
                    <input type="number" name="harga" class="form-control" id="harga" readonly>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Total Harga</label>
                    <input type="number" name="total" class="form-control" id="total" readonly>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
            </div>
            
            <hr>
            
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-save"></i> Simpan Transaksi
            </button>
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </form>
    </div>
</div>

<script>
document.getElementById('selectBarang').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var harga = selectedOption.getAttribute('data-harga');
    var stok = selectedOption.getAttribute('data-stok');
    
    document.getElementById('harga').value = harga;
    document.getElementById('maxStok').textContent = stok;
    hitungTotal();
});

document.getElementById('jumlah').addEventListener('input', function() {
    var jumlah = parseInt(this.value) || 0;
    var selectedOption = document.getElementById('selectBarang').options[document.getElementById('selectBarang').selectedIndex];
    var stok = parseInt(selectedOption.getAttribute('data-stok')) || 0;
    
    if (jumlah > stok) {
        document.getElementById('stokWarning').style.display = 'block';
        this.classList.add('is-invalid');
    } else {
        document.getElementById('stokWarning').style.display = 'none';
        this.classList.remove('is-invalid');
    }
    
    hitungTotal();
});

function hitungTotal() {
    var jumlah = document.getElementById('jumlah').value || 0;
    var harga = document.getElementById('harga').value || 0;
    var total = jumlah * harga;
    document.getElementById('total').value = total;
}
</script>

<?php include '../../includes/footer.php'; ?>