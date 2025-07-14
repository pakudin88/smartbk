<?= $this->extend('layouts/auth_layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Dashboard - Jendela Kemitraan</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <h5>Selamat Datang, <?= esc($user_name) ?>!</h5>
                        <p>Anda berhasil login ke sistem Jendela Kemitraan.</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>Informasi Akun</h6>
                                    <p><strong>Username:</strong> <?= session('username') ?></p>
                                    <p><strong>Email:</strong> <?= session('email') ?></p>
                                    <p><strong>Hubungan:</strong> <?= session('hubungan_keluarga') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>Menu Utama</h6>
                                    <div class="d-grid gap-2">
                                        <a href="/notifications" class="btn btn-outline-primary">Notifikasi</a>
                                        <a href="/profile" class="btn btn-outline-info">Profil Anak</a>
                                        <a href="/academic" class="btn btn-outline-success">Laporan Akademik</a>
                                        <a href="/logout" class="btn btn-outline-danger">Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
