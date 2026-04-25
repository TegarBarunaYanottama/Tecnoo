<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-boxes"></i>
        <span>TECHNO</span>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' && dirname($_SERVER['PHP_SELF']) == '/modules/dashboard' ? 'active' : '' ?>" 
               href="<?= BASE_URL ?>modules/dashboard/">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], '/barang/') !== false ? 'active' : '' ?>" 
               href="<?= BASE_URL ?>modules/barang/">
                <i class="fas fa-box"></i>
                <span>Data Barang</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], '/transaksi/') !== false ? 'active' : '' ?>" 
               href="<?= BASE_URL ?>modules/transaksi/">
                <i class="fas fa-exchange-alt"></i>
                <span>Transaksi</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], '/laporan/') !== false ? 'active' : '' ?>" 
               href="<?= BASE_URL ?>modules/laporan/">
                <i class="fas fa-file-alt"></i>
                <span>Laporan</span>
            </a>
        </li>
    </ul>
</aside>