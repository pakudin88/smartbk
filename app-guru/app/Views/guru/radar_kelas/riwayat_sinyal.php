<?= $this->extend('layouts/dashboard_sidebar_layout') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header-modern">
    <div class="page-header-icon">
        <i class="fas fa-history"></i>
    </div>
    <div class="page-header-title">
        <h1 class="page-title">Riwayat Sinyal Pribadi</h1>
        <p class="page-subtitle">Daftar semua laporan yang telah Anda kirimkan.</p>
    </div>
    <div class="page-header-actions">
        <a href="<?= base_url('/radar-kelas/lapor-cepat') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Buat Laporan Baru
        </a>
    </div>
</div>

<div class="container-fluid">
    <div class="content-card">
        <div class="card-header">
            <h5 class="card-title"><i class="fas fa-list-ul me-2"></i>Daftar Laporan Terkirim</h5>
            <small class="card-subtitle">Total <?= count($riwayat) ?> laporan ditemukan.</small>
        </div>
        <div class="card-body">
            <?php if (empty($riwayat)): ?>
                <div class="text-center p-5">
                    <img src="https://cdn.jsdelivr.net/gh/zuramai/mazer/dist/assets/images/svg/no-data.svg" alt="No Data" style="width: 150px;" class="mb-3">
                    <h5 class="text-muted">Belum Ada Riwayat</h5>
                    <p class="text-muted">Anda belum pernah mengirimkan laporan. <br>Gunakan tombol "Buat Laporan Baru" untuk memulai.</p>
                </div>
            <?php else: ?>
                <!-- Tampilan Card untuk Mobile -->
                <div class="d-block d-md-none">
                    <?php foreach ($riwayat as $item): ?>
                        <div class="card mobile-report-card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="card-title mb-1"><?= esc($item->nama_siswa) ?></h6>
                                    <span class="badge <?= ($item->tingkat_prioritas == 'Tinggi') ? 'bg-danger' : (($item->tingkat_prioritas == 'Sedang') ? 'bg-warning' : 'bg-success') ?>"><?= esc($item->tingkat_prioritas) ?></span>
                                </div>
                                <small class="text-muted d-block mb-2"><?= date('d M Y, H:i', strtotime($item->created_at)) ?></small>
                                <p class="card-text small text-muted"><?= esc(substr($item->deskripsi, 0, 100)) . (strlen($item->deskripsi) > 100 ? '...' : '') ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge bg-light text-dark"><?= esc($item->kategori) ?></span>
                                        <span class="badge bg-info text-dark"><?= esc($item->status) ?></span>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $item->id ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Tampilan Tabel untuk Desktop -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover table-striped" id="riwayatTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Lapor</th>
                                <th>Siswa</th>
                                <th>Kategori</th>
                                <th>Prioritas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($riwayat as $index => $item): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= date('d M Y, H:i', strtotime($item->created_at)) ?></td>
                                    <td>
                                        <strong><?= esc($item->nama_siswa) ?></strong><br>
                                        <small class="text-muted">NIS: <?= esc($item->username) ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark"><?= esc($item->kategori) ?></span>
                                    </td>
                                    <td>
                                        <?php 
                                        $prioritas_class = 'bg-secondary';
                                        if ($item->tingkat_prioritas == 'Tinggi') $prioritas_class = 'bg-danger';
                                        if ($item->tingkat_prioritas == 'Sedang') $prioritas_class = 'bg-warning';
                                        if ($item->tingkat_prioritas == 'Rendah') $prioritas_class = 'bg-success';
                                        ?>
                                        <span class="badge <?= $prioritas_class ?>"><?= esc($item->tingkat_prioritas) ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark"><?= esc($item->status) ?></span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $item->id ?>">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Detail Modals -->
<?php foreach ($riwayat as $item): ?>
<div class="modal fade" id="detailModal-<?= $item->id ?>" tabindex="-1" aria-labelledby="detailModalLabel-<?= $item->id ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel-<?= $item->id ?>"><i class="fas fa-file-alt me-2"></i>Detail Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Siswa:</strong><br> <?= esc($item->nama_siswa) ?> (<?= esc($item->username) ?>)</p>
                        <p><strong>Tanggal Lapor:</strong><br> <?= date('l, d F Y, H:i', strtotime($item->created_at)) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Kategori:</strong><br> <span class="badge bg-light text-dark"><?= esc($item->kategori) ?></span></p>
                        <p><strong>Prioritas:</strong><br> <span class="badge <?= ($item->tingkat_prioritas == 'Tinggi') ? 'bg-danger' : (($item->tingkat_prioritas == 'Sedang') ? 'bg-warning' : 'bg-success') ?>"><?= esc($item->tingkat_prioritas) ?></span></p>
                    </div>
                </div>
                <hr>
                <h6>Deskripsi Masalah:</h6>
                <p class="text-muted" style="white-space: pre-wrap;"><?= esc($item->deskripsi) ?></p>
                <hr>
                <h6>Status Laporan:</h6>
                <p><strong><i class="fas fa-info-circle me-2"></i><?= esc($item->status) ?></strong></p>
                <?php if(!empty($item->catatan_wali)): ?>
                    <h6>Catatan dari Wali Kelas:</h6>
                    <p class="text-muted fst-italic">"<?= esc($item->catatan_wali) ?>"</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        if (window.innerWidth > 768) {
            $('#riwayatTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.12.1/i18n/id.json"
                }
            });
        }
    });
</script>

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
        margin-bottom: 2rem;
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
    .content-card {
        background-color: var(--white);
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
    .mobile-report-card {
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }
    .mobile-report-card:hover {
        border-color: var(--primary-blue);
        box-shadow: var(--shadow-md);
    }
</style>

<?= $this->endSection() ?>