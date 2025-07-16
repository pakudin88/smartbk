<?= $this->extend('layouts/dashboard_sidebar_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4 px-4">

    <!-- Page Header -->
    <div class="page-header-modern">
        <div class="page-header-icon">
            <i class="fas fa-radar"></i>
        </div>
        <div class="page-header-title">
            <h1 class="page-title">Radar Kelas</h1>
            <p class="page-subtitle">Sistem pelaporan cepat untuk monitoring siswa.</p>
        </div>
    </div>

    <!-- Action Cards Menu -->
    <div class="row text-center mb-4">
        <div class="col-6 col-md-3 mb-3">
            <a href="<?= base_url('/radar-kelas/lapor-cepat') ?>" class="action-card bg-danger-soft">
                <div class="action-card-icon text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="action-card-text">Lapor Cepat</div>
            </a>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <a href="<?= base_url('/radar-kelas/riwayat-sinyal') ?>" class="action-card bg-primary-soft">
                <div class="action-card-icon text-primary"><i class="fas fa-history"></i></div>
                <div class="action-card-text">Riwayat Sinyal</div>
            </a>
        </div>
    </div>


    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="stats-card h-100">
                <div class="stats-icon bg-danger"><i class="fas fa-file-alt"></i></div>
                <div class="stats-info">
                    <div class="stats-number"><?= $laporanBulanIni ?? 0 ?></div>
                    <div class="stats-label">Laporan Bulan Ini</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="stats-card h-100">
                <div class="stats-icon bg-warning"><i class="fas fa-users"></i></div>
                <div class="stats-info">
                    <div class="stats-number"><?= $siswaDilaporkan ?? 0 ?></div>
                    <div class="stats-label">Siswa Terlapor</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="stats-card h-100">
                <div class="stats-icon bg-success"><i class="fas fa-check-circle"></i></div>
                <div class="stats-info">
                    <div class="stats-number"><?= $kasusDitangani ?? 0 ?></div>
                    <div class="stats-label">Kasus Ditangani</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="stats-card h-100">
                <div class="stats-icon bg-info"><i class="fas fa-hourglass-half"></i></div>
                <div class="stats-info">
                    <div class="stats-number"><?= $responseTime ?? 0 ?>j</div>
                    <div class="stats-label">Waktu Respon</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-history me-2"></i>Riwayat Sinyal Terakhir Anda</h5>
                    <a href="<?= base_url('/radar-kelas/riwayat-sinyal') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <?php if (isset($riwayat) && !empty($riwayat)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($riwayat as $item): 
                                $badgeClass = 'bg-secondary';
                                if ($item->tingkat_prioritas == 'Tinggi') $badgeClass = 'bg-danger';
                                if ($item->tingkat_prioritas == 'Sedang') $badgeClass = 'bg-warning';
                                if ($item->tingkat_prioritas == 'Rendah') $badgeClass = 'bg-success';
                            ?>
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?= esc($item->nama_siswa) ?></h6>
                                    <small class="text-muted"><?= date('d M Y', strtotime($item->created_at)) ?></small>
                                </div>
                                <p class="mb-1 small text-muted"><?= esc($item->deskripsi) ?></p>
                                <div class="d-flex justify-content-start align-items-center mt-2">
                                    <span class="badge <?= $badgeClass ?> me-2"><?= esc($item->tingkat_prioritas) ?></span>
                                    <span class="badge bg-light text-dark me-2"><?= esc($item->kategori) ?></span>
                                    <span class="badge bg-info text-dark"><?= esc($item->status) ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center p-5">
                            <img src="https://cdn.jsdelivr.net/gh/zuramai/mazer/dist/assets/images/svg/no-data.svg" alt="No Data" style="width: 150px;" class="mb-3">
                            <h5 class="text-muted">Belum Ada Riwayat</h5>
                            <p class="text-muted">Anda belum pernah mengirimkan laporan.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
.page-header-modern {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    padding: 1.5rem;
    background-color: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    margin-bottom: 1rem; /* Adjusted margin */
}
.page-header-icon {
    font-size: 2rem;
    color: var(--primary-blue);
}
.page-header-title .page-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
}
.page-header-title .page-subtitle {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin: 0;
}

/* New Action Card Styles */
.action-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1rem 0.5rem;
    border-radius: var(--radius-md);
    text-decoration: none;
    color: var(--text-primary);
    font-weight: 600;
    transition: all 0.3s ease;
    height: 100px; /* Fixed height */
    box-shadow: var(--shadow-sm);
}
.action-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
    color: var(--text-primary);
}
.action-card-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}
.action-card-text {
    font-size: 0.85rem;
}
.bg-danger-soft {
    background-color: rgba(244, 67, 54, 0.1);
}
.bg-primary-soft {
    background-color: rgba(63, 81, 181, 0.1);
}


.stats-card {
    display: flex;
    align-items: center;
    background: var(--white);
    border-radius: var(--radius-md);
    padding: 1rem;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
}
.stats-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}
.stats-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    margin-right: 1rem;
}
.stats-info .stats-number {
    font-size: 1.5rem;
    font-weight: 700;
}
.stats-info .stats-label {
    font-size: 0.8rem;
    color: var(--text-secondary);
}

.content-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}
.content-card .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    background-color: var(--gray-50);
    border-bottom: 1px solid var(--border-color);
}
.content-card .card-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
}

.list-group-item-action:hover {
    background-color: var(--light-blue);
}
</style>
<?= $this->endSection() ?>
